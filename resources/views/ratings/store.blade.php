<form method='post' action  ='{{url("/api/ratings")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'searcher_id' placeholder="searcher_id" type = 'text' value="1"/><br> 
    <input name = 'bussines_id' placeholder="bussines_id" type = 'text' /><br> 
    <input name = 'rating' placeholder="rating" type = 'text' /><br> 
    
    <input type = 'submit' />
</form>