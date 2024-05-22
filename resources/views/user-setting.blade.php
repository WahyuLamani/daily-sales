<x-main-layout resources="resources/js/datatables.js" title="Setting">
    <div class="container-fuild">
        <h1 class="app-page-title">Settings</h1>
        <x-modal modal-id='CreateUser' title='Buat User baru' size=''>
            <div class="row">
                <form action="" method="post">@csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            id="nama">
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email">
                        @error('email')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                id="password">
                            <input type="password" name="password_confirmation" class="form-control" id="password" placeholder="Konfirmasi Password">
                            @error('password')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
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
                    data-bs-target="#modalCreateUser">
                    Create User
                </button>
                <div class="p-3">
                    <table id='data-table' class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($users as $user)
                           <tr>
                               <td>{{$loop->iteration}}</td>
                               <td>{{$user->name}}</td>
                               <td>{{$user->email}}</td>
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