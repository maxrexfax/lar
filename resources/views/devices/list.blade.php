@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header center-text">{{ __('List of all your devices') }}</div>
                    <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                    <h3>List of devices:</h3>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Device name</th>
                            <th>Start usage</th>
                        </tr>
                        </thead>
                        <tbody>
                    @foreach($devices as $device)
                        <tr>
                        @foreach($device->users as $devuser)
                            @if($devuser->id==$logined_user['id'])
                                <td> {{$device->device_name}} for {{$devuser->login}} (id={{$devuser->id}};)</td>
                                <td>
                                    <form method="POST" action="{{route('devices.use')}}">
                                        <input type="hidden" name="id" id="id" value="{{$device->id}}">
                                        <input type="submit" class="btn btn-primary" value="Connect device">
                                    </form>
                                </td>
                            @endif
                        @endforeach
                        <br>
                    @endforeach
                        </tr>

                        </tbody>
                    </table>
                    </div>
                    <br>
                    <p>List of all users</p>
                    @foreach($users as $user)
                        {{$user->login}}-{{$user->device}}<br>
                    @endforeach
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

