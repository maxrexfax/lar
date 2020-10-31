@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header center-text">{{ __('Messaging page') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            {{ __('List of users:') }}
                        @endif
                            <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                                <h3 class="center-text">Outgoing messages</h3>
                                <table border="1px" class="table">
                                    <thead>
                                        <tr>
                                            <th>Login</th>
                                            <th>Action</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($mesListOut as $mlo)
                                        <tr>
                                            <td>{{$mlo->login}}</td>
                                            <td><span class="btn btn-primary" data-toggle="modal" data-target="#modalID" onclick="editModalWindowOut({{$logineduser->id}}, {{$mlo->target_id}}, 'to {{$mlo->login}}', {{$logineduser->id}})">Message list</span></td>
                                            <td class="msg_quantity" data-target_id="{{$mlo->target_id}}" data-author_id="{{$logineduser->id}}"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                                <h3 class="center-text">Incoming messages</h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Login</th>
                                        <th>Action</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($mesListIn as $mli)
                                        <tr>
                                            <td>{{$mli->login}}</td>
                                            <td><span class="btn btn-primary" data-toggle="modal" data-target="#modalID" onclick="editModalWindowOut({{$logineduser->id}}, {{$mli->author_id}}, 'from {{$mli->login}}', {{$logineduser->id}})">Message list</span></td>
                                            <td class="msg_quantity" data-target_id="{{$logineduser->id}}" data-author_id="{{$mli->user_id}}"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive col-lg-3 col-md-4 col-sm-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>
                                            Choose user
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><select id="selectNewUser" name="selectNewUser">
                                                @foreach($users as $u)
                                                    @if($u->id!=$logineduser->id)
                                                    <option value="{{$u->id}}">{{$u->login}}</option>
                                                    @endif
                                                @endforeach
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><span class="btn btn-primary" data-toggle="modal" data-target="#modalID" onclick="prepareDataToWriteMessage({{$logineduser->id}})">Write new message</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                        <div id="main">
                            <div class="accord_body">
                                <div class="accord_header">
                                    <h2>ALL mesgs</h2>
                                </div>
                                <div class="accord_content">
                                    @foreach($messages as $message)
                                        The author <i>{{$message->author->login}}</i> wrotes to user <i>{{$message->recipient->login}}</i> message: <b> {{$message->text}}</b><br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalID" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="height: 90vh;">
                <div class="modal-header" style="height: 10vh;">
                    <h4 class="modal-title">Messages <span id="loginSpan"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" onclick="stopTimer()">&times;</button>
                </div>
                <div class="modal-body" style="height: 60vh; overflow: auto;" id="msgList">
                </div>
                <div class="modal-footer" style="height: 30vh;">
                    <textarea cols="2" class="form-control" id="textToSend" placeholder="Type message here..."></textarea>
                    <div style="width: 100%">
                        <span id="span_notification"></span>
                        <button class="glyphicon glyphicon-remove" data-dismiss="modal" title="Close dialog" onclick="stopTimer()"></button>
                        <button class="glyphicon glyphicon-refresh" title="Refresh dialog" onclick="reloadMessages()"></button>
                        <button class="glyphicon glyphicon-plus" title="Send message" onclick="sendNewMessage()"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function (){
            showMessagesQuantity();
        }
    </script>
@endsection
