<x-main-layout resources="resources/js/jquery.js,resources/js/sweetalert2.js,resources/js/datatables.js,resources/css/dataTables.bootstrap5.css" title="Product">
    <div class="container-fuild">
        <h1 class="app-page-title">Produk</h1>
        <x-modal modal-id='newProduk' title='Buat produk baru' size=''>
            <div class="row">
                <form action="" method="post">@csrf
                    <div class="mb-3">
                        <label for="produk" class="form-label">Nama Produk</label>
                        <input type="text" name="produk" class="form-control @error('produk') is-invalid @enderror"
                            id="produk">
                        @error('produk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" class="form-control @error('kategori') is-invalid @enderror"
                            id="kategori">
                            <option selected disabled>Pilih kategori </option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->nama_kategori}}</option>
                            @endforeach
                        </select>
                        @error('kategori')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                            id="harga">
                        @error('harga')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                            id="stok">
                        @error('stok')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" name="submit" class="btn app-btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </x-modal>
        <div class="row">
            <div class="app-card">
                <div class="p-3">
                    <button type="button" class="btn app-btn-primary my-3" data-bs-toggle="modal"
                        data-bs-target="#modalnewProduk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-fill-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1"/>
                            <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12 12 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7m6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.55 4.55 0 0 1 .23-2.002m-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-1.3-1.905"/>
                          </svg> 
                          Produk
                    </button>
                    <table id='data-table' class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr data-id="{{$product->id}}">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$product->nama_produk}}</td>
                                <td>{{$product->category->nama_kategori}}</td>
                                <td><span class="harga">{{$product->harga}}</span></td>
                                <td class="stok">{{$product->stok}}</td>
                                <td><button class="btn btn-warning updateBtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-plus-fill" viewBox="0 0 16 16">
                                    <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zm4.5 6V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5a.5.5 0 0 1 1 0"/>
                                  </svg></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        $(document).ready(function() {
            $('.updateBtn').click(function() {
                var row = $(this).closest('tr');
                var productId = row.data('id');
                var currentPrice = parseInt(row.find('.harga').text());
                var currentStock = row.find('.stok').text();
                console.log(currentPrice);

                // Tampilkan modal input menggunakan SweetAlert2
                Swal.fire({
                    title: 'Update Produk',
                    html:
                        '<input id="price" class="swal2-input" placeholder="Harga" type="number" value="' + currentPrice + '">' +
                        '<input id="stock" class="swal2-input" placeholder="Stok" type="number" value="' + currentStock + '">',
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            price: $('#price').val(),
                            stock: $('#stock').val()
                        };
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var price = result.value.price;
                        var stock = result.value.stock;

                        // Kirim request ke server untuk memperbarui data produk
                        $.ajax({
                            url: '/products/' + productId,
                            method: 'PUT',
                            data: {
                                price: price,
                                stock: stock,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Perbarui nilai di tabel
                                    row.find('.harga').text(price);
                                    row.find('.stok').text(stock);

                                    Swal.fire(
                                        'Berhasil!',
                                        'Data produk berhasil diperbarui.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Terjadi kesalahan saat memperbarui data produk.',
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
        });
    </script>
</x-main-layout>