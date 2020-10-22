@extends('layouts.app')
@section('content')
    <div class="center-text">
        <h2 class="h2">Cities in database</h2>
        <p><i>Center view:</i></p>
        <form>
            <div class="form-group">
                <label for="latcoord">Latitude</label>
                <input type="text" id="latcoord" name="latcoord" value="47.871633">
            </div>
            <div class="form-group">
                <label for="longcoord">Longtitude</label>
                <input type="text" id="longcoord" name="longcoord" value="35.053650">
            </div>
        </form>
        <button class="btn btn-secondary btn-block" onclick="getAllCities()">Show cities</button>
    </div>

    <div style="padding: 0 20px;">
        <div>
            <div id="map" style="width: 100%; height: 600px; background-color:lightgray;"></div>
        </div>
    </div>

@endsection
