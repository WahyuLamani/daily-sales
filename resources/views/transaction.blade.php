<x-main-layout resources="resources/js/jquery.js,resources/js/datatables.js,resources/css/dataTables.bootstrap5.css" title="Transaction">
    <div class="container-fuild">
        <h1 class="app-page-title">Transaction</h1>

        <x-modal modal-id='NewOrder' title='Order Baru' size='modal-lg'>
            <div class="row">
                <form id="transaksiForm" action="{{ route('store.transaction') }}" method="POST">
                    @csrf
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
                    <div class="mb-3">
                        <label for="status_pembayaran" class="form-label">Kategori</label>
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
                    <div class="form-group">
                        <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                        <input type="number" name="jumlah_pembayaran" id="jumlah_pembayaran" class="form-control" step="0.01" readonly>
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
                                    <td><input type="number" name="produk[0][harga]" class="form-control harga" readonly /></td>
                                    <td><input type="number" name="produk[0][subtotal]" class="form-control subtotal" readonly /></td>
                                    <td><button type="button" class="removeRow btn btn-danger">Hapus</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                </form>
            </div>
            @push('modalScript')
            <script type="module">
                $(document).ready(function() {
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
                                        <td><input type="number" name="produk[${rowNumber}][harga]" class="form-control harga" readonly /></td>
                                        <td><input type="number" name="produk[${rowNumber}][subtotal]" class="form-control subtotal" readonly /></td>
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
                        console.log(stok, typeof stok);
                        if (parseInt(jumlah) > stok ) {
                            alert('Jumlah pembelian melebihi stok produk ' + $row.find('.product-select option:selected').text());
                            $(this).val(''); // Kosongkan input jumlah
                            updateSubtotal($row); // Update subtotal dengan nilai sebelumnya
                        } else {
                            updateSubtotal($row); // Update subtotal jika jumlah valid
                        }
                    });
                
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
                        console.log(stok)

                        if (parseInt(jumlah) > stok || isNaN(parseInt(jumlah))) {
                            isValid = false;
                            alert('Jumlah pembelian melebihi stok produk ' + $row.find('.product-select option:selected').text());
                            return false; // Hentikan iterasi
                        }
                    });

                    if (isValid) {
                        this.submit(); // Submit form jika valid
                    }
                });
                });
                </script>
            @endpush
        </x-modal>
        <div class="row">
            <div class="app-card">
                <button type="button" class="btn app-btn-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#modalNewOrder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5z"/>
                      </svg>
                      Order
                </button>
                <div class="p-3">
                    
                </div>
            </div>
        </div>
    </div>
</x-main-layout>