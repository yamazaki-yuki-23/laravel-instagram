@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="infinite-scroll">
            <search-button></search-button>
            @isset($items)
                {{ $items->links() }}
            @endisset
        </div>
    </div>



@endsection