@if(count($errors) > 0)
    @foreach ($errors->all() as $error )
        <div class="alert text-center alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert text-center alert-success">
        {{session('success')}}
    </div>
@endif

@if(session('errpr'))
    <div class="alert text-center alert-danger">
        {{session('error')}}
    </div>
@endif