<style>
    /* Chat button style */
    .chat-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 25px;
        font-size: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 999;
    }

    .chat-button:hover {
        background-color: #0056b3;
    }

    /* Chat container style */
    .chat-container {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 300px;
        max-height: 80%;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        display: none;
        z-index: 1000;
    }

    .chat-header {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        font-weight: bold;
        position: relative;
    }

    .chat-header .close-chat {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: #ccc;
        font-size: 18px;
    }

    .chat-body {
        max-height: 400px;
        overflow-y: auto;
        padding: 20px;
    }

    .message {
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 5px;
        max-width: 80%;
    }

    .sender-message {
        background-color: #007bff;
        color: #fff;
        align-self: flex-end;
    }

    .receiver-message {
        background-color: #f0f0f0;
        color: #333;
    }

    .chat-footer {
        padding: 10px;
        border-top: 1px solid #ccc;
        display: flex;
        align-items: center;
    }

    .chat-footer input[type="text"] {
        flex: 1;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        margin-right: 10px;
    }

    .chat-footer button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
    }

    .chat-footer button:hover {
        background-color: #0056b3;
    }

    .chat-button .unread-indicator {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        font-size: 12px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 600px) {
        .chat-container {
            width: 100%;
            max-width: 100%;
            bottom: 0;
            left: 0;
            border-radius: 0;
        }
    }
</style>

<button class="chat-button" onclick="toggleChat()">Chat with us <div class="unread-indicator" id="unreadIndicator"
        style="display: none;">0</div>
</button>
<div id="chatContainer" class="chat-container">
    <div class="chat-header">
        Chat with Support
        <span class="close-chat" onclick="toggleChat()">×</span>
    </div>
    <div class="chat-body" id="chatBody">
        <!-- Messages will be appended dynamically here -->
    </div>
    <div class="chat-footer">
        <!-- Chat input area and send button -->
        <input type="text" id="chatMessage" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
    </div>



</div>

@push('scripts')
    <script>
        function generateGuestId() {
            return new Date().getTime().toString();
        }

        function storeGuestId(guestId) {
            localStorage.setItem('guestId', guestId);
        }

        function getGuestId() {
            return localStorage.getItem('guestId');
        }

        function hasGuestId() {
            return localStorage.getItem('guestId') !== null;
        }

        function toggleChat() {
            var chatContainer = $('#chatContainer');
            chatContainer.slideToggle(function() {
                if (chatContainer.is(':visible')) {

                    fetchMessages();
                    clearUnreadIndicator();
                    markMessagesAsRead();
                }
            });
        }


        function fetchMessages() {
            var guestId = getGuestId();

            $.ajax({
                url: '{{ route('chat.index') }}',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    guest_id: guestId
                },
                success: function(response) {
                    var messages = response.messages;
                    var chatBody = $('#chatBody');
                    chatBody.empty();
                    messages.forEach(function(message) {
                        var messageClass = message.message_type === 'sent' ? 'sender-message' :
                            'receiver-message';
                        var newMessage = '<div class="message ' + messageClass + '">' + message
                            .message + '</div>';
                        chatBody.append(newMessage);
                    });
                    scrollToBottom(chatBody);

                    if ($('#chatContainer').is(':visible')) {
                        markMessagesAsRead();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching messages:', error);
                }
            });
        }

        function scrollToBottom(element) {
            element.scrollTop(element[0].scrollHeight);
        }

        function sendMessage() {

            var messageInput = $('#chatMessage');
            var message = messageInput.val().trim();

            if (message !== '') {
                var guestId = getGuestId();
                if (!guestId) {
                    guestId = generateGuestId();
                    storeGuestId(guestId);
                }

                $.ajax({
                    url: '{{ route('chat.store') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        guest_id: guestId,
                        message: message
                    },
                    success: function(response) {
                        messageInput.val('');
                        var chatBody = $('#chatBody');
                        var messageClass = 'sender-message';
                        var newMessage = '<div class="message ' + messageClass + '">' + message + '</div>';
                        chatBody.append(newMessage);
                        messageInput.val('');
                        scrollToBottom(chatBody);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending message:', error);
                    }
                });
            }
        }

        function checkForNewMessages() {

            var guestId = getGuestId();
            $.ajax({
                url: '{{ route('chat.index') }}',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    guest_id: guestId
                },
                success: function(response) {
                    var messages = response.messages;
                    var unreadCount = 0;
                    messages.forEach(function(message) {
                        if (message.message_type === 'received' && !message.read) {
                            unreadCount++;
                        }
                    });
                    updateUnreadIndicator(unreadCount);

                    if ($('#chatContainer').is(':visible')) {
                        markMessagesAsRead();
                        fetchMessages();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking for new messages:', error);
                }
            });
        }

        function updateUnreadIndicator(count) {

           
            var unreadIndicator = $('#unreadIndicator');
            if (count > 0 && !$('#chatContainer').is(':visible')) {
                unreadIndicator.text(count);
                unreadIndicator.show();
            } else {
                unreadIndicator.hide();
            }
        }

        function clearUnreadIndicator() {
            $('#unreadIndicator').hide();
        }

        function markMessagesAsRead() {
            var guestId = getGuestId();

            $.ajax({
                url: '{{ route('chat.markRead') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    guest_id: guestId
                },
                success: function(response) {
                    console.log('Messages marked as read');
                },
                error: function(xhr, status, error) {
                    console.error('Error marking messages as read:', error);
                }
            });
        }

        $(document).ready(function() {
            if (!hasGuestId()) {
                var guestId = generateGuestId();
                storeGuestId(guestId);
            }

            setInterval(checkForNewMessages, 1000);
        });
    </script>
@endpush
