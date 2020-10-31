@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header center-text">{{ __('List of all users') }}
                        <form method="GET" action="{{route('userslist')}}" id="form-pagin-quantity" class="float-right">
                            <div class="div-set-paginatin-quantity">
                                <input value="{{$quantity}}" type="number" name="paginationQuantity" id="paginationQuantity" class="input-for-pagination-quantity" placeholder="15">
                                <button type="submit" class="btn btn-primary set-horisontal-margin-3">Users per page</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            {{ __('List of users:') }}
                        @endif
                    <div class="div-for-form-search">
                        <form method="GET" action="{{route('userslist.filter')}}">
                        <div id="filer-inputs" class="filer-inputs">
                            <a href="{{route('userslist')}}" id="btn-reset" class="btn btn-primary btn-reset-filter-search">Reset filter</a>
                            <input type="text" class="form-control input-search-filter-users" id="namesearch" name="namesearch" placeholder="Search by name...">
                            <input value="" type="text" class="form-control input-search-filter-users" id="loginsearch" name="loginsearch" placeholder="Search by login...">
                            <input value="" type="text" class="form-control input-search-filter-users" id="emailsearch" name="emailsearch" placeholder="Search by email...">
                            <select name="citiessearch" id="citiessearch" class="input-search-filter-users">
                                <option value="0" selected>Not set</option>
                                @foreach($cities as $city)
                                <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary max-width-button-search-filter"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                        </form>
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
                                    <th scope="col">Mark</th>
                                    <th scope="col">&nbsp;Buttons&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
                                        @if($user->id!=Auth::user()->id)
                                        <a href="{{route('userslist.destroy', ['id' => $user->id])}}" title="Delete" onclick="confirm('Really delete?')"><span class="glyphicon glyphicon-trash"></span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                        <div class="center-text">
                        {{$users->appends(['paginationQuantity' => $quantity])->render()}}
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
