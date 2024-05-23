<x-main-layout resources="resources/js/datatables.js,resources/js/jquery.js,resources/js/sweetalert2.js" title="Account">
    <div class="container-fluid">			    
        <h1 class="app-page-title">Account Management</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-4">
                <h3 class="section-title">Personal</h3>
                <div class="section-intro">Berisi data pribadi anda. tekan Update jika ingin mengupdate data. Jika anda ingin melihat User lain <a href="{{route('user.setting')}}">Klik disini</a></div>
            </div>
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    
                    <div class="app-card-body">
                        <form id="accountForm" class="settings-form">@csrf
                            <div class="mb-3">
                                <label for="setting-input-1" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" id="setting-input-1" value="{{ucwords($user->name)}}" required>
                            </div>
                            <div class="mb-3">
                                <label for="setting-input-2" class="form-label">Email Address</label>
                                <input type="text" class="form-control" name="email" id="setting-input-2" value="{{$user->email}}" required>
                            </div>
                            <div class="mb-3">
                                <label for="setting-input-3" class="form-label">Password sebelumnya</label>
                                <input type="password" class="form-control" name="current_password" id="setting-input-3">
                            </div>
                            <div class="mb-3">
                                <label for="setting-input-4" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="new_password" id="setting-input-4">
                            </div>
                            <div class="mb-3">
                                <label for="setting-input-5" class="form-label">Konfirmasi Password baru</label>
                                <input type="password" class="form-control" name="new_password_confirmation" id="setting-input-5">
                            </div>
                            <button type="submit" class="btn app-btn-primary" >Save Changes</button>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div> 
    <script type="module">
        $(document).ready(function() {
            $('#accountForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("user.account.update") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        let errorText = '';

                        $.each(errors, function(key, value) {
                            errorText += value[0] + '<br>';
                        });

                        Swal.fire({
                            title: 'Kesalahan!',
                            html: errorText,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
</x-main-layout>