<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap Multiple Item Product Carousel</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');

body {
    background: #F5F1EE;
    font-family: 'Roboto', sans-serif
}

.card {
    width: 250px;
    border-radius: 10px
}

.card-img-top {
    border-top-right-radius: 10px;
    border-top-left-radius: 10px
}

span.text-muted {
    font-size: 12px
}

small.text-muted {
    font-size: 8px
}

h5.mb-0 {
    font-size: 1rem
}

small.ghj {
    font-size: 9px
}

.mid {
    background: #ECEDF1
}

h6.ml-1 {
    font-size: 13px
}

small.key {
    text-decoration: underline;
    font-size: 9px;
    cursor: pointer
}

.btn-danger {
    color: #FFCBD2
}

.btn-danger:focus {
    box-shadow: none
}

small.justify-content-center {
    font-size: 9px;
    cursor: pointer;
    text-decoration: underline
}

@media screen and (max-width:600px) {
    .col-sm-4 {
        margin-bottom: 50px
    }
}
</style>
<script>
$(document).ready(function(){
	$(".wish-icon i").click(function(){
		$(this).toggleClass("fa-heart fa-heart-o");
	});
});	
</script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <li class="nav-item">
        <a class="nav-link" href="{{route('login')}}">Login</a>
      </li>
    </ul>
  </div>
</nav>
<div class="container-fluid d-flex justify-content-center">
    <div class="row mt-5">
        @foreach($products as $product)
        <div class="col-sm-4">
            <div class="card"> <img src="{{asset('storage/uploads/'.$product->path_image)}}" class="card-img-top" width="100%">
                <div class="card-body pt-0 px-0">
                    <p class="text-center">{{$product->name}} -  <small>{{$product->category->name}}</small></p>
                    <hr>
                    <p class="text-center"><small>Rp {{ number_format($product->price,2,',','.'); }}</small></p>
                    
                    <hr class="mt-2 mx-3">
                    <div class="flex-row justify-content-between px-3 pb-4">
                        {{$product->description}}
                    </div>
                    <div class="mx-3 mt-3 mb-2"><button type="button" class="btn btn-danger btn-block"><small>BUILD & PRICE</small></button></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</body>
</html>                                		