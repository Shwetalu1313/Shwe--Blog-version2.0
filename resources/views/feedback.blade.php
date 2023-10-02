@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{route('mail.send')}}" method="POST" id="myForm" class="border border-info pt-5 px-5">
                    @csrf
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text"
                                                         class="form-control"
                                                         name="name"
                                                         id="name"
                                                         placeholder="Your name/company"
                                                         value="{{old('name')}}" required>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label><input type="email"
                                                          class="form-control"
                                                          name="email"
                                                          id="email"
                                                          placeholder="your-email@gmail.com"
                                                          value="{{old('email')}}" required>
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="body">Message</label><textarea class="form-control"
                                                            name="body"
                                                            id="body"
                                                            rows="3"
                                                            placeholder="mail body">{{old('body')}}</textarea>
                        @error('body')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>


                    <div class="text-center my-5">
                        <button type="reset" class="btn btn-outline-danger">
                            <i class="bi bi-x-circle-fill"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-info me-3">
                            <i class="bi bi-send"></i> Send
                        </button>
                    </div>

                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

@endsection
