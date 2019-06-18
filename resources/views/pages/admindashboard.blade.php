@section('content')
@include('layouts.messages')
<div class="container mt-4">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <div>
            <i class="fas fa-cog fa-4x float-left"></i>
        </div>
        <h1 class="card-title float-center">Welcome to your admin dashboard, {{ Auth::user()->name }}</h1>
        <form class="form-inline" id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline-success my-2 my-sm-0" href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();" {{ __('Logout') }}>Logout</button>
        </form>
    </nav> 
    <br>
    <div class="card text-center mx-auto border-primary" style="width:30rem;">
        <div class="card-body">
            <i class="fas fa-plane-departure fa-4x"></i>
            <h3 class="card-title">Your Holiday Summary</h3>
            <p class="card-text">You have used <strong>{{Auth::user()->amount_holiday_used}}</strong> days out of your <strong>{{Auth::user()->base_holiday_entitlement}}</strong> day leave entitlement</p>
            <button class="btn btn-primary" data-toggle="modal" data-target="#newRequest"> New Holiday Request</button>
        </div>
    </div>
    <br>
@endsection()
@include('auth.register')
