@extends('layout.index')

@section('content')

    <div id ='app'>
        @include('components.searchbar')
        @include('components.error_alert')
        @include('components.advanced_search')
    </div>
@endsection
