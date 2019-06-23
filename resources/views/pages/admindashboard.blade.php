@extends('layouts.app')
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
    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card text-center mx-auto border-primary" style="width:20rem;">
                <div class="card-header">
                    <i class="fas fa-user-friends fa-4x"></i>
                    <h3 class="card-title">User Management</h3>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#newUser">Add New User</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteUser">Delete User</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card text-center mx-auto border-primary" style="width:20rem;">
            <div class="card-header">
                <i class="fas fa-chart-pie fa-4x"></i>
                <h3 class="card-title">Reporting</h3>
            </div>
                <div class="card-body">    
                    <p>Coming Soon
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card text-center mx-auto border-primary" style="width:20rem;">
                <div class="card-header">
                    <i class="fas fa-clock fa-4x"></i>
                    <h3 class="card-title">Company Holidays</h3>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#newHoliday">Add New Holiday</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteHoliday">Delete Holiday</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div id="accordion">
        <div class="card border-primary" style="width:auto;">
            <div class="card-header text-center" id="headingOne">
                 <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Pending Requests <span class="badge badge-primary">{{count($pending_requests)}}</span></h3> 
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body text-center ">
                @if(count($pending_requests) > 0)
                    @foreach ($pending_requests as $request )
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Date From</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Date To</th>
                                        <th scope="col">Time</th>
                                        <th scope="col"># Days</th>
                                        <th scope="col">Requester Comments</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Last Edited</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$request->request_start->format('d/m/Y') }}</td>
                                        <td>{{date('G:i', strtotime($request->request_start_time)) }}
                                        <td>{{$request->request_end->format('d/m/Y') }}</td>
                                        <td>{{date('G:i', strtotime($request->request_end_time))}}
                                        <td>{{$request->total_days_requested}}</td>
                                        <td>{{$request->requester_comments}}</td>
                                        <td>{{$request->request_status}}</td>
                                        <td>{{$request->updated_at->format('d/m/Y H:i') }}</td>
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
                <h3 class="card-title"><i class="fas fa-calendar-check"></i> Completed Requests <span class="badge badge-success">{{count($completed_requests)}}</span></h3>
            </div>
            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion-two">
            <div class="card-body text-center">
                
                @if(count($completed_requests) > 0)
                    @foreach ($completed_requests as $completedrequest )
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Requester</th>
                                        <th scope="col">Date From</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Date To</th>
                                        <th scope="col">Time</th>
                                        <th scope="col"># Days</th>
                                        <th scope="col">Requester Comments</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date Submitted</th>
                                        <th scope="col">Reviewed By</th>
                                        <th scope="col">Your Comments</th>
                                        <th scope="col">Date Reviewed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$completedrequest->request_staff_id}}</td>
                                        <td>{{$completedrequest->request_start->format('d/m/Y') }}</td>
                                        <td>{{$completedrequest->request_start_time}}
                                        <td>{{$completedrequest->request_end->format('d/m/Y') }}</td>
                                        <td>{{$completedrequest->request_end_time}}
                                        <td>{{$completedrequest->total_days_requested}}</td>
                                        <td>{{$completedrequest->requester_comments}}</td>
                                        <td>{{$completedrequest->request_status}}</td>
                                        <td>{{$completedrequest->created_at}}</td>
                                        <td>{{$completedrequest->reviewer_name}}</td>
                                        <td>{{$completedrequest->reviewer_comments}}</td>
                                        <td>{{$completedrequest->updated_at}}</td>
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
</div>
<footer id="footer">
    <p>Copyright &copy; 2019 Stephen Lower Insurance Services</p>
</footer>

{{--Modals--}}
<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action={{action('Users@store')}} method="POST">
            
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="user-name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Staff ID</label>
                    <input type="text" name="staff-id" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                     <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                     <input type="password" class="form-control" name="confirm-password" required>
                </div>
                <div class="form-group">
                    <label>Admin User?</label>
                     <select class="form-control" name="admin" selected="False">
                        <option>False</option>
                        <option>True</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Current Year Holiday Entitlement</label>
                    <input type="number" name="current-year-holiday" class="form-control" required> 
                </div>
                <div class="form-group">
                    <label>Next Year Holiday Entitlement</label>
                    <input type="number" name="next-year-holiday" class="form-control" required> 
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

<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action={{action('Users@destroy', ['id' => $request->id])}} method="POST">
            
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Staff ID</label>
                    <input type="text" name="staff-id" class="form-control" required>
                </div>
                @csrf
                <input type="hidden" name="_method" value="DELETE"> 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="newHoliday" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action={{action('CompanyHolidays@store')}} method="POST">
            
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal">Add New Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Half Day?</label>
                     <select class="form-control" name="half-day" selected="False">
                        <option>False</option>
                        <option>True</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Start Time</label>
                    <select class="form-control" name="start-time" selected="False">
                        <option>09:00</option>
                        <option>12:30</option>
                    </select>
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

<div class="modal fade" id="deleteHoliday" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action={{action('CompanyHolidays@destroy', ['id' => $request->id])}} method="POST">
            
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                @csrf
                <input type="hidden" name="_method" value="DELETE"> 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection()

