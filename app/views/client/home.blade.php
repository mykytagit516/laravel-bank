@extends('layouts.default')

@section('pageLevelPluginStyles')
	{{HTML::style('assets/global/plugins/gritter/css/jquery.gritter.css')}} 
	{{HTML::style('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}
	{{HTML::style('assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css')}}
	{{HTML::style('assets/global/plugins/jqvmap/jqvmap/jqvmap.css')}}
@endsection

@section('pageStyles')
	{{HTML::style('assets/admin/pages/css/tasks.css')}}
@endsection

@section('themeStyles')
	{{HTML::style('assets/global/css/components.css')}}
	{{HTML::style('assets/global/css/plugins.css')}}
	{{HTML::style('assets/admin/layout/css/layout.css')}}
	{{HTML::style('assets/admin/layout/css/themes/default.css')}}
	{{HTML::style('assets/admin/layout/css/custom.css')}}
@endsection

@section('content')
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
    @include('client.sidebar')
	<!-- END SIDEBAR -->

	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">		
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Dashboard
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="{{URL::route('client/home')}}">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Dashboard</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range">
						<i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN DASHBOARD STATS -->
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								 1349
							</div>
							<div class="desc">
								 New Feedbacks
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 12,5M$
							</div>
							<div class="desc">
								 Total Profit
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 549
							</div>
							<div class="desc">
								 New Orders
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 +89%
							</div>
							<div class="desc">
								 Brand Popularity
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- END DASHBOARD STATS -->
			<div class="clearfix">
			</div>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
@endsection

@section('pageLevelPlugins')
{{HTML::script('assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js')}}
{{HTML::script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js')}}
{{HTML::script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js')}}
{{HTML::script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js')}}
{{HTML::script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js')}}
{{HTML::script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js')}}
{{HTML::script('assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js')}}
{{HTML::script('assets/global/plugins/flot/jquery.flot.min.js')}}
{{HTML::script('assets/global/plugins/flot/jquery.flot.resize.min.js')}}
{{HTML::script('assets/global/plugins/flot/jquery.flot.categories.min.js')}}
{{HTML::script('assets/global/plugins/jquery.pulsate.min.js')}}
{{HTML::script('assets/global/plugins/bootstrap-daterangepicker/moment.min.js')}}
{{HTML::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}

<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
{{HTML::script('assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js')}}
{{HTML::script('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}
{{HTML::script('assets/global/plugins/jquery.sparkline.min.js')}}
{{HTML::script('assets/global/plugins/gritter/js/jquery.gritter.js')}}
@endsection

@section('pageLevelScripts')
{{HTML::script('assets/global/scripts/metronic.js')}}
{{HTML::script('assets/admin/layout/scripts/layout.js')}}
{{HTML::script('assets/admin/layout/scripts/quick-sidebar.js')}}
{{HTML::script('assets/admin/layout/scripts/demo.js')}}
{{HTML::script('assets/admin/pages/scripts/index.js')}}
{{HTML::script('assets/admin/pages/scripts/tasks.js')}}
@endsection

@section('javaScript')
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init(); // init quick sidebar
   Demo.init(); // init demo features 

});
</script>
@endsection