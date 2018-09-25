<!DOCTYPE html>
<html>
<head>
     
</head>
 
<body>
<h2>send mail </h2>
<br/>
	<form method = 'post' action="{{url('/api/owner/mail')}}">
		<input type = 'text' name = 'email'> 
		<input type = 'submit' value = 'send mail' > 
	</form>
</body>
 
</html>