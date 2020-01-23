<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
        <link rel="stylesheet" href="/css/dropzone.css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="/js/dropzone.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
      <div class="container" style="margin-top: 50px;">
        @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
        <div class="row">
            <form class="form" action="/createLib" method="POST" >
                @csrf
            <input type="hidden" name="id" value="{{$lib->id}}">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="name" aria-label="name" aria-describedby="basic-addon1" value="{{$lib->name}}">
                  </div>                  
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Description</span>
                    </div>
                <textarea class="form-control" name="description" aria-label="With textarea">{{$lib->description}}</textarea>
                  </div>
                  <div class="from-group">
                  <div class="dropzone" id="my-dropzone"></div>
                  </div>
                  <input type="submit" class="btn btn-success">
                @foreach ($lib->images as $image)
                <input type="hidden" name="images[]" value="{{$image->file_name}}">
                @endforeach
            </form>
        </div>
    </div>
    <script>
        var thisDropzone = null;
        Dropzone.options.myDropzone = {
            url:"/saveImage",
                addRemoveLinks: true,
                maxFiles:3,
                
            init: function() {
                
                thisDropzone = this;
                this.on("removedfile", function (file) {
                    
                    let f;
                    if(file.xhr){
                        f = file.xhr.response;
                    }else{
                        f = file.name;
                    }                    
                    $($("form >input[value='"+f+"']")[0]).remove();
                    // console.log(file.xhr.response);
                    $.post({
                        url: '/deleteImage',
                        data: {id: $("form>input[name='id']").val(),name: file.name, _token: "{{ csrf_token() }}"},
                        dataType: 'json',
                        success: function (data) {
                            console.log('file deleted');
                      }
                    });
                });
            },
            success: function (file, done) {
                // console.log(file.xhr);
                $("form").append("<input type='hidden' name='images[]' value='"+file.xhr.response+"'/>");
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id",$("form>input[name='id']").val());
            },
        };
        var mockFile = [
            @foreach($lib->images as $image)
            {name:"{{$image->file_name}}"},

            @endforeach
        ];
        $( document ).ready(function() {
            mockFile.forEach(element => {
                thisDropzone.emit("addedfile", element);
                thisDropzone.emit("thumbnail", element,element.name);
                thisDropzone.emit("complete", element);
            });
        });
        // 
        
       
        </script> 
    </body>
</html>
