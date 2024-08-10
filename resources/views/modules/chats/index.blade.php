@extends('dashboard.layouts.app')

@section('content')
    <div class="app-content main-content">
        <div class="side-app">
            @include('dashboard.layouts.header')

            <div class="page-header d-xl-flex d-block">
                <div class="page-leftheader">
                    <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Chat</span></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card overflow-hidden">
                        <div class="tile tile-alt mb-0 border-0" id="messages-main">
                            <div class="ms-menu">

                                <div class="tab-content">
                                    <div class="rounded-0 p-0 border-0 border-top">
                                        <ul class="list-group lg-alt chat-conatct-list rounded-0" id="ChatList">


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-body">

                                <div class="chat-body-style ps" id="ChatBody">
                                    <!-- Chat messages will be appended here -->
                                </div>
                                <div class="msb-reply">
                                    <textarea placeholder="What's on your mind..." id="adminChatMessage"></textarea>
                                    <button onclick="sendAdminMessage()"><span class="fe fe-send"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var selectedGuestId = null;

        function fetchChatList() {
            $.ajax({
                url: '{{ route('admin.chat.list') }}',
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    var chatList = $('#ChatList');
                    chatList.empty();
                    response.guests.forEach(function(guest) {
                        var chatListItem =
                            '<li class="list-group-item d-flex p-3 mt-0 rounded-0 border-top border-bottom" onclick="selectChat(\'' +
                            guest.guest_id + '\')">' +
                            '<a href="javascript:void(0);">' +
                            '<div class="float-start pe-2 flex-shrink-0">' +
                            '<span class="avatar avatar-md online avatar-rounded" style="background-color:white !important;">' +
                            '<img src="{{ asset('dashboard-assets/assets/images/chat.png') }}" class="rounded-circle" alt="img"></span></div>' +
                            '<div class="d-table-cell">' +
                            '<div class="list-group-item-heading fw-semibold">' + guest.guest_id +
                            '</div>' +
                            '<small class="list-group-item-text text-muted">' + guest.last_message +
                            '</small></div>' +
                            '<span class="chat-time text-muted"> ' + guest.created_at_human +
                            ' </span></a></li>';

                        $('#ChatList').append(chatListItem);


                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching chat list:', error);
                }
            });
        }

        function selectChat(guestId) {
            selectedGuestId = guestId;

            $.ajax({
                url: '{{ route('admin.chat.messages') }}',
                type: 'GET',
                data: {
                    guest_id: guestId
                },
                success: function(response) {
                    var chatUserInfo = $('#chatUserInfo');
                    chatUserInfo.html(
                        '<img src="{{ asset('dashboard-assets/assets/images/chat.png') }}" alt="" class="avatar avatar-lg avatar-rounded me-2">' +
                        '<div class="align-items-center mt-2">' +
                        '<div class="fw-semibold">Guest ' + guestId +
                        '</div> <span class="w-2 h-2 bg-success d-inline-block me-1 rounded"></span><small>active</small>' +
                        '</div>');

                    var chatBody = $('#ChatBody');
                    chatBody.empty();
                    response.messages.forEach(function(message) {
                        var messageClass = message.message_type === 'received' ? 'message-feed right' :
                            'message-feed d-flex';
                        var messageContent = '<div class="' + messageClass +
                            '"><div class="float-start pe-2 flex-shrink-0"> </div><div class=""><div class="mf-content">' +
                            message.message +
                            '</div><small class="mf-date d-block"><i class="fe fe-clock"></i> ' +
                            message.created_at_human + '</small></div></div>';
                        chatBody.append(messageContent);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching chat messages:', error);
                }
            });
        }

        function sendAdminMessage() {
            var messageInput = $('#adminChatMessage');
            var message = messageInput.val().trim();

            if (message !== '' && selectedGuestId) {
                $.ajax({
                    url: '{{ route('admin.chat.store') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        guest_id: selectedGuestId,
                        message: message
                    },
                    success: function(response) {
                        var chatBody = $('#ChatBody');
                        var messageContent =
                            '<div class="message-feed right"><div class="float-end ps-2"></div><div class="media-body"><div class="mf-content">' +
                            message +
                            '</div><small class="mf-date"><i class="fe fe-clock"></i> just now</small></div></div>';
                        chatBody.append(messageContent);
                        messageInput.val('');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending message:', error);
                    }
                });
            }
        }

        $(document).ready(function() {
            fetchChatList();
        });
    </script>
@endpush
