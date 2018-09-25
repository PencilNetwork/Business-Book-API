<form method='post' action  ='{{url("/api/owner/signup")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'name'  type = 'text' value="{{ old('name') }}"/><br> 
    <input name = 'email'  type = 'text' value="{{ old('email') }}"/><br> 
    <input name = 'password' type = 'text' value="{{ old('password') }}"/><br>
    <input name = 'token' type = 'text' value="{{ old('token') }}"/>
    <input type = 'submit' />
</form>