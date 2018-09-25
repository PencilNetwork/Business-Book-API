<form method='post' action  ='{{url("/api/files/$file->id")}}' enctype="multipart/form-data" >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'bussines_id'  type = 'text' value="{{ $file->bussines_id }}"/>
    <input name = 'image' type = 'file' value="{{ asset('images'.$file->image )}}"/>
    <input type = 'submit' />
</form>


