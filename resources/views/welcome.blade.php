@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center">Update News</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-1 mb-5">
        @foreach ($latestPosts as $post)
            <div class="col-md-4">
                <div class="card d-flex flex-fill">
                    <img src="{{ asset('storage/' . preg_replace('/^public\//', '', $post->image)) }}" class="card-img-top"
                        alt="Post Image" style="height: 7rem; object-fit:cover">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($post->content, 100) }}</p>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary mt-auto">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div> <hr style="width: 50%" class="d-block mx-auto">

    <!-- Category List -->
    <h3 class="text-center mt-4">Topics</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-1 mb-5">
        @foreach ($categories as $category)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="{{ $category->icon }}"></i> {{ $category->name }}
                        </h5>
                        <p class="card-text">{{ $category->description }}</p>
                        <a href="{{ route('index', ['category_id' => $category->id]) }}" class="btn btn-primary">Explore</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
