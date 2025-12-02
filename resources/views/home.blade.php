@extends('layouts.app')

@section('title', 'Repositories - RepoScope')

@section('content')
    <div class="bg-slate-950 text-slate-100 h-screen overflow-hidden">
        @include('_partials.header')
        <main class="max-w-[1800px] mx-auto px-8 py-6 h-full">
            @include('_partials.filters')
            <rs-dashboard :repositories='@json($repositories)'></rs-dashboard>
        </main>
    </div>
@endsection
