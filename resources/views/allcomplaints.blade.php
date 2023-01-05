<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="{{asset('/app.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body class="bg-dark">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-2 d-flex flex-column vh-100 justify-content-between p-3" style="background: url(/images/comsatswah.jpg); background-position: center;
            background-size: cover; border-radius:0 0.6rem 0.6rem 0;">
                <div class="d-flex flex-column" style="">
                    <h3 class="fw-bold">ADMIN PANEL</h3>
                    <a href="/admin" class="fw-bold text-decoration-none py-2 px-4 text-white my-2 bg-success" style="border-radius:0.6rem;">
                        List of Un-Completed Complaints
                    </a>
                    <a href="/list" class="fw-bold text-decoration-none py-2 px-4 text-white my-2 bg-success" style="border-radius:0.6rem;">
                        List of Students
                    </a>
                    <a href="/listofall" class="fw-bold text-decoration-none py-2 px-4 text-white my-2 bg-success" style="border-radius:0.6rem;">
                        List of All Complaints
                    </a>
                </div>
                <div>
                    <a href="/logout" class="text-danger fw-bold text-decoration-none py-2 px-4" style="background: rgb(255, 137, 137); border-radius:0.6rem;">Logout</a>
                </div>
            </div>
            <div class="col col-10 px-4 d-flex flex-column justify-content-center align-items-center">
                <table class="table text-white my-5">
                    <thead>
                        <tr>
                            <th>@sortablelink('id', 'ID')</th>
                            <th>@sortablelink('name', 'Name')</th>
                            <th>@sortablelink('registration', 'Registration')</th>
                            <th>@sortablelink('department', 'Department')</th>
                            <th>Complain</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->registration}}</td>
                                <td>{{$item->department}}</td>
                                <td>{{$item->message}}</td>
                                @if ($item->status==0)
                                    <td><p class="bg-danger py-1 text-center" style="border-radius: 0.5rem">Uncompleted</p></td>
                                @else
                                    <td><p class="bg-success py-1 text-center" style="border-radius: 0.5rem">Completed</p></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $collection->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </div>
</body>
</html>