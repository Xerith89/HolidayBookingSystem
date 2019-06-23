<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class Users extends Controller
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
            'user-name' => 'required|max:255|string',
            'staff-id' => 'required|unique:users,staff_id|alpha_num',
            'email' => 'required|email',
            'password' => 'required',
            'confirm-password' => 'required|same:password',
            'admin-user' => 'boolean',
            'current-holiday-year' => 'digits',
            'next-holiday-year' => 'digits',
        ]);

        $user = new User;

        $user->staff_id = $request->input('staff-id');
        $user->name = $request->input('user-name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->admin_user = $request->input('admin');
        $user->currentyear_holiday_entitlement = $request->input('current-year-holiday');
        $user->currentyear_holiday_used = 0;
        $user->nextyear_holiday_entitlement = $request->input('next-year-holiday');
        $user->nextyear_holiday_used = 0;
        $user->pending_holiday_used = 0;

        $user->save();

        return redirect('/dashboard')->with('success', 'User Successfully Added');
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
       //This will be ajax
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
            'staff-id' => 'exists:users,staff_id',           
        ]);
        $user = User::where('staff_id',$request->input('staff-id'));
        
        $user->delete();

        return redirect('/dashboard')->with('success', 'User Deleted');
    }
}
