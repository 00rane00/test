<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row">
            @foreach ($libs as $lib)
            <div class="col-3">
                <a href="{!!route('show',['lib_id'=>$lib->id])!!}">
                    <div class="row">{{$lib->name}}</div>
                    @isset($lib->images->first()->file_name)
                    <img src="storage/{{$lib->images[1]->file_name}}" class="img-fluid" alt="">
                    @endisset

                </a>
            </div>
            @endforeach
        </div>
    </div>
</body>

</html>