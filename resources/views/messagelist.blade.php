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
                        <p>---------------Debug all messages START---------------</p>
                            @foreach($messages as $message)
                                The author <i>{{$message->author->login}}</i> wrotes to user <i>{{$message->recipient->login}}</i> message: <b> {{$message->text}}</b><br>
                            @endforeach
                            <p>--------------Debug all messages END---------------</p>
                            <br>
                            <h3>Outgoing messages</h3>
                            <div class="table-responsive">
                                <table class="table table-hover table stripped table-bordered">
                                    <tr>
                                        <th>Author name</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                    @foreach($messagesOutgoing as $mo)
                                        <tr>
                                            <td>{{$mo->login}}</td>
                                            <td style="overflow: hidden;">{{$mo->text}}</td>
                                            <td>{{$mo->message_date}}</td>
                                        </tr>
                                        You sent a letter to <i>{{$mo->login}}</i>: <b> {{$mo->text}}</b><br>
                                    @endforeach
                                </table>
                            </div>
                            <br>
                            <h3>Incoming messages</h3>
                            <div class="table-responsive">
                                <table class="table table-hover table stripped table-bordered">
                                    <tr>
                                        <th>Author name</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                    @foreach($messagesIncoming as $mi)
                                        <tr>
                                            <td>{{$mi->login}}</td>
                                            <td style="overflow: hidden;">{{$mi->text}}</td>
                                            <td>{{$mi->message_date}}</td>
                                        </tr>
                                        You recieved a letter from <i>{{$mi->login}}</i>: <b> {{$mi->text}}</b><br>
                                    @endforeach
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
