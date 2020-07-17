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

              {{Form::open(array('url' => 'admin/cash_add', 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'cashAdd', 'autocomplete' => 'off'))}}
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
                      <input name="c1_loaded" id="c1_loaded" type="text" class="form-control form-cassetle" value="@if($interactionByID != null){{$interactionByID->C1loaded}}@endif" />
                      </div>
                      <div>
                      <input name="c2_loaded" id="c2_loaded" type="text" class="form-control form-cassetle" value="@if($interactionByID != null){{$interactionByID->C2loaded}}@endif" />
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-3">Total Cash Added </label>
                    <div class="col-md-4">
                      <input name="totalDeposited" id="totalDeposited" type="text" class="form-control" readonly value="@if($interactionByID != null){{$interactionByID->totalDeposited}}@endif" />
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
					  <a href="{{URL::route('admin/interactions')}}" class="btn default">Cancel</a>
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
            $( '#cashForm' ).ajaxForm(options).submit();           
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
	$('#c1_loaded').keyup(function(e){
		var c1_loaded = $('#c1_loaded').val();
		var c2_loaded = $('#c2_loaded').val();	
		
		if (c1_loaded == "") {
			c1_loaded = 0;
		}	

		if (c2_loaded == "") {
			c2_loaded = 0;
		}

		var sum = parseInt(c1_loaded) + parseInt(c2_loaded);
		$('#totalDeposited').val(sum);

	});
	
	$('#c2_loaded').keyup(function(e){    
		var c1_loaded = $('#c1_loaded').val();
		var c2_loaded = $('#c2_loaded').val();	
		
		if (c1_loaded == "") {
			c1_loaded = 0;
		}	

		if (c2_loaded == "") {
			c2_loaded = 0;
		}

		var sum = parseInt(c1_loaded) + parseInt(c2_loaded);
		$('#totalDeposited').val(sum);		
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
		else
			var url = "../../cash/pre_loaded/" + $(this).val() + "/" + Math.random();
		
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
	
    $('#cash').change(function(e){     
		var source = $(this).val();

		if ($('#id').val() == "")
			var url = "../cash/source_terminal/" + $(this).val() + "/" + Math.random();
		else
			var url = "../../cash/source_terminal/" + $(this).val() + "/" + Math.random();
		
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