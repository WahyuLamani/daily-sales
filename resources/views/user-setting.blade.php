<x-main-layout resources="resources/js/datatables.js,resources/css/dataTables.bootstrap5.css,resources/js/jquery.js,resources/js/sweetalert2.js" title="Setting">
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
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                            @error('password')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="settings-switch-1" name="is_admin">
                        <label class="form-check-label" for="settings-switch-1">Sebagai Admin ?</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" name="submit" class="btn app-btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </x-modal>
        <div class="row">
            <div class="app-card">
                <div class="p-2">
                    <button type="button" class="btn app-btn-primary my-3" data-bs-toggle="modal"
                        data-bs-target="#modalCreateUser">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                        User
                    </button>
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
                           <tr id="user-{{ $user->id }}">
                               <td>{{$loop->iteration}}</td>
                               <td>{{$user->name}}</td>
                               <td>{{$user->email}}</td>
                               <td>
                                <button class="btn btn-warning btn-reset" data-id="{{$user->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lock" viewBox="0 0 16 16">
                                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m0 5.996V14H3s-1 0-1-1 1-4 6-4q.845.002 1.544.107a4.5 4.5 0 0 0-.803.918A11 11 0 0 0 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664zM9 13a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1"/>
                                      </svg>
                                </button>
                                <button class="btn btn-danger btn-delete" data-id="{{$user->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                  </svg></button>
                               </td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        $(document).ready(function(){
            $(document).on('click', '.btn-delete', function(){
                let userId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "User ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/users/setting/' + userId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if(response.status === 'success'){
                                    $('#user-' + userId).remove();
                                    Swal.fire(
                                        'Dihapus!',
                                        'User telah dihapus.',
                                        'success'
                                    );
                                }else{
                                    Swal.fire(
                                        'Gagal!',
                                         response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Kesalahan!',
                                    'Terjadi kesalahan, coba lagi nanti.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
            $(document).on('click', '.btn-reset', function(){
                var userId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Password user ini akan direset!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, reset!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/users/setting/' + userId + '/reset-password',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Direset!',
                                    'Password user telah direset. Password baru: ' + response.newPassword,
                                    'success'
                                );
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Kesalahan!',
                                    'Terjadi kesalahan, coba lagi nanti.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        })
    </script>
</x-main-layout>