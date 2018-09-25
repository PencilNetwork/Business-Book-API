<form method='post' action  ='{{url("/api/favoirtes")}}' >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'searcher_id' placeholder = 'searcher id '  type = 'text'  />
    <input name = 'bussines_id'  placeholder = 'bussines  id ' type = 'text'  />
    <input type = 'submit' />
</form>