<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', session('lang')?? app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="author" content="{{ $author ?? '' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link  >
{{--    @admin--}}

    @php
    $component= explode('::', $page['component']);
    @endphp
    @vite(['Modules/Admin/resources/assets/js/adminApp.js',"Modules/$component[0]/$component[1].vue"])
    @inertiaHead
</head>
<body >
@inertia
<x-main::trans/>
</body>

