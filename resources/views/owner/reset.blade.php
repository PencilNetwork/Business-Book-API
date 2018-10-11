<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Reset</title>
      <link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>
    </head>
<style>
    body {
   background: #e1eec3;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #f05053, #e1eec3);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #f05053, #e1eec3); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

  margin:0px;
  font-family: 'Ubuntu', sans-serif;
	background-size: 100% 110%;
}
h1, h2, h3, h4, h5, h6, a {
  margin:0; padding:0;
}
.login {
  margin:0 auto;
  max-width:500px;
}
.login-header {
  color:#fff;
  text-align:center;
  font-size:300%;
}

}
.login-form {
  border:.5px solid #fff;
  background:#4facff;
  border-radius:10px;
  box-shadow:0px 0px 10px #000;
}
.login-form h3 {
  text-align:left;
  margin-left:40px;
  color:#fff;
}
.login-form {
  box-sizing:border-box;
  padding-top:15px;
	padding-bottom:10%;
  margin:5% auto;
  text-align:center;
}
.login input[type="text"],
.login input[type="password"] {
  max-width:400px;
	width: 80%;
  line-height:3em;
  font-family: 'Ubuntu', sans-serif;
  margin:1em 2em;
  border-radius:5px;
  border:2px solid #f2f2f2;
  outline:none;
  padding-left:10px;
}
.login-form input[type="button"] {
  height:30px;
  width:100px;
  background:#fff;
  border:1px solid #f2f2f2;
  border-radius:20px;
  color: slategrey;
  text-transform:uppercase;
  font-family: 'Ubuntu', sans-serif;
  cursor:pointer;
}

/*Media Querie*/
@media only screen and (min-width : 150px) and (max-width : 530px){
  .login-form h3 {
    text-align:center;
    margin:0;
   
  }
   h1{
        font-size:40px;
    }
 
  .login-button {
    margin-bottom:10px;
  }
}
</style>
<body>

<div class="login">
  <div class="login-header">
    <h1>Reset Password</h1>
  </div>
  <div class="login-form">
  	@if(session('status'))  
		{{ session('status') }}
	@endif
	<form method = 'post' action="{{url('/api/owner/reset')}}">
			{{csrf_field()}}
		<input type = 'hidden' name = 'email' value="{{$email}}" > 
		<br>
		<input type = 'password' name = 'password' placeholder="Enter New password"> 
		<br>
		<input type = 'submit' value = 'Reset' > 
	</form>
  </div>
</div>

	
