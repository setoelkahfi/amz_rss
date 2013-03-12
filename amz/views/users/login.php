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
		<button type="submit" class="btn btn-primary btn-login">Login</button>
		<!--<button type="cancel" class="btn">Cancel</button>-->
	</div>
</form>
<script type="text/javascript">
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