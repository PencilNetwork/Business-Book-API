<form method='post' action  ='{{url("/api/interests/$interest->id")}}' enctype="multipart/form-data" >
    <!-- {{method_field('post')}} -->
    {{csrf_field()}}
    <input name = 'searcher_id'  type = 'text' value="{{ $interest->searcher_id }}"/>
    <input name = 'categories' type = 'text' value="{{$interest->categories}}"/>
    <input type = 'city' name = 'description'  value="{{ $interest->city }}"/>
    <input type = 'regoins' name = 'description'  value="{{ $interest->regoins }}"/>
    <input type = 'submit' />
</form>
