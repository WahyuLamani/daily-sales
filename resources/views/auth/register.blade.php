<x-guest title='Register'>
    <div class="row g-0 app-auth-wrapper">
	    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5 w-100 h-100">
		    <div class="d-flex flex-column">
			    <div class="app-auth-body mx-auto">	
				    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"></a></div>
					<h2 class="auth-heading text-center mb-4">Sign up to Portal</h2>					
	
					<div class="auth-form-container text-start mx-auto">
						<form class="auth-form auth-signup-form" method="POST" action="{{route('register')}}">@csrf         
							<div class="email mb-3">
								<label class="sr-only" for="signup-email">Your Name</label>
								<input id="signup-name" name="name" type="text" class="form-control signup-name @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Full name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="email mb-3">
								<label class="sr-only" for="signup-email">Your Email</label>
								<input id="signup-email" name="email" type="email" class="form-control signup-email @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="signup-password">Password</label>
								<input id="signup-password" name="password" type="password" class="form-control signup-password @error('password') is-invalid @enderror" placeholder="Create a password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="confirm-password">Confirm Password</label>
								<input id="confirm-password" name="password_confirmation" type="password" class="form-control signup-password" placeholder="Confirm your password">
							</div>
							
							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Sign Up</button>
							</div>
						</form><!--//auth-form-->
						
						<div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="{{route('login')}}" >Log in</a></div>
					</div><!--//auth-form-container-->	
			    </div><!--//auth-body-->
		    </div><!--//flex-column-->   
	    </div><!--//auth-main-col-->
    
    </div><!--//row-->
</x-guest>