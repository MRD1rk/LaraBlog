@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faced">
                </nav>
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                        @foreach($availableFormats as $format)
                                            <li class="nav-item @if($format === $type) active @endif">
                                                <a class="nav-link" href="{{ route('parser.parsed', $format) }}">{{ $format }} <span class="sr-only">(current)</span></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <form method="POST" action="{{ route('parser.union') }}">
                            @csrf
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Files</th>
                                    <th>Download</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($files as $index => $file)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input value="{{ $file->getFilename() }}" id="selected_{{$index}}" name="selected[{{$index}}]" class="form-check-input" type="checkbox">
                                                <label for="selected_{{$index}}" class="form-check-label">{{ $file->getFilename() }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('parser.download', [$type, basename($file)]) }}" class="btn btn-link">Download</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <input type="hidden" name="type" value="{{ $type }}">
                                <button type="submit" class="btn btn-primary">Union</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
