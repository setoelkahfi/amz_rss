<form id="form-login" class="form-horizontal">
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
	<p class="ajax-loader">
		<img src="assets/img/ajax-loader-60x60.gif" id="ajax-loader-login" >
	</p>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary btn-login">Login</button>
		<!--<button type="cancel" class="btn">Cancel</button>-->
	</div>
</form>
<script>
$('#form-login').submit(function(e) {	
	if ($('input[name="inputPassword"]').val() == '') {
		$('div.control-group').addClass('error');
		return false;
	} else if ($('input[name="inputName"]').val() == '') {
		$('div.control-group').addClass('error');
		return false;
	}
	$('#ajax-loader-login').show();
	$.post(location.href + 'ajax-loader/login-do/', $(this).serialize(), function(data) {
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
</script>