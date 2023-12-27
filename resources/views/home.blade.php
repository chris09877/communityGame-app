
@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="w-3/4 mx-auto">
    @if(session('success'))
    <div  id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="flex items-center justify-between mb-4">
        <button onclick="window.location='{{ route('post.create') }}'" style="float: right;"
            class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded border">CREATE POST</button>
        {{-- Uncommented card-header div --}}
        {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}
    </div>

    <div class="w-3/4">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        @if ($allPosts->isEmpty())
        <h1 class="subtitle mb-4 text-xl font-bold leading-none tracking-tight text-gray-700 md:text-2xl lg:text-3xl">No Posts Available</h1>
        @else
        <h1 class="text-2xl font-bold mb-4">Latest Posts</h1>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            @foreach($allPosts as $post)
            <a href="{{ route('post.show', $post->id) }}" class="hover:no-underline">
                <div class="rounded-xl overflow-hidden hover:cursor-pointer px-2 py-1 flex flex-col gap-2">
                    <div>
                        {{-- Code for image --}}
                        <img src="{{ $post->{'images/videos'} }}" alt="Post Image" class="w-full h-60 object-cover">
                    </div>
                    <div class="rounded-b-xl border-2 border-t-0 p-4 flex flex-col gap-2">
                        <h2 class="text-2xl font-bold">{{ $post->title }}</h2>
                        <p>{{ $post->content }}</p>
                        <p>{{ $post->created_at }}</p>
                    </div>
                </div>
            </a>
            <br>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
<script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
        }, 2000); // 2000 milliseconds = 2 seconds
    });
</script>