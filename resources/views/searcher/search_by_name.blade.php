<form method='post' action  ='{{url("/api/search/bussines_name")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'searcher_id'  type = 'text' value="1"/><br> 
    <input name = 'bussines_name'  type = 'text' /><br> 
    
    <input type = 'submit' />
</form>