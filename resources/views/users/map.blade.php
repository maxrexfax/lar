@extends('layouts.app')
@section('content')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuuEunVyGucPGOXANU2-zrrmrh85WlyEQ"></script>
    <!--<script src='http://maps.googleapis.com/maps/api/js?sensor=false' type='text/javascript'></script>-->
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
