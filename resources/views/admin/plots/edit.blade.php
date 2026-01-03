@extends('admin.layouts.dashboard')
@section('title', ' Edit Property List')
@section('content')

    @include('admin.plots.form', ['property' => $plot])

@endsection
