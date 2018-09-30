<form method='post' action  ='{{url("/api/offer/search")}}'  >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'bussines_name'  type = 'text'  placeholder="bussines_name " /><br> 
    <input name = 'city_id'  type = 'text' placeholder="province_name" /><br> 
    <input name = 'regoin_id'  type = 'text'  placeholder="regoin_name" /><br> 
    <input name = 'category_id'  type = 'text' placeholder="category_id" /><br> 
    
    <input type = 'submit' />
</form>