/**
 * POD Starter Pro - AI Chatbot
 */

(function () {
    'use strict';

    const trigger = document.getElementById('chatbot-trigger');
    const window_ = document.getElementById('chatbot-window');
    const closeBtn = document.getElementById('chatbot-close');
    const messagesContainer = document.getElementById('chatbot-messages');
    const input = document.getElementById('chatbot-input');
    const quickReplies = document.querySelectorAll('.chatbot-quick-reply');

    if (!trigger || !window_) return;

    const config = typeof podChatbot !== 'undefined' ? podChatbot : {
        restUrl: '/wp-json/pod/v1/',
        restNonce: '',
        i18n: {
            typingText: 'is typing...',
            errorMessage: 'Sorry, something went wrong.',
        },
    };

    let sessionId = sessionStorage.getItem('pod_chat_session') || generateId();
    sessionStorage.setItem('pod_chat_session', sessionId);

    // ===========================================
    // TOGGLE CHAT
    // ===========================================
    trigger.addEventListener('click', () => {
        window_.classList.toggle('is-open');
        if (window_.classList.contains('is-open')) {
            input.focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        window_.classList.remove('is-open');
    });

    // ===========================================
    // SEND MESSAGE
    // ===========================================
    function sendMessage(message) {
        if (!message.trim()) return;

        // Add user message
        addMessage(message, 'user');
        input.value = '';

        // Show typing indicator
        const typingEl = showTyping();

        // Send to API
        fetch(config.restUrl + 'chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': config.restNonce,
            },
            body: JSON.stringify({
                message: message,
                session_id: sessionId,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                removeTyping(typingEl);
                addMessage(data.reply || config.i18n.errorMessage, 'bot');
            })
            .catch(() => {
                removeTyping(typingEl);
                addMessage(config.i18n.errorMessage, 'bot');
            });
    }

    // Input handlers
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage(input.value);
        }
    });

    // Send button
    const sendBtn = document.querySelector('.chatbot-send-btn');
    if (sendBtn) {
        sendBtn.addEventListener('click', () => {
            sendMessage(input.value);
        });
    }

    // Quick replies
    quickReplies.forEach((btn) => {
        btn.addEventListener('click', function () {
            sendMessage(this.dataset.message);
        });
    });

    // ===========================================
    // HELPERS
    // ===========================================
    function addMessage(text, type) {
        const div = document.createElement('div');
        div.className = `chatbot-message chatbot-message--${type}`;
        div.innerHTML = `<div class="chatbot-message__bubble">${escapeHtml(text)}</div>`;
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function showTyping() {
        const div = document.createElement('div');
        div.className = 'chatbot-message chatbot-message--bot chatbot-typing';
        div.innerHTML = '<div class="chatbot-message__bubble">⏳ Thinking...</div>';
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        return div;
    }

    function removeTyping(el) {
        if (el && el.parentNode) {
            el.parentNode.removeChild(el);
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function generateId() {
        return 'chat_' + Math.random().toString(36).substring(2, 15);
    }

    console.log('💬 AI Chatbot initialized');
})();