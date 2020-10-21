@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('All messages page') }}</div>
                    <br>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            {{ __('List of users:') }}
                        @endif
                            <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                                <h3 class="center-text">Outgoing messages</h3>
                                <table border="1px" class="table table-hover table stripped" style="margin-top: 13px;">
                                    <thead>
                                        <tr>
                                            <th>Login</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($mesListOut as $mlo)
                                        <tr>
                                            <td>{{$mlo->login}}</td>
                                            <td><span class="btn btn-primary" data-toggle="modal" data-target="#modalID" onclick="editModalWindowOut({{$logineduser->id}}, {{$mlo->target_id}}, 'to {{$mlo->login}}', {{$logineduser->id}})">Message list</span></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                                <h3 class="center-text">Incoming messages</h3>
                                <table class="table table-hover table stripped">
                                    <thead>
                                    <tr>
                                        <th>Login</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($mesListIn as $mli)
                                        <tr>
                                            <td>{{$mli->login}}</td>
                                            <td><span class="btn btn-primary" data-toggle="modal" data-target="#modalID" onclick="editModalWindowOut({{$logineduser->id}}, {{$mli->author_id}}, 'from {{$mli->login}}', {{$logineduser->id}})">Message list</span></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                                <h3 class="center-text">Choose user and write message</h3>
                                <table class="table table-hover table stripped">
                                    <tr>
                                        <td><select id="selectNewUser" name="selectNewUser">
                                                @foreach($users as $u)
                                                    @if($u->id!=$logineduser->id)
                                                    <option value="{{$u->id}}">{{$u->login}}</option>
                                                    @endif
                                                @endforeach
                                            </select></td>
                                        <td><span class="btn btn-primary" data-toggle="modal" data-target="#modalID" onclick="prepareDataToWriteMessage({{$logineduser->id}})">Write new message</span></td>
                                    </tr>

                                </table>
                            </div>
                    </div>
                    <div id="main">
                        <div class="accord_body">
                            <div class="accord_header">
                                <h2>List of ALL messages (for debug)</h2>
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
@endsection
