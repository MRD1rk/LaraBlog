@extends('layouts.app')

@section('content')
    <div class="container">
        @if($item->exists)
            <form method="POST" action="{{ route('blog.admin.categories.update', $item->id) }}">
                @method('PATCH')
                @else
                    <form method="POST" action="{{ route('blog.admin.categories.store') }}">
                        @endif
                        @csrf

                        @include('layouts.alerts')
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                @include('blog.admin.categories.includes.item_edit_main_col')
                            </div>
                            <div class="col-md-4">
                                @include('blog.admin.categories.includes.item_edit_add_col')
                            </div>
                        </div>
                    </form>
    </div>
@endsection
