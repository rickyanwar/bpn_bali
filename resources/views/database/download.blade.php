@extends('layouts.auth')

@section('page-title')
    {{ __('Download Database') }}
@endsection

@section('content')
    <div class="text-center">
        <img src="{{ asset('assets/images/logo-with-subtitle.png') }}" alt="{{ env('APP_NAME') }}" class="logo logo-lg" />
    </div>
    <div>
        <h2 class="mb-2 f-w-600">{{ __('Download Database') }}</h2>
        <p class="text-muted mb-4">Unduh backup database dengan data terakhir. Masukkan password akses untuk melanjutkan.</p>
    </div>
    <form action="{{ route('database.download') }}" method="POST" id="downloadForm">
        @csrf
        <div class="form-group mb-3">
            <label for="password" class="form-label">{{ __('Password Akses') }}</label>
            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password"
                name="password" required autofocus>
            @error('password')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block mt-2" style="border-radius: 20px"
                id="download_button">
                <i class="ti ti-download"></i> {{ __('Download Database') }}
            </button>
        </div>
    </form>
@endsection
