<!DOCTYPE html>
<html>
<head>
    <title>Welcome  {{$email}}</title>
</head>
 
<body>
<h2>Reset Password</h2>
<br/>
<!-- <a href = "{{url('/api/owner/')}}" > reset pass </a> -->
	<form method = 'post' action="{{url('/api/owner/reset')}}">
		
		<input type = 'text' name = 'email' value="{{$email}}" > 
		<input type = 'text' name = 'password'> 
		<input type = 'submit' value = 'Reset' > 
	</form>
</body>
 
</html>