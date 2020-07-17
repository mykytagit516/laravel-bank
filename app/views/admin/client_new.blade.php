@extends('layouts.default')

@section('pageLevelPluginStyles')
  {{HTML::style('assets/global/plugins/select2/select2.css')}} 
  {{HTML::style('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}
  {{HTML::style('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}
  {{HTML::style('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}
@endsection

@section('themeStyles')
  {{HTML::style('assets/global/css/components.css')}}
  {{HTML::style('assets/global/css/plugins.css')}}
  {{HTML::style('assets/admin/layout/css/layout.css')}}
  {{HTML::style('assets/admin/layout/css/themes/default.css')}}
  {{HTML::style('assets/admin/layout/css/custom.css')}} 
  <!-- BEGIN CONFIRM DIALOG -->
  {{HTML::style('assets/admin/layout/jquery.confirm/jquery.confirm.css')}}
  <!-- END CONFIRM DIALOG -->
@endsection

@section('content')
<div class="page-container">
  <!-- BEGIN SIDEBAR -->
	@if ($user->permission == 'administrator')
		@include('admin.sidebar')
	@else
		@include($user->permission . '.sidebar')
	@endif
  <!-- END SIDEBAR -->
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content">     
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
      Client Management 
      </h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li>
            <i class="fa fa-home"></i>
            <a href="{{URL::route('admin/home')}}">Home</a>
            <i class="fa fa-angle-right"></i>
          </li>
          <li>
            <a href="{{URL::route('admin/clients')}}">{{$title}}</a>
            <i class="fa fa-angle-right"></i>
          </li>
          <li>
            {{$sub_title}}
          </li>
        </ul>
      </div>
      <!-- END PAGE HEADER-->
	@if (!is_null(Session::get('status_success')))
	<div class="alert alert-success">
		<a class="close" data-dismiss="alert" href="#">×</a>
		@if (is_array(Session::get('status_success')))
			<ul>
			@foreach (Session::get('status_success') as $success)
				<li>{{ $success }}</li>
			@endforeach
			</ul>
		@else
			{{ Session::get('status_success') }}
		@endif
	</div>
	@endif
      <!-- BEGIN PAGE CONTENT-->
      <div class="row">
        <div class="col-md-12">
          <!-- BEGIN VALIDATION STATES-->
          <div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-gift"></i>{{$sub_title}}
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
                <a href="javascript:;" class="remove">
                </a>
              </div>
            </div>
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
			  @if ($clientByID == null)
              {{Form::open(array('url' => 'admin/client_add', 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'clientAdd', 'autocomplete' => 'off'))}}
			  @else
              {{Form::open(array('url' => 'admin/client_update', 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'clientAdd', 'autocomplete' => 'off'))}}
			  @endif
				<input type="hidden" name="id" id="id" value="@if($clientByID != null){{$clientByID->id}}@endif">
                <div class="form-body">
                  <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Name <span class="required">
                    * </span>
                    </label>
                    <div class="col-md-4">
                      <input type="text" name="name" data-required="1" class="form-control" value="@if($clientByID != null){{$clientByID->name}}@endif"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Address <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <input type="text" name="address" data-required="1" class="form-control" value="@if($clientByID != null){{$clientByID->address}}@endif"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">ABN <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <input name="abn" type="text" class="form-control" value="@if($clientByID != null){{$clientByID->abn}}@endif"/>                      
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Phone <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <input name="phone" type="text" class="form-control" value="@if($clientByID != null){{$clientByID->phone}}@endif"/>                      
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Email <span class="required">
                    * </span>
                    </label>
                    <div class="col-md-4">
                      <input name="email" type="text" class="form-control" @if($clientByID !=null) disabled @endif value="@if($clientByID != null) {{$clientByID->email}} @endif"/>
                    </div>
                  </div>                  

                  <div class="form-group">
                    <label class="control-label col-md-3">Region <span class="required">
                    * </span></label>
                    <div class="col-md-4">
						  @if ($clientByID == null)
						  <select class="form-control" name="region">
							<option value="Byronia">Byronia</option>
							<option value="Region 001">Region 002</option>
							<option value="Region 001">Region 003</option>
							<option value="Region 001">Region 004</option>
							<option value="Region 001" selected>Region 005</option>
						  </select>
						  @else
						  <select class="form-control" name="region">
							<option value="administrator" @if($clientByID->region == 'Byronia') selected @endif>{{$clientByID->region}}</option>
							<option value="master" @if($clientByID->region == 'Region 002') selected @endif>{{$clientByID->region}}</option>
							<option value="manager" @if($clientByID->region == 'Region 003') selected @endif>{{$clientByID->region}}</option>
							<option value="contractor" @if($clientByID->region == 'Region 004') selected @endif>{{$clientByID->region}}</option>
							<option value="client"  @if($clientByID->region == 'Region 005') selected @endif>{{$clientByID->region}}</option>
						  </select>
						  @endif
                    </div>
                  </div>  
				<div class="form-group">
				  <label class="control-label col-md-3">Publish</label>                  
				  <div class="col-md-4">
					<div class="radio-list">					  
					  @if ($clientByID == null)
					  <label>
					  <input type="radio" name="publish" value="1" checked/>
					  Yes </label>
					  <label>
					  <input type="radio" name="publish" value="0" />
					  No </label>
					  @elseif ($clientByID->published == 1)
					  <label>
					  <input type="radio" name="publish" value="1" checked/>
					  Yes </label>
					  <label>
					  <input type="radio" name="publish" value="0" />
					  @elseif ($clientByID->published == 0)
					  <label>
					  <input type="radio" name="publish" value="1" />
					  Yes </label>
					  <label>
					  <input type="radio" name="publish" value="0" checked/>
					  No </label>
					  @endif
					</div>
				  </div>
				</div>
				<div class="form-actions">
				  <div class="row">
					<div class="col-md-offset-3 col-md-9">
					  <button type="submit" class="btn green">Submit</button>
					  <a href="{{URL::route('admin/clients')}}" class="btn default">Cancel</a>
					</div>
				  </div>
				</div>
              </form>
              <!-- END FORM-->
            </div>
          </div>
          <!-- END VALIDATION STATES-->
        </div>
      </div>

      <!-- END PAGE CONTENT-->
    </div>
  </div>
  <!-- END CONTENT -->
</div>
@endsection

@section('pageLevelPlugins')
{{HTML::script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
{{HTML::script('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}
{{HTML::script('assets/global/plugins/select2/select2.min.js')}}
{{HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
{{HTML::script('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}
{{HTML::script('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}
{{HTML::script('assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js')}}
{{HTML::script('assets/global/plugins/bootstrap-markdown/lib/markdown.js')}}
@endsection

@section('pageLevelScripts')
{{HTML::script('assets/global/scripts/metronic.js')}}
{{HTML::script('assets/admin/layout/scripts/layout.js')}}
{{HTML::script('assets/admin/layout/scripts/quick-sidebar.js')}}
{{HTML::script('assets/admin/layout/scripts/demo.js')}}
{{HTML::script('assets/admin/pages/scripts/form-validation.js')}}
{{ HTML::script('assets/admin/layout/scripts/chosen.jquery.min.js') }}
<!-- BEGIN CONFIRM DIALOG -->
{{ HTML::script('assets/admin/layout/scripts/jquery.form.min.js') }}
{{ HTML::script('assets/admin/layout/jquery.confirm/jquery.confirm.js') }}
{{ HTML::script('assets/admin/layout/scripts/script.js') }}
<!-- END CONFIRM DIALOG -->

@endsection

@section('javaScript')
<script>
  // Delete row in a table
  var options = {
    success:  showResponse,
    dataType: 'json' 
  };

  function showResponse(response, statusText, xhr, $form)  {
    if (response.status == true) {
      $row = jQuery('.delete-row' + response.idx);
      alert(response.message);
      $row.closest('tr').fadeOut(function(){
        $row.remove();
      });
    } else {
      alert(response.message);
    }
  }

  function doDelete(id) {
    $.confirm({
      'title'   : 'Delete Confirmation',
      'message' : 'Do you really want to delete selected user?',
      'buttons' : {
        'Yes' : {
          'class' : 'blue',
          'action': function(){   
            jQuery('#id').val(id);
            $( '#userForm' ).ajaxForm(options).submit();           
          }
        },
        'No'  : {
          'class' : 'gray',
          'action': function(){}  // Nothing to do in this case. You can as well omit the action property.
        }
      }
    }); 
  }

jQuery(document).ready(function() {       
    // initiate layout and plugins
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features
    FormValidation.init();
});
</script>
@endsection