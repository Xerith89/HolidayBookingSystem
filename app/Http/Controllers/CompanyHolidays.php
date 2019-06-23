<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyHoliday;

class CompanyHolidays extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|after:today',
            'start-time' => 'required_if:half-day,True'           
        ]);

        $comphol = new CompanyHoliday;

        $comphol->holiday_date = $request->input('date');
        $comphol->half_day = $request->input('half-day');
        if ($request->input('half-day') == 'True') {
            $comphol->start_time = $request->input('start-time');
        } else {
            $comphol->start_time = NULL;
        }
        
        $comphol->save();

        return redirect('/dashboard')->with('success', 'Holiday Successfully Added');
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
    public function destroy(Request $request,$id)
    {
        $this->validate($request, [
            'date' => 'exists:company_holidays,holiday_date',           
        ]);
        $comphol = CompanyHoliday::where('holiday_date',$request->input('date'));
        
        $comphol->delete();

        return redirect('/dashboard')->with('success', 'Holiday Deleted');
    }
}
