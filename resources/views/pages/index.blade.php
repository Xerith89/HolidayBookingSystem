@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="card" style="width: auto;">
            <div class="card-body">
            <h1 class="display-4 text-center">
                <span class="text-primary">SLIS Holiday Booking Portal</span>
            </h1>
            <br>
            <br>
            <!-- Form -->
            @guest                       
            @include('auth.login')     
            @endguest
            </div>
        </div>
    </div>
@endsection()
