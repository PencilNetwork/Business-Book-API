<form method='post' action  ='{{url("/api/offers/$offer->id")}}'>
    {{method_field('DELETE')}}
    {{csrf_field()}}
    <input type = 'submit' value = 'delete' />
</form>