@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-center">Explore</h3>

        <!-- Search form -->
        <form action="{{ route('index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search posts...">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Display posts -->
        @foreach ($posts as $post)
            <div class="card mb-4">
                <!-- Display post details here -->
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Read More</a>
                </div>
            </div>
        @endforeach

        <!-- Pagination links -->
        {{ $posts->links() }}

    </div>
@endsection
