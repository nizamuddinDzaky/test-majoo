@extends('layout.main-layout')
@section('content')
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="icofont icofont-table bg-c-blue"></i>
                <div class="d-inline">
                    <h4>Bootstrap Basic Tables</h4>
                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Bootstrap Table</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Basic Table</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
<div class="card">
        <div class="card-header">
            <h5>Product Category Form</h5>
        </div>
        
        <form action="" method="POST" id="form">
            @csrf
            <div class="product-category-form">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Name</b></label>
                                <input name="name" type="text" class="form-control" id="" placeholder="Masukkan First Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Code</b></label>
                                <input name="code" type="text" class="form-control" id="" placeholder="Masukkan First Name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Basic table card start -->
    <div class="card">
        <div class="card-header">
            <h5>List Product Category</h5>
            <div class="card-header-right">    
                <ul class="list-unstyled card-option">       
                     <li><i class="icofont icofont-simple-left "></i></li>        
                     <li><i class="icofont icofont-maximize full-card"></i></li>        
                     <li><a id="btn-add-category" data-url-form = "{{route('add-product-category')}}"><i class="ti-plus"></i></li></a> 
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productCategory as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>{{$category->code}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm btn-get-data" data-url-get = "{{route('get-data-product-category', ['id'=> $category->id])}}" data-url-form = "{{route('update-data-product-category', ['id'=> $category->id])}}" >Edit</button>
                                <button type="button" class="btn btn-danger btn-sm btn-delete-data" data-url-delete = "{{route('delete-data-product-category', ['id'=> $category->id])}}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                        
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    collapse('product-category-form');
    $('#btn-add-category').click(function () {
       $('#form').attr('action', $(this).data('url-form'))
       collapse('product-category-form');
    })
    $(document).on('click','.btn-get-data', async function () {
        let  url = $(this).data('url-get');
        let resp = await send_data(url, 'GET', []);
        $('#form').fromJSON(JSON.stringify(resp.data.productCategory));
        collapse('product-category-form');
        $('#form').attr('action', $(this).data('url-form'))
    })
    $(document).on('click','.btn-delete-data', function () {
        sweet_alert("question", "Delete Data", "Are youe Sure ?", true).then((result) => {
            if (result.isConfirmed) {
                let  url = $(this).data('url-delete');
                deleteData(url);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                console.log("123")
            }
        })
    })
    async function deleteData(url) {
        try {
            
            let resp = await send_data(url, 'GET', []);
            sweet_alert("success", "Berhasil", resp.message).then(function (e) {
                window.location.href = resp.data.url;
            }, function (dismiss) {
                return false;
            })
        } catch (error) {
            sweet_alert("error", "Error", error).then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            })
        }
    }
</script>
@endsection