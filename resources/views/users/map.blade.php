@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header center-text">{{ __('Cities in database') }}</div>
                    <div class="center-text form-map">
                        <p><i>Pointers on the map show city location</i></p>
                    </div>
                    <div id="map" class="div-for-map"></div>
                    <script>
                        window.onload = function (){
                            getAllCities();
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
