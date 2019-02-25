@extends('layout')
@section('content')
<section class="site-content">
<div class="container">
<div class="breadcum-area">
    <div class="breadcum-inner">
        <h3>@lang('website.Forgot Password')</h3>
        <ol class="breadcrumb">
            
            <!-- <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li> -->
            <li class="breadcrumb-item active">@lang('website.Forgot Password')</li>
        </ol>
    </div>
</div>
<div class="registration-area">
	
	<div class="row justify-content-center">
	<div class="col-12 col-md-6 col-lg-5 registered-customers">
        	
            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">@lang('website.error'):</span>
                    {!! session('error') !!}
                    
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
			<h5 class="title-h4 text-right"> 
				@lang('website.Forgot Password')
			</h5>
			<p>@lang('website.Please Enter your email to recover your password')</p>

			<form name="signup" enctype="multipart/form-data" class="form-validate"  action="{{ URL::to('/processPassword')}}" method="post">

				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">@lang('website.Phone')</label>
					<div class="col-sm-9">
						<input type="number" name="phone" id="phone" class="form-control ">
						<span class="help-block error-content" hidden>@lang('website.Please enter your valid email address')</span>
					</div>
				</div>
				
                <div class="button text-right">
                	<a href="{{ URL::to('/login')}}" class="btn btn-link ml-1 mr-4">@lang('website.Login')</a>
                	<button type="submit" class="btn btn-dark">@lang('website.Send')</button>
                </div>


                
			</form>

		</div>
		<div class="col-12 col-md-6 col-lg-7 new-customers">
			<h5 class="title-h4 text-right">@lang('website.New Customers')</h5>
			<p>@lang('website.login page text for customer')</p>

			<hr class="featurette-divider">
			<p class="text-center">@lang('website.Dont have account') <a href="{{ URL::to('/signup')}}" class="btn btn-link ml-1"><b>@lang('website.Sign Up')</b></a></p>
			
			<!-- <p class="font-small dark-grey-text text-right d-flex justify-content-center mb-3 pt-2"> @lang('website.or Sign in with'):</p> -->

			<div class="row my-3 d-flex justify-content-center">
				<!--Facebook-->
				<!-- <a href="login/facebook" class="btn btn-light facebook"><i class="fa fa-facebook"></i>@lang('website.Login with Facebook')</a> -->
				<!--Google +-->
				<!-- <a href="login/google" class="btn btn-light google"><i class="fa fa-google-plus"></i>@lang('website.Login with Google')</a> -->
			</div>
		</div>
	</div>
</div> 
</div>
</section>
	
@endsection 	


