<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Metronic | Login Options - Login Form 1</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!--{{HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}} -->
{{HTML::style('assets/global/css/font.css')}}
{{HTML::style('assets/global/plugins/font-awesome/css/font-awesome.min.css')}} 
{{HTML::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}} 
{{HTML::style('assets/global/plugins/bootstrap/css/bootstrap.min.css')}} 
{{HTML::style('assets/global/plugins/uniform/css/uniform.default.css')}} 
{{HTML::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}} 

<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
{{HTML::style('assets/global/plugins/select2/select2.css')}} 
{{HTML::style('assets/admin/pages/css/login.css')}} 

<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
{{HTML::style('assets/global/css/components.css')}} 
{{HTML::style('assets/global/css/plugins.css')}} 
{{HTML::style('assets/admin/layout/css/layout.css')}} 
{{HTML::style('assets/admin/layout/css/themes/default.css')}} 
{{HTML::style('assets/admin/layout/css/custom.css')}} 
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
  <a href="#">
  <img src="assets/admin/layout/img/logo-big.png" alt=""/>
  </a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
  <!-- BEGIN LOGIN FORM -->
  @yield('content')
  <!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
  Copyright Message Here
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
{{HTML::script('assets/global/plugins/jquery-1.11.0.min.js')}}
{{HTML::script('assets/global/plugins/jquery-migrate-1.2.1.min.js')}}

<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
{{HTML::script('assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}
{{HTML::script('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}
{{HTML::script('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}

{{HTML::script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}
{{HTML::script('assets/global/plugins/jquery.blockui.min.js')}}
{{HTML::script('assets/global/plugins/jquery.cokie.min.js')}}
{{HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js')}}
{{HTML::script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
{{HTML::script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
{{HTML::script('assets/global/plugins/select2/select2.min.js')}}

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
{{HTML::script('assets/global/scripts/metronic.js')}}
{{HTML::script('assets/admin/layout/scripts/layout.js')}}
{{HTML::script('assets/admin/layout/scripts/quick-sidebar.js')}}
{{HTML::script('assets/admin/layout/scripts/demo.js')}}
{{HTML::script('assets/admin/pages/scripts/login.js')}}

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
  Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
  Login.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>