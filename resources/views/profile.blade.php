@extends('layouts.app')

@section('content')
    <div class="container hero">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="profile text-center">
                    @auth
                        <a href="" data-category-id="{{ Auth::user()->id }}" data-category-image="{{ Auth::user()->image }}"
                            data-bs-toggle="modal" data-bs-target="#editCategoryModal_{{ Auth::user()->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 76 76"
                                fill="none">
                                <circle cx="38" cy="38" r="33" fill="#417682" stroke="#CDE3E8"
                                    stroke-width="10" />
                                <path
                                    d="M38 36C36.374 36 35 37.374 35 39C35 40.626 36.374 42 38 42C39.626 42 41 40.626 41 39C41 37.374 39.626 36 38 36Z"
                                    fill="#92FCFC" />
                                <path
                                    d="M46 32H43.414L40.707 29.293C40.6143 29.2 40.5041 29.1262 40.3828 29.0759C40.2614 29.0256 40.1313 28.9998 40 29H36C35.8687 28.9998 35.7386 29.0256 35.6172 29.0759C35.4959 29.1262 35.3857 29.2 35.293 29.293L32.586 32H30C28.897 32 28 32.897 28 34V45C28 46.103 28.897 47 30 47H46C47.103 47 48 46.103 48 45V34C48 32.897 47.103 32 46 32ZM38 44C35.29 44 33 41.71 33 39C33 36.29 35.29 34 38 34C40.71 34 43 36.29 43 39C43 41.71 40.71 44 38 44Z"
                                    fill="#92FCFC" />
                            </svg>
                        </a>
                    @endauth

                    <!-- Modal for Editing User Profile -->
                    <div class="modal fade" id="editCategoryModal_{{ Auth::user()->id }}" tabindex="-1"
                        aria-labelledby="editCategoryModalLabel_{{ Auth::user()->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCategoryModalLabel_{{ Auth::user()->id }}">Upload
                                        Profile Picture</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="editCategoryForm_{{ Auth::user()->id }}"
                                    action="{{ route('updateProfileImage', ['user' => Auth::user()]) }}" method="POST"
                                    enctype="multipart/form-data"> <!-- Add enctype for file uploads -->
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="categoryName_{{ Auth::user()->id }}" class="form-label">Profile
                                                Picture</label>
                                            <input type="file" class="form-control"
                                                id="categoryName_{{ Auth::user()->id }}" name="image">
                                        </div>
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



                    <img src="{{ asset('storage/profile_images/' . preg_replace('/^public\/profile_images\//', '', Auth::user()->image)) }}"
                        alt="This is my image" id="profile_img" class="rounded-circle order-1 object-fit-cover image-fluid">


                    <div class="profile-body flex-cloumn justify-content-space-between align-items-center text-center g-6">
                        <h5 title="user name" class="mt-4 mb-4">{{ Auth::user()->name }}</h5>
                        <hr>
                        <span title="user's bio" class="mt-4 mb-4">{{ Auth::user()->bio }}</span>
                        <hr>
                        @auth
                            <p title="user's email" class="mt-4 mb-4">{{ Auth::user()->email }}</p>
                        @endauth
                        <span title="user's address" class="mt-4 mb-4">{{ Auth::user()->Address }}</span><br>
                        Blogs: <span title="user's total blog" class="text-danger">{{ Auth::user()->posts->count() }}</span><br>
                        @auth
                            <button class="btn btn-outline-primary mt-4 mb-4" data-bs-toggle="modal"
                                data-bs-target="#ProfileUpdate">Edit</button>


                        @endauth
                    </div>


                </div>
            </div>


            <!-- Profile Update Modal -->
            <div class="modal fade" id="ProfileUpdate" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Profile Update</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('user/' . rawurlencode(Auth::user()->id)) }}" method="POST">

                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                {{-- name --}}
                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- end name --}}

                                {{-- email --}}
                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ Auth::user()->email }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- end of email --}}

                                {{-- Bio --}}
                                <div class="row mb-3">
                                    <label for="bio"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Bio') }}</label>

                                    <div class="col-md-6">
                                        <input id="bio" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="bio"
                                            value="{{ Auth::user()->bio }}" required autocomplete="I like Banana."
                                            autofocus>

                                        @error('bio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- end of Bio --}}

                                {{-- DOB --}}
                                <div class="row mb-3">
                                    <label for="dob"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>

                                    <div class="col-md-6">
                                        <input id="dob" type="date"
                                            class="form-control @error('dob') is-invalid @enderror" name="dob"
                                            value="{{ Auth::user()->dob }}" required autocomplete="19/20/2003" autofocus>

                                        @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- end of Dob --}}

                                {{-- adress --}}
                                <div class="row mb-3">
                                    <label for="address"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text"
                                            class="form-control @error('address') is-invalid @enderror" name="address"
                                            value="{{ Auth::user()->Address }}" required autocomplete="19/20/2003"
                                            autofocus>

                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="reset" class="btn btn-outline-danger" value="Reset">
                                <input type="submit" class="btn btn-primary" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-lg-8">
                <div class="blog">
                    <div class="d-flex py-3 justify-content-end align-items-center">
                        @auth
                        <div class="btnadd mx-3">
                            <button class="btn btn-primary" title="create a post" data-bs-toggle="modal" data-bs-target="#postModal">Post <i class="bi bi-cloud-arrow-up"></i></button>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#blogModal" title="upload category">Category <i class="bi bi-cloud-plus"></i></button>
                        </div>
                        @endauth
                    </div>
                    <div class="container border-top border-1 p-3">
                        <div class="row row-cols-1 row-cols-md-1 g-4">
                            @foreach (Auth::user()->posts()->latest()->get() as $post)
                                <div class="col">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . preg_replace('/^public\//', '', $post->image)) }}"
                                            class="card-img-top image-fluid"
                                            style="width: 100%; height: 15rem; object-fit: cover" alt="Post Image">
                                        <div class="card-body">
                                            <a href="{{ url('posts/' . $post->id) }}" class=""
                                                style="text-decoration: none">
                                                <h5 class="card-title">{{ $post->title }}</h5>
                                            </a>

                                            <p class="card-text text-truncate">{{ $post->content }}</p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            <small class="text-muted">{{ Auth::user()->name }} |
                                                {{ $post->updated_at->diffForHumans() }}</small>
                                            <div class="btn-group dropup">
                                                @if ($post->privacy == 0)
                                                    <span class="badge bg-success text-white">Public</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Private</span>
                                                @endif
                                                <button type="button" class="badge bg-light" style="border:none;"
                                                    data-bs-toggle="dropdown" aria-expanded="false" title="Edit">
                                                    <div class="flex items-center leading-none justify-center gap-xs">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="3"
                                                            height="11" viewBox="0 0 3 11" fill="none">
                                                            <circle cx="1.42593" cy="1.42593" r="1.42593"
                                                                fill="#1B363C" />
                                                            <circle cx="1.42593" cy="5.50002" r="1.42593"
                                                                fill="#1B363C" />
                                                            <circle cx="1.42593" cy="9.57406" r="1.42593"
                                                                fill="#1B363C" />
                                                        </svg>
                                                    </div>
                                                </button>
                                                <form action="{{ url('posts/'.$post->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <ul class="dropdown-menu text-center">
                                                        <li><a class="dropdown-item" href="{{url('posts/'.$post->id.'/edit')}}">Edit</a></li>
                                                        <div class="dropdown-divider"></div>
                                                        <li>
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                                        </li>
                                                    </ul>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category Security Pass Modal -->
                    <div class="modal fade" id="blogModal" tabindex="-1" aria-labelledby="blogModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="blogModalLabel">Security Answer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('passvalidator') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="color" class="form-label">Security Color</label>
                                            <input type="color" name="passcolor" class="form-control" id="color"
                                                aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="textcode" class="form-label">Security Code</label>
                                            <input type="password" name="textcode" class="form-control" id="textcode">
                                        </div>

                                        <button class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Create Blog Modal --}}
                    <div class="modal fade modal-dialog-scrollable" id="postModal" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">

                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Post</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">

                                        @csrf

                                        <div class="form-group py-3">
                                            <label for="title">Title:</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required>
                                            <input type="hidden" name="userid" value="{{ Auth::user()->id }}">
                                        </div>

                                        <div class="form-group py-3">
                                            <label for="content_id">Category:</label><br>
                                            @foreach ($categories as $item)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="category_ids[]"
                                                        id="category_{{ $item->id }}" value="{{ $item->id }}">
                                                    <label class="form-check-label"
                                                        for="category_{{ $item->id }}">{{ $item->name }}</label>
                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="form-group py-3">
                                            <label for="privacy">Privacy:</label>
                                            <select class="form-control" id="privacy" name="privacy">
                                                <option value="0">Public</option>
                                                <option value="1">Private</option>
                                            </select>
                                        </div>

                                        <div class="form-group py-3">
                                            <label for="content">Content:</label>
                                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                                        </div>

                                        <div class="form-group py-3">
                                            <label for="image">Image:</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // JQuery code for modal
        $(document).ready(function() {
            $('.edit-category').click(function() {
                var categoryId = $(this).data('category-id');
                var categoryName = $(this).data('category-name');

                // Set the form action dynamically
                var userId = {{ Auth::user()->id }};
                var routeUrl = "{{ route('updateProfileImage', ['user' => ':user']) }}";
                routeUrl = routeUrl.replace(':user', userId);
                $('#editCategoryForm_' + categoryId).attr('action', routeUrl);


                // Set the input field value dynamically
                $('#categoryName_' + categoryId).val(categoryName);

                // Show the corresponding modal
                $('#editCategoryModal_' + categoryId).modal('show');
            });
        });
    </script>
@endsection
