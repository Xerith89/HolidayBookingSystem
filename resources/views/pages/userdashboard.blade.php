{{-- Load this version of dashboard for a non admin user --}}

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
    @include('layouts.messages')
    <div class="card text-center mx-auto border-primary" style="width:30rem;">
        <div class="card-body">
            <i class="fas fa-plane-departure fa-4x"></i>
            <h3 class="card-title">Your Holiday Summary</h3>
            <p class="card-text">You have used <strong>{{number_format(Auth::user()->currentyear_holiday_used)}}</strong> days out of your <strong>{{number_format(Auth::user()->currentyear_holiday_entitlement)}}</strong> day leave entitlement</p>
            <p class="card-text">You have <strong>{{number_format(Auth::user()->pending_holiday_used)}}</strong> days requested that are pending approval.</p>
            <p class="card-text">You may request <strong>{{(Auth::user()->currentyear_holiday_entitlement - Auth::user()->pending_holiday_used - Auth::user()->currentyear_holiday_used)}}</strong> more days for the year.</p>
            @if (Auth::user()->currentyear_holiday_used < Auth::user()->currentyear_holiday_entitlement && Auth::user()->pending_holiday_used < Auth::user()->currentyear_holiday_entitlement )
                <button class="btn btn-primary" data-toggle="modal" data-target="#newRequest"> New Holiday Request</button>
            @endif
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
                                        <th scope="col">Date From</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Date To</th>
                                        <th scope="col">Time</th>
                                        <th scope="col"># Days</th>
                                        <th scope="col">Your Comments</th>
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
                                        <td><button class="btn btn-primary" data-toggle="modal" data-target="#editRequest-{{$request->id}}">Edit</button>
                                        
                                        <div class="modal fade" id="editRequest-{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
                                            <form action={{action('HolidayRequests@update',['id' => $request->id])}} method="POST">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content"> {{----}}
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="requestModal">Edit Holiday Request</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    
                                                        <div class="form-group">
                                                            <label>Start Date</label>
                                                            <input type="date" name="start-date" value="{{$request->request_start->format('Y-m-d')}}"  class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Start Time</label>
                                                            <select name="start-time" class="form-control form-control-sm" required>
                                                                <option>09:00</option>
                                                                <option>12:30</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <input type="date" class="form-control" value="{{$request->request_end->format('Y-m-d')}}" name="end-date" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>End Time</label>
                                                            <select name="end-time" class="form-control form-control-sm" required>
                                                                <option>17:00</option>
                                                                <option>12:30</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Total Days Taken</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Comments</label>
                                                            <input type="text" name="comments" class="form-control" value="{{$request->requester_comments}}" placeholder="Optional">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit Request</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </form>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteRequest-{{$request->id}}">Delete</button>
                                        <div class="modal fade" id="deleteRequest-{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="requestModal">Delete Holiday Request</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <p>This will delete your holiday request for <strong>{{$request->request_start->format('d/m/Y')}}</strong> to <strong>{{$request->request_end->format('d/m/Y')}}</strong>.
                                                            <br>
                                                            <p><strong>Are you sure?</strong>  
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action={{action('HolidayRequests@destroy',['id' => $request->id])}} method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>   
                                        </div>
                                    </td>
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
                                        <th scope="col">Time</th>
                                        <th scope="col">Date To</th>
                                        <th scope="col">Time</th>
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
                    <label>Start Time</label>
                    <select name="start-time" class="form-control form-control-sm" required>
                        <option>09:00</option>
                        <option>12:30</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" class="form-control" name="end-date" required>
                </div>
                <div class="form-group">
                    <label>End Time</label>
                    <select name="end-time" class="form-control form-control-sm" required>
                        <option>17:00</option>
                        <option>12:30</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Total Days Taken</label>
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
@endsection()