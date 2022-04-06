@extends('layouts.app')

@section('content')

    <div class="container">
        @if($item->exists)
            <form method="POST" action="{{ route('blog.admin.posts.update', $item->id) }}">
                @method('PATCH')
                @else
                    <form method="POST" action="{{ route('blog.admin.posts.store') }}">
                        @endif
                        @csrf

                        @include('layouts.alerts')
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                @include('blog.admin.posts.includes.item_edit_main_col')
                            </div>
                            <div class="col-md-4">
                                @include('blog.admin.posts.includes.item_edit_add_col')
                            </div>
                        </div>
                    </form>
            @if($item->exists)
                <br>
                <form method="POST" action="{{ route('blog.admin.posts.destroy', $item->id) }}">
                    @method('DELETE')
                    @csrf
                    <div class="row justiny-content-center">
                        <div class="col-md-8">
                            <div class="card card-block">
                                <div class="card-body ml-auto">
                                    <button class="btn btn-link">Удалить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
    </div>
@endsection
