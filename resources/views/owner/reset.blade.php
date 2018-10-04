<form method = 'post' action="{{url('/api/owner/reset')}}">
		{{csrf_field()}}

	<input type = 'hidden' name = 'email' value="{{$email}}" > 
	@if($errors->has())
	   @foreach ($errors->all() as $error)
	      <div>{{ $error }}</div>
	  @endforeach
	@endif
	<!-- @if($errors->has('password'))
        <strong>{{ $errors->first('password') }}</strong>
    @endif -->
	<input type = 'text' name = 'password' placeholder="Enter New password"> 
	<input type = 'submit' value = 'Reset' > 
</form>