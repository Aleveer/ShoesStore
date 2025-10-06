<?php
if (!defined('_CODE')) {
    die('Access denied');
}
?>
<!-- Add jQuery with integrity check -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Add Bootstrap JS with integrity check -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

<div class="chat-container">
    <div class="chat-window">
        <div class="chat-header">
            <h4>Chat Support</h4>
            <button type="button" class="btn-close" id="closeChatWindow"></button>
        </div>
        <div class="chat-messages" id="chatMessages">
            <!-- Messages will be inserted here -->
            <div class="chat-message bot-message">
                Hello! How can I help you with your shoe shopping today?
            </div>
        </div>
        <div class="chat-input">
            <div class="input-group">
                <input type="text" class="form-control" id="messageInput" placeholder="Type your message...">
                <button class="btn btn-primary" id="sendMessage">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .chat-container {
        position: fixed;
        bottom: 100px;
        right: 30px;
        z-index: 1000;
        width: 350px;
        height: 500px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        display: none;
        /* Default to hidden, JavaScript will show if needed */
        flex-direction: column;
    }

    .chat-container.visible {
        display: flex;
    }

    .chat-window {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .chat-header {
        padding: 15px;
        background: #0d6efd;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .chat-messages {
        flex-grow: 1;
        padding: 15px;
        overflow-y: auto;
        background: #f8f9fa;
    }

    .chat-message {
        margin-bottom: 10px;
        max-width: 80%;
        padding: 8px 12px;
        border-radius: 15px;
        word-wrap: break-word;
    }

    .user-message {
        background: #0d6efd;
        color: white;
        margin-left: auto;
    }

    .bot-message {
        background: white;
        border: 1px solid #dee2e6;
        margin-right: auto;
    }

    .chat-input {
        padding: 15px;
        background: white;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
        border-top: 1px solid #dee2e6;
    }

    .chat-input .input-group {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 25px;
        overflow: hidden;
    }

    .chat-input .form-control {
        border: none;
        padding: 12px 20px;
    }

    .chat-input .form-control:focus {
        box-shadow: none;
    }

    .chat-input .btn {
        border-radius: 0;
        padding: 12px 20px;
    }

    .chat-input .btn i {
        margin: 0;
    }

    .chat-message.loading {
        background: #e9ecef;
        color: #6c757d;
        margin-right: auto;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .loading-dots {
        display: flex;
        gap: 4px;
    }

    .loading-dots span {
        width: 8px;
        height: 8px;
        background: #6c757d;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out both;
    }

    .loading-dots span:nth-child(1) {
        animation-delay: -0.32s;
    }

    .loading-dots span:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0);
        }

        40% {
            transform: scale(1.0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatContainer = document.querySelector('.chat-container');
        const closeChatWindow = document.getElementById('closeChatWindow');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendMessage');
        const chatMessages = document.getElementById('chatMessages');
        const chatButton = document.querySelector('.chat-button');

        // Load chat state and history on page load
        loadChatState();
        loadChatHistory();

        // Show chat window when chat button is clicked
        if (chatButton) {
            chatButton.addEventListener('click', () => {
                showChat();
            });
        }

        // Close chat window
        closeChatWindow.addEventListener('click', () => {
            hideChat();
        });

        // Chat visibility functions
        function showChat() {
            chatContainer.classList.add('visible');
            if (chatButton) {
                chatButton.style.display = 'none';
            }
            saveChatState(true);
            console.log('Chat shown and state saved');
        }

        function hideChat() {
            chatContainer.classList.remove('visible');
            if (chatButton) {
                chatButton.style.display = 'flex';
            }
            saveChatState(false);
            console.log('Chat hidden and state saved');
        }

        // Save/Load chat state functions
        function saveChatState(isVisible) {
            localStorage.setItem('chatVisible', isVisible ? 'true' : 'false');
            console.log('Saved chat state:', isVisible);
        }

        function loadChatState() {
            const chatState = localStorage.getItem('chatVisible');
            console.log('Loaded chat state from storage:', chatState);

            // Default to showing chat if no state is saved (first time visitor)
            // or if explicitly set to true
            const shouldShow = chatState === null || chatState === 'true';

            if (shouldShow) {
                chatContainer.classList.add('visible');
                if (chatButton) {
                    chatButton.style.display = 'none';
                }
                console.log('Chat set to visible');
            } else {
                chatContainer.classList.remove('visible');
                if (chatButton) {
                    chatButton.style.display = 'flex';
                }
                console.log('Chat set to hidden');
            }
        }

        // Load chat history from server
        function loadChatHistory() {
            console.log('Loading chat history...');
            fetch(generateUrl({ module: 'chat', action: 'get_history' }), {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(response => {
                    console.log('History response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Chat history data:', data);
                    if (data.success && data.messages && data.messages.length > 0) {
                        // Clear existing messages except welcome message
                        const welcomeMessage = chatMessages.querySelector('.bot-message').cloneNode(true);
                        chatMessages.innerHTML = '';
                        chatMessages.appendChild(welcomeMessage);

                        // Add messages from history
                        data.messages.forEach(msg => {
                            if (msg.role !== 'system') {
                                const messageType = msg.role === 'user' ? 'user' : 'bot';
                                addMessage(msg.content, messageType);
                            }
                        });
                        console.log('Loaded', data.messages.length, 'messages from history');
                    } else {
                        console.log('No chat history found or empty response');
                    }
                })
                .catch(error => {
                    console.error('Error loading chat history:', error);
                });
        }

        // Add loading indicator
        function addLoadingMessage() {
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'chat-message loading';
            loadingDiv.innerHTML = `
                Thinking
                <div class="loading-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            `;
            chatMessages.appendChild(loadingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return loadingDiv;
        }

        // Remove loading indicator
        function removeLoadingMessage(loadingDiv) {
            if (loadingDiv && loadingDiv.parentNode) {
                loadingDiv.remove();
            }
        }

        // Send message
        function sendMessage() {
            const message = messageInput.value.trim();
            if (message) {
                // Add user message to chat
                addMessage(message, 'user');

                // Show loading indicator
                const loadingDiv = addLoadingMessage();

                // Send to server
                fetch(generateUrl({ module: 'chat', action: 'send_message' }), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'message=' + encodeURIComponent(message)
                })
                    .then(async response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', Object.fromEntries(response.headers.entries()));

                        const responseText = await response.text();
                        console.log('Raw response:', responseText);

                        if (!response.ok) {
                            throw new Error(
                                `HTTP error! status: ${response.status}, body: ${responseText}`);
                        }

                        try {
                            return JSON.parse(responseText);
                        } catch (e) {
                            console.error('JSON parse error:', e);
                            console.log('Invalid JSON received:', responseText);
                            throw new Error('Invalid JSON response from server');
                        }
                    })
                    .then(data => {
                        // Remove loading indicator
                        removeLoadingMessage(loadingDiv);

                        console.log('Parsed server response:', data);

                        if (data.success) {
                            addMessage(data.message, 'bot');
                        } else {
                            console.warn('Server reported error:', data);
                            const errorMessage = data.message ||
                                'An error occurred while processing your message.';
                            addMessage(errorMessage, 'bot');
                        }
                    })
                    .catch(error => {
                        console.error('Detailed error information:', {
                            error: error,
                            message: error.message,
                            stack: error.stack,
                            type: error.name
                        });

                        // Remove loading indicator
                        removeLoadingMessage(loadingDiv);

                        let errorMessage = 'Sorry, there was an error connecting to the chat service.';
                        if (error.message.includes('401') || error.message.includes('403')) {
                            errorMessage = 'Please log in to use the chat service.';
                        } else if (error.message.includes('Invalid JSON')) {
                            errorMessage = 'The server returned an invalid response format.';
                        } else if (error.message.includes('body:')) {
                            errorMessage = `Server error: ${error.message.split('body:')[1].trim()}`;
                        }

                        console.log('Showing error message to user:', errorMessage);
                        addMessage(errorMessage, 'bot');
                    });

                messageInput.value = '';
            }
        }

        // Add message to chat
        function addMessage(text, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${type}-message`;

            // For bot messages, preserve formatting (bullet points, line breaks)
            if (type === 'bot') {
                // Convert bullet points and line breaks to HTML
                const formattedText = text
                    .replace(/\n/g, '<br>')
                    .replace(/• /g, '&bull; ');
                messageDiv.innerHTML = formattedText;
            } else {
                messageDiv.textContent = text;
            }

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Send message on button click
        sendButton.addEventListener('click', sendMessage);

        // Send message on Enter key
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Chat state is now controlled by loadChatState() function
    });
</script>