@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 px-4">
                <h3 class="text-center mt-3 mb-2 fw-bold">{{ $post->title }}</h3>
                <div class="post-categories mb-3">
                    @foreach ($categoryNames as $categoryName)
                        <span class="badge bg-primary">{{ $categoryName }}</span>
                    @endforeach
                </div>
                <div class="post-info mb-3">
                    <span class="fw-bold">{{ $userName }}</span> <i class="bi bi-arrow-right-circle-fill"></i>
                    @if ($post->created_at == $post->updated_at)
                        <span>created at: {{ $post->updated_at->diffForHumans() }}</span>
                    @else
                        <span>created at: {{ $post->created_at->diffForHumans() }}</span> |
                        <span>updated at: {{ $post->updated_at->diffForHumans() }}</span>
                    @endif
                </div>

                {{-- if create data is equal to edit dat => show only creaete date if not show all --}}
                <img src="{{ asset('storage/' . preg_replace('/^public\//', '', $post->image)) }}"
                    class="card-img-top image-fluid border border-1 rounded border-info mb-2"
                    style="width: 100%; height: 30rem; object-fit: cover" alt="Post Image">

                <p class="fs-5">{{ $post->content }}</p>
                <hr style="width: 30%; margin: 3rem auto;">

                <div class="comment container px-4">
                    <form action="{{ url('comments') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="userID" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="postId" value="{{ $post->id }}">
                            <label for="content">Comment:</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content" cols="30" rows="5">{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary my-3">Submit Comment</button>
                    </form>


                </div>

                <a class="my-3 py-5" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                    aria-controls="collapseExample" style="text-decoration: none">
                    Show comments <span class="fw-bold badge bg-secondary">{{ $post->comments->count() }}</span>
                </a>

                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <!-- Display comments -->
                        <div class="card p-3 mb-3">
                            @foreach ($post->comments as $comment)
                                <div class="comment-item mb-3 border-bottom">
                                    <div class="comment-header d-flex justify-content-between">
                                        <div>
                                            <span class="fw-bold">{{ $comment->user->name }}</span>
                                            <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if ($comment->user_id == Auth::user()->id)
                                            <!-- Button to trigger the dropdown menu -->
                                        <div class="btn-group dropup">
                                            <button type="button" class="badge bg-light" style="border:none;"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="flex items-center leading-none justify-center gap-xs">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="3" height="11"
                                                        viewBox="0 0 3 11" fill="none">
                                                        <circle cx="1.42593" cy="1.42593" r="1.42593"
                                                            fill="#1B363C" />
                                                        <circle cx="1.42593" cy="5.50002" r="1.42593"
                                                            fill="#1B363C" />
                                                        <circle cx="1.42593" cy="9.57406" r="1.42593"
                                                            fill="#1B363C" />
                                                    </svg>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu text-center">
                                                <li>
                                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#commentsEdit">Edit</a>

                                                </li>
                                                <div class="dropdown-divider"></div>
                                                <li>
                                                    <form action="{{ route('comments.destroy', $comment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item"
                                                            onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif

                                    </div>
                                    <p class="comment-content">{{ $comment->content }}</p>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="commentsEdit" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Comment</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('comments.update', $comment->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <textarea name="content" id="content" cols="30" rows="10"
                                                        class="form-control @error('content') is-invalid @enderror">{{ $comment->content }}</textarea>
                                                    @error('content')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 px-4 border-start border-1">
                <!-- Related News -->
                <h3 class="mb-5 mt-3 fw-bold text-cener">Related News</h3>
                <div class="row row-cols-1 row-cols-md-1 g-4 mt-1">
                    @foreach ($relatedPosts as $relatedPost)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . preg_replace('/^public\//', '', $relatedPost->image)) }}"
                                    class="card-img-top image-fluid" style="width: 100%; height: 10rem; object-fit: cover"
                                    alt="Related Post Image">
                                <div class="card-body">
                                    <a href="{{ url('posts/' . $relatedPost->id) }}" class=""
                                        style="text-decoration: none">
                                        <h5 class="card-title">{{ $relatedPost->title }}</h5>
                                    </a>

                                    <p class="card-text text-truncate">{{ $relatedPost->content }}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    @if ($relatedPost->user_id === Auth::user()->id)
                                        <small class="text-muted">{{ Auth::user()->name }} |
                                            {{ $relatedPost->updated_at->diffForHumans() }}</small>

                                        <div class="btn-group dropup">
                                            <button type="button" class="badge bg-light" style="border:none;"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="flex items-center leading-none justify-center gap-xs">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="3" height="11"
                                                        viewBox="0 0 3 11" fill="none">
                                                        <circle cx="1.42593" cy="1.42593" r="1.42593"
                                                            fill="#1B363C" />
                                                        <circle cx="1.42593" cy="5.50002" r="1.42593"
                                                            fill="#1B363C" />
                                                        <circle cx="1.42593" cy="9.57406" r="1.42593"
                                                            fill="#1B363C" />
                                                    </svg>
                                                </div>
                                            </button>
                                            <form action="{{ url('posts/' . $relatedPost->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <ul class="dropdown-menu text-center">
                                                    <li><a class="dropdown-item"
                                                            href="{{ url('posts/' . $relatedPost->id . '/edit') }}">Edit</a>
                                                    </li>
                                                    <div class="dropdown-divider"></div>
                                                    <li>
                                                        <button type="submit" class="dropdown-item"
                                                            onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    @else
                                        <small class="text-muted">{{ $relatedPost->user->name }} |
                                            {{ $relatedPost->updated_at->diffForHumans() }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
