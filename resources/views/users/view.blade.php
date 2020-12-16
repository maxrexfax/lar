@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('View user data') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('userslist.edit', ['id' => $user->id])}}">
                            @csrf
                            <div class="form-group row">
                                <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Login') }}</label>

                                <div class="col-md-6">
                                    <input readonly value="{{$user->login}}" id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" placeholder="Empty field">

                                    @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role_id" class="col-md-4 col-form-label text-md-right">{{ __('Role name') }}</label>

                                <div class="col-md-6">
                                    <span class="form-control">
                                        @foreach($roles as $role)
                                            @if($user->role_id==$role->id)
                                                {{$role->roles}}
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First name') }}</label>

                                <div class="col-md-6">
                                    <input readonly value="{{$user->first_name}}" id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Empty field">

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="middle_name" class="col-md-4 col-form-label text-md-right">{{ __('Middle name') }}</label>

                                <div class="col-md-6">
                                    <input readonly value="{{$user->middle_name}}" id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" placeholder="Empty field">

                                    @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>

                                <div class="col-md-6">
                                    <input readonly value="{{$user->last_name}}" id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Empty field">

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('Birthday') }}</label>

                                <div class="col-md-6">
                                    <input readonly value="{{$user->birthday}}" id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" placeholder="Empty field">

                                    @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input readonly value="{{$user->email}}" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required placeholder="Empty field">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                <div class="col-md-6">
                                    <input readonly value="{{$user->phone_number}}" id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="Empty field">

                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="city_id" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                <div class="col-md-6">
                                    <span class="form-control">
                                        @foreach($cities as $city)
                                            @if($user->city_id==$city->id)
                                                {{$city->name}}
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="is_eaten" class="col-md-4 col-form-label text-md-right">{{ __('Is infected') }}</label>

                                <div class="col-md-6">
                                    <span class="form-control">
                                        @if($user->is_eaten==0)
                                            Healthy
                                        @else
                                            Infected
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Edit this user data') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if(isset($message))
                        {{$message}}
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
