@extends('layouts.defaultLogin')
@section('content')  
    <div class="signinpanel">        
    {{ Form::open(array('url' => url('user/login'), 'autocomplete' => 'off', 'class' =>'login-form', 'id' => 'submit_form')) }}
    <h3 class="form-title">Login to your account</h3>
    @if (!is_null(Session::get('status_error')))
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert" href="#">¡¿</a>
            <h4 class="alert-heading">Error!</h4>
            @if (is_array(Session::get('status_error')))
                <ul>
                @foreach (Session::get('status_error') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            @else
                {{ Session::get('status_error')}}
            @endif
        </div>
    @endif    
    <div class="alert alert-danger display-hide">
      <button class="close" data-close="alert"></button>
      <span>
      Enter any email and password. </span>
    </div>
    <div class="form-group">
      <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
      <label class="control-label visible-ie8 visible-ie9">Email</label>
      <div class="input-icon">
        <i class="fa fa-user"></i>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Password</label>
      <div class="input-icon">
        <i class="fa fa-lock"></i>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
      </div>
    </div>
    <div class="form-actions">
      <label class="checkbox">
      <input type="checkbox" name="remember" value="1"/> Remember me </label>
      <button type="submit" class="btn green pull-right">
      Login <i class="m-icon-swapright m-icon-white"></i>
      </button>
    </div>
    <div class="login-options">
      <h4>Or login with</h4>
      <ul class="social-icons">
        <li>
          <a class="facebook" data-original-title="facebook" href="#">
          </a>
        </li>
        <li>
          <a class="twitter" data-original-title="Twitter" href="#">
          </a>
        </li>
        <li>
          <a class="googleplus" data-original-title="Goole Plus" href="#">
          </a>
        </li>
        <li>
          <a class="linkedin" data-original-title="Linkedin" href="#">
          </a>
        </li>
      </ul>
    </div>
    <div class="forget-password">
      <h4>Forgot your password ?</h4>
      <p>
         no worries, click <a href="javascript:;" id="forget-password">
        here </a>
        to reset your password.
      </p>
    </div>
    <div class="create-account">
      <p>
         Don't have an account yet ?&nbsp; <a href="javascript:;" id="register-btn">
        Create an account </a>
      </p>
    </div>
  {{ Form::close() }}
  <!-- END LOGIN FORM -->
  <!-- BEGIN FORGOT PASSWORD FORM -->
 {{ Form::open(array('url' => url('user/request'), 'autocomplete' => 'off', 'class' =>'forget-form','id'=>'request_form' )) }} 
    <h3>Forget Password ?</h3>
    <p>
       Enter your e-mail address below to reset your password.
    </p>
    <div class="form-group">
      <div class="input-icon">
        <i class="fa fa-envelope"></i>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
      </div>
    </div>
    <div class="form-actions">
      <button type="button" id="back-btn" class="btn">
      <i class="m-icon-swapleft"></i> Back </button>
      <button type="submit" class="btn green pull-right">
      Submit <i class="m-icon-swapright m-icon-white"></i>
      </button>
    </div>
  {{ Form::close() }}
  <!-- END FORGOT PASSWORD FORM -->
  <!-- BEGIN REGISTRATION FORM -->
  {{ Form::open(array('url' => 'user/register','autocomplete' => 'off', 'method' => 'post', 'class' => 'register-form', 'id' => 'submit_form')) }}    
    <h3>Sign Up</h3>
    <p>
       Enter your personal details below:
    </p>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Frist Name</label>
      <div class="input-icon">
        <i class="fa fa-font"></i>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="firstname"/>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Last Name</label>
      <div class="input-icon">
        <i class="fa fa-font"></i>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Last Name" name="lastname"/>
      </div>
    </div>
    <div class="form-group">
      <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
      <label class="control-label visible-ie8 visible-ie9">Email</label>
      <div class="input-icon">
        <i class="fa fa-envelope"></i>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email"/>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Mobile</label>
      <div class="input-icon">
        <i class="fa fa-check"></i>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Mobile" name="mobile"/>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Title</label>
      <div class="input-icon">
        <i class="fa fa-location-arrow"></i>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Title" name="title"/>
      </div>
    </div>   
    <p>
       Enter your account details below:
    </p>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Password</label>
      <div class="input-icon">
        <i class="fa fa-lock"></i>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password"/>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
      <div class="controls">
        <div class="input-icon">
          <i class="fa fa-check"></i>
          <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword"/>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label>
      <input type="checkbox" name="tnc"/> I agree to the <a href="#">
      Terms of Service </a>
      and <a href="#">
      Privacy Policy </a>
      </label>
      <div id="register_tnc_error">
      </div>
    </div>
    <div class="form-actions">
      <button id="register-back-btn" type="button" class="btn">
      <i class="m-icon-swapleft"></i> Back </button>
      <button type="submit" id="register-submit-btn" class="btn green pull-right">
      Sign Up <i class="m-icon-swapright m-icon-white"></i>
      </button>
    </div>
  {{ Form::close() }} 
    </div><!-- signin -->
@endsection