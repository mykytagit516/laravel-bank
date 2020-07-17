<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Metronic | Admin Dashboard Template</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!-- {{HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}} -->
{{HTML::style('assets/global/css/font.css')}} 
{{HTML::style('assets/global/plugins/font-awesome/css/font-awesome.min.css')}} 
{{HTML::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}} 
{{HTML::style('assets/global/plugins/bootstrap/css/bootstrap.min.css')}} 
{{HTML::style('assets/global/plugins/uniform/css/uniform.default.css')}} 
{{HTML::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}  
{{HTML::style('assets/admin/layout/css/chosen.css')}}


{{HTML::style('assets/global/bootstrap-modal/css/bootstrap-modal-bs3patch.css')}}
{{HTML::style('assets/global/bootstrap-modal/css/bootstrap-modal.css')}}
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
@yield('pageLevelPluginStyles')

<!-- END PAGE LEVEL PLUGIN STYLES -->

<!-- BEGIN PAGE STYLES -->
@yield('pageStyles')

<!-- END PAGE STYLES -->

<!-- BEGIN THEME STYLES -->
@yield('themeStyles')


<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="page-header-fixed page-quick-sidebar-over-content">
<!-- BEGIN HEADER -->
@include('layouts.header')
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
    @yield('content')
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
  <div class="page-footer-inner">
    Copyright Message Here
  </div>
  <div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
  </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
{{HTML::script('assets/global/plugins/respond.min.js')}}
{{HTML::script('assets/global/plugins/excanvas.min.js')}}
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

{{HTML::script('assets/global/bootstrap-modal/js/bootstrap-modalmanager.js')}}
{{HTML::script('assets/global/bootstrap-modal/js/bootstrap-modal.js')}}
{{HTML::script('assets/admin/pages/scripts/ui-extended-modals.js')}}

<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
@yield('pageLevelPlugins')
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
@yield('pageLevelScripts')
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN JAVASCRIPTS -->
@yield('javaScript')
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>