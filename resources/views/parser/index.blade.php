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
                        <form method="POST" action="{{ route('parser.parse') }}">
                            @csrf
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Databases</th>
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
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label for="format">File format:</label>
                                <select class="form-control" name="format">
                                    @foreach($availableFormats as $format)
                                        <option value="{{ $format }}">{{ $format }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Parse</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
