{{-- Load this version of dashboard for a non admin user --}}

@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <div>
            <i class="fas fa-cog fa-4x float-left"></i>
        </div>
        <h1 class="card-title">Welcome to your dashboard, name</h1>
        <form class="form-inline">
            <button class="btn btn-outline-success my-2 my-sm-0" href="#">Logout</button>
        </form>
    </nav> 
    <br>
    @include('layouts.messages')
    <div class="card text-center mx-auto border-primary" style="width:30rem;">
        <div class="card-body">
            <i class="fas fa-plane-departure fa-4x"></i>
            <h3 class="card-title">Your Holiday Summary</h3>
            <p class="card-text">You have used 0 days out of your 24 day leave entitlement</p>
            <p class="card-text">Your next booked date is bla</p>
            <button class="btn btn-primary" data-toggle="modal" data-target="#newRequest"> New Holiday Request</button>
        </div>
    </div>
    <br>
    <div id="accordion">
        <div class="card border-primary" style="width:auto;">
            <div class="card-header text-center" id="headingOne">
                <h3 class="mb-0 card-title">
                    <button class="fa fa-chevron-circle-up" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"></button>
                </h3>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body text-center ">
                <h3 class="card-title">Pending Requests</h3>
                @if(count($pending_requests) > 0)
                    @foreach ($pending_requests as $request )
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">From</th>
                                        <th scope="col">To</th>
                                        <th scope="col"># Days</th>
                                        <th scope="col">Your Comments</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date Submitted</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$request->request_start->format('d/m/Y') }}</td>
                                        <td>{{$request->request_end->format('d/m/Y') }}</td>
                                        <td>{{$request->total_days_requested}}</td>
                                        <td>{{$request->requester_comments}}</td>
                                        <td>{{$request->request_status}}</td>
                                        <td>{{$request->created_at->format('d/m/Y H:i') }}</td>
                                        <td><button class="btn btn-info" data-toggle="modal" data-target="#editRequest">Edit</button>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteRequest">Delete</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @else
                    <p>No Open Holiday Requests</p>
                @endif
            </div>
        </div>
    </div>
    <br>
    <div id="accordion-two">
        <div class="card border-primary" style="width:auto;">
            <div class="card-header text-center" id="headingTwo">
                <h3 class="mb-0 card-title">
                <button class="fa fa-chevron-circle-up" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"></button>
                </h3>
            </div>
            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion-two">
            <div class="card-body text-center">
                <h3 class="card-title">Completed Requests</h3>
                @if(count($completed_requests) > 0)
                    @foreach ($completed_requests as $completedrequest )
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">From</th>
                                        <th scope="col">To</th>
                                        <th scope="col"># Days</th>
                                        <th scope="col">Your Comments</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date Submitted</th>
                                        <th scope="col">Reviewed By</th>
                                        <th scope="col">Reviewer Comments</th>
                                        <th scope="col">Date Reviewed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$completedrequest->request_start->format('d/m/Y') }}</td>
                                        <td>{{$completedrequest->request_end->format('d/m/Y') }}</td>
                                        <td>{{$completedrequest->total_days_requested}}</td>
                                        <td>{{$completedrequest->requester_comments}}</td>
                                        <td>{{$completedrequest->request_status}}</td>
                                        <td>{{$completedrequest->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{$completedrequest->reviewer_name}}</td>
                                        <td>{{$completedrequest->reviewer_comments}}</td>
                                        <td>{{$completedrequest->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @else
                    <p>No Completed Holiday Requests</p>
                @endif
            </div>
        </div>
    </div> 
    <br>   
</div>

<div class="modal fade" id="newRequest" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action={{action('HolidayRequests@store')}} method="POST">
            
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal">New Holiday Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start-date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" class="form-control" name="end-date" required>
                </div>
                <div class="form-group">
                    <br>
                    <label>Total Days Taken:</label>
                </div>
                <div class="form-group">
                    <label>Comments</label>
                    <input type="text" name="comments" class="form-control" placeholder="Optional">
                </div>
                @csrf
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
            </form>
        </div>
    </div>
</div>

@if (count($pending_requests) > 0)
<div class="modal fade" id="editRequest" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> {{----}}
            <form action={{action('HolidayRequests@update',['id' => $request->id])}} method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal">Edit Holiday Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" value="{{$request->start_date}}" name="start-date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date"value="{{$request->end_date}}" class="form-control" name="end-date" required>
                </div>
                <div class="form-group">
                    <br>
                    <label>Total Days Taken: {{$request->total_days_requested}}</label>
                </div>
                <div class="form-group">
                    <label>Comments</label>
                    <input type="text" name="comments" value="{{$request->id}}" class="form-control" placeholder="Optional">
                </div>
                @csrf
            </div>
            <div class="modal-footer">
            <input type="hidden" name="_method" value="PUT">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteRequest" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action={{action('HolidayRequests@destroy',['id' => $request->id])}} method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal">Delete Holiday Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                <p>This will delete your holiday request for {{$request->start_date}}
                to {{$request->end_date}} 
                <br>
                <p class="text-center">Are you sure?  
                @csrf
            </div>
            <div class="modal-footer">
            <input type="hidden" name="_method" value="DELETE">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endif
</div>
<footer id="footer">
    <p>Copyright &copy; 2019 Stephen Lower Insurance Services</p>
</footer>
@endsection()