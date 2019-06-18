<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HolidayRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class HolidayRequests extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending_requests = HolidayRequest::where('request_status', 'pending')->get();
        $completed_requests = HolidayRequest::where('request_status', 'approved')
        ->where('request_status', 'declined')->get();
        return view('pages.dashboard',compact('pending_requests', 'completed_requests'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function show()
    {
        
    }

    public function edit($id)
    {
        $holrequest = HolidayRequest::find($id);
        return view('requests.edit')->with('holrequest', $holrequest);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'start-date' => 'required',
            'end-date' => 'required',
            'start-time' => 'required',
            'end-time' => 'required',
            'start-date' => 'after_or_equal:today',
            'end-date' => 'after:start-date'
        ]);

        $holrequest = new HolidayRequest;
        $holrequest->request_staff_id = Auth::user()->staff_id;
        $holrequest->request_start = $request->input('start-date');
        $holrequest->request_start_time = $request->input('start-time');
        $holrequest->request_end = $request->input('end-date');
        $holrequest->request_end_time = $request->input('end-time');
        $holrequest->total_days_requested = '6';
        $holrequest->requester_email_address = Auth::user()->email;
        $holrequest->requester_comments = $request->input('comments');
        $holrequest->request_status = 'Pending'; 

        $holrequest->save();

        $user = User::where('staff_id', Auth::user()->staff_id)->first();
        $user->amount_holiday_used += $holrequest->total_days_requested;
        $user->save();
        
        return redirect('/dashboard')->with('success', 'Holiday Request Submitted');
        
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'start-date' => 'required',
            'end-date' => 'required',
            'start-date' => 'after_or_equal:today',
            'end-date' => 'after:start_date'
        ]);

        $holrequest = HolidayRequest::find($id);
        $holrequest->request_staff_id = Auth::user()->staff_id;
        $holrequest->request_start = $request->input('start-date');
        $holrequest->request_end = $request->input('end-date');
        $holrequest->total_days_requested = '6';
        $holrequest->requester_email_address = Auth::user()->staff_id;
        $holrequest->requester_comments = $request->input('comments');
        $holrequest->request_status = 'Pending'; 

        $user = User::where('staff_id', Auth::user()->staff_id)->first();
        $user->pending_holiday_used += $holrequest->total_days_requested;
        $user->save();

        $holrequest->save();
        
        return redirect('/dashboard')->with('success', 'Holiday Request Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $holrequest = HolidayRequest::find($id);
        $user = User::where('staff_id', Auth::user()->staff_id)->first();
        $user->pending_holiday_used -= $holrequest->total_days_requested;
        $user->save();
        $holrequest->delete();

        return redirect('/dashboard')->with('success', 'Holiday Request Deleted');
    }
}
