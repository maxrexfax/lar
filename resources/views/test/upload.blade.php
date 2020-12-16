@extends('layouts.app')
{{test()}}
@section('content')
    <p class="col-12 col-md-2">Тестирую получение данных из файла переводов: {{__('messages.welcome')}}</p>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data">
                    @csrf
                    Select image to upload:
                    <input type="file" name="file" id="file">
                    <input type="text" name="texttest" placeholder="123..." value="123">
                    <input type="submit" value="Upload Image" name="submit">
                </form>
                <div class="card">
                    <div class="card-body">
                        @if (!empty($file))
                            File name = {{$file}}
                        @else
                            <p>Empty variable $file!</p>
                        @endif

                        @if (!empty($info))
                                $info =  {{($info)}}
                        @else
                            <p>Empty variable $info!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


