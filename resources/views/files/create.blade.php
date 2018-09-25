<form method='post' action  ='{{url("/api/files/store")}}' enctype="multipart/form-data" >
    {{method_field('POST')}}
    {{csrf_field()}}
    <input name = 'bussines_id'  type = 'text' value=7>
    <input name = 'image[]' type = 'file' multiple="yes" value="{{ old('image') }}"/>
    <!-- <input name = 'image[]' type = 'file' value="{{ old('image') }}"/> -->
    <input type = 'submit' />
</form>

<!-- <html lang="en">
<head>
  <title>Laravel Multiple File Upload Example</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
   

  <div class="container">

    <h3 class="jumbotron">Laravel Multiple File Upload</h3>
	
	<form action= ="{{url('/api/files/store')}}" method="post"   enctype="multipart/form-data">
 		 {{csrf_field()}}
 		 {{method_field('POST')}}

        <div class="input-group control-group increment" >
          <input type="file" name="image[]" class="form-control">
          <input name = 'bussines_id'  type = 'text' value=7>

          <div class="input-group-btn"> 
            <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
          </div>
        </div>
        
        <div class="clone hide">
          <div class="control-group input-group" style="margin-top:10px">
            <input type="file" name="image[]" class="form-control">

            <div class="input-group-btn"> 
              <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>

    </form>        
  </div>


<script type="text/javascript">

    $(document).ready(function() {

      $(".btn-success").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    });

</script>


</body>
</html> -->