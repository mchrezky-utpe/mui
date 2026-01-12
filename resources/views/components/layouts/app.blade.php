@extends('template.main') @section("extra-css") {{-- sweetalert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.2/dist/sweetalert2.all.min.js"></script>
<link
    href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.22.2/dist/sweetalert2.min.css"
    rel="stylesheet"
/>
@vite(['resources/css/app.css', 'resources/js/app.js']) @livewireStyles
@endsection @section('content') {{ $slot }} @endsection
@section('extra-content') <x-toast-notif /> @endsection
