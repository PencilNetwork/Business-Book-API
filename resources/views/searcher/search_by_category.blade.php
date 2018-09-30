<form method='post' action  ='{{url("/api/bussines/search/category")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'searcher_id'  type = 'text' value="1"/><br> 
    <input name = 'category_id'  type = 'text' /><br> 
    
    <input type = 'submit' />
</form>