<?php

if (!defined('_CODE')) {
     die('Access denied');
}

?>

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/custom.js"></script> -->
     <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
     <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
     <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/home.js"></script>
     <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/css/style.css">
</head>

<body>
     <div id="footer" class="footer">
          <div class="in-wrap">
               <div class="footer1">
                    <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/logoShoes.jpg" alt="">
                    <p>Thank you for visiting our shoe store. We strive to provide the highest <br>quality footwear for
                         all
                         occasions. For any inquiries, please contact us.<br> © All rights reserved.</p>
                    <h4>Follow Us</h4>
                    <div class="footer-icon">
                         <a href=""><i class="fa-brands fa-facebook" style="color: #ffffff;"></i></a>
                         <a href=""><i class="fa-brands fa-square-instagram" style="color: #ffffff;"></i></a>
                         <a href=""><i class="fa-brands fa-twitter" style="color: #ffffff;"></i></a>
                         <a href=""><i class="fa-brands fa-invision" style="color: #ffffff;"></i></a>
                         <a href=""><i class="fa-brands fa-tiktok" style="color: #ffffff;"></i></a>
                    </div>
               </div>
               <div class="footer2">
                    <h2>QUICK LINK</h2>
                    <ul>
                         <li>Home</li>
                         <li>About Us</li>
                         <li>Destination</li>
                         <li>Contact</li>
                    </ul>
               </div>
               <div class="footer3">
                    <h2>OTHERS PAGES</h2>
                    <ul>
                         <li>Privacy & Policy</li>
                         <li>Terms of Use</li>
                         <li>Disclaimer</li>
                         <li>FAQ</li>
                    </ul>
               </div>
               <div class="footer3">
                    <h2>CONTACT INFO</h2>
                    <ul>
                         <li><i class="fa-solid fa-location-dot" style="color: #df2020;"></i> Jl. Raya Mas Ubud No.88,
                              Gianyar, Bali, Indonesia - 80571</li>
                         <li><i class="fa-solid fa-phone" style="color: #ffffff;"></i> +62 361 154874</li>
                         <li><i class="fa-solid fa-envelope" style="color: #ffffff;"></i> contact@domain.com</li>
                    </ul>
               </div>
          </div>
     </div>
     <?php if (isLogin()): ?>
          <!-- Chat Button -->
          <div class="chat-button-container">
               <button class="btn btn-primary rounded-circle chat-button" id="chatButton">
                    <i class="fa-solid fa-comments"></i>
               </button>
          </div>

          <!-- Chat Dialog -->
          <div class="chat-dialog" id="chatDialog">
               <div class="chat-header">
                    <h5 class="mb-0">Chat with Us</h5>
                    <button type="button" class="btn-close" id="closeChatButton"></button>
               </div>
               <div class="chat-messages" id="chatMessages">
                    <!-- Messages will be inserted here -->
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

          <style>
               .chat-button-container {
                    position: fixed;
                    bottom: 30px;
                    right: 30px;
                    z-index: 1000;
               }

               .chat-button {
                    width: 60px;
                    height: 60px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    border: none;
               }

               .chat-button i {
                    font-size: 24px;
               }

               .chat-dialog {
                    display: none;
                    position: fixed;
                    bottom: 100px;
                    right: 30px;
                    width: 350px;
                    height: 500px;
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                    z-index: 1000;
                    overflow: hidden;
                    flex-direction: column;
               }

               .chat-header {
                    padding: 15px;
                    background: #0d6efd;
                    color: white;
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
               }

               .chat-message {
                    margin-bottom: 10px;
                    max-width: 80%;
                    padding: 8px 12px;
                    border-radius: 15px;
               }

               .user-message {
                    background: #e9ecef;
                    margin-left: auto;
               }

               .bot-message {
                    background: #0d6efd;
                    color: white;
                    margin-right: auto;
               }

               .chat-input {
                    padding: 15px;
                    border-top: 1px solid #dee2e6;
               }

               .chat-dialog.show {
                    display: flex;
               }
          </style>

          <script>
               document.addEventListener('DOMContentLoaded', function () {
                    const chatButton = document.getElementById('chatButton');
                    const chatDialog = document.getElementById('chatDialog');
                    const closeChatButton = document.getElementById('closeChatButton');
                    const messageInput = document.getElementById('messageInput');
                    const sendButton = document.getElementById('sendMessage');
                    const chatMessages = document.getElementById('chatMessages');

                    // Load chat history from server
                    function loadChatHistory() {
                         console.log('Loading chat history...');
                         fetch('?module=chat&action=get_history', {
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
                                        // Clear all messages first
                                        chatMessages.innerHTML = '';

                                        // Add messages from history
                                        data.messages.forEach(msg => {
                                             if (msg.role !== 'system') {
                                                  const messageType = msg.role === 'user' ? 'user' : 'bot';
                                                  addMessage(msg.content, messageType);
                                             }
                                        });
                                        console.log('Loaded', data.messages.length, 'messages from history');
                                   } else {
                                        // Only show welcome message if no history exists
                                        console.log('No chat history found, showing welcome message');
                                        chatMessages.innerHTML = '';
                                        addMessage('Hello! How can I help you with your shoe shopping today?', 'bot');
                                   }
                              })
                              .catch(error => {
                                   console.error('Error loading chat history:', error);
                                   // Show welcome message on error
                                   chatMessages.innerHTML = '';
                                   addMessage('Hello! How can I help you with your shoe shopping today?', 'bot');
                              });
                    }

                    // Save/Load chat state functions
                    function saveChatState(isVisible) {
                         localStorage.setItem('chatVisible', isVisible ? 'true' : 'false');
                         console.log('Saved chat state:', isVisible);
                    }

                    function loadChatState() {
                         const chatState = localStorage.getItem('chatVisible');
                         console.log('Loaded chat state from storage:', chatState);

                         // Show chat if it was previously visible
                         const shouldShow = chatState === 'true';

                         if (shouldShow) {
                              chatDialog.classList.add('show');
                              if (chatButton) {
                                   chatButton.style.display = 'none';
                              }
                              console.log('Chat set to visible from saved state');
                         } else {
                              chatDialog.classList.remove('show');
                              if (chatButton) {
                                   chatButton.style.display = 'flex';
                              }
                              console.log('Chat set to hidden');
                         }
                    }

                    // Load chat history and state when page loads
                    loadChatHistory();
                    loadChatState();

                    // Toggle chat dialog
                    chatButton.addEventListener('click', () => {
                         const isVisible = chatDialog.classList.toggle('show');
                         saveChatState(isVisible);
                         if (isVisible) {
                              chatButton.style.display = 'none';
                         }
                    });

                    // Close chat dialog
                    closeChatButton.addEventListener('click', () => {
                         chatDialog.classList.remove('show');
                         saveChatState(false);
                         chatButton.style.display = 'flex';
                    });

                    // Send message
                    function sendMessage() {
                         const message = messageInput.value.trim();
                         if (message) {
                              // Add user message to chat
                              addMessage(message, 'user');

                              // Send to server
                              fetch('?module=chat&action=send_message', {
                                   method: 'POST',
                                   headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                   },
                                   body: 'message=' + encodeURIComponent(message)
                              })
                                   .then(response => response.json())
                                   .then(data => {
                                        if (data.success) {
                                             addMessage(data.message, 'bot');
                                        } else {
                                             addMessage('Sorry, there was an error processing your message.', 'bot');
                                        }
                                   })
                                   .catch(error => {
                                        console.error('Error:', error);
                                        addMessage('Sorry, there was an error processing your message.', 'bot');
                                   });

                              messageInput.value = '';
                         }
                    }

                    // Add message to chat
                    function addMessage(text, type) {
                         const messageDiv = document.createElement('div');
                         messageDiv.className = `chat-message ${type}-message`;
                         messageDiv.textContent = text;
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
               });
          </script>
     <?php endif; ?>
</body>