@extends('layouts.app')
{{test()}}
@section('content')
    <p class="col-12 col-md-2">Тестирую получение данных из файла переводов: {{__('messages.welcome')}}</p>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            {{ __('List of users:') }}
                        @endif
                        <div class="div-for-form-search">
                            <div style="overflow-x:auto;">
                                <table class="table table-hover table stripped table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Login<br><i>Last logined date</i></th>
                                        <th scope="col">Name<br><i>Last logined ip</i></th>
                                        <th scope="col">Email<br><i>Last logined city</i></th>
                                        <th scope="col">Is eaten</th>
                                        <th scope="col">City</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td scope="col">{{$user->id}}</td>
                                            <td scope="col">{{$user->login}}<br><i>{{$user->last_logined_date}}</i></td>
                                            <td scope="col">{{$user->first_name}}<br>{{$user->last_logined_ip}}</td>
                                            <td scope="col">{{$user->email}}<br>{{$user->last_logined_city}}</td>
                                            <td scope="col">
                                                @if($user->is_eaten==1)
                                                    <span class="badge badge-danger">Infected</span>
                                                @else
                                                    <span class="badge badge-success">Healthy</span>
                                                @endif
                                            </td>
                                            <td scope="col">{{$user->city->name}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="center-text">
                                {{$users->render()}}
                            </div>
                            <div class="center-text">
                                @if(isset($message))
                                    {{$message}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


