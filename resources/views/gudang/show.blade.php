<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head');
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>

.sticky {
    position: fixed;
  right: 20px;
  top: 20px;
}
.toast:not(.showing):not(.show) {
  display: none !important;
}

    </style>
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
                        <div class="text-center text-bold">STOCK OPNAME TOKO</div>
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
                                <th></th>
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
                                <td><a href="#" data-toggle="modal" data-target="#imageModal{{ $item->id }}">
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
                                {{ $item->opt_answare }}
                                @else
                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalJawab{{ $item->id }}">
                                    Jawab
                                </a>
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

    <!-- Modal -->
    @foreach ($requestProducts as $index => $item)
    <div class="modal fade" id="modalJawab{{ $item->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Jawab Permintaan
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
                    <div class="form-group">
                        <label>Jawaban</label>
                        {{-- <div class="form-group">
                            <select name="opt_answare" class="form-control">
                                <option>Tidak ada STOK</option>
                                <option>Diturunkan sesuai permintaan</option>
                                <option>Diturunkan sebagian</option>
                            </select>
                        </div> --}}
                        <div>
                            <input type="hidden" name="id" id="request-id" value="{{ $item->id }}">
                            <input type="hidden" name="total" value="{{ $item->total }}">
                            <input type="number" name="answare" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">
                        Close
                    </button>
                    <input type="submit" class="btn btn-primary" value="Save">
                </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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

<div class="toast sticky" id="toast" role="alert" aria-live="assertive" aria-atomic="true" data-animation="true" data-delay="5000"  style="position: fixed;top: 0; right: 0; z-index:1;" data-autohide="false">
    <div class="toast-header">
        <span class="rounded mr-2 bg-danger" style="width: 15px;height: 15px"></span>

        <strong class="mr-auto">Permintaan Barang</strong>
        <small></small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        <h4><font color="red">Mohon untuk segera di jawab</font></h4>
    </div>
</div>
<script>
    window.onscroll = function() {myFunction()};

    var header = document.getElementById("toast");
    var sticky = header.offsetTop;

    function myFunction() {
      if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    }
    </script>
<script>
    setInterval(function(){
		showNotif()
	}, 5000);

    function showNotif(){
        $('.toast').toast('show');
        console.log("modal");
    }

</script>
