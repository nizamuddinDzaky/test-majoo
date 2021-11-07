@extends('layout.main-layout')
@section('content')
<style>
    .custom-select {
  display: inline-block;
  width: 100%;
  height: calc(2.25rem + 2px);
  padding: 0.375rem 1.75rem 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  vertical-align: middle;
  background: #fff url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E") no-repeat right 0.75rem center/8px 10px;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
}
</style>
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
<input type="hidden" name="" id="defaultPatImage" value="{{asset('storage/uploads/')}}">
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <h5>Product Form</h5>
        </div>
        <form action="" method="POST" id="form">
            @csrf
            <div class="product-form">
                <div class="card-body">
                    <div class="row">
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Category</b></label>
                                <select name="category_id" id="" class="select2">
                                    <option value=""></option>
                                    @foreach($productCatgory as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Price</b></label>
                                <input name="price"   data-identifier = "formatrupiah" type="text" class="form-control price" id="" placeholder="" value="123123">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Description</b></label>
                                <textarea name="description" type="text" class="form-control " id="" placeholder="Masukkan Alamat" style="height: 100px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" name="image" id="image" class = "form-control" onchange="uploadFile()">
                                <br>
                                <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
                                <h3 id="status"></h3>
                                <p id="loaded_n_total"></p>
                                <img src="" id="avatar_preview" class="avatar" width="150px"/>
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
            <h5>List Product</h5>
            <div class="card-header-right">    
                <ul class="list-unstyled card-option">       
                     <li><i class="icofont icofont-simple-left "></i></li>        
                     <li><i class="icofont icofont-maximize full-card"></i></li>        
                     <li><a id="btn-add-product" data-url-form = "{{route('add-product')}}"><i class="ti-plus"></i></li></a> 
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Name (Code)</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td><img src='{{asset('storage/uploads/'.$product->path_image)}}'  style="height: 50px;"></td>
                            <td>{{$product->name}} {{$product->code}} </td>
                            <td>{{$product->category->name}}</td>
                            <td> Rp {{ number_format($product->price,2,',','.'); }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm btn-get-data" data-url-get = "{{route('get-data-product', ['id'=> $product->id])}}" data-url-form = "{{route('update-data-product', ['id'=> $product->id])}}" >Edit</button>
                                <button type="button" class="btn btn-danger btn-sm btn-delete-data" data-url-delete = "{{route('delete-data-product', ['id'=> $product->id])}}">Delete</button>
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
    collapse('product-form');
    $('.select2').select2({ placeholder: "Select an Option", allowClear: true, theme: 'bootstrap4'});
    $('#btn-add-product').click(function () {
       $('#form').attr('action', $(this).data('url-form'))
       collapse('product-form');
    })
    $(document).on('click','.btn-get-data', async function () {
        let  url = $(this).data('url-get');
        let resp = await send_data(url, 'GET', []);
        console.log(resp);
        $('#form').fromJSON(JSON.stringify(resp.data.product));
        collapse('product-form');
        let defaultPathImage = $('#defaultPatImage').val()
        $('#avatar_preview').attr('src',defaultPathImage +'/'+ resp.data.product.path_image)
        $('#form').attr('action', $(this).data('url-form'))
    })
    var rupiah = document.getElementsByClassName('price');
    for ( let i=0; i < rupiah.length; i++){
        rupiah[i].addEventListener('keyup', function(e){
            rupiah[i].value = formatRupiah(this.value, 'Rp. ');
        })
    };

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
function _(el) {
    return document.getElementById(el);
}

function uploadFile() {
  var file = _("image").files[0];
  previewImage(file);
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData();
  formdata.append("image", file);
  formdata.append("_token", "{{csrf_token()}}");
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "file-upload-parser"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
  //use file_upload_parser.php from above url
  ajax.send(formdata);
}
function previewImage(params) {
    var reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('avatar_preview').setAttribute('src', e.target.result);
    };

    reader.readAsDataURL(params);
}
function progressHandler(event) {
  _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
  _("status").innerHTML = event.target.responseText;
  _("progressBar").value = 0; //wil clear progress bar after successful upload
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}
</script>
@endsection