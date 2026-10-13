
<style>
    [hidden] {
        display: none !important;
    }

    .ai-chat-toggle {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 9998;
        border: none;
        border-radius: 999px;
        padding: 14px 20px;
        color: white;
        background: #2563eb;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 26px rgba(37, 99, 235, 0.30);
    }

    .ai-chat-toggle:hover {
        background: #1d4ed8;
    }

    .ai-chat-panel {
        position: fixed;
        right: 24px;
        bottom: 85px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        width: 360px;
        max-width: calc(100vw - 32px);
        height: 490px;
        max-height: calc(100vh - 120px);
        overflow: hidden;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        box-shadow: 0 15px 50px rgba(15, 23, 42, 0.20);
        font-family: Arial, sans-serif;
    }

    .ai-chat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 17px;
        color: white;
        background: #1e40af;
    }

    .ai-chat-header h2 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
    }

    .ai-chat-header p {
        margin: 4px 0 0;
        font-size: 12px;
        opacity: 0.9;
    }

    .ai-chat-close {
        border: none;
        background: transparent;
        color: white;
        font-size: 25px;
        cursor: pointer;
    }

    .ai-chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
        background: #f8fafc;
    }

    .ai-message {
        display: flex;
        margin-bottom: 12px;
    }

    .ai-message.user {
        justify-content: flex-end;
    }

    .ai-bubble {
        max-width: 86%;
        padding: 11px 13px;
        border-radius: 13px;
        font-size: 14px;
        line-height: 1.5;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
    }

    .ai-message.assistant .ai-bubble {
        color: #1f2937;
        background: white;
        border: 1px solid #e5e7eb;
        border-bottom-left-radius: 4px;
    }

    .ai-message.user .ai-bubble {
        color: white;
        background: #2563eb;
        border-bottom-right-radius: 4px;
    }

    .ai-chat-suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        padding: 0 12px 10px;
        background: #f8fafc;
    }

    .ai-suggestion {
        padding: 7px 9px;
        border: 1px solid #bfdbfe;
        border-radius: 999px;
        background: white;
        color: #1d4ed8;
        font-size: 11px;
        cursor: pointer;
    }

    .ai-chat-form {
        display: flex;
        gap: 8px;
        padding: 12px;
        border-top: 1px solid #e5e7eb;
        background: white;
    }

    .ai-chat-input {
        flex: 1;
        min-width: 0;
        padding: 11px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 14px;
        outline: none;
    }

    .ai-chat-input:focus {
        border-color: #2563eb;
    }

    .ai-chat-send {
        border: none;
        border-radius: 10px;
        padding: 0 14px;
        color: white;
        background: #2563eb;
        font-weight: 600;
        cursor: pointer;
    }

    .ai-chat-send:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    @media (max-width: 480px) {
        .ai-chat-panel {
            right: 12px;
            bottom: 78px;
            width: calc(100vw - 24px);
            height: min(490px, calc(100vh - 100px));
        }

        .ai-chat-toggle {
            right: 12px;
            bottom: 14px;
        }
    }
</style>

<button
    type="button"
    id="ai-chat-toggle"
    class="ai-chat-toggle"
    aria-label="Open AI Student Assistant"
>
    ✦ AI Assistant
</button>

<section
    id="ai-chat-panel"
    class="ai-chat-panel"
    aria-label="AI Student Assistant"
    hidden
>
    <header class="ai-chat-header">
        <div>
            <h2>✦ AI Student Assistant</h2>
            <p>Ask about courses and study topics</p>
        </div>

        <button
            type="button"
            id="ai-chat-close"
            class="ai-chat-close"
            aria-label="Close chatbot"
        >
            ×
        </button>
    </header>

    <div
        id="ai-chat-messages"
        class="ai-chat-messages"
        role="log"
        aria-live="polite"
    >
        <div class="ai-message assistant">
            <div class="ai-bubble">
                Assalam-o-Alaikum! 👋

                I'm your AI Student Assistant.

                You can ask me about available courses, credit hours,
                study topics or the Student Management System.
            </div>
        </div>
    </div>

    <div class="ai-chat-suggestions">
        <button
            type="button"
            class="ai-suggestion"
            data-prompt="What courses are available?"
        >
            Available courses
        </button>

        <button
            type="button"
            class="ai-suggestion"
            data-prompt="Explain credit hours in simple words."
        >
            Credit hours
        </button>
    </div>

    <form id="ai-chat-form" class="ai-chat-form">
        <input
            id="ai-chat-input"
            class="ai-chat-input"
            type="text"
            maxlength="1000"
            placeholder="Type your question..."
            autocomplete="off"
            required
        >

        <button
            id="ai-chat-send"
            class="ai-chat-send"
            type="submit"
        >
            Send
        </button>
    </form>
</section>

<script>
(function () {
    const toggle = document.getElementById('ai-chat-toggle');
    const panel = document.getElementById('ai-chat-panel');
    const closeButton = document.getElementById('ai-chat-close');
    const messages = document.getElementById('ai-chat-messages');
    const form = document.getElementById('ai-chat-form');
    const input = document.getElementById('ai-chat-input');
    const sendButton = document.getElementById('ai-chat-send');

    if (!toggle || !panel || !form) {
        return;
    }

    const endpoint = @json(route('ai-assistant.chat'));
    const csrfToken = @json(csrf_token());

    let chatHistory = [];

    toggle.addEventListener('click', function () {
        panel.hidden = !panel.hidden;

        if (!panel.hidden) {
            input.focus();
        }
    });

    closeButton.addEventListener('click', function () {
        panel.hidden = true;
    });

    document.querySelectorAll('.ai-suggestion').forEach(function (button) {
        button.addEventListener('click', function () {
            input.value = button.dataset.prompt || '';
            input.focus();
        });
    });

    function addMessage(text, role) {
        const wrapper = document.createElement('div');
        wrapper.className = 'ai-message ' + role;

        const bubble = document.createElement('div');
        bubble.className = 'ai-bubble';

        // Use textContent to display text safely.
        bubble.textContent = text;

        wrapper.appendChild(bubble);
        messages.appendChild(wrapper);
        messages.scrollTop = messages.scrollHeight;

        return wrapper;
    }

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const text = input.value.trim();

        if (!text || sendButton.disabled) {
            return;
        }

        const previousHistory = chatHistory.slice(-8);

        addMessage(text, 'user');

        chatHistory.push({
            role: 'user',
            content: text
        });

        input.value = '';
        input.disabled = true;
        sendButton.disabled = true;
        sendButton.textContent = '...';

        const waitingMessage = addMessage('Thinking...', 'assistant');

        try {
            const response = await fetch(endpoint, {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },

                body: JSON.stringify({
                    message: text,
                    history: previousHistory
                })
            });

            const data = await response.json().catch(function () {
                return {};
            });

            waitingMessage.remove();

            if (!response.ok) {
                throw new Error(
                    data.message ||
                    'The assistant could not respond. Please try again.'
                );
            }

            const answer = data.answer ||
                'Sorry, I could not generate an answer.';

            addMessage(answer, 'assistant');

            chatHistory.push({
                role: 'assistant',
                content: answer
            });

            chatHistory = chatHistory.slice(-8);

        } catch (error) {
            waitingMessage.remove();

            addMessage(
                error.message ||
                'Something went wrong. Please try again.',
                'assistant'
            );

        } finally {
            input.disabled = false;
            sendButton.disabled = false;
            sendButton.textContent = 'Send';
            input.focus();
        }
    });
})();
</script>
