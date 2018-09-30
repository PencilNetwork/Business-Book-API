<form method='post' action  ='{{url("/api/interests/$interest->id")}}' enctype="multipart/form-data" >
    <!-- {{method_field('post')}} -->
    {{csrf_field()}}
    <input name = 'searcher_id'  type = 'text' value="{{ $interest->searcher_id }}"/>
    <input name = 'categories_ids' type = 'text' value="{{$interest->categories_ids}}"/>
    <input type = 'text' name = 'city_id'  value="{{ $interest->city_id }}"/>
    <input type = 'text' name = 'regoins_ids'  value="{{ $interest->regoins_ids }}"/>
    <input type = 'submit' />
</form>
