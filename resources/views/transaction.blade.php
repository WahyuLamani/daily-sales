<x-main-layout resources="resources/js/datatables.js,resources/css/dataTables.bootstrap5.css" title="Transaction">
    <div class="container-fuild">
        <h1 class="app-page-title">Transaction</h1>

        <x-modal modal-id='newProduk' title='Buat produk baru'>
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
                            <option selected disabled>select one</option>
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
                <button type="button" class="btn app-btn-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#newProduk">
                    Create produk baru
                </button>
                <div class="p-3">
                    <table class="table table-striped">
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
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$product->nama_produk}}</td>
                                <td>{{$product->category->nama_kategori}}</td>
                                <td>{{$product->harga}}</td>
                                <td>{{$product->stok}}</td>
                                <td>action</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>