@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header center-text">
                            {{ __('List of all users') }}
                    </div>
                            <form method="GET" action="{{route('userslist')}}" style="margin: 5px 0;">
                                <div class="flex-class width-300 margin-els float-right">
                                <input value="{{$quantity}}" type="number" name="paginQuant" id="paginQuant" class="margin-els" size="5" placeholder="15">
                                <button type="submit" class="btn btn-primary btn-block margin-els">Users on the page</button>
                                </div>
                            </form>
                    <br>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            {{ __('List of users:') }}
                        @endif
                    <div class="for-div-table">
                        <form method="GET" action="{{route('userslist.filter')}}" style="margin-bottom: 5px;">
                        <div style="display: flex;">
                            <a href="{{route('userslist')}}" class="btn btn-primary btn-block">Reset filter</a>
                            <input type="text" class="form-control miniwidth margin-els" id="namesearch" name="namesearch" placeholder="Search by name...">
                            <input value="" type="text" class="form-control miniwidth margin-els" id="loginsearch" name="loginsearch" placeholder="Search by login...">
                            <input value="" type="text" class="form-control miniwidth margin-els" id="emailsearch" name="emailsearch" placeholder="Search by email...">
                            <select name="citiessearch" id="citiessearch" class="margin-els">
                                <option value="0" selected>Not set</option>
                                @foreach($cities as $city)
                                <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-block miniwidth margin-els"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                        </form>
                        <table class="table table-hover table stripped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Login<br><i>Last logined date</i></th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Is eaten</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Mark</th>
                                    <th scope="col">Buttons</th>
                                </tr>
                            </thead>
                            <tbody>
                           @foreach($users as $user)
                                <tr>
                                    <td scope="col">{{$user->id}}</td>
                                    <td scope="col">{{$user->login}}<br><i>{{$user->last_logined_date}}</i></td>
                                    <td scope="col">{{$user->first_name}}</td>
                                    <td scope="col">{{$user->email}}</td>
                                    <td scope="col">
                                        @if($user->is_eaten==1)
                                            <span class="badge badge-danger">Infected</span>
                                        @else
                                            <span class="badge badge-success">Healthy</span>
                                        @endif
                                    </td>
                                    <td scope="col">{{$user->city->name}}</td>
                                    <td scope="col">
                                        <button type="submit" class="btn btn-secondary btn-block btn-sm" id="{{$user->id}}" onclick="MarkUser(id)">
                                            @if($user->is_eaten)
                                            Unmark?
                                            @else
                                                <span style="color: red; font-weight: bold;">Mark infected</span>
                                            @endif
                                        </button>
                                    </td>
                                    <td>@if($user->id!=Auth::user()->id)
                                        <a href="{{route('messages')}}" target="_blank" title="Write message"><span class="glyphicon glyphicon-envelope"></span></a>
                                        @endif
                                        <a href="{{route('userslist.show', ['id' => $user->id])}}" title="View"><span class="glyphicon glyphicon-eye-open"></span></a>
                                        <a href="{{route('userslist.edit', ['id' => $user->id])}}" title="Update"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="{{route('userslist.destroy', ['id' => $user->id])}}" title="Delete" onclick="confirm('Really delete?')"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="center-text">
                        {{$users->appends(['paginQuant' => $quantity])->render()}}
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
