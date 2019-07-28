<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HolidayRequest;
use App\User;
use App\CompanyHoliday;
use App\Lib\BusinessDays;
use Carbon\Carbon;

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
        //make sure we are logged in
        if (Auth::guest())
        {
            return redirect('/');
        }
        //If we are an admin we need to see all requests
        if (Auth::user()->admin_user)
        {
            $pending_requests = HolidayRequest::where('request_status', 'Pending')->get();
            $completed_requests = HolidayRequest::where('request_status', 'approved')
            ->orWhere('request_status', 'Declined')->get();
            $approved_requests = HolidayRequest::where('request_status', 'Approved')->where('request_start', '>=', Carbon::now())
            ->where('request_end', '<=', Carbon::now()->addDays(5))->get();
        } else { 
            //We only want to see our own
            $pending_requests = HolidayRequest::where('request_status', 'pending')->where('request_staff_id','=', Auth::user()->staff_id)->get();
            $completed_requests = HolidayRequest::where('request_status', 'Approved')->where('request_staff_id', '=', Auth::user()->staff_id)
            ->orWhere('request_status', 'Declined')->where('request_staff_id', '=', Auth::user()->staff_id)->get();
            $approved_requests = HolidayRequest::where('request_status', 'Approved')->where('request_staff_id', '=', Auth::user()->staff_id)->orderBy('request_start')->get();
        }

        return response()->json([$pending_requests, $completed_requests, $approved_requests]);
        
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
            'end-date' => 'after_or_equal:today',
        ]);

        $holrequest = new HolidayRequest;
        $date = new BusinessDays();

         //Add company holidays - full days
        $companyholiday = CompanyHoliday::where('half_day', false)->get();
        foreach($companyholiday as $holiday){
            $splitDate = explode("-", $holiday->holiday_date->format('Y-m-d'));
            $date->addHoliday(Carbon::createFromDate($splitDate[0],$splitDate[1],$splitDate[2]));
        }

        //Split the dates up into integer arrays for use with carbon
        $startdate = explode("-", $request->input('start-date'));
        $enddate = explode("-", $request->input('end-date'));
        $days = $date->daysBetween(Carbon::createFromDate($startdate[0],$startdate[1],$startdate[2]), Carbon::createFromDate($enddate[0],$enddate[1],$enddate[2]));

        //Add company holidays - half days
        $companyholiday = CompanyHoliday::where('half_day', true)->get();
        foreach($companyholiday as $holiday){
            if ($holiday->holiday_date >= $request->input('start-date') && $holiday->holiday_date <= $request->input('end-date')) {
                $days -= 0.5;
            }
        }

        //Calculate half days
        if (date('G:i', strtotime($request->input('end-time'))) == '12:30' && date('G:i', strtotime($request->input('start-time'))) == '12:30')
        {
            $days -= 1.0;
        }
        else if (date('G:i', strtotime($request->input('end-time'))) == '12:30' || date('G:i', strtotime($request->input('start-time'))) == '12:30')
        {
            $days -= 0.5;
        } 

        //Throw error if we have 0 days
        if ($days < 0.5) {
            $error = \Illuminate\Validation\ValidationException::withMessages(['days' => ['Total Days Requested Cannot Be Zero'],]);
            throw $error;
        }
        
        //Store the values from the input form
        $holrequest->request_staff_id = Auth::user()->staff_id;
        $holrequest->request_name = Auth::user()->name;
        $holrequest->request_start = $request->input('start-date');
        $holrequest->request_start_time = $request->input('start-time');
        $holrequest->request_end = $request->input('end-date');
        $holrequest->request_end_time = $request->input('end-time');
        $holrequest->total_days_requested = $days;
        $holrequest->requester_email_address = Auth::user()->email;
        $holrequest->requester_comments = $request->input('comments');
        $holrequest->request_status = 'Pending'; 

        $holrequest->save();

        //Adjust the user's pending holiday count
        $user = User::where('staff_id', Auth::user()->staff_id)->first();
        $user->pending_holiday_used += $holrequest->total_days_requested;
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
        $holrequest = HolidayRequest::find($id);
        

        if (Auth::user()->admin_user) {

            $this->validate($request, [
                'start-date' => 'required|after_or_equal:today',
                'decision' => 'required',
                'start-time' => 'required',
                'end-time' => 'required',                
            ]);

            $user = User::where('staff_id', $holrequest->request_staff_id)->first();

            if (  $request->input('decision') == 'Approve') {
                
                $holrequest->request_status='Approved';
                $user->pending_holiday_used -= $holrequest->total_days_requested;
                $user->currentyear_holiday_used += $holrequest->total_days_requested;
            } else {

                $holrequest->request_status='Declined';
                $user->pending_holiday_used -= $holrequest->total_days_requested;
            }

            $holrequest->reviewer_comments = $request->input('reviewer-comments');
            $holrequest->reviewer_name = Auth::user()->name;
            $holrequest->save();
            $user->save();

        } else {

            $this->validate($request, [
                'start-date' => 'required',
                'end-date' => 'required',
                'start-time' => 'required',
                'end-time' => 'required',
                'start-date' => 'after_or_equal:today',
                'end-date' => 'after:start_date'
            ]);

            $date = new BusinessDays();
             //Add company holidays
            $companyholiday = CompanyHoliday::where('half_day', false)->get();

            foreach($companyholiday as $holiday) {
                $splitDate = explode("-", $holiday->holiday_date->format('Y-m-d'));
                $stuff = Carbon::createFromDate($splitDate[0],$splitDate[1],$splitDate[2]);
                $date->addHoliday(Carbon::createFromDate($splitDate[0],$splitDate[1],$splitDate[2]));
            }

            //Split the dates up into integer arrays for use with carbon
            $startdate = explode("-", $request->input('start-date'));
            $enddate = explode("-", $request->input('end-date'));
            $days = $date->daysBetween(Carbon::createFromDate($startdate[0],$startdate[1],$startdate[2]), Carbon::createFromDate($enddate[0],$enddate[1],$enddate[2]));
            
            //Add company holidays - half days
            $companyholiday = CompanyHoliday::where('half_day', true)->get();
            foreach($companyholiday as $holiday){
                if ($holiday->holiday_date >= $request->input('start-date') && $holiday->holiday_date <= $request->input('end-date')) {
                    $days -= 0.5;
                }
            }

            //Calculate half days
            if (date('G:i', strtotime($request->input('end-time'))) == '12:30' && date('G:i', strtotime($request->input('start-time'))) == '12:30')
            {
                $days -= 1.0;
            }
            else if (date('G:i', strtotime($request->input('end-time'))) == '12:30' || date('G:i', strtotime($request->input('start-time'))) == '12:30')
            {
                $days -= 0.5;
            } 

            //Throw error if we have 0 days
            if ($days < 0.5) {
                $error = \Illuminate\Validation\ValidationException::withMessages(['days' => ['Total Days Requested Cannot Be Zero'],]);
                throw $error;
            }

            $user = User::where('staff_id', Auth::user()->staff_id)->first();

            $user->pending_holiday_used -= $holrequest->total_days_requested;
            
            $holrequest->request_staff_id = Auth::user()->staff_id;
            $holrequest->request_name = Auth::user()->name;
            $holrequest->request_start = $request->input('start-date');
            $holrequest->request_start_time = $request->input('start-time');
            $holrequest->request_end_time = $request->input('end-time');
            $holrequest->request_end = $request->input('end-date');
            $holrequest->total_days_requested = $days;
            $holrequest->requester_email_address = Auth::user()->email;
            $holrequest->requester_comments = $request->input('comments');
            $holrequest->request_status = 'Pending'; 

            
            $user->pending_holiday_used += $holrequest->total_days_requested;
            $user->save();

            $holrequest->save();
        }
        
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
