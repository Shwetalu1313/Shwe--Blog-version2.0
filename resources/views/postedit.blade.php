@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 border rounded border-5 px-5 py-3">
                <h4>Update Post</h4>
                <form action="{{ url('posts/'.$posts->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group py-3">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$posts->title}}" required>
                        <input type="hidden" name="userid" value="{{ Auth::user()->id }}">
                    </div>

                    <div class="form-group py-3">
                        <label for="content_id">Category:</label><br>
                        @foreach ($categories as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="category_ids[]"
                                    id="category_{{ $item->id }}" value="{{ $item->id }}" 
                                    {{ in_array($item->id, $posts->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="category_{{ $item->id }}">{{ $item->name }}</label>
                            </div>
                        @endforeach

                    </div>

                    <div class="form-group py-3">
                        <label for="privacy">Privacy:</label>
                        <select class="form-control" id="privacy" name="privacy">
                            @if ($posts->privacy == 0)
                            <option value="0" checked>Public</option>
                            <option value="1">Private</option>
                            @else
                            <option value="0">Public</option>
                            <option value="1" checked>Private</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group py-3">
                        <label for="content">Content:</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required>{{$posts->content}}</textarea>
                    </div>

                    <div class="form-group py-3">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
