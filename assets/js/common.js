/**
 * Common JavaScript of the apps.
 * V.0.2
 */
 
$(document).ready(function(){

	// Show hide input new email
	$('#default-email').click(function() {
		var status = this.checked;
		if (status) {
			$('#rss-email').val('').hide('slow');
		} else {
			$('#rss-email').show('slow');
		}
	});
	
	// Get rss at the home page
	$('#form-rss').submit(function() {
		if ($('#rss-link').val() == '') { 
			alert('Please fill the link');
			return false;
		}
		// disabled new email toggle
		$.post(location.href + 'ajax-loader/rss-show/', $(this).serialize(), function(data) {
			$('div.ajax-content').empty();
			data = JSON.parse(data);
			if (data['result'] == false ) {
				//alert('Sorry, can not save ' + data['status_text']);
				$('div.ajax-loader').html(data['msg']);
			} else if (data['result'] == true) {
				//alert('Succesfully saved ' + data['status_text']);
				$('div.ajax-loader').html(data['msg']).css('color','red');
				$('div.ajax-content').html(data['rss'] + data['product']);
			}
			$('#ajax-loader').hide();			
		});
		return false;
	});
	
	// Flash out message box
	setTimeout(function(){
		$('.flash').fadeOut(2000, function () {
			$('.flash').remove();
		  }); }, 2000);
	$('.check-all').toggle(function(){
        $('input:checkbox').attr('checked','checked');
        $(this).text('uncheck all')
    },function(){
        $('input:checkbox').removeAttr('checked');
        $(this).text('check all');        
    });
	
	/**
	 * Global ajax-loader
	 */
	$(document).ajaxStart(function() {
		$( ".ajax-loader" ).fadeIn();
	}).ajaxComplete(function() {
		$( ".ajax-loader" ).fadeOut();
	});
	
});