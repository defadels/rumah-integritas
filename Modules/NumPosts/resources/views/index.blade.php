@extends('numposts::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('numposts.name') !!}</p>
@endsection
