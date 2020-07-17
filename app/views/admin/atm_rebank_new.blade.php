@extends('layouts.default')

@section('pageLevelPluginStyles')
  {{HTML::style('assets/global/plugins/select2/select2.css')}} 
  {{HTML::style('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}
  {{HTML::style('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}
  {{HTML::style('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}
  {{HTML::style('assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}
@endsection

@section('themeStyles')
  {{HTML::style('assets/global/css/components.css')}}
  {{HTML::style('assets/global/css/plugins.css')}}
  {{HTML::style('assets/admin/layout/css/layout.css')}}
  {{HTML::style('assets/admin/layout/css/themes/default.css')}}
  {{HTML::style('assets/admin/layout/css/custom.css')}} 

  {{HTML::style('assets/admin/layout/css/jquery.fileupload.css')}}
  {{HTML::style('assets/admin/layout/css/jquery.fileupload-ui.css')}}

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
      ATM Management 
      </h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li>
            <i class="fa fa-home"></i>
            <a href="{{URL::route('admin/home')}}">Home</a>
            <i class="fa fa-angle-right"></i>
          </li>
          <li>
            <a href="{{URL::route('admin/atm')}}">{{$title}}</a>
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
      {{Form::open(array('url' => 'asset/delete', 'method' => 'post', 'id' => 'assetDelete'))}}   
        <input type="hidden" name="assetFile" id="assetFile">
        <input type="hidden" name="assetType" id="assetType">
      {{Form::close()}}

              {{Form::open(array('url' => 'admin/rebank_add', 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'rebankAdd', 'autocomplete' => 'off'))}}
				<input type="hidden" name="id" id="id" value="@if($interactionByID != null){{$interactionByID->id}}@endif">
                <div class="form-body">
                  <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Select Terminal ID <span class="required">
                    * </span>
                    </label>
                    <div class="col-md-4">
                      <select class="form-control" name="atm" id="atm">
                        <option value=""></option>
            @foreach($atm as $atminfo)
              @if ($interactionByID != null && $atminfo->id == $interactionByID->atm_id)
              <option value="{{$atminfo->id}}" selected>{{$atminfo->terminalID}}</option>
              @else
              <option value="{{$atminfo->id}}">{{$atminfo->terminalID}}</option>
              @endif
            @endforeach
                      </select>
                    </div>
                  </div>                  
                  <div class="form-group">
                    <label class="control-label col-md-3">Cash Source <span class="required">
                    * </span>
                    </label>
                    <div class="col-md-4">
                      <select class="form-control" name="cash" id="cash">
                        <option value=""></option>
						<option value="bank" @if($interactionByID != null && $interactionByID->sourceMoney == 'bank') selected @endif)>Bank</option>
						<option value="atm" @if($interactionByID != null && $interactionByID->sourceMoney == 'atm') selected @endif)>ATM</option>
						<option value="spare" @if($interactionByID != null && $interactionByID->sourceMoney == 'spare') selected @endif)>Spare</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group sub_cash" style="@if($interactionByID==null)display:none; @else display:block; @endif">
                    @if ($interactionByID == null)
						<label class="control-label col-md-3"><span id="sub_cash_label"></span> <span class="required">
						* </span>
						</label>
					@else
						<label class="control-label col-md-3"><span id="sub_cash_label">
							@if ($interactionByID->sourceMoney == 'bank')
								Bank Account
							@elseif ($interactionByID->sourceMoney == 'atm')
								ATM
							@else
								Spare
							@endif
						</span> <span class="required">
						* </span>
						</label>
					@endif
                    <div class="col-md-4 sub_cash_source">
					@if ($interactionByID != null)
                      <select class="form-control" name="CashSourceID">
                        <option value=""></option>
						@if ($interactionByID->sourceMoney == 'atm')
							@foreach($sources as $sourceinfo)
							  @if ($interactionByID != null && $sourceinfo->id == $interactionByID->CashSourceID)								
							  <option value="{{$sourceinfo->id}}" selected>{{$sourceinfo->terminalID}}</option>
							  @else
							  <option value="{{$sourceinfo->id}}">{{$sourceinfo->terminalID}}</option>
							  @endif
							@endforeach
						@elseif ($interactionByID->sourceMoney == 'bank')
							@foreach($sources as $sourceinfo)
							  @if ($interactionByID != null && $sourceinfo->id == $interactionByID->CashSourceID)								
							  <option value="{{$sourceinfo->id}}" selected>{{$sourceinfo->accountNumber}}</option>
							  @else
							  <option value="{{$sourceinfo->id}}">{{$sourceinfo->accountNumber}}</option>
							  @endif
							@endforeach						
						@else
							<option value="spare">Spare</option>
						@endif
                      </select>			
					  @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Previously Loaded </label>
                    <div class="col-md-4">
                      <input type="text" name="pre_loaded" id="pre_loaded" data-required="1" placeholder="$" readonly class="form-control" value="" />
                    </div>
                  </div>             
					
                  <div class="form-group">
                    <label class="control-label col-md-3">Loaded <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <div class="form-cassetle-div">
                      <input name="c1_loaded" id="c1_loaded" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C1loaded}}@endif" />
                      </div>
                      <div>
                      <input name="c2_loaded" id="c2_loaded" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C2loaded}}@endif" />
                      </div>
                    </div>
                  </div>  
                  <div class="form-group">
                    <label class="control-label col-md-3">Dispensed <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <div class="form-cassetle-div">
                      <input name="c1_dispensed" id="c1_dispensed" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C1dispensed}}@endif" />
                      </div>
                      <div>
                      <input name="c2_dispensed" id="c2_dispensed" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C2dispensed}}@endif" />
                      </div>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3">Remaining <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <div class="form-cassetle-div">
                      <input name="c1_remaining" id="c1_remaining" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C1remaining}}@endif" />
                      </div>
                      <div>
                      <input name="c2_remaining" id="c2_remaining" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C2remaining}}@endif"/>
                      </div>
                    </div>
                  </div>      
                  <div class="form-group">
                    <label class="control-label col-md-3">Rejects <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <div class="form-cassetle-div">
                      <input name="c1_rejects" id="c1_rejects" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C1rejects}}@endif" />
                      </div>
                      <div>
                      <input name="c2_rejects" id="c2_rejects" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C2rejects}}@endif" />
                      </div>
                    </div>
                  </div>      
                  <div class="form-group">
                    <label class="control-label col-md-3">Test <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <div class="form-cassetle-div">
                      <input name="c1_test" id="c1_test" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C1tests}}@endif" />
                      </div>
                      <div>
                      <input name="c2_test" id="c2_test" type="text" class="form-control form-cassetle" value="@if ($interactionByID != null){{$interactionByID->C2tests}}@endif" />
                      </div>
                    </div>
                  </div>   
                  <div class="form-group">
                    <label class="control-label col-md-3">Rebank Amount <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <div class="form-cassetle-div">
                      <input name="c1_rebank_amount" id="c1_rebank_amount" type="text" class="form-control form-cassetle" readonly />
                      </div>
                      <div>
                      <input name="c2_rebank_amount" id="c2_rebank_amount" type="text" class="form-control form-cassetle" readonly />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Total Rebank Amount <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <input name="totalRebankAmount" id="totalRebankAmount" type="text" class="form-control" readonly value="@if ($interactionByID != null){{$interactionByID->totalRebankAmount}}@endif" />
                    </div>
                  </div>    
                  <div class="form-group">
                    <label class="control-label col-md-3">Total Cash Added </label>
                    <div class="col-md-4">
                      <input name="totalDeposited" id="totalDeposited" type="text" class="form-control" readonly value="@if ($interactionByID != null){{$interactionByID->totalDeposited}}@endif" />
                    </div>
                  </div>      
                  <div class="form-group">
                    <label class="control-label col-md-3">Day Total <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <input name="day_total" id="day_total" type="text" class="form-control" value="" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Terminal Total Amount Dispensed <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <input name="terminal_total_amount" id="terminal_total_amount" type="text" class="form-control" value="" />
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3">Host Total Amount Dispensed <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <input name="host_total_amount" id="host_total_amount" type="text" class="form-control" value="" />
                    </div>
                  </div>      
                  <div class="form-group">
                    <label class="control-label col-md-3">Evidence <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <div id="f_image_add" style="@if ($interactionByID != null && $interactionByID->filename != "") display:none; @else display:block; @endif">
                        <button type="button" class="btn btn-default" id="image-modal-ajax" disabled
                          data-toggle="modal" data-key="" data-url="{{URL::route('modals/addImage', array('id'=>'')) }}">
                          <i class="fa fa-plus"></i> Add Image...
                        </button>
                        <input type="hidden" name="evidence" id="evidence" value="@if($interactionByID != null){{$interactionByID->filepath}}{{$interactionByID->filename}}@endif">
                      </div>
                      <div id="f_image_previewer" style="@if ($interactionByID != null && $interactionByID->filename != "")display:block; @else display:none; @endif">
                        <div id="f_image_preview">
                            @if ($interactionByID != null && $interactionByID->filename != "")
                             <img id="f_img" src='{{$interactionByID->filepath}}{{$interactionByID->filename}}' />
                             @endif
                        </div>
                        <div class="clearfix"></div>
                        <div id="f_image_delete">
                          <button type="button" class="btn btn-default delete-asset" data-toggle="modal">
                          <i class="fa fa-minus"></i> Delete Image</button>
                         </div>
                      </div>
                    </div>
                  </div>                              
				<div class="form-actions">
				  <div class="row">
					<div class="col-md-offset-3 col-md-9">
					  <button type="submit" class="btn green">Submit</button>
					  <a href="{{URL::route('admin/atm')}}" class="btn default">Cancel</a>
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
<div id="ajax-modal" class="modal container fade" tabindex="-1"></div>
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
<!-- BEGIN CONFIRM DIALOG -->
{{ HTML::script('assets/admin/layout/scripts/jquery.form.min.js') }}
{{ HTML::script('assets/admin/layout/jquery.confirm/jquery.confirm.js') }}
{{ HTML::script('assets/admin/layout/scripts/script.js') }}
<!-- END CONFIRM DIALOG -->
{{HTML::script('assets/admin/layout/jquery_uploader/vendor/jquery.ui.widget.js') }}
{{HTML::script('assets/admin/layout/jquery_uploader/jquery.iframe-transport.js') }}
{{HTML::script('assets/admin/layout/jquery_uploader/jquery.fileupload.js') }}
{{HTML::script('assets/admin/layout/jquery_uploader/jquery.fileupload-validate.js') }}
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
      'message' : 'Do you really want to delete selected ATM?',
      'buttons' : {
        'Yes' : {
          'class' : 'blue',
          'action': function(){   
            jQuery('#id').val(id);
            $( '#rebankForm' ).ajaxForm(options).submit();           
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
    UIExtendedModals.init(); 

	//$('.sub_cash').css('display', 'none');
	if ($('#id').val() != "") {
		var c1_remaining = $('#c1_remaining').val();
		var c1_rejects = $('#c1_rejects').val();	
		var c1_test = $('#c1_test').val();
		if (c1_remaining == "") c1_remaining = 0;
		if (c1_rejects == "") c1_rejects = 0;
		if (c1_test == "") c1_test = 0;
		var sum = parseInt(c1_remaining) + parseInt(c1_rejects) + parseInt(c1_test);
		$('#c1_rebank_amount').val(sum);

		var c2_remaining = $('#c2_remaining').val();
		var c2_rejects = $('#c2_rejects').val();	
		var c2_test = $('#c2_test').val();		
		
		if (c2_remaining == "")	c2_remaining = 0;
		if (c2_rejects == "") c2_rejects = 0;
		if (c2_test == "") c2_test = 0;

		var sum = parseInt(c2_remaining) + parseInt(c2_rejects) + parseInt(c2_test);
		$('#c2_rebank_amount').val(sum);

		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "")	c1_rebank_amount = 0;
		if (c2_rebank_amount == "") c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);

		var c1_dispensed = $('#c1_dispensed').val();
		var c2_dispensed = $('#c2_dispensed').val();	
		
		if (c1_dispensed == "")	c1_dispensed = 0;
		if (c2_dispensed == "")	c2_dispensed = 0;

		var sum = parseInt(c1_dispensed) + parseInt(c2_dispensed);
		$('#day_total').val(sum);
	}

	$('#c1_loaded').keyup(function(e){
		var c1_loaded = $('#c1_loaded').val();
		var c2_loaded = $('#c2_loaded').val();	
		
		if (c1_loaded == "") c1_loaded = 0;
		if (c2_loaded == "") c2_loaded = 0;
		
		var sum = parseInt(c1_loaded) + parseInt(c2_loaded);
		$('#totalDeposited').val(sum);
		$('#terminal_total_amount').val('');
	});
	
	$('#c2_loaded').keyup(function(e){    
		var c1_loaded = $('#c1_loaded').val();
		var c2_loaded = $('#c2_loaded').val();	
		
		if (c1_loaded == "") c1_loaded = 0;
		if (c2_loaded == "") c2_loaded = 0;

		var sum = parseInt(c1_loaded) + parseInt(c2_loaded);
		$('#totalDeposited').val(sum);		
		$('#terminal_total_amount').val('');
	});

	$('#c1_dispensed').keyup(function(e){
		var c1_dispensed = $('#c1_dispensed').val();
		var c2_dispensed = $('#c2_dispensed').val();	
		
		if (c1_dispensed == "")	c1_dispensed = 0;
		if (c2_dispensed == "")	c2_dispensed = 0;

		var sum = parseInt(c1_dispensed) + parseInt(c2_dispensed);
		$('#day_total').val(sum);
		$('#host_total_amount').val('');
	});
	
	$('#c2_dispensed').keyup(function(e){
		var c1_dispensed = $('#c1_dispensed').val();
		var c2_dispensed = $('#c2_dispensed').val();	
		
		if (c1_dispensed == "")	c1_dispensed = 0;
		if (c2_dispensed == "")	c2_dispensed = 0;

		var sum = parseInt(c1_dispensed) + parseInt(c2_dispensed);
		$('#day_total').val(sum);
		$('#host_total_amount').val('');
	});

	$('#c1_remaining').keyup(function(e){
		var c1_remaining = $('#c1_remaining').val();
		var c1_rejects = $('#c1_rejects').val();	
		var c1_test = $('#c1_test').val();		
		
		if (c1_remaining == "") c1_remaining = 0;
		if (c1_rejects == "") c1_rejects = 0;
		if (c1_test == "") c1_test = 0;

		var sum = parseInt(c1_remaining) + parseInt(c1_rejects) + parseInt(c1_test);
		$('#c1_rebank_amount').val(sum);

		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "")	c1_rebank_amount = 0;
		if (c2_rebank_amount == "")	c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);

	});
	
	$('#c2_remaining').keyup(function(e){    
		var c2_remaining = $('#c2_remaining').val();
		var c2_rejects = $('#c2_rejects').val();	
		var c2_test = $('#c2_test').val();		
		
		if (c2_remaining == "")	c2_remaining = 0;
		if (c2_rejects == "") c2_rejects = 0;
		if (c2_test == "") c2_test = 0;

		var sum = parseInt(c2_remaining) + parseInt(c2_rejects) + parseInt(c2_test);
		$('#c2_rebank_amount').val(sum);

		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "")	c1_rebank_amount = 0;
		if (c2_rebank_amount == "")	c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);
	});

	$('#c1_rejects').keyup(function(e){
		var c1_remaining = $('#c1_remaining').val();
		var c1_rejects = $('#c1_rejects').val();	
		var c1_test = $('#c1_test').val();		
		
		if (c1_remaining == "")	c1_remaining = 0;
		if (c1_rejects == "") c1_rejects = 0;
		if (c1_test == "") c1_test = 0;

		var sum = parseInt(c1_remaining) + parseInt(c1_rejects) + parseInt(c1_test);
		$('#c1_rebank_amount').val(sum);

		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "")	c1_rebank_amount = 0;
		if (c2_rebank_amount == "")	c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);
	});
	
	$('#c2_rejects').keyup(function(e){    
		var c2_remaining = $('#c2_remaining').val();
		var c2_rejects = $('#c2_rejects').val();	
		var c2_test = $('#c2_test').val();		
		
		if (c2_remaining == "")	c2_remaining = 0;
		if (c2_rejects == "") c2_rejects = 0;
		if (c2_test == "") c2_test = 0;

		var sum = parseInt(c2_remaining) + parseInt(c2_rejects) + parseInt(c2_test);
		$('#c2_rebank_amount').val(sum);
		
		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "")	c1_rebank_amount = 0;
		if (c2_rebank_amount == "")	c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);
	});

	$('#c1_test').keyup(function(e){
		var c1_remaining = $('#c1_remaining').val();
		var c1_rejects = $('#c1_rejects').val();	
		var c1_test = $('#c1_test').val();		
		
		if (c1_remaining == "")	c1_remaining = 0;
		if (c1_rejects == "") c1_rejects = 0;
		if (c1_test == "") c1_test = 0;

		var sum = parseInt(c1_remaining) + parseInt(c1_rejects) + parseInt(c1_test);
		$('#c1_rebank_amount').val(sum);		

		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "")	c1_rebank_amount = 0;
		if (c2_rebank_amount == "")	c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);
	});
	
	$('#c2_test').keyup(function(e){    
		var c2_remaining = $('#c2_remaining').val();
		var c2_rejects = $('#c2_rejects').val();	
		var c2_test = $('#c2_test').val();		
		
		if (c2_remaining == "")	c2_remaining = 0;
		if (c2_rejects == "") c2_rejects = 0;
		if (c2_test == "") c2_test = 0;

		var sum = parseInt(c2_remaining) + parseInt(c2_rejects) + parseInt(c2_test);
		$('#c2_rebank_amount').val(sum);
		
		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "")	c1_rebank_amount = 0;
		if (c2_rebank_amount == "")	c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);
	});	

	$('#c1_rebank_amount').keyup(function(e){
		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "")	c1_rebank_amount = 0;
		if (c2_rebank_amount == "") c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);
	});
	
	$('#c2_rebank_amount').keyup(function(e){
		var c1_rebank_amount = $('#c1_rebank_amount').val();	
		var c2_rebank_amount = $('#c2_rebank_amount').val();

		if (c1_rebank_amount == "") c1_rebank_amount = 0;
		if (c2_rebank_amount == "")	c2_rebank_amount = 0;

		var sum = parseInt(c1_rebank_amount) + parseInt(c2_rebank_amount);
		$('#totalRebankAmount').val(sum);
		
	});

    $('#atm').change(function(e){     
      var terminalID = $("#atm option:selected").text();
      terminalID = terminalID.replace(/\s/g, "");
      $('#image-modal-ajax').attr('data-key', terminalID);
      
      if ($(this).val() != "") {
        $('#image-modal-ajax').removeAttr('disabled');
      } else {        
        $('#image-modal-ajax').attr('disabled', true);
      }      

		if ($('#id').val() == "")
		  var url = "../cash/pre_loaded/" + $(this).val() + "/" + Math.random();
		
		$.ajax({
		  type: "GET",
		  url : url,
		  success : function(data){	
			  var parsed = JSON.parse(data);
			  $('#pre_loaded').val(parsed['pre_loaded']);		
		  },
		  error : function(error){
		  
		  }   
		}, "json");
   });

	$('#terminal_total_amount').change(function(e){ 
		
		var terminal_total_amount = $('#terminal_total_amount').val();
		var pre_loaded = $('#pre_loaded').val();
		var totalRebankAmount = $('#totalRebankAmount').val();
		var sum = parseInt(pre_loaded) - parseInt(totalRebankAmount);
		if (sum > terminal_total_amount) {
			$(this).css('border', '1px solid green');
		} else if (sum < terminal_total_amount) {
			$(this).css('border', '1px solid red');
		} else {
			$(this).css('border', '1px solid #E5E5E5');
		}
		/*
		var c1_loaded = $('#c1_loaded').val();
		var c2_loaded = $('#c2_loaded').val();	
		
		if (c1_loaded == "") c1_loaded = 0;
		if (c2_loaded == "") c2_loaded = 0;

		var sum_loaded = parseInt(c1_loaded) + parseInt(c2_loaded);
		var terminalID = $("#atm option:selected").text();
		terminalID = terminalID.replace(/\s/g, "");
		
		if (terminal_total_amount < sum_loaded) {
			var min = sum_loaded - terminal_total_amount;
			alert("Terminal ID " + terminalID + " is down " + min + "");
			$('#terminal_total_amount').val('');
			$('#terminal_total_amount').focus();
		} else if (terminal_total_amount > sum_loaded) {
			var min = sum_loaded - terminal_total_amount;
			alert("Terminal ID " + terminalID + " is up " + min + "");
			$('#terminal_total_amount').val('');
			$('#terminal_total_amount').focus();
		}
		*/
	});

	$('#host_total_amount').change(function(e){ 
		var host_total_amount = $('#host_total_amount').val();
		var c1_dispensed = $('#c1_dispensed').val();
		var c2_dispensed = $('#c2_dispensed').val();	

		if (c1_dispensed == "") c1_dispensed = 0;
		if (c2_dispensed == "") c2_dispensed = 0;
		var sum = parseInt(c1_dispensed) + parseInt(c2_dispensed);
		
		if (sum < host_total_amount) {			
			$(this).css('border', '1px solid green');
		} else {
			$(this).css('border', '1px solid #E5E5E5');
		}
		/*
		var sum_dispensed = parseInt(c1_dispensed) + parseInt(c2_dispensed);
		var terminalID = $("#atm option:selected").text();
		terminalID = terminalID.replace(/\s/g, "");
		if (host_total_amount > sum_dispensed) {
			var min = sum_dispensed - host_total_amount;
			alert("Terminal ID " + terminalID + " is up " + min + "");
			$('#host_total_amount').val('');
			$('#host_total_amount').focus();
		}*/
	});

    $('#cash').change(function(e){     
		var source = $(this).val();
		
		if ($('#id').val() == "")
		  var url = "../cash/source_terminal/" + $(this).val() + "/" + Math.random();
		
		$.ajax({
		  type: "GET",
		  url : url,
		  success : function(data){	
			  var branchs = [];
			  var parsed = JSON.parse(data);
			  var appendText = "<select class='form-control' name='CashSourceID'>";
			  
			  for (var i in parsed) {
				var id = parsed[i]["id"];
				var value = parsed[i]["value"];
				
				appendText += "<option value='"+ id +"'>"+value+"</option>";
			  }
			  appendText += "</select>";
			  $('.sub_cash').css('display', 'block');

			  var lbl_cash = "Bank Account";

			  if ($('#cash').val() == 'atm') {
					lbl_cash = "ATM";
			  } else if ($('#cash').val() == 'spare') {
					lbl_cash = "Spare";
			  }
			  
			  $('#sub_cash_label').html(lbl_cash);
			  $('.sub_cash_source').html(appendText);
		  },
		  error : function(error){
		  
		  }   
		}, "json");
   });

    $('.delete-asset').click(function() {
      var data_src = $('#f_img').attr('src');

      if (data_src != "") {
        var pathArray = data_src.split( '/' );
        var protocol = pathArray[0];
        var host = pathArray[2];
        var url = protocol + '//' + host;
        var real_path = data_src.replace(url, "");

        jQuery('#assetFile').val(real_path);
        $( '#assetDelete' ).ajaxForm(options).submit();       
      }

    });    
});

  var options = {
    success:  showResponse,
    dataType: 'json' 
  };


  function showResponse(response, statusText, xhr, $form)  {
    
    if (response.status == true) {
      $( '#f_image_previewer').css('display', 'none'); 
      $( '#f_image_add').css('display', 'block');
      $( '#evidence').val();
    } else {
        
    }
  }

</script>
@endsection