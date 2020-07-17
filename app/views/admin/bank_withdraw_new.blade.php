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
      Bank Transaction Management 
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
    <a class="close" data-dismiss="alert" href="#">?/a>
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

        @if ($transactionByID == null)
              {{Form::open(array('url' => 'admin/withdraw_add', 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'transactionAdd', 'autocomplete' => 'off'))}}
        @else
              {{Form::open(array('url' => 'admin/withdraw_update', 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'transactionAdd', 'autocomplete' => 'off'))}}
        @endif
        <input type="hidden" name="id" id="id" value="@if($transactionByID != null){{$transactionByID->id}}@endif">
                <div class="form-body">
                  <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Bank Accounts <span class="required">
                    * </span>
                    </label>
                    <div class="col-md-4">
                      <select class="form-control" name="account" id="account">
                        <option value=""></option>
                        @foreach($accounts as $accountinfo)
                          @if ($transactionByID != null && $accountinfo->id == $transactionByID->bankAccount_id)
                          <option value="{{$accountinfo->id}}" selected>{{$accountinfo->accountNumber}}</option>
                          @else
                          <option value="{{$accountinfo->id}}">{{$accountinfo->accountNumber}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Bank Branches <span class="required">
                    * </span>
                    </label>
                    <div class="col-md-4 branches">
                      <select class="form-control" name="branch">
                        <option value=""></option> 
                        @if ($transactionByID != null)
                        @foreach($branchs as $branchinfo)
                          @if ($transactionByID != null && $branchinfo->id == $transactionByID->bankBranch_id)
                          <option value="{{$branchinfo->id}}" selected>{{$branchinfo->bankAddress}}</option>
                          @else
                          <option value="{{$branchinfo->id}}">{{$branchinfo->bankAddress}}</option>
                          @endif
                        @endforeach
                        @endif  
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">ATM <span class="required">
                    * </span>
                    </label>
                    <div class="col-md-4">
                      <select class="form-control" name="atm" id="atm">
                        <option value=""></option>
                        @foreach($atm as $atminfo)
                          @if ($transactionByID != null && $atminfo->id == $transactionByID->atm_id)
                          <option value="{{$atminfo->id}}" selected>{{$atminfo->terminalID}}</option>
                          @else
                          <option value="{{$atminfo->id}}">{{$atminfo->terminalID}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Is this spare cash? </label>
            <div class="col-md-9">
              <div class="checkbox-list">
              <label class="checkbox-inline">
              <input type="checkbox" id="sourceDestination" name="sourceDestination" value="1" @if($transactionByID != null && $transactionByID->sourceDestination == 'spare') checked @endif>              
              </label>
              </div>
            </div>
          </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Number of 20's</label>
                    <div class="col-md-2">
                      <input name="C1" id="C1" type="text" class="form-control" value="@if($transactionByID != null){{$transactionByID->C1}}@endif"/>
                    </div>
                    <div class="col-md-2">
                      <input name="C1value" id="C1value" type="text" class="form-control" readonly/>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-2">Number of 50's</label>
                    <div class="col-md-2">
                      <input name="C2" id="C2" type="text" class="form-control" value="@if($transactionByID != null){{$transactionByID->C2}}@endif"/>
                    </div>
                    <div class="col-md-2">
                      <input name="C2value" id="C2value" type="text" class="form-control" readonly/>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3">Total Withdrawn</label>
                    <div class="col-md-4">
                      <input name="TotalAmountWithdrawn" type="text" class="form-control" value="@if($transactionByID != null){{$transactionByID->TotalAmountWithdrawn}}@endif"/>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3">Evidence <span class="required">
                    * </span></label>
                    <div class="col-md-4">
                      <div id="f_image_add" style="@if ($transactionByID != null && $transactionByID->filename != "") display:none; @else display:block; @endif">
                        <button type="button" class="btn btn-default" id="image-modal-ajax" disabled
                          data-toggle="modal" data-key="" data-url="{{URL::route('modals/addImage', array('id'=>'')) }}">
                          <i class="fa fa-plus"></i> Add Image...
                        </button>
                        <input type="hidden" name="evidence" id="evidence" value="@if($transactionByID != null){{$transactionByID->filepath}}{{$transactionByID->filename}}@endif">
                      </div>
                      <div id="f_image_previewer" style="@if ($transactionByID != null && $transactionByID->filename != "")display:block; @else display:none; @endif">
                        <div id="f_image_preview">
                            @if ($transactionByID != null && $transactionByID->filename != "")
                             <img id="f_img" src='{{$transactionByID->filepath}}{{$transactionByID->filename}}' />
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
            <a href="{{URL::route('admin/withdraws')}}" class="btn default">Cancel</a>
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
    //client side math calculation of amounts/notes
    //$('.sub_cash').css('display', 'none');
    if ($('#id').val() != "") {
      var C1 = $('#C1').val();
      if (C1 == "") C1 = 0;
      var sum = parseInt(C1) * 20;
      $('#C1value').val(sum);

      var C2 = $('#C2').val();    
      if (C2 == "") C2 = 0;
      var sum = parseInt(C2) * 50;
      $('#C2value').val(sum);
    }

    $('#C1').keyup(function(e){
      var C1 = $('#C1').val();
      if (C1 == "") C1 = 0;
      var sum = parseInt(C1) * 20;
      $('#C1value').val(sum);
    });
    
    $('#C2').keyup(function(e){    
      var C2 = $('#C2').val();    
      if (C2 == "") C2 = 0;
      var sum = parseInt(C2) * 50;
      $('#C2value').val(sum);
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
    UIExtendedModals.init(); 

  $('#account').change(function(e){
    var account = $(this).val();

    if ($('#id').val() == "")
      var url = "../bank/account/" + account + "/" + Math.random();
    else
      var url = "../../bank/account/" + account + "/" + Math.random();

    $.ajax({
      type: "GET",
      url : url,
      success : function(data){
      var branchs = [];
      var parsed = JSON.parse(data);

      var appendText = "<select class='form-control' name='branch'>";
      
      for (var i in parsed) {
        var id = parsed[i]["id"];
        var address = parsed[i]["address"];
        appendText += "<option value='"+ id +"'>"+address+"</option>";
      }
      appendText += "</select>";
     
      $('.branches').html(appendText);
      },
      error : function(error){
      
      }   
    }, "json");
  })

  $('#atm').change(function(e){
    //var terminalID = $.trim($(this).text());
    var terminalID = $("#atm option:selected").text();
    terminalID = terminalID.replace(/\s/g, "");
    $('#image-modal-ajax').attr('data-key', terminalID);
    
    if ($(this).val() != "") {
      $('#image-modal-ajax').removeAttr('disabled');
    } else {
      
      $('#image-modal-ajax').attr('disabled', true);
    }
    
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