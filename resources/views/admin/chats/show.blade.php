@extends('adminlte::page')

@section('title', 'Chat with ' . $chat->name)

@section('content')
    <div class="whatsapp-chat-container">
        <!-- Chat Header -->
        <div class="whatsapp-header">
            <div class="d-flex align-items-center">
                <div class="whatsapp-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-white">{{ $chat->name }}</h5>
                    <small class="text-white-50 typing-status" id="typingStatus">
                        <span class="typing-indicator" style="display: none;">
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                            typing...
                        </span>
                        <span class="online-status">{{ $chat->email }}</span>
                    </small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if($chat->chat_type === 'customer_admin' && $chat->user)
                    <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#customerDetailsModal" title="Customer Details">
                        <i class="fas fa-info-circle"></i>
                    </button>
                @endif
                <a href="{{ route('admin.chats.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>

        <!-- Chat Messages Area -->
        <div id="chat-messages" class="whatsapp-messages">
            @foreach($chat->messages as $message)
                @php
                    $isAdmin = $message->sender_type === 'admin';
                    $bgClass = $isAdmin ? 'message-sent' : 'message-received';
                    $alignment = $isAdmin ? 'message-aligned-right' : 'message-aligned-left';
                @endphp
                <div class="message {{ $bgClass }} {{ $alignment }}" data-message-id="{{ $message->id }}">
                    <div class="message-content">
                        @if(isset($message->message_type) && $message->message_type === 'file')
                            <div class="message-file">
                                <i class="fas fa-file fa-lg"></i>
                                <a href="{{ asset('storage/' . $message->message) }}" target="_blank" class="file-link">
                                    {{ $message->file_name ?? 'Attachment' }}
                                </a>
                                <span class="file-size">{{ $message->file_size ? round($message->file_size / 1024, 1) . ' KB' : '' }}</span>
                            </div>
                        @else
                            <div class="message-text">{{ $message->message }}</div>
                        @endif
                        <div class="message-meta">
                            <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                            @if($isAdmin)
                                <span class="message-status">
                                    <i class="fas fa-check-double"></i>
                                </span>
                            @endif
                        </div>
                        @if($isAdmin)
                        <div class="message-actions">
                            <button type="button" class="message-action-btn delete-message-btn" title="Delete" data-message-id="{{ $message->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Typing Indicator Template -->
        <div id="typingIndicator" class="typing-indicator-container" style="display: none;">
            <div class="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Message Input -->
        <div class="whatsapp-input-area">
            <form action="{{ route('admin.chats.reply', $chat) }}" method="POST" class="d-flex align-items-center gap-2 w-100" id="chatForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="chat_id" value="{{ $chat->id }}">

                <!-- Emoji Button -->
                <div class="emoji-wrapper">
                    <button type="button" class="btn btn-link text-secondary p-0" title="Emoji" id="emojiBtn">
                        <i class="far fa-smile fa-lg"></i>
                    </button>
                    <!-- Simple Emoji Picker -->
                    <div class="emoji-picker" id="emojiPicker" style="display: none;">
                        <div class="emoji-grid">
                            <span>😀</span><span>😃</span><span>😄</span><span>😁</span><span>😆</span><span>😅</span><span>😂</span><span>🤣</span>
                            <span>😊</span><span>😇</span><span>🙂</span><span>🙃</span><span>😉</span><span>😌</span><span>😍</span><span>🥰</span>
                            <span>😘</span><span>😗</span><span>😙</span><span>😚</span><span>😋</span><span>😛</span><span>😜</span><span>🤪</span>
                            <span>😝</span><span>🤑</span><span>🤗</span><span>🤭</span><span>🤫</span><span>🤔</span><span>🙄</span><span>😏</span>
                            <span>😣</span><span>😥</span><span>😮</span><span>🤐</span><span>😯</span><span>😪</span><span>😫</span><span>😴</span>
                            <span>😬</span><span>🤒</span><span>🤕</span><span>🤢</span><span>🤧</span><span>😷</span><span>🤖</span><span>😃</span>
                            <span>🥳</span><span>🥴</span><span>🥺</span><span>🤯</span><span>🤠</span><span>🥳</span><span>😎</span><span>🤓</span>
                            <span>👋</span><span>✋</span><span>🖖</span><span>👌</span><span>🤌</span><span>🤏</span><span>✌️</span><span>🤞</span>
                            <span>🤟</span><span>🤘</span><span>🤙</span><span>👈</span><span>👉</span><span>👆</span><span>👇</span><span>☝️</span>
                            <span>👍</span><span>👎</span><span>✊</span><span>👊</span><span>🤛</span><span>🤜</span><span>💪</span><span>👐</span>
                            <span>👀</span><span>👁</span><span>👅</span><span>👄</span><span>💋</span><span>👶</span><span>👦</span><span>👧</span>
                        </div>
                    </div>
                </div>

                <!-- Attachment Button -->
                <label class="btn btn-link text-secondary p-0 m-0" title="Attach file" style="cursor: pointer;">
                    <i class="fas fa-paperclip fa-lg"></i>
                    <input type="file" name="file" id="fileInput" style="display: none;" accept="image/*,.pdf,.doc,.docx,.txt">
                </label>

                <!-- File Preview -->
                <div id="filePreview" class="file-preview" style="display: none;">
                    <span class="file-name"></span>
                    <button type="button" class="btn-remove-file">&times;</button>
                </div>

                <input type="text" name="message" id="messageInput" class="form-control whatsapp-input" placeholder="Type a message..." autocomplete="off">

                <button type="submit" class="btn btn-link text-secondary" title="Send">
                    <i class="fas fa-paper-plane fa-lg"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Customer Details Modal -->
    @if($chat->chat_type === 'customer_admin' && $chat->user)
    <div class="modal fade" id="customerDetailsModal" tabindex="-1" aria-labelledby="customerDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerDetailsModalLabel">Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>ID:</strong></td>
                                    <td>{{ $chat->user->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $chat->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $chat->user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $chat->user->phone ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Registered:</strong></td>
                                    <td>{{ $chat->user->created_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Activity Summary</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Exchanges:</strong></td>
                                    <td>{{ $chat->user->receivedExchanges()->count() + $chat->user->proposedExchanges()->count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Rentals:</strong></td>
                                    <td>{{ $chat->user->rentals()->count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Products:</strong></td>
                                    <td>{{ $chat->user->products()->count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Location:</strong></td>
                                    <td>{{ $chat->user->location ?? 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('admin.users.show', $chat->user) }}" class="btn btn-primary">View Full Profile</a>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        /* Allow scrolling in content area */
        .content-wrapper { min-height: 100vh !important; height: auto !important; }
        .content { padding: 0 !important; min-height: calc(100vh - 56px) !important; }
        body { overflow: auto !important; }

        :root {
            --primary-color: {{ config('settings.primary_color', '#1a6969') }};
            --whatsapp-bg: #e5ddd5;
            --whatsapp-sent: #dcf8c6;
            --whatsapp-received: #ffffff;
        }

        .whatsapp-chat-container {
            max-width: 600px;
            width: 100%;
            height: calc(100vh - 56px);
            margin: 0 auto;
            background-color: var(--whatsapp-bg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 56px;
            left: 50%;
            transform: translateX(-50%);
            background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z\' fill=\'%239c928c\' fill-opacity=\'0.1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .whatsapp-chat-container {
                max-width: 100%;
                width: 100%;
                height: calc(100vh - 56px) !important;
                position: fixed !important;
                top: 56px !important;
                left: 0 !important;
                transform: none !important;
            }

            .whatsapp-messages {
                flex: 1;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                padding: 12px 8px;
            }

            .message {
                max-width: 80%;
            }

            .whatsapp-header {
                padding: 10px 12px;
                flex-shrink: 0;
            }

            .whatsapp-input-area {
                padding: 8px;
                flex-shrink: 0;
            }
        }

        @media (max-width: 480px) {
            .whatsapp-chat-container {
                height: calc(100vh - 56px) !important;
                top: 56px !important;
            }

            .whatsapp-messages {
                padding: 8px 6px;
            }

            .message-content {
                padding: 6px 10px;
                font-size: 14px;
            }

            .whatsapp-header h5 {
                font-size: 14px;
            }

            .whatsapp-input {
                padding: 8px 12px;
                font-size: 14px;
            }
        }

        /* Ensure vertical scroll works properly */
        .whatsapp-messages {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            scroll-behavior: smooth;
        }

        .whatsapp-header {
            background-color: var(--primary-color);
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .whatsapp-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .whatsapp-avatar i {
            color: white;
            font-size: 18px;
        }

        .whatsapp-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .message {
            max-width: 65%;
            margin-bottom: 2px;
        }

        .message-content {
            padding: 8px 12px;
            border-radius: 7px;
            position: relative;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .message-sent .message-content {
            background-color: var(--whatsapp-sent);
            border-top-right-radius: 0;
        }

        .message-received .message-content {
            background-color: var(--whatsapp-received);
            border-top-left-radius: 0;
        }

        .message-aligned-right {
            align-self: flex-end;
        }

        .message-aligned-left {
            align-self: flex-start;
        }

        .message-text {
            word-wrap: break-word;
            line-height: 1.4;
            color: #303030;
        }

        .message-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            margin-top: 4px;
        }

        .message-time {
            font-size: 11px;
            color: #667781;
        }

        .message-status {
            font-size: 14px;
        }

        .message-status i {
            color: #53bdeb;
        }

        .message-file {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .message-file .file-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .message-file .file-link:hover {
            text-decoration: underline;
        }

        .message-file .file-size {
            font-size: 11px;
            color: #667781;
        }

        .whatsapp-input-area {
            background-color: #f0f0f0;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .whatsapp-input {
            border-radius: 20px;
            border: none;
            padding: 10px 16px;
            background-color: white;
        }

        .whatsapp-input:focus {
            box-shadow: none;
            border: none;
        }

        /* Typing Indicator */
        .typing-status {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            background-color: white;
            border-radius: 50%;
            animation: typing-bounce 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typing-bounce {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.6; }
            30% { transform: translateY(-4px); opacity: 1; }
        }

        .typing-indicator-container {
            padding: 8px 16px;
            background-color: var(--whatsapp-received);
            border-radius: 7px;
            border-top-left-radius: 0;
            max-width: 60px;
            margin: 0 0 4px 8px;
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

        /* Emoji Picker */
        .emoji-wrapper {
            position: relative;
        }

        .emoji-picker {
            position: absolute;
            bottom: 60px;
            left: 0;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 8px;
            z-index: 1000;
            width: 320px;
            max-height: 280px;
            overflow-y: auto;
        }

        .emoji-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 2px;
        }

        .emoji-grid span {
            cursor: pointer;
            padding: 6px;
            text-align: center;
            border-radius: 4px;
            font-size: 20px;
            line-height: 1;
        }

        .emoji-grid span:hover {
            background-color: #e8e8e8;
        }

        /* File Preview */
        .file-preview {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 8px;
            background: white;
            border-radius: 20px;
            max-width: 200px;
        }

        .file-preview .file-name {
            font-size: 12px;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .btn-remove-file {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 18px;
            padding: 0;
            line-height: 1;
        }

        .btn-remove-file:hover {
            color: #333;
        }

        /* Custom scrollbar */
        .whatsapp-messages::-webkit-scrollbar {
            width: 6px;
        }

        .whatsapp-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .whatsapp-messages::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }

        /* Message actions */
        .message-actions {
            position: absolute;
            top: 4px;
            right: 4px;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .message-sent .message-content:hover .message-actions {
            opacity: 1;
        }

        .message-action-btn {
            background: none;
            border: none;
            padding: 4px 6px;
            cursor: pointer;
            color: #667781;
            font-size: 12px;
            border-radius: 4px;
        }

        .message-action-btn:hover {
            background-color: rgba(0,0,0,0.1);
        }

        .message-action-btn.delete:hover {
            background-color: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }
    </style>
@stop

@section('js')
<script>
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

$(document).ready(function() {
    let lastMessageId = {{ $chat->messages->max('id') ?? 0 }};
    const chatId = {{ $chat->id }};
    const currentUserId = {{ auth()->id() }};
    let typingTimeout = null;
    let isTyping = false;

    // Scroll to bottom
    function scrollToBottom() {
        $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
    }
    scrollToBottom();

    // Emoji Picker Toggle
    $('#emojiBtn').on('click', function(e) {
        e.stopPropagation();
        $('#emojiPicker').toggle();
    });

    // Insert Emoji
    $('.emoji-grid span').on('click', function() {
        const emoji = $(this).text();
        const input = $('#messageInput');
        input.val(input.val() + emoji).focus();
    });

    // Close emoji picker when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.emoji-wrapper').length) {
            $('#emojiPicker').hide();
        }
    });

    // File Preview
    $('#fileInput').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            $('#filePreview .file-name').text(file.name);
            $('#filePreview').show();
        }
    });

    // Remove File
    $('.btn-remove-file').on('click', function() {
        $('#fileInput').val('');
        $('#filePreview').hide();
    });

    // Typing indicator - send typing status
    $('#messageInput').on('input', function() {
        if (!isTyping && $(this).val().length > 0) {
            isTyping = true;
            $.ajax({
                url: '/admin/chats/' + chatId + '/typing',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_typing: true,
                    user_id: currentUserId
                }
            });
        }

        // Clear previous timeout
        if (typingTimeout) clearTimeout(typingTimeout);

        // Stop typing after 2 seconds of inactivity
        typingTimeout = setTimeout(function() {
            if (isTyping) {
                isTyping = false;
                $.ajax({
                    url: '/admin/chats/' + chatId + '/typing',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_typing: false,
                        user_id: currentUserId
                    }
                });
            }
        }, 2000);
    });

    // Check for typing status
    function checkTypingStatus() {
        $.ajax({
            url: '/admin/chats/' + chatId + '/typing',
            method: 'GET',
            success: function(response) {
                if (response.is_typing && response.typing_user && response.typing_user.id !== currentUserId) {
                    $('#typingIndicator').show();
                    $('#typingStatus .online-status').hide();
                } else {
                    $('#typingIndicator').hide();
                    $('#typingStatus .online-status').show();
                }
            }
        });
    }

    // Check typing status every 2 seconds
    setInterval(checkTypingStatus, 2000);

    // Handle file upload form submission
    let isUploading = false;

    $('#chatForm').on('submit', function(e) {
        const fileInput = $('#fileInput')[0];
        const messageText = $('#messageInput').val().trim();

        // If uploading, prevent duplicate submissions
        if (isUploading) {
            e.preventDefault();
            return false;
        }

        // If there's a file, upload it via AJAX
        if (fileInput && fileInput.files.length > 0) {
            e.preventDefault();
            isUploading = true;

            const formData = new FormData(this);

            $.ajax({
                url: '/admin/chats/' + chatId + '/upload',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Clear file input and message
                    $('#fileInput').val('');
                    $('#filePreview').hide();
                    $('#messageInput').val('');

                    // Add file message to chat
                    const messageHtml = `
                        <div class="message message-sent message-aligned-right">
                            <div class="message-content">
                                <div class="message-file">
                                    <i class="fas fa-file fa-lg"></i>
                                    <a href="/storage/${response.message.message}" target="_blank" class="file-link">
                                        ${response.message.file_name}
                                    </a>
                                    <span class="file-size">${Math.round(response.message.file_size / 1024)} KB</span>
                                </div>
                                <div class="message-meta">
                                    <span class="message-time">${new Date(response.message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                                    <span class="message-status">
                                        <i class="fas fa-check"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#chat-messages').append(messageHtml);
                    scrollToBottom();

                    // Update last message ID
                    lastMessageId = response.message.id;

                    // Stop typing status
                    if (isTyping) {
                        isTyping = false;
                        clearTimeout(typingTimeout);
                    }

                    isUploading = false;
                },
                error: function(xhr) {
                    console.error('File upload failed:', xhr.responseText);
                    alert('File upload failed. Please try again.');
                    isUploading = false;
                }
            });
            return false;
        }

        // For text-only messages, submit normally if there's text
        if (messageText) {
            // Clear typing status
            if (isTyping) {
                isTyping = false;
                clearTimeout(typingTimeout);
                $.ajax({
                    url: '/admin/chats/' + chatId + '/typing',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_typing: false,
                        user_id: currentUserId
                    }
                });
            }
            // Let the form submit normally
            return true;
        }

        // No message and no file - prevent submit
        e.preventDefault();
        return false;
    });

    // Submit form on Enter
    $('#messageInput').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if ($(this).val().trim() || $('#fileInput')[0].files.length > 0) {
                $(this).closest('form').submit();
            }
        }
    });

    // Fetch new messages via AJAX
    let hasInitialFetched = false;

    function fetchNewMessages() {
        // Skip first fetch since messages are already rendered server-side
        if (!hasInitialFetched) {
            hasInitialFetched = true;
            return;
        }

        $.ajax({
            url: '/api/chats/' + chatId + '/messages',
            method: 'GET',
            success: function(messages) {
                if (messages.length > 0) {
                    const latestMessageId = messages[messages.length - 1].id;

                    // Check if there are new messages
                    if (latestMessageId > lastMessageId) {
                        // Play sound for new messages
                        playMessageSound();

                        // Append new messages only
                        messages.forEach(function(message) {
                            if (message.id > lastMessageId) {
                                const isAdmin = message.sender_type === 'admin';
                                const bgClass = isAdmin ? 'message-sent' : 'message-received';
                                const alignment = isAdmin ? 'message-aligned-right' : 'message-aligned-left';
                                const statusIcon = isAdmin ? '<i class="fas fa-check-double"></i>' : '';

                                let messageContent = '';
                                if (message.message_type === 'file') {
                                    messageContent = `
                                        <div class="message-file">
                                            <i class="fas fa-file fa-lg"></i>
                                            <a href="/storage/${message.message}" target="_blank" class="file-link">
                                                ${message.file_name || 'Attachment'}
                                            </a>
                                            <span class="file-size">${message.file_size ? Math.round(message.file_size / 1024) + ' KB' : ''}</span>
                                        </div>
                                    `;
                                } else {
                                    messageContent = `<div class="message-text">${message.message}</div>`;
                                }

                                const messageHtml = `
                                    <div class="message ${bgClass} ${alignment}">
                                        <div class="message-content">
                                            ${messageContent}
                                            <div class="message-meta">
                                                <span class="message-time">${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                                                ${statusIcon ? '<span class="message-status">' + statusIcon + '</span>' : ''}
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#chat-messages').append(messageHtml);
                            }
                        });

                        lastMessageId = latestMessageId;
                        scrollToBottom();
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    // Start polling for new messages after 5 seconds (skip initial fetch)
    setInterval(fetchNewMessages, 5000);

    // Delete message functionality
    $(document).on('click', '.delete-message-btn', function() {
        const messageId = $(this).data('message-id');
        const messageElement = $(this).closest('.message');

        if (confirm('Are you sure you want to delete this message?')) {
            $.ajax({
                url: '/admin/chats/' + chatId + '/messages/' + messageId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        messageElement.fadeOut(300, function() {
                            $(this).remove();
                            // Adjust scroll if needed
                            const remainingMessages = $('#chat-messages .message').length;
                            if (remainingMessages === 0) {
                                $('#chat-messages').html('<div class="empty-chat"><i class="fas fa-comments"></i><p>No messages yet.</p></div>');
                            }
                        });
                    } else {
                        alert('Failed to delete message. Please try again.');
                    }
                },
                error: function(xhr) {
                    console.error('Delete failed:', xhr.responseText);
                    alert('Failed to delete message. Please try again.');
                }
            });
        }
    });
});
</script>
@stop
