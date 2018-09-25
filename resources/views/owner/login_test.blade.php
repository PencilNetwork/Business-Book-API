<form method='post' action  ='{{url("/api/owner/login")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'name'  type = 'text'  placeholder="name" /><br> 
    <!-- <input name = 'email'  type = 'text' value="{{ old('email') }}" placeholder="email" /><br>  -->
    <input name = 'password' type = 'text' value="{{ old('password') }}" placeholder="password" /><br>
    <input name = 'token' type = 'text' value="{{ old('token') }}" placeholder="token" />
    <input type = 'submit' />
</form>