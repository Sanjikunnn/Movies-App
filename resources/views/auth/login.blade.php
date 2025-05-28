@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@700&display=swap" rel="stylesheet">
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        {{-- Apply movie-card styling for the neobrutalism look --}}
        <div class="card movie-card">
            {{-- Card header with neobrutalism primary color text --}}
            <div class="card-header card-title text-center py-3">{{ trans('messages.login') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="username" class="text-muted">{{ trans('messages.username') }}</label>
                        {{-- Apply custom-form-control for neobrutalism input styling --}}
                        <input type="text" name="username" id="username" class="form-control custom-form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="text-muted">{{ trans('messages.password') }}</label>
                        {{-- Apply custom-form-control for neobrutalism input styling --}}
                        <input type="password" name="password" id="password" class="form-control custom-form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="d-grid">
                        {{-- Apply cta-button and btn-primary for neobrutalism button styling --}}
                        <button type="submit" class="btn cta-button btn-primary w-100">{{ trans('messages.login') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection