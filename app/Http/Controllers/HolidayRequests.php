<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HolidayRequest;

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
            'start-date' => 'after_or_equal:today',
            'end-date' => 'after:start_date'
        ]);

        $holrequest = new HolidayRequest;
        $holrequest->request_staff_id = 'DE001';
        $holrequest->request_start = $request->input('start-date');
        $holrequest->request_end = $request->input('end-date');
        $holrequest->total_days_requested = '6';
        $holrequest->requester_email_address = 'default.user@stephenlower.co.uk';
        $holrequest->requester_comments = $request->input('comments');
        $holrequest->request_status = 'pending'; 

        $holrequest->save();
        
        return redirect('/dashboard')->with('success', 'Holiday Request Submitted');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
