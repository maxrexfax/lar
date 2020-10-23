@extends('layouts.app')
@section('content')
<div class="center-text form-map">
    <h2 class="h2">Cities in database</h2>
    <p><i>Pointers on the map show cities with users</i></p>
</div>
<div id="map"></div>
<script>
    window.onload = function (){
        getAllCities();
    }
</script>
@endsection
