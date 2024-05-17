<x-guest title='Login'>
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5 w-100 h-100">
            <div class="d-flex flex-column">
                <div class="app-auth-body mx-auto">	
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"></a></div>
                    <h2 class="auth-heading text-center mb-5">Log in to Portal</h2>
                    <div class="auth-form-container text-start">
                        <form class="auth-form login-form " method="POST" action="{{ route('login') }}">@csrf       
                            <div class="email mb-3">
                                <label class="sr-only" for="signin-email">Email</label>
                                <input id="signin-email" name="email" type="email" class="form-control signin-email @error('email') is-invalid @enderror" placeholder="Email address" value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div><!--//form-group-->
                            <div class="password mb-3">
                                <label class="sr-only" for="signin-password">Password</label>
                                <input id="signin-password" name="password" type="password" class="form-control signin-password @error('password') is-invalid @enderror" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="extra mt-3 row justify-content-between">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="RememberPassword" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="RememberPassword">
                                            Remember me
                                            </label>
                                        </div>
                                        
                                    </div><!--//col-6-->
                                    <div class="col-6">
                                        @if (Route::has('password.request'))   
                                            <div class="forgot-password text-end">
                                                <a href="{{route('password.request')}}">Forgot password?</a>
                                            </div>
                                        @endif
                                    </div><!--//col-6-->
                                </div><!--//extra-->
                            </div><!--//form-group-->
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
                            </div>
                        </form>
                        
                        <div class="auth-option text-center pt-5">No Account? Sign up <a class="text-link" href="{{route('register')}}" >here</a>.</div>
                    </div><!--//auth-form-container-->	

                </div><!--//auth-body-->
            
            </div><!--//flex-column-->   
        </div><!--//auth-main-col-->
    </div>
</x-guest>