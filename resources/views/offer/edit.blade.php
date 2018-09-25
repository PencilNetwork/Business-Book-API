<form method='post' action  ='{{url("/api/offers/$offer->id")}}' enctype="multipart/form-data" >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'caption'  type = 'text' value="{{ $offer->caption }}"/>
    <input name = 'image' type = 'file' value="{{ $offer->image }}"/>

    <input type = 'text' name = 'bussines_id' value= "{{ $offer->bussines_id }}"/>
    <input type = 'submit' />
</form>