<form method='post' action  ='{{url("/api/bussines_search")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'bussines_name'  type = 'text'  placeholder="bussines_name " /><br> 
    <input name = 'city_id'  type = 'text' placeholder="city_id" /><br> 
    <input name = 'regoin_id'  type = 'text'  placeholder="regoin_id" /><br> 
    <input name = 'category_id'  type = 'text' placeholder="category_id" /><br> 
    <input name = 'page_number'  type = 'text' placeholder="page number" /><br> 
    <input type = 'submit' />
</form>