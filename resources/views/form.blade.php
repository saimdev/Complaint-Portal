<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints | Portal</title>
    <link rel="stylesheet" href="{{asset('/app.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body class="complaintform text-white">
    <div class="d-flex flex-column jusitfy-content-center align-items-center my-5">
    <h1 class="text-center mb-4">Complaint Form</h1>

        <form class="form w-50" action="/register/{{$name}}" style="padding:3rem" enctype="multipart/form-data" method="POST">
            @csrf
            @foreach ($collection as $item)
            <div class="d-flex flex-column my-3">
                <label for="">Name</label>
                <input type="text" name="name" class="my-1" value="{{$item->name}}" placeholder="Enter Name">
            </div>
            <div class="d-flex flex-column my-3">
                <label for="">Registration No.</label>
                <input type="text" name="registration" class="my-1" value="{{$item->registration}}" placeholder="FA20-BSE-001">
            </div>
            @endforeach
            <div class="d-flex flex-column my-3">
                <label for="">File Name</label>
                <input type="text" name="filename" class="my-1" placeholder="Enter Filename">
                <input type="file" name="file" class="my-1">
            </div>
            <div class="d-flex flex-column my-3">
                <label for="">Complaint</label>
                <textarea name="message" class="my-1" id="" cols="30" rows="10" placeholder="Write Message"></textarea>
            </div>
            @if(session()->has('error'))
                            <div class="alert alert-danger error-message text-center" style="background: transparent; font-size:0.8rem; margin-top:0.4rem; border:none; color:rgb(237, 73, 86)">
                                {{ session()->get('error') }}</div>
            @endif
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>
</html>
