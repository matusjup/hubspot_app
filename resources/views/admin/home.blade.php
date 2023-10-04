@section('page_title') Products @endsection

@extends('main')

@section('content')
    <div class="col py-3 bg-white">
        <home-page :api="`/api/admin/products`" :products="{{ $products }}"/>
    </div>
@endsection

