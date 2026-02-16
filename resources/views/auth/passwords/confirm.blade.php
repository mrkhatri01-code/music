@extends('layouts.app')

@section('content')
    <div class="container"
        style="background: url('{{ asset('images/banner/login-bg.jpg') }}') no-repeat center center/cover; min-height: 80vh; display: flex; align-items: center; justify-content: center;">
        <div class="card"
            style="max-width: 400px; width: 100%; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; text-align: center;">
            <div class="card-body" style="padding: 3rem 2rem;">
                <div
                    style="width: 80px; height: 80px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="fa-solid fa-check" style="font-size: 2.5rem; color: #16a34a;"></i>
                </div>
                <h3 style="font-weight: 700; color: #1f2937; margin-bottom: 1rem;">Request Sent!</h3>
                <p style="color: #4b5563; line-height: 1.6; margin-bottom: 2rem;">
                    Your request has been sent to the administrator. They will contact you shortly with manual reset
                    instructions.
                </p>
                <a href="{{ route('login') }}" class="btn btn-primary w-100"
                    style="display: block; width: 100%; padding: 0.75rem; border-radius: 8px; font-weight: 600; background: var(--color-primary); color: white; border: none; cursor: pointer; text-decoration: none;">
                    Back to Login
                </a>
            </div>
        </div>
    </div>
@endsection