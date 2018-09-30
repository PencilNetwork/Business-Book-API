<form method='post' action  ='{{url("/api/bussines/store")}}' enctype="multipart/form-data" >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'name'  type = 'text' value="{{ old('name') }}"/>
    <input name = 'image' type = 'file' value="{{ old('image') }}"/>
    <input type = 'text' name = 'description' value="{{ old('description') }}" />
    <input name = 'logo' type = 'file' value="{{ old('logo') }}"/>
    <input type = 'text' name = 'contact_number' value="{{ old('contact_number') }}" />
    <input type = 'text' name = 'city_id' value="{{ old('city') }}"/>
    <input type = 'text' name = 'regoin_id' value="{{ old('regoin') }}"/>
    <input type = 'text' name = 'address' value="{{ old('address') }}"/>
    <input type = 'text' name = 'langitude' value="{{ old('langitude') }}"/>
    <input type = 'text' name = 'lattitude' value="{{ old('lattitude') }}"/>
    <input type = 'text' name = 'category_id' value = '1' value="{{ old('category_id') }}"/>
    <input type = 'text' name = 'owner_id' value = '1' value="{{ old('owner') }}"/>
    <input type = 'submit' />
</form>