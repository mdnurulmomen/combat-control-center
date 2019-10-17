@extends('errors.illustrated-layout')

{{-- 
@section('code', $exceptionStatus)
@section('title', $exceptionMessage) 
--}}

@section('image')
    <div style="background-image: url({{ asset('assets/admin/svg/5.jpg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', 'Sorry, looks like something went wrong')
