<form method='post' action  ='{{url("/api/interests")}}' >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'searcher_id'  type = 'text' value="1"/>
    <input name = 'categories' type = 'text' value="{{ old('categories') }}"/>
    <input name = 'city' type = 'text' value="{{ old('city') }}"/>
    <input name = 'regoins' type = 'text' value="{{ old('regoins') }}"/>
    <input type = 'submit' />
</form>