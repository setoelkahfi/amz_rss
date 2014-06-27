<div id="fb-root"></div>
<form action="" method="post" id="form-login" class="form-horizontal">
	<div class="control-group">
		<label class="control-label" for="inputEmail">Email</label>
		<div class="controls">
			<input type="text" name="inputEmail" placeholder="Email">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Password</label>
		<div class="controls">
			<input type="password" name="inputPassword" placeholder="Password">
		</div>
	</div>
	<p class="ajax-loader" style="display:none;">
		<img src="<?php echo base_url(); ?>assets/img/ajax-loader-60x60.gif">
	</p>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary btn-login">Login</button> or 
		<a href="<?php echo $fb_login; ?>" class="btn btn-primary btn-login">Login With Facebook</a>
		<!--<button type="cancel" class="btn">Cancel</button>-->
	</div>
</form>
<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.init({ 
			appId:'279581002064597', 
			cookie:true, 
			status:true, 
			xfbml:true,
			oauth:true 
		});
	};
	(function(d){
           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           ref.parentNode.insertBefore(js, ref);
    }(document));
	$('#facebook').click(function(e) {
		FB.login(function(response) {
			if(response.authResponse) {
				parent.location ='<?php echo base_url(); ?>facebook';
			}
		},{scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'});
	});
$(document).ready(function() {
	$('#form-login').submit(function(e) {
			e.preventDefault();
		if ($('input[name="inputPassword"]').val() == '') {
			$('div.control-group').addClass('error');
			return false;
		} else if ($('input[name="inputName"]').val() == '') {
			$('div.control-group').addClass('error');
			return false;
		}
		var url = '<?php echo base_url().'users/login-do/'; ?>';
		$.post(url, $(this).serialize(), function(data) {
			data = JSON.parse(data);
			status = JSON.stringify(data['status']);
			if (status == 'false') {
				alert('Email atau nama Anda salah!');
			} else {
				//alert('berhasil son...');
				history.pushState(null, null, ' ');
				location.reload(true);
			}
		});
		$('#ajax-loader-login').hide('slow');
		return false;
});
});
</script>