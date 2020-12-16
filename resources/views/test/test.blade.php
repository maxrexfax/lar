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
                            {{ __('Test view file:') }}
                        @endif
                        <div class="filer-inputs">
                            @foreach($images as $image)
                                <div style="max-width: 230px; width: 100%;">
                                    <span>Title for image</span>
                                    <img width="225px" height="225px" src="{{$image->getPathname()}}">
                                </div>
                            @endforeach
                            @foreach($images as $file)
                                {{asset($file)}}<br>
                            @endforeach
                        </div>
                        <a href="{{asset('storage/file.txt')}}">Url to file</a>
                        <a href="{{asset('download/file.txt')}}">Test Url to file</a>
                            <div class="center-text">
                                @if(isset($message))
                                    {{$message}}
                                @endif
                            </div>
                        @if(!empty($allFiles))
                            @foreach($allFiles as $file)
                                <a href="{{url('/').'/'.$file}}">{{$file}}</a><br>
                                @endforeach
                            @foreach($allFiles as $file)
                            {{asset($file)}}<br>
                                @endforeach
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


