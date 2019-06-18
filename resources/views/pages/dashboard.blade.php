@if (Auth::user()->admin_user == true)
    @include ('pages.admindashboard')
@else
    @include ('pages.userdashboard')
@endif