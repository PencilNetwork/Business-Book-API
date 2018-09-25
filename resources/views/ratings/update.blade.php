<form method='post' action  ='{{url("/api/ratings/$rating->id")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'searcher_id' placeholder="searcher_id" type = 'text' value="{{$rating->searcher_id}}"/><br> 
    <input name = 'bussines_id' placeholder="bussines_id" type = 'text' value="{{$rating->bussines_id}}"/><br> 
    <input name = 'rating'      placeholder="rating"      type = 'text' value="{{$rating->rating}}" /><br> 
    
    <input type = 'submit' />
</form>