@if (Auth::user()->admin_user)
    @include ('pages.admindashboard')
@else
    @include ('pages.userdashboard')
@endif