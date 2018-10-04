<form method='post' action  ='{{url("/api/favoirtes/1/2")}}' >
    {{method_field('DELETE')}}
    {{csrf_field()}}
    {{--  <input type = 'text '  name = 'searcher_id'>
    <input type = 'text '  name = 'bussines_id'>  --}}
    <input type = 'submit' />
</form>