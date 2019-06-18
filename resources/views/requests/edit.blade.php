@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <div>
            <i class="fas fa-cog fa-4x float-left"></i>
        </div>
        <h1 class="card-title float-center">Welcome to your dashboard, {{ Auth::user()->name }}</h1>
        <form class="form-inline" id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline-success my-2 my-sm-0" href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();" {{ __('Logout') }}>Logout</button>
        </form>
    </nav> 
    <br>
    <div class="card">
        <form action={{action('HolidayRequests@update', ['id' => $holrequest->id])}} method="POST">        
    
        <h5 class="card-title" >Edit Holiday Request</h5>
            <div class="form-group">
            <label>Start Date</label>
            <input type="date" value="{{$holrequest->start_date}}" name="start-date" class="form-control" required>
            </div>
            <div class="form-group">
            <label>End Date</label>
            <input type="date" value="{{$holrequest->end_date}}" class="form-control" name="end-date" required>
            </div>
            <div class="form-group">
            <br>
            <label>Total Days Taken:</label>
            </div>
            <div class="form-group">
            <label>Comments</label>
            <textarea value="{{$holrequest->requester_comments}}" rows="5" cols="70" class="form-control" placeholder="Optional"></textarea> 
            </div>
            @csrf
        </div>
        <input type="hidden" name="_method" value="PUT">
        <a href="/dashboard" class="btn btn-danger" >Cancel</a>
        <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>

@endsection()