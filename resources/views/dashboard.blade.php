<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Portal</title>
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
    <div class="row">
        <div class="d-flex align-items-center mt-4 justify-content-around">
          <h1 class="h1 fw-bold text-center text-white" style="color: #0d6efd !important">Comsats University Islamabad, Wah Campus</h1>
          <a href="/logout" class="text-white text-decoration-none">Logout ></a>
        </div>
        <div class="col col-12 d-flex justify-content-center align-items-center flex-wrap">
            <div class="card m-4" style="width: 18rem;">
                <img src="{{asset('images/cafeteria.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Cafe</h5>
                  <p class="card-text">Register your complaint for cafe system.</p>
                  <a href="/complaint/cafe/{{$registration}}" class="btn btn-primary">Register</a>
                </div>
              </div>
              <div class="card m-4" style="width: 18rem;">
                <img src="{{asset('images/transport.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Transport</h5>
                  <p class="card-text">Register your complaint for transport section</p>
                  <a href="/complaint/transport/{{$registration}}" class="btn btn-primary">Register</a>
                </div>
              </div>
              <div class="card m-4" style="width: 18rem;">
                <img src="{{asset('images/furniture.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Classrooms</h5>
                  <p class="card-text">Register your complaint for classrooms management</p>
                  <a href="/complaint/classrooms/{{$registration}}" class="btn btn-primary">Register</a>
                </div>
              </div>
              <div class="card m-4" style="width: 18rem;">
                <img src="{{asset('images/hostel-vector-26477303.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Hostel</h5>
                  <p class="card-text">Register your complaint for hostel management</p>
                  <a href="/complaint/hostel/{{$registration}}" class="btn btn-primary">Register</a>
                </div>
              </div>
              <div class="card m-4" style="width: 18rem;">
                <img src="{{asset('images/admin.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Admin</h5>
                  <p class="card-text">Register your complaint for admin management</p>
                  <a href="/complaint/admin/{{$registration}}" class="btn btn-primary">Register</a>
                </div>
              </div>
              <div class="card m-4" style="width: 18rem;">
                <img src="{{asset('images/faculty.webp')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Faculty</h5>
                  <p class="card-text">Register your complaint for faculty management</p>
                  <a href="/complaint/faculty/{{$registration}}" class="btn btn-primary">Register</a>
                </div>
              </div>
              <div class="card m-4" style="width: 18rem;">
                <img src="{{asset('images/sports.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Sports</h5>
                  <p class="card-text">Register your complaint for sports management</p>
                  <a href="/complaint/sports/{{$registration}}" class="btn btn-primary">Register</a>
                </div>
              </div>
        </div>
    </div>
</body>

</html>
