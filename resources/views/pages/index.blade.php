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
        
            <div class="form-group w-25 mx-auto text-center">
                <form id="login-form" action="dashboard.php" method="POST">
                    <label>Username</label>
                    <input type="text" id="username" class="form-control" placeholder="Username" required>
                    <br>
                    <label>Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Password" required>
                    <br>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberme">
                        <label class="form-check-label" for="remember">Remember Username</label> 
                    </div>
                    <br>
                    <div>      
                        <input type="Submit" class="btn btn-primary" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection()
