<form method='post' action  ='{{url("/api/bussines/$bussines->id")}}' enctype="multipart/form-data" >
    <!-- {{method_field('post')}} -->
    {{csrf_field()}}
    <input name = 'name'  type = 'text' value="{{ $bussines->name }}"/>
    <input name = 'image' type = 'file' value="{{ asset('/images/'.$bussines->image )}}"/>
    <input type = 'text' name = 'description'  value="{{ $bussines->description }}"/>
    <input name = 'logo' type = 'file' />
    <input type = 'text' name = 'contact_number' value="{{ $bussines->contact_number }}" />
    <input type = 'text' name = 'city_id' value="{{ $bussines->city_id }}"/>
    <input type = 'text' name = 'regoin_id' value="{{ $bussines->regoin_id }}"/>
    <input type = 'text' name = 'address' value="{{$bussines->address }}"/>
    <input type = 'text' name = 'langitude' value="{{ $bussines->langitude }}"/>
    <input type = 'text' name = 'lattitude' value="{{ $bussines->lattitude }}"/>
    <input type = 'text' name = 'category_id' value = '1' value="$bussines->category_id }}"/>
    <input type = 'text' name = 'owner_id' value = '1' value="{{ $bussines->owner }}"/>
    <input type = 'submit' />
</form>
<img src="{{$bussines->image}}"  alt = 'image'> 