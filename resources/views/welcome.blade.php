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
      <div class="container">
        <div class="row">
            <form action="/" method="POST" >
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                  </div>
                  
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon2">@example.com</span>
                    </div>
                  </div>
                  
                  <label for="basic-url">Your vanity URL</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
                    </div>
                    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                  </div>
                  
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-append">
                      <span class="input-group-text">.00</span>
                    </div>
                  </div>
                  
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">With textarea</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea"></textarea>
                  </div>
                  <div class="dropzone" id="my-dropzone"></div>
            </form>
        </div>
    </div>
    <script>
        Dropzone.options.myDropzone = {
            url:"/",
                addRemoveLinks: true,
                maxFiles:3,
            init: function() {
                thisDropzone = this;
                this.on("removedfile", function (file) {
                    $.post({
                        url: '/deleteImage',
                        data: {id: file.name, _token: "{{ csrf_token() }}"},
                        dataType: 'json',
                        success: function (data) {
                            $("#counter").text();
                        }
                    });
                });
            },
            success: function (file, done) {
                console.log(file);
                $("form").append("<input type='hidden' name='images[]' value='"+file+"'/>");
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
        };
        </script>
    </body>
</html>
