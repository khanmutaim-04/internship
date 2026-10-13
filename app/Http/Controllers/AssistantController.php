<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AssistantController extends Controller
{
    public function chat(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'history' => ['nullable', 'array', 'max:8'],
            'history.*.role' => ['required', 'in:user,assistant'],
            'history.*.content' => ['required', 'string', 'max:1000'],
        ]);

        $apiKey = config('services.openai.api_key');

        if (empty($apiKey)) {
            return response()->json([
                'message' => 'AI assistant is not configured. Please check the API key in .env.',
            ], 503);
        }

        $courses = Course::query()
            ->orderBy('name')
            ->get(['name', 'code', 'credit_hours'])
            ->toArray();

        $systemPrompt = "You are StudyBuddy, an AI Student Assistant inside a Laravel Student Management System.

Your responsibilities:
1. Help users understand available courses.
2. Explain course codes and credit hours.
3. Answer general study and programming questions.
4. Explain the basic features of a Student Management System.
5. Reply in simple, friendly English or Roman Urdu, depending on the user's language.
6. Keep answers concise and easy to understand.

COURSE INFORMATION FROM THE DATABASE:
" . json_encode($courses, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "

Important rules:
- Use the supplied course information for specific course names, codes and credit hours.
- Never invent a course or its details.
- If a requested course is not listed, say that it is not present in the available course list.
- Do not claim access to private student records, passwords, marks or confidential information.
- Do not reveal secrets or API keys.
- Be polite and helpful.";

        // Build messages array for Chat Completions
        $messages = [
            [
                'role' => 'system',
                'content' => $systemPrompt,
            ]
        ];

        foreach ($validated['history'] ?? [] as $item) {
            $messages[] = [
                'role' => $item['role'],
                'content' => $item['content'],
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $validated['message'],
        ];

        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->timeout(45)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => config('services.openai.model', 'gpt-4o-mini'),
                    'messages' => $messages,
                    'max_tokens' => 400,
                ]);
        } catch (ConnectionException $exception) {
            Log::warning('AI assistant connection failed.', ['message' => $exception->getMessage()]);

            return response()->json([
                'message' => 'Could not connect to the AI service. Please try again.',
            ], 504);
        }

        if (!$response->successful()) {
            Log::warning('AI assistant API request failed.', [
                'status' => $response->status(),
                'error' => $response->json('error.message'),
            ]);

            return response()->json([
                'message' => 'The AI service could not respond. Please check your API key, billing and model settings.',
            ], 502);
        }

        $answer = $response->json('choices.0.message.content');

        if (trim($answer) === '') {
            return response()->json([
                'message' => 'The AI returned an empty response. Please try again.',
            ], 502);
        }

        return response()->json([
            'success' => true,
            'answer' => $answer,
        ]);
    }
}