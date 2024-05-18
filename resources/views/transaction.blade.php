<x-main-layout resources="resources/js/datatables.js,resources/css/dataTables.bootstrap5.css" title="Transaction">
    <div class="container-fuild">
        <h1 class="app-page-title">Transaction</h1>

        <x-modal modal-id='NewOrder' title='Order Baru'>
            <div class="row">
                <form id="transaksiForm" action="{{ route('store.transaction') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tanggal_transaksi">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status_pembayaran">Status Pembayaran</label>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                    </div>
            
                    <h4>Detail Produk</h4>
                    <table class="table" id="produkTable">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th><button type="button" id="addRow" class="btn btn-primary">Tambah Produk</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="produk[0][id_produk]" class="form-control">
                                        @foreach($products as $p)
                                            <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="produk[0][jumlah]" class="form-control" /></td>
                                <td><input type="number" name="produk[0][subtotal]" class="form-control" /></td>
                                <td><button type="button" class="removeRow btn btn-danger">Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                </form>
            </div>
            @push('modalScript')
                <script>
                    $(document).ready(function() {
                        let rowNumber = 1;

                        $('#addRow').click(function() {
                            let row = `<tr>
                                            <td>
                                                <select name="produk[${rowNumber}][id_produk]" class="form-control">
                                                    @foreach($produk as $p)
                                                        <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="produk[${rowNumber}][jumlah]" class="form-control" /></td>
                                            <td><input type="number" name="produk[${rowNumber}][subtotal]" class="form-control" /></td>
                                            <td><button type="button" class="removeRow btn btn-danger">Hapus</button></td>
                                        </tr>`;
                            $('#produkTable tbody').append(row);
                            rowNumber++;
                        });

                        $(document).on('click', '.removeRow', function() {
                            $(this).closest('tr').remove();
                        });
                    });
                </script>
            @endpush
        </x-modal>
        <div class="row">
            <div class="app-card">
                <button type="button" class="btn app-btn-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#modalNewOrder">
                    Create produk baru
                </button>
                <div class="p-3">
                    
                </div>
            </div>
        </div>
    </div>
</x-main-layout>