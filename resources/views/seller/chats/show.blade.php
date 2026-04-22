@extends('adminlte::page')

@section('title', 'Chat with ' . ($chat->user_id === auth()->id() ? ($chat->relatedUser ? $chat->relatedUser->name : 'Unknown') : ($chat->user ? $chat->user->name : 'Unknown')))

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        /* Hide sidebar and navbar */
        .main-sidebar { display: none !important; }
        .main-header { display: none !important; }
        .content-wrapper { margin-left: 0 !important; height: 100vh !important; }
        .content { padding: 0 !important; height: 100vh !important; }
        body { overflow: hidden !important; }

        :root {
            --primary-color: {{ config('settings.primary_color', '#1a6969') }};
            --whatsapp-bg: #e5ddd5;
            --whatsapp-sent: #dcf8c6;
            --whatsapp-received: #ffffff;
        }

        .whatsapp-chat-container {
            max-width: 900px;
            width: 100%;
            height: 100vh;
            margin: 0 auto;
            background-color: var(--whatsapp-bg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z\' fill=\'%239c928c\' fill-opacity=\'0.1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');
        }

        /* WhatsApp Header */
        .whatsapp-header {
            background-color: var(--primary-color);
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .whatsapp-welcome {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .whatsapp-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .whatsapp-avatar i {
            color: white;
            font-size: 18px;
        }

        .whatsapp-info h5 {
            color: white;
            margin: 0;
            font-size: 16px;
        }

        .whatsapp-info small {
            color: rgba(255,255,255,0.7);
            font-size: 12px;
        }

        .whatsapp-actions .btn {
            border-radius: 50%;
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
        }

        .whatsapp-actions .btn:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Messages Area */
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

        .message-sender {
            font-size: 12px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 4px;
        }

        .message-text {
            word-wrap: break-word;
            line-height: 1.4;
            color: #303030;
        }

        .message-time {
            font-size: 11px;
            color: #667781;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            margin-top: 4px;
        }

        .message.own .message-time {
            justify-content: flex-end;
        }

        .read-indicator {
            font-size: 14px;
        }

        .read-indicator i {
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

        /* Input Area */
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

        /* Date Separator */
        .date-separator {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 16px 0;
        }

        .date-separator span {
            background: rgba(255,255,255,0.7);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            color: #667781;
        }

        /* Empty Chat */
        .empty-chat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #667781;
            text-align: center;
            padding: 40px;
        }

        .empty-chat i {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            background-color: #667781;
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

        /* Message delete menu */
        .message-menu {
            position: absolute;
            top: -10px;
            right: -30px;
            display: none;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            padding: 4px 0;
            z-index: 100;
            min-width: 120px;
        }

        .message-sent .message-content:hover .message-menu {
            display: block;
        }

        .message-menu-btn {
            display: block;
            width: 100%;
            padding: 6px 12px;
            text-align: left;
            border: none;
            background: none;
            font-size: 13px;
            color: #333;
            cursor: pointer;
        }

        .message-menu-btn:hover {
            background-color: #f5f5f5;
        }

        .message-menu-btn.delete {
            color: #e74c3c;
        }

        .message-menu-btn.delete:hover {
            background-color: #fee;
        }

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

        /* Responsive */
        @media (max-width: 768px) {
            .whatsapp-header {
                padding: 10px 12px;
            }

            .whatsapp-messages {
                padding: 12px;
            }

            .message {
                max-width: 80%;
            }
        }
    </style>
@stop

@section('content')
    <div class="whatsapp-chat-container">
        <!-- Chat Header -->
        <div class="whatsapp-header">
            <div class="whatsapp-welcome">
                <div class="whatsapp-avatar">
                    <i class="fas {{ $chat->chat_type === 'seller_admin' ? 'fa-user-shield' : 'fa-user' }}"></i>
                </div>
                <div class="whatsapp-info">
                    <h5>Chat with {{ $chat->user_id === auth()->id() ? ($chat->relatedUser ? $chat->relatedUser->name : 'Unknown') : ($chat->user ? $chat->user->name : 'Unknown') }}</h5>
                    <small>
                        @if($chat->chat_type === 'seller_admin')
                            <i class="fas fa-shield-alt me-1"></i>Admin Support
                        @else
                            <i class="fas fa-user me-1"></i>Customer Chat
                        @endif
                        @if($chat->subject)
                            - {{ $chat->subject }}
                        @endif
                        <span class="typing-indicator-inline" id="typingIndicatorInline" style="display: none; margin-left: 8px;">
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                        </span>
                    </small>
                </div>
            </div>
            <div class="whatsapp-actions">
                <a href="{{ route('seller.chats.index') }}" class="btn" title="Back">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>

        <!-- Chat Messages Area -->
        <div id="chat-messages" class="whatsapp-messages">
            @if($chat->messages->count() > 0)
                @php
                    $lastDate = null;
                @endphp
                @foreach($chat->messages as $message)
                    @php
                        $isOwnMessage = $message->user_id === auth()->id();
                        $senderName = $message->user ? $message->user->name : 'Unknown';
                        $currentDate = $message->created_at->format('Y-m-d');
                        $bgClass = $isOwnMessage ? 'message-sent' : 'message-received';
                        $alignment = $isOwnMessage ? 'message-aligned-right' : 'message-aligned-left';
                    @endphp

                    {{-- Date separator --}}
                    @if($currentDate !== $lastDate)
                        @php $lastDate = $currentDate; @endphp
                        <div class="date-separator">
                            <span>{{ $message->created_at->isToday() ? 'Today' : ($message->created_at->isYesterday() ? 'Yesterday' : $message->created_at->format('M d, Y')) }}</span>
                        </div>
                    @endif

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
                                @if(!$isOwnMessage)
                                    <div class="message-sender">{{ $senderName }}</div>
                                @endif
                                <div class="message-text">{{ $message->message }}</div>
                            @endif
                            <div class="message-time">
                                {{ $message->created_at->format('H:i') }}
                                @if($isOwnMessage)
                                    <span class="read-indicator">
                                        <i class="fas fa-check-double"></i>
                                    </span>
                                @endif
                            </div>
                            @if($isOwnMessage)
                            <div class="message-actions">
                                <button type="button" class="message-action-btn delete-message-btn" title="Delete" data-message-id="{{ $message->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-chat">
                    <i class="fas fa-comments"></i>
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endif
        </div>

        <!-- Message Input Form -->
        <div class="whatsapp-input-area">
            <form action="{{ route('seller.chats.store') }}" method="POST" class="d-flex align-items-center gap-2 w-100" id="chatForm" enctype="multipart/form-data">
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
    const messageInput = document.getElementById('messageInput');
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
                url: '/seller/chats/' + chatId + '/typing',
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
                    url: '/seller/chats/' + chatId + '/typing',
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
            url: '/seller/chats/' + chatId + '/typing',
            method: 'GET',
            success: function(response) {
                if (response.is_typing && response.typing_user && response.typing_user.id !== currentUserId) {
                    $('#typingIndicatorInline').show();
                } else {
                    $('#typingIndicatorInline').hide();
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
                url: '/seller/chats/' + chatId + '/upload',
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
                                <div class="message-time">
                                    ${new Date(response.message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                    <span class="read-indicator">
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
                    url: '/seller/chats/' + chatId + '/typing',
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

    // Submit form on Enter (for text only, not for file)
    $('#messageInput').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            const messageText = $(this).val().trim();
            const fileInput = $('#fileInput')[0];

            if (messageText || (fileInput && fileInput.files.length > 0)) {
                $(this).closest('form').submit();
            }
        }
    });

    // Focus input on load
    messageInput.focus();

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
                                const isOwnMessage = message.user_id === currentUserId;
                                const senderName = message.user ? message.user.name : 'Unknown';
                                const bgClass = isOwnMessage ? 'message-sent' : 'message-received';
                                const alignment = isOwnMessage ? 'message-aligned-right' : 'message-aligned-left';
                                const statusIcon = isOwnMessage ? '<i class="fas fa-check-double"></i>' : '';

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
                                    messageContent = `
                                        ${!isOwnMessage ? '<div class="message-sender">' + senderName + '</div>' : ''}
                                        <div class="message-text">${message.message}</div>
                                    `;
                                }

                                const messageHtml = `
                                    <div class="message ${bgClass} ${alignment}">
                                        <div class="message-content">
                                            ${messageContent}
                                            <div class="message-time">
                                                ${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                                ${statusIcon ? '<span class="read-indicator">' + statusIcon + '</span>' : ''}
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
                url: '/seller/chats/' + chatId + '/messages/' + messageId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        messageElement.fadeOut(300, function() {
                            $(this).remove();
                            // Adjust scroll if needed
                            if ($('#chat-messages .message').length === 0) {
                                $('#chat-messages').html('<div class="empty-chat"><i class="fas fa-comments"></i><p>No messages yet. Start the conversation!</p></div>');
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
