@extends('template.main') @section("extra-css") @vite(['resources/css/app.css',
'resources/js/app.js']) @livewireStyles @endsection @section('content')
{{ $slot }} @endsection
