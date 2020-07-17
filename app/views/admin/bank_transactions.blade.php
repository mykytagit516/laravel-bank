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
      Bank Transactions Management 
      </h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li>
            <i class="fa fa-home"></i>
            <a href="{{URL::route('admin/home')}}">Home</a>
            <i class="fa fa-angle-right"></i>
          </li>
          <li>
            {{$title}}
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
      {{Form::open(array('url' => 'admin/transaction_delete', 'method' => 'post', 'class' => 'form', 'id' => 'transactionForm', 'autocomplete' => 'off'))}} 
      <input type="hidden" name="id" id="id">       
      <div class="row">
        <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box green-haze">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-globe"></i>{{$title}}
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
                <a href="javascript:;" class="remove">
                </a>
              </div>
            </div>
            <div class="portlet-body">
              @if ($transaction == 'deposit')
              <table class="table table-striped table-bordered table-hover" id="sample_6">
              <thead>
              <tr>
                <th>
                   Bank
                </th>                
                <th>
                   Bank Account
                </th>
                <th>
                   Bank Branch
                </th>
                <th class="hidden-xs">
                   ATM Terminal ID
                </th>
                <th class="hidden-xs">
                   TotalAmountDeposited
                </th>                
                <th>
                   Action
                </th>                
              </tr>
              </thead>
              <tbody>
              @foreach ($transactions as $transactioninfo)
              <tr>
                <td>
                  {{BaseController::getBankByAccount($transactioninfo->bankAccount_id)}}
                </td>                
                <td>
                  {{BaseController::getBankAccount($transactioninfo->bankAccount_id)}}
                </td>
                <td>
                   {{BaseController::getBankBranch($transactioninfo->bankBranch_id)}}
                </td>
                <td>
                  {{BaseController::getTerminalID($transactioninfo->atm_id)}}
                </td>
                <td>
                   {{$transactioninfo->TotalAmountDeposited}}
                </td>
        				<td class="table-action">
        				  <a href="{{ URL::route("admin/deposit_edit", $transactioninfo->id) }}"><i class="fa fa-pencil"></i></a>
                  @if ($user->permission == 'administrator' || $user->permission == 'manager')
                  &nbsp;&nbsp;
                  <a href="#" onclick="doDelete('{{$transactioninfo->id}}')" class="delete-row{{$transactioninfo->id}}"><i class="fa fa-trash-o"></i></a>                                  
                  @endif                  
        				</td>              
              </tr>
              @endforeach  
              </tbody>
              </table>
              @elseif ($transaction == 'withdraw')
              <table class="table table-striped table-bordered table-hover" id="sample_6">
              <thead>
              <tr>
                <th>
                   Bank
                </th>                
                <th>
                   Bank Account
                </th>
                <th>
                   Bank Branch
                </th>
                <th class="hidden-xs">
                   ATM Terminal ID
                </th>
                <th class="hidden-xs">
                   TotalAmountWithdrawn
                </th>                
                <th>
                   Action
                </th>                
              </tr>
              </thead>
              <tbody>
              @foreach ($transactions as $transactioninfo)
              <tr>
                <td>
                  {{BaseController::getBankByAccount($transactioninfo->bankAccount_id)}}
                </td>                
                <td>
                  {{BaseController::getBankAccount($transactioninfo->bankAccount_id)}}
                </td>
                <td>
                   {{BaseController::getBankBranch($transactioninfo->bankBranch_id)}}
                </td>
                <td>
                  {{BaseController::getTerminalID($transactioninfo->atm_id)}}
                </td>
                <td>
                   {{$transactioninfo->TotalAmountWithdrawn}}
                </td>
                <td class="table-action">
                  <a href="{{ URL::route("admin/withdraw_edit", $transactioninfo->id) }}"><i class="fa fa-pencil"></i></a>
                  @if ($user->permission == 'administrator' || $user->permission == 'manager')
                  &nbsp;&nbsp;
                  <a href="#" onclick="doDelete('{{$transactioninfo->id}}')" class="delete-row{{$transactioninfo->id}}"><i class="fa fa-trash-o"></i></a>                
                  @endif                  
                </td>              
              </tr>
              @endforeach  
              </tbody>
              </table>
              @endif
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
        </div>
      </div>
      {{ Form::close() }}
      <!-- END PAGE CONTENT-->
    </div>
  </div>
  <!-- END CONTENT -->
</div>
@endsection

@section('pageLevelPlugins')
{{HTML::script('assets/global/plugins/select2/select2.min.js')}}
{{HTML::script('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}
{{HTML::script('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}
{{HTML::script('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}
{{HTML::script('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}
{{HTML::script('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}
@endsection

@section('pageLevelScripts')
{{HTML::script('assets/global/scripts/metronic.js')}}
{{HTML::script('assets/admin/layout/scripts/layout.js')}}
{{HTML::script('assets/admin/layout/scripts/quick-sidebar.js')}}
{{HTML::script('assets/admin/layout/scripts/demo.js')}}
{{HTML::script('assets/admin/pages/scripts/table-advanced.js')}}

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
      'message' : 'Do you really want to delete selected transaction?',
      'buttons' : {
        'Yes' : {
          'class' : 'blue',
          'action': function(){   
            jQuery('#id').val(id);
            $( '#transactionForm' ).ajaxForm(options).submit(); 
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
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features
    TableAdvanced.init();   
});
</script>

@endsection