@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header center-text">{{ __('List of all devices') }}</div>
                    <ol>
                        <li>First device</li>
                        <li>Second device</li>
                        <li>Third device</li>
                    </ol>
                    <span class="btn btn-primary" data-toggle="modal" data-target="#modalID">Connect device</span>
                    <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                        <h3 class="center-text">Outgoing messages</h3>
                        <table border="1px" class="table">
                            <thead>
                            <tr>
                                <th>Device</th>
                                <th>Users owners</th>
                                <th>Delete selected user</th>
                                <th>Add user for device</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($devices as $device)
                                <tr>
                                    <td>
                                        {{$device->device_id}} {{$device->device_name}}
                                    </td>
                                    <td>
                                    <select name="oneDeviceUsers" size="3">
                                        <option value="0" selected>...</option>
                                        @foreach($device->users as $devuser)
                                            <option value="{{$devuser->id}}">{{$devuser->login}}</option>
                                        @endforeach
                                    </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary" onclick="confirm('really?')">Delete</button>
                                    </td>
                                    <td>
                                        <select name="allUsersList" size="3">
                                            @foreach($users as $user)
                                                <option value="{{$user->id}};">{{$user->login}}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-secondary" onclick="confirm('really?')">Add</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    List of all users
                    <select name="allUsersList" size="3">
                    @foreach($users as $user)
                            <option value="{{$user->id}};">{{$user->login}}</option>
                    @endforeach
                    </select>
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

