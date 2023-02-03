<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head');
</head>
<body>
<div class="wrapper">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><img src="{{ asset('assets/img/logo2.png') }}" alt="User Image" width="50%">
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
                @endif
                <div class="card-body">
                    <div class="col mb-4">
                        <div class="text-center text-bold">APLIKASI PERMINTAAN BARANG</div>
                        <div class="text-left">
                            <label>{{ date('Y-m-d H:i:s') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Sales</th>
                                <th scope="col"></th>
                                <th scope="col">Permintaan Barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Jam Minta</th>
                                <th scope="col">Jam Selesai</th>
                                <th scope="col">Jawaban Gudang</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($requestProducts as $index => $item)
                              <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    @if(!empty($item->sales_name))
                                    {{ $item->sales_name }}
                                    @else
                                    {{ $item->user_name }}
                                    @endif
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#imageModal{{ $item->id }}">
                                        <img src="https://tianliong.co.id/info/assets/img/products/{{ $item->gambar }}" width="60"></a></td>

                                <td>
                                    {{ $item->kode_barang }}<br>
                                    {{ $item->nama_barang }}
                                </td>
                                <td>{{ $item->total }}</td>
                                <td>{{ $item->request_time }}</td>
                                <td>{{ $item->answare_time }}</td>
                                <td>
                                    @if($item->opt_answare)
                                    {{ $item->opt_answare }}<br>
                                    {{ $item->answare }}<hr>
                                    <div class="col-6">
                                        <a class="btn btn-danger" href="{{ url('deleteRequest') }}/{{$item->request_id}}">
                                        Selesai
                                    </a>
                                    </div>

                                    @endif
                                </td>
                              </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                        <hr>
                        <div id="jumlah" style="display: block">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ url('stocks') }}" class="btn btn-primary">Kembali</a>

                                    <a href="{{ url('history') }}" class="btn btn-primary">History</a>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="far fa-circle nav-icon"></i>
                                    {{ __('Logout') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                    </form>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<footer class="main-footer">
    <strong>@2022<a href="#">Tiang Liong</a>.</strong>
    All rights reserved.
  </footer>
</div>
</body>
<link rel="stylesheet" href=
"https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity=
"sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I"
        crossorigin="anonymous">
    <script src=
"https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity=
"sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous">
    </script>
    <script src=
"https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity=
"sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous">
    </script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#btnsearch').click(function(e){
          e.preventDefault();
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "{{ route('product.search') }}",
             method: 'post',
             data: {
                kode_barang: jQuery('#kode_barang').val(),
             },
             success: function(result){
                var result = JSON.parse(result);

                if(result.statusCode == 200){
                    jQuery('#merk').html(result.data.merk);
                    jQuery('#nama_barang').html(result.data.nama_barang);
                    jQuery('#barcode').html(result.data.barcode);
                    jQuery('#satuan').html(result.data.satuan);
                    jQuery('#id').val(result.data.id);
                    var x = document.getElementById("jumlah");
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    } else {
                        x.style.display = "none";
                    }
                }else{
                    alert("Data tidak ditemukan !");
                }
             }});
          });
       });
</script>
<!-- Modal -->
@foreach ($requestProducts as $index => $item)
<div class="modal fade" id="imageModal{{ $item->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                    </h5>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <form method="POST" action="{{ route('request.update') }}">
                @csrf
                <div class="modal-body">
                    <img src="https://tianliong.co.id/info/assets/img/products/{{ $item->gambar }}"></a></td>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">
                        Close
                    </button>
                </div>
                </form>
            </div>
        </div>
</div>
@endforeach
