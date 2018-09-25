<form method='post' action  ='{{url("/api/offers")}}' enctype="multipart/form-data" >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'caption'  type = 'text' value="{{ old('caption') }}"/>
    <input name = 'image' type = 'file' value="{{ old('image') }}"/>

    <input type = 'text' name = 'bussines_id' value=7 }}/>
    <input type = 'submit' />
</form>