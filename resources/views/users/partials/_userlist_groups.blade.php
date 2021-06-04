<!-- Тестовое создание селекта с группировкой юзеров по городам -->
<?php $counter = 0 ?>
<select>
@foreach($cities as $city)
        <optgroup label="{{ $city->name }}">
        @foreach($users as $user)
            @if($user->city_id === $city->id)
                <option value="{{$counter++}}">{{$user->login}}</option>
                @endif
        @endforeach
        </optgroup>
@endforeach
</select>
