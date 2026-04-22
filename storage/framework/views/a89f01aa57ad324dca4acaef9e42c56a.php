<!-- Live Chat Widget -->
<style>
.chat-widget-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99999;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.chat-toggle-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a6969 0%, #2a7a7a 100%);
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: transform 0.3s ease;
}

.chat-toggle-btn:hover {
    transform: scale(1.1);
}

.chat-toggle-btn i {
    pointer-events: none;
}

.chat-box {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    height: 450px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.3);
    display: none;
    flex-direction: column;
    overflow: hidden;
}

.chat-box.active {
    display: flex;
}

.chat-header {
    background: linear-gradient(135deg, #1a6969 0%, #2a7a7a 100%);
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header h5 {
    margin: 0;
    font-size: 16px;
}

.chat-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chat-close:hover {
    background: rgba(255,255,255,0.3);
}

.chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    background: #f8f9fa;
}

.pre-chat-form {
    padding: 10px;
}

.pre-chat-form h5 {
    color: #1a6969;
    margin-bottom: 10px;
    font-size: 18px;
}

.pre-chat-form p {
    color: #666;
    font-size: 14px;
    margin-bottom: 15px;
}

.form-group {
    margin-bottom: 12px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #1a6969;
}

.form-group textarea {
    resize: none;
    height: 80px;
}

.submit-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #1a6969 0%, #2a7a7a 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.submit-btn:hover {
    background: linear-gradient(135deg, #2a7a7a 0%, #3a8a8a 100%);
}

.submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.chat-messages {
    height: 100%;
    overflow-y: auto;
    padding: 10px;
}

.message {
    margin-bottom: 10px;
    padding: 10px 14px;
    border-radius: 15px;
    max-width: 80%;
    font-size: 14px;
    word-wrap: break-word;
}

.message.visitor {
    background: linear-gradient(135deg, #1a6969 0%, #2a7a7a 100%);
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 4px;
}

.message.admin {
    background: white;
    color: #333;
    border: 1px solid #e0e0e0;
    margin-right: auto;
    border-bottom-left-radius: 4px;
}

.message-time {
    font-size: 10px;
    opacity: 0.7;
    margin-top: 4px;
    display: block;
}

.chat-input-area {
    padding: 12px;
    border-top: 1px solid #e0e0e0;
    display: flex;
    gap: 8px;
    background: white;
}

.chat-input-area input {
    flex: 1;
    padding: 10px 12px;
    border: 2px solid #e0e0e0;
    border-radius: 20px;
    outline: none;
    font-size: 14px;
}

.chat-input-area input:focus {
    border-color: #1a6969;
}

.chat-input-area button {
    padding: 10px 16px;
    background: #1a6969;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background 0.3s;
}

.chat-input-area button:hover {
    background: #2a7a7a;
}

.no-messages {
    text-align: center;
    color: #999;
    padding: 20px;
}

.typing-indicator-container {
    padding: 8px 16px;
    background-color: #f8f9fa;
    border-radius: 15px;
    margin: 0 0 10px 0;
    max-width: 60px;
    align-self: flex-start;
}

.typing-indicator-container .typing-indicator {
    display: flex;
    gap: 3px;
}

.typing-indicator-container .typing-indicator span {
    width: 6px;
    height: 6px;
    background-color: #667781;
    border-radius: 50%;
    animation: typing-bounce 1.4s infinite ease-in-out;
}

.typing-indicator-container .typing-indicator span:nth-child(1) { animation-delay: 0s; }
.typing-indicator-container .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
.typing-indicator-container .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

@keyframes typing-bounce {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.6; }
    30% { transform: translateY(-4px); opacity: 1; }
}

@media (max-width: 768px) {
    .chat-widget-container {
        bottom: 100px;
    }
}

@media (max-width: 400px) {
    .chat-box {
        width: calc(100vw - 40px);
        right: -10px;
    }
}
</style>

<div class="chat-widget-container">
    <!-- Chat Toggle Button -->
    <button class="chat-toggle-btn" id="chatToggleBtn" aria-label="Open Chat">
        <i class="fas fa-comments"></i>
    </button>

    <!-- Chat Box -->
    <div class="chat-box" id="chatBox">
        <div class="chat-header">
            <h5>💬 Live Chat Support</h5>
            <button class="chat-close" id="chatCloseBtn" aria-label="Close Chat">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="chat-body" id="chatBody">
            <!-- Pre-chat form or messages will be loaded here -->
        </div>

        <div class="chat-input-area" id="chatInputArea" style="display: none;">
            <input type="text" id="messageInput" placeholder="Type your message...">
            <button id="sendMessageBtn">Send</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const chatToggleBtn = document.getElementById('chatToggleBtn');
    const chatBox = document.getElementById('chatBox');
    const chatCloseBtn = document.getElementById('chatCloseBtn');
    const chatBody = document.getElementById('chatBody');
    const chatInputArea = document.getElementById('chatInputArea');
    const messageInput = document.getElementById('messageInput');
    const sendMessageBtn = document.getElementById('sendMessageBtn');

    let chatId = localStorage.getItem('chat_id');
    let visitorId = localStorage.getItem('visitor_id') || generateUUID();
    let lastMessageId = 0;
    let typingTimeout = null;
    let isTyping = false;

    localStorage.setItem('visitor_id', visitorId);

    // Generate UUID
    function generateUUID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    // Message notification sound (bell) using Web Audio API
    function playMessageSound() {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
        oscillator.frequency.exponentialRampToValueAtTime(1200, audioContext.currentTime + 0.1);

        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);

        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    }

    // Toggle chat box
    function toggleChat() {
        if (chatBox.classList.contains('active')) {
            chatBox.classList.remove('active');
        } else {
            chatBox.classList.add('active');
            loadChat();
        }
    }

    // Close chat box
    function closeChat() {
        chatBox.classList.remove('active');
    }

    // Load chat - show prechat form or messages
    function loadChat() {
        chatId = localStorage.getItem('chat_id');
        if (chatId) {
            // Check if chat is still active
            fetch(`/visitor/chat/${chatId}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(chat => {
                if (chat.status === 'active') {
                    showChatInterface();
                } else {
                    // Chat is closed, start new
                    localStorage.removeItem('chat_id');
                    showPrechatForm();
                }
            })
            .catch(error => {
                console.error('Error checking chat status:', error);
                // Assume chat is invalid, start new
                localStorage.removeItem('chat_id');
                showPrechatForm();
            });
        } else {
            showPrechatForm();
        }
    }

    // Show pre-chat form
    function showPrechatForm() {
        chatBody.innerHTML = `
            <div class="pre-chat-form">
                <h5>👋 Hi there!</h5>
                <p>How can we help you today?</p>
                <form id="prechatForm">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Your Phone (optional)">
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Tell us how we can help..." required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Start Chat</button>
                </form>
            </div>
        `;
        chatInputArea.style.display = 'none';
    }

    // Show chat interface
    function showChatInterface() {
        chatInputArea.style.display = 'flex';
        fetchMessages();
    }

    // Handle prechat form submission
    document.addEventListener('submit', function(e) {
        if (e.target.id === 'prechatForm') {
            e.preventDefault();

            const form = e.target;
            const submitBtn = form.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Starting...';

            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            fetch('/visitor/chat', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    visitor_id: visitorId,
                    name: formData.get('name'),
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    message: formData.get('message')
                })
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('Page expired. Please refresh the page and try again.');
                    }
                    return response.json().then(err => {
                        throw new Error(err.message || 'Failed to start chat');
                    });
                }
                return response.json();
            })
            .then(data => {
                chatId = data.chat_id;
                localStorage.setItem('chat_id', chatId);
                showChatInterface();
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Failed to start chat. Please try again.');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        }
    });

    // Send message
    function sendMessage() {
        const message = messageInput.value.trim();
        if (!message || !chatId) return;

        // Stop typing status
        if (isTyping) {
            isTyping = false;
            clearTimeout(typingTimeout);
            sendTypingStatus(false);
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        fetch(`/visitor/chat/${chatId}/messages`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            messageInput.value = '';
            fetchMessages();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send message. Please try again.');
        });
    }

    // Send typing status
    function sendTypingStatus(isTyping) {
        if (!chatId) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        fetch(`/visitor/chat/${chatId}/typing`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                is_typing: isTyping,
                user_id: null // Visitor, no user ID
            })
        }).catch(error => {
            console.error('Error sending typing status:', error);
        });
    }

    // Fetch messages
    function fetchMessages() {
        if (!chatId) return;

        fetch(`/visitor/chat/${chatId}/messages`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(messages => {
            // Check for new messages and play sound
            if (messages.length > 0 && lastMessageId > 0 && messages[messages.length - 1].id > lastMessageId) {
                playMessageSound();
            }

            renderMessages(messages);
            if (messages.length > 0) {
                lastMessageId = messages[messages.length - 1].id;
            }
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
    }

    // Check for typing status
    function checkTypingStatus() {
        if (!chatId) return;

        fetch(`/visitor/chat/${chatId}/typing`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.is_typing && data.typing_user) {
                showTypingIndicator();
            } else {
                hideTypingIndicator();
            }
        })
        .catch(error => {
            console.error('Error checking typing status:', error);
        });
    }

    // Show typing indicator
    function showTypingIndicator() {
        let typingIndicator = chatBody.querySelector('.typing-indicator-container');
        if (!typingIndicator) {
            typingIndicator = document.createElement('div');
            typingIndicator.className = 'typing-indicator-container';
            typingIndicator.innerHTML = `
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            `;
            chatBody.appendChild(typingIndicator);
        }
        typingIndicator.style.display = 'block';
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // Hide typing indicator
    function hideTypingIndicator() {
        const typingIndicator = chatBody.querySelector('.typing-indicator-container');
        if (typingIndicator) {
            typingIndicator.style.display = 'none';
        }
    }

    // Render messages
    function renderMessages(messages) {
        if (messages.length === 0) {
            chatBody.innerHTML = '<div class="no-messages">No messages yet. Start the conversation!</div>';
            return;
        }

        let html = '<div class="chat-messages">';
        messages.forEach(msg => {
            const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            html += `
                <div class="message ${msg.sender_type}">
                    <div>${msg.message}</div>
                    <span class="message-time">${time}</span>
                </div>
            `;
        });
        html += '</div>';
        chatBody.innerHTML = html;

        // Scroll to bottom
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // Typing indicator - send typing status
    messageInput.addEventListener('input', function() {
        if (!isTyping && this.value.length > 0) {
            isTyping = true;
            sendTypingStatus(true);
        }

        // Clear previous timeout
        if (typingTimeout) clearTimeout(typingTimeout);

        // Stop typing after 2 seconds of inactivity
        typingTimeout = setTimeout(function() {
            if (isTyping) {
                isTyping = false;
                sendTypingStatus(false);
            }
        }, 2000);
    });

    // Event listeners
    chatToggleBtn.addEventListener('click', toggleChat);
    chatCloseBtn.addEventListener('click', closeChat);
    sendMessageBtn.addEventListener('click', sendMessage);

    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.chat-widget-container') && chatBox.classList.contains('active')) {
            closeChat();
        }
    });

    // Poll for new messages and typing status
    setInterval(function() {
        if (chatId && chatBox.classList.contains('active')) {
            fetchMessages();
            checkTypingStatus();
        }
    }, 5000);
});
</script>
<?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/partials/chat-widget.blade.php ENDPATH**/ ?>