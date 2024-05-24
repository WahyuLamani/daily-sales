<x-main-layout resources="resources/js/jquery.js,resources/js/datatables.js,resources/js/sweetalert2.js,resources/css/dataTables.bootstrap5.css" title="Transaction">
    <div class="container-fuild">
        <h1 class="app-page-title">Transaction</h1>

        <x-modal modal-id='NewOrder' title='Order Baru' size='modal-lg'>
            <div class="row">
                <form id="transaksiForm" action="{{ route('store.transaction') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                                <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                    id="tanggal_transaksi">
                                @error('tanggal_transaksi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user" class="form-label">Petugas</label>
                                <input type="text" id="user" class="form-control" value="{{Auth::user()->name}}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-control @error('status_pembayaran') is-invalid @enderror"
                            id="status_pembayaran">
                            <option selected disabled>Pilih status pembayaran</option>
                            <option value="lunas">Lunas</option>
                            <option value="belum lunas">Belum lunas</option>
                        </select>
                        @error('status_pembayaran')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_pembayaran" class="form-label">Jumlah Pembayaran</label>
                        <input type="number" name="jumlah_pembayaran" class="form-control @error('jumlah_pembayaran') is-invalid @enderror" id="jumlah_pembayaran" step="0.01" readonly disabled>
                        @error('jumlah_pembayaran')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>

                    <h4>Detail Produk</h4>
                    <button type="button" id="addRow" class="btn app-btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                      </svg></button>
                    <div class="col-lg-12">
                        <table class="table" id="produkTable">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Stok</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                    <th>tambah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="produk[0][id_produk]" class="form-control product-select">
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $p)
                                                <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="stok">0</td>
                                    <td><input type="number" name="produk[0][jumlah]" class="form-control jumlah" /></td>
                                    <td><input type="number" name="produk[0][harga]" class="form-control harga" readonly disabled/></td>
                                    <td><input type="number" name="produk[0][subtotal]" class="form-control subtotal" readonly disabled/></td>
                                    <td><button type="button" class="removeRow btn btn-danger">Hapus</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12 gap-2 d-flex justify-content-end">
                            <button type="button" id="kalkulasi" class="btn btn-info">Total Pembayaran</button>
                            <button type="submit" id="submitForm" class="btn btn-success">Simpan Transaksi</button>
                        </div>
                    </div>
                </form>
            </div>
        </x-modal>
        <x-modal modal-id="SeeProduk" title="List Produk" size="modal-xl">
            <table style="width:100% ; font-size: 22px" class="table data-table table-striped">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th style="text-align: center">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->category->nama_kategori}}</td>
                        <td><b>{{$product->nama_produk}}</b></td>
                        <td>Rp. {{number_format($product->harga)}}</td>
                        <td style="text-align: center">{{$product->stok}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-modal>
        <div class="row">
            <div class="app-card">
                <div class="p-3">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn app-btn-primary my-3" data-bs-toggle="modal"
                        data-bs-target="#modalNewOrder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5z"/>
                        </svg>
                        Order
                    </button>
                    <button type="button" class="btn btn-dark my-3" data-bs-toggle="modal"
                        data-bs-target="#modalSeeProduk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database" viewBox="0 0 16 16">
                            <path d="M4.318 2.687C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4c0-.374.356-.875 1.318-1.313M13 5.698V7c0 .374-.356.875-1.318 1.313C10.766 8.729 9.464 9 8 9s-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777A5 5 0 0 0 13 5.698M14 4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13zm-1 4.698V10c0 .374-.356.875-1.318 1.313C10.766 11.729 9.464 12 8 12s-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777A5 5 0 0 0 13 8.698m0 3V13c0 .374-.356.875-1.318 1.313C10.766 14.729 9.464 15 8 15s-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13s3.022-.289 4.096-.777c.324-.147.633-.323.904-.525"/>
                          </svg>
                        Produk
                    </button>
                    </div>
                    <table id="data-table" class="table data-table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>User</th>
                                <th style="text-align: left">Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$transaction->user->name}}</td>
                                <td style="text-align: left">{{$transaction->tanggal_transaksi}}</td>
                                <td><span class="status-pembayaran badge text-bg-{{$transaction->status_pembayaran == 'lunas' ? 'success' : 'warning'}}">{{$transaction->status_pembayaran}}</span></td>
                                <td>Rp. {{number_format($transaction->total_harga)}}</td>
                                <td>
                                    <button class="btn btn-dark view-pdf" data-id="{{ $transaction->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                                            <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
                                            <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
                                          </svg>
                                    </button>
                                    <a href="transaksi/{{ $transaction->id }}/download" class="btn btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0"/>
                                          </svg>
                                    </a>
                                    @if ($transaction->status_pembayaran == 'belum lunas')
                                        <button class="btn btn-primary handle-pembayaran" data-id="{{ $transaction->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Klik untuk Pelunasan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1"/>
                                            </svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-modal modal-id='Transaksi' title='Detail transaksi' size='modal-lg'>
        <iframe id="pdfFrame" src="" width="100%" height="600px" frameborder="0"></iframe>
    </x-modal>
    <script type="module">
        $('#submitForm').hide();
        $(document).ready(function() {
            $(document).on('click', '.handle-pembayaran', function() {
                let idTransaksi = $(this).data('id')
                let $rowtx = $(this).closest('tr');
                let status = $rowtx.find('.status-pembayaran')
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Lunasi Pembayaran User" ,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, bayar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim request ke server untuk menyimpan pembayaran
                        $.ajax({
                            url: '/order/payment',
                            method: 'POST',
                            data: {
                                id: idTransaksi,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if(response.status === 'success') {
                                    Swal.fire(
                                        'Berhasil!',
                                        'Pembayaran berhasil dilakukan.',
                                        'success'
                                    );
                                    $('.handle-pembayaran').hide();
                                    status.text('lunas')
                                    status.removeClass('text-bg-warning').addClass('text-bg-success');
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan: ' + error,
                                    'error'
                                );
                            }
                        });
                    }
                });
                
            });

            let rowNumber = 1;      
            $('#addRow').click(function() {
                let row = `<tr>
                                <td>
                                    <select name="produk[${rowNumber}][id_produk]" class="form-control product-select">
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="stok">0</td>
                                <td><input type="number" name="produk[${rowNumber}][jumlah]" class="form-control jumlah" /></td>
                                <td><input type="number" name="produk[${rowNumber}][harga]" class="form-control harga" readonly disabled/></td>
                                <td><input type="number" name="produk[${rowNumber}][subtotal]" class="form-control subtotal" readonly disabled/></td>
                                <td><button type="button" class="removeRow btn btn-danger">Hapus</button></td>
                            </tr>`;
                $('#produkTable tbody').append(row);
                rowNumber++;
            });
        
            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });
        
            $(document).on('change', '.product-select', function() {
                let $row = $(this).closest('tr');
                let productId = $(this).val();
                if (productId) {
                    $.ajax({
                        url: '/produk/' + productId + '/harga-stok',
                        method: 'GET',
                        success: function(response) {
                            $row.find('.harga').val(response.harga);
                            $row.find('.stok').text(response.stok);
                            updateSubtotal($row);
                        }
                    });
                }
            });
        
            $(document).on('input', '.jumlah', function() {
                let $row = $(this).closest('tr');
                let jumlah = parseInt($(this).val());
                let stok =parseInt($row.find('.stok').text());
                if (parseInt(jumlah) > stok ) {
                    Swal.fire(
                        'Error!',
                        'Jumlah pembelian melebihi stok produk ' + $row.find('.product-select option:selected').text(),
                        'error'
                    );
                    $(this).val(''); // Kosongkan input jumlah
                    updateSubtotal($row); // Update subtotal dengan nilai sebelumnya
                } else {
                    updateSubtotal($row); // Update subtotal jika jumlah valid
                }
            });

            $('#kalkulasi').click(function() {
                calculateTotal();
            });

            function calculateTotal() {
                let totalPembayaran = 0;
                $('.subtotal').each(function() {
                    totalPembayaran += parseFloat($(this).val() || 0);
                });
                $('#jumlah_pembayaran').val(totalPembayaran);
                $('#submitForm').show();
            }
        
            function updateSubtotal($row) {
                let jumlah = $row.find('.jumlah').val();
                let harga = $row.find('.harga').val();
                let subtotal = jumlah * harga;
                $row.find('.subtotal').val(subtotal);
            }

            // validasi stok
            $('#transaksiForm').submit(function(event) {
                event.preventDefault(); // Mencegah submit default

                let isValid = true;
                $('.product-select').each(function() {
                    let $row = $(this).closest('tr');
                    let productId = $(this).val();
                    let jumlah = $row.find('.jumlah').val();
                    let stok = parseInt($row.find('.stok').text());

                    if (parseInt(jumlah) > stok || isNaN(parseInt(jumlah))) {
                        isValid = false;
                        Swal.fire(
                            'Error!',
                            'Jumlah pembelian melebihi stok produk ' + $row.find('.product-select option:selected').text(),
                            'error'
                        );
                        return false; // Hentikan iterasi
                    }
                });

                if (isValid) {
                    $('#transaksiForm :input').prop('disabled', false);
                    this.submit(); // Submit form jika valid
                }
            });

            $(document).on('mouseenter', '.view-pdf', function() {
                var transaksiId = $(this).data('id');
                console.log(transaksiId);
                var url = '/transaksi/' + transaksiId + '/pdf';
                $('#pdfFrame').attr('src', url);
                $(this).attr('data-bs-toggle' , 'modal');
                $(this).attr('data-bs-target', '#modalTransaksi');
            });
        });
    </script>
</x-main-layout>