<!DOCTYPE html>
<html>
<head>
    <title>Welcome  {{$email}}</title>
</head>
 
<body>
<h2>Reset Password</h2>
<br/>

<form method = 'get' action="{{url('/api/owner/reset_page')}}">
	{{--  <input type = 'hidden'  name = 'email' value="{{$email}}" >   --}}
	<input type = 'text' name = 'email' value="{{$email}}" > 
	<input type = 'submit' value = 'Reset' > 
</form>

</body>
 
</html>