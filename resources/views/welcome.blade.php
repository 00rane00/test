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
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="name" aria-label="name" aria-describedby="basic-addon1">
                  </div>                  
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Description</span>
                    </div>
                    <textarea class="form-control" name="description" aria-label="With textarea"></textarea>
                  </div>
                  <div class="from-group">
                  <div class="dropzone" id="my-dropzone"></div>
                  </div>
                  <input type="submit" class="btn btn-success">
            </form>
        </div>
    </div>
    <script>
        Dropzone.options.myDropzone = {
            url:"/saveImage",
                addRemoveLinks: true,
                maxFiles:3,
            init: function() {
                
                thisDropzone = this;
                this.on("removedfile", function (file) {
                    $($("form >input[value='"+file.xhr.response+"']")[0]).remove();
                    console.log(file.xhr.response);
                    $.post({
                        url: '/deleteImage',
                        data: {id: file.name, _token: "{{ csrf_token() }}"},
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
            },
        };
        </script>
    </body>
</html>
