@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="{{ url('category') }}" method="POST" class="text-center">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" id="basic-addon1">Category Name</span>
                        <input type="text" class="form-control @error('name') is-invalid {{ $message }} @enderror"
                            placeholder="Computer Science" aria-label="name" aria-describedby="basic-addon1" id="inputField"
                            name="name"><br>

                        @error('name')
                            <br><span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <button class="btn btn-primary mb-5">Add <i class="bi bi-backpack-fill"></i></button>

                </form>
                @if (session('addsuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-check-circle-fill"></i> {!! Session('addsuccess') !!}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('addfail'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-check-circle-fill"></i> {!! Session('addfail') !!}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('deletesuccess'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-check-circle-fill"></i> {!! Session('deletesuccess') !!}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('updatesuccess'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-check-circle-fill"></i> {!! Session('updatesuccess') !!}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="col-md-4"></div>
        </div>

        <table class="table table-responsive table-bordered table-hover table-striped">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Name</th>
                <th class="text-center">Actions</th>
            </thead>
            <tbody class="table-group-divider">
                @php
                    $i = 1;
                @endphp
                @foreach ($categories as $category)
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{ $category->name }}</td>
                        <td class="text-center">
                            <form action="{{ url('category/' . $category->id) }}" method="POST">
                                @method('DELETE') <!-- This sets the HTTP method to DELETE -->
                                @csrf <!-- CSRF token for security -->
                                <a href="#" class="btn btn-outline-success edit-category"
                                    data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}"
                                    data-bs-toggle="modal" data-bs-target="#editCategoryModal_{{ $category->id }}">
                                    <i class="bi bi-pen"></i> Edit
                                </a>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are You Sure 🤨')">
                                    <i class="bi bi-trash3-fill"></i> Delete
                                </button>
                            </form>

                            <!-- Modal for Editing Categories -->
                            <div class="modal fade" id="editCategoryModal_{{ $category->id }}" tabindex="-1"
                                aria-labelledby="editCategoryModalLabel_{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCategoryModalLabel_{{ $category->id }}">Edit
                                                Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form id="editCategoryForm" action="{{ url('category/' . $category->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="categoryName" class="form-label">Category Name</label>
                                                    <input type="text" class="form-control"
                                                        id="categoryName_{{ $category->id }}" name="name"
                                                        value="{{ $category->name }}">
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

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        var inputField = document.getElementById("inputField");
        var placeholders = ['Computer Science...', 'Web Development...', 'Data Science...',
            'Software Engineering'
        ]; // Add your placeholders here
        var currentPlaceholder = 0;
        var speed = 80; // Typing speed in milliseconds

        function typeWriter() {
            var placeholder = placeholders[currentPlaceholder];
            var i = 0;

            function addNextCharacter() {
                if (i < placeholder.length) {
                    inputField.setAttribute('placeholder', placeholder.substring(0, i + 1));
                    i++;
                    setTimeout(addNextCharacter, speed);
                } else {
                    setTimeout(erasePlaceholder, 1000); // Wait for 1 second before erasing
                }
            }

            function erasePlaceholder() {
                if (i >= 0) {
                    inputField.setAttribute('placeholder', placeholder.substring(0, i));
                    i--;
                    setTimeout(erasePlaceholder, speed);
                } else {
                    currentPlaceholder = (currentPlaceholder + 1) % placeholders.length; // Cycle through placeholders
                    setTimeout(typeWriter, 1000); // Wait for 1 second before typing the next placeholder
                }
            }

            addNextCharacter();
        }

        // Start the typewriter effect when the page loads
        window.addEventListener('load', typeWriter);

        // JQuery code for modal
        $(document).ready(function() {
            $('.edit-category').click(function() {
                var categoryId = $(this).data('category-id');
                var categoryName = $(this).data('category-name');

                // Set the correct form action and input value for the modal
                $('#editCategoryForm').attr('action', "{{ url('category') }}" + '/' + categoryId);
                $('#categoryName_' + categoryId).val(categoryName);

                // Show the modal
                $('#editCategoryModal_' + categoryId).modal('show');
            });
        });
    </script>
@endsection
