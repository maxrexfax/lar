@extends('layouts.app')
@if (!$errors->isEmpty())
    <div class="alert alert-danger center-text">
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header center-text">{{ __('Add city in database') }}</div>
                    <div class="card-body">

                    <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                        <h4 class="center-text">List of cities already in base</h4>
                        <div class="tableFixHead">
                            <table class="table table-with-city-list">
                                <thead>
                                <tr>
                                    <th>City name</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cities as $c)
                                    <tr>
                                        <td>{{$c->name}}</td>
                                        <td>{{$c->lat}}</td>
                                        <td>{{$c->lon}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="table-responsive col-lg-6 col-md-6 col-sm-12">
                        @if (session()->exists('success'))
                            <div class="alert alert-success center-text" role="alert">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        <h4 class="center-text">Add new city to database</h4>
                        <form class="form-create-city" method="POST" action="{{route('userslist.mapsave')}}">
                            @csrf
                            <input id="inp-city-name" class="form-control" name="name" placeholder="City name..." required>
                            <input id="inp-city-lat" class="form-control" name="lat" readonly required>
                            <input id="inp-city-lon" class="form-control" name="lon" readonly required>
                            <input id="inp-city-descr" class="form-control" name="description" placeholder="Post some description..." required>
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Create new city') }}
                            </button>
                        </form>
                    </div>
                    <div id="map-city" class="div-for-map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        window.onload = function (){
            showMapToChooseCity();
        }
    </script>

@endsection
