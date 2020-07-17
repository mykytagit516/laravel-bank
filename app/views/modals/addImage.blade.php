<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">Add Image file</h4>
</div>
<div class="modal-body">
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-align-justify"></i> Add Image form
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->			
				<br>
				<input type="hidden" id="terminalID" value="{{$terminalID}}">
				<div id="divAdd" style="display:block;">
					<!-- The fileinput-button span is used to style the file input field as button -->
					<span class="btn btn-success fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span>Add files...</span>
						<!-- The file input field used as target for the file upload widget -->
						<input id="fileupload" type="file" name="files" multiple>
					</span>
					<br>
					<br>
					<!-- The global progress bar -->
					<div id="progress" class="progress">
						<div class="progress-bar progress-bar-success"></div>
					</div>
					<!-- The container for the uploaded files -->
					<div id="files" class="files"></div>
				</div>			
			<!-- END FORM-->
		</div>
	</div>
</div><!--/modal-body-->
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Close</button>
</div>
<script>
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '../addImageFile/' + $('#terminalID').val();

    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
        done: function (e, data) {
            $.each(data.result.files, function (index, file) { 

                if (file.url) {
					$( '#f_image_previewer').css('display', 'block'); 
					$( '#f_image_add').css('display', 'none');                   
					$( '#f_image_preview').html("<img id='f_img' src='"+ file.url +"' />");

					$( '#f_image').val(file.url);                            
                    $( '#evidence').val(file.url);
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );			
        },
        fail: function(e, data) {
            $.each(data.files, function (index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });            
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
