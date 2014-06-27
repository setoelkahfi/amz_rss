<form action="" method="" id="form-rss">
	<?php 
		if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg');
	?>
	<p class="lead"><?php echo $title; ?></p>
	<div class="row-fluid">
		<div class="span12">
			<ul class="nav nav-tabs" id="tabs-user">
				<li class="active"><a href="#logs" data-toggle="tab">Logs</a></li>
				<li><a href="#tracking-ids" data-toggle="tab">Tracking IDs</a></li>
				<li><a href="#api-keys" data-toggle="tab">API Keys</a></li>
			</ul>
			<p class="ajax-loader">
				<img src="<?php echo base_url(); ?>assets/img/ajax-loader-strip.gif" class="ajax-loader-save" />
			</p>
			<div class="tab-content">
				<div class="tab-pane active" id="logs"></div>
				<div class="tab-pane" id="tracking-ids"></div>
				<div class="tab-pane" id="api-keys"></div>
			</div>
		</div>
	</div>
</form>
<script>
$(document).ready(function(){	
	var baseURL = 'http://localhost/amazon/users/';
	// Function to get the last string
	var lastWord = function(o) {
		return (""+o).replace(/[\s-]+$/,'').split(/[\s-]/).pop();
	};
    //load content for first tab and initialize
    $('#logs').load(baseURL+'logs', function() {
        $('#tabs-user').tab(); //initialize tabs
		$('.tab-content').slideDown('slow');
    });    
    $('#tabs-user').bind('show', function(e) {    
        var pattern=/#.+/gi //use regex to get anchor(==selector)
        var contentID = e.target.toString().match(pattern)[0]; //get anchor         
        //load content for selected tab
        $(contentID).load(baseURL+contentID.replace('#',''), function(){
            $('#tabs-user').tab(); //reinitialize tabs
			$('.tab-content').slideDown('slow');
        });
    });
		
	$('#modal-form').modal({show: false, backdrop: 'static'});
	
	// Modal trigger
	// Attach to .on() function as it .live() deprecated on version 1.7+
	$('.tab-pane').on('click','.modal-trigger',function(){			
		// remove last word
		var lastIndexOf = $(this).attr('href').lastIndexOf('-');
		var str= $(this).attr('href').substring(0, lastIndexOf);
		var act = str.replace('#','').split('-');
		var url = baseURL + $(this).attr('href').replace('#','');
		if (act[0]=== 'edit') {
			url = baseURL + str.replace('#','') + '/' + lastWord($(this).attr('href'));
		}
		$('#modal-form').modal('show').load(url);
	});	
	// Normalize url when modal closed
	$('#modal-form').on('hide', function () {
		history.pushState(null, null, ' ');
	});
	
	// Save form new
	$('#modal-form').on('submit','form.add-new',function() {
		var url = baseURL + $(this).attr('id');
		//alert('url form adalah ' + url);
		
		$.post(url,$(this).serialize(),function(data){
			data = JSON.parse(data);
			if (data['status'] === 'true'){
				$('#modal-form').modal('hide');
				contentID = $('li.active a').attr('href').toString();
				$(contentID).load(baseURL+contentID.replace('#',''), function(){
					$('#tabs-user').tab(); //reinitialize tabs
				});
			} else {
				alert(data['msg']);
			}			
		});
		return false;
	});
	
	// Delete 
	$('.tab-pane').on('click','.delete-trigger',function() {		
		// remove last word
		var lastIndexOf = $(this).attr('href').lastIndexOf('-');
		var str = $(this).attr('href').substring(0, lastIndexOf);
		
		if ( ! confirm('Are you sure want to delete this ?')) {
			return false;
		}
		var url = baseURL + str.replace('#','');
		$.post(url,{id:lastWord($(this).attr('href'))},function(data) {
			data = JSON.parse(data);
			if (data['status'] === 'true'){
				contentID = $('li.active a').attr('href').toString();
				$(contentID).load(baseURL+contentID.replace('#',''), function(){
					$('#tabs-user').tab(); //reinitialize tabs
				});
			} else {
				alert(data['msg']);
			}	
		});
		return false;
	});
});
</script>
<!-- Modal -->
<div id="modal-form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>