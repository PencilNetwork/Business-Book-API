<form method='POST' action  ='{{url("/api/files/$file->id")}}'>
    {{method_field('DELETE')}}
    {{csrf_field()}}
    <input type = 'submit' value = 'delete' />
</form>