<form method='post' action  ='{{url("/api/searchers/update_token")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'searcher_id'  type = 'text' value="1"/><br> 
    <input name = 'old_token'  type = 'text' placeholder = 'old_token'  /><br> 
    <input name = 'new_token'  type = 'text' placeholder = 'new_token'/><br> 
    
    <input type = 'submit' />
</form>