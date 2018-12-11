@if(Session::get('err'))    
        <div class="alert alert-danger" role="alert">
            <br>
            {{ trans(Session::get('err')) }}
            <br>
        </div>    
@endif
@if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <br><br>
        </div>   
@endif