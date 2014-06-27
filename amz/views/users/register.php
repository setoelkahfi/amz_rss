<form id="form-register" class="form-horizontal">
	<div class="control-group input-name">
		<label class="control-label" for="inputName">Name</label>
		<div class="controls">
			<input type="text" name="inputName" id="inputName" placeholder="Full name">
			<span class="help-inline"></span>
		</div>
	</div>
	<div class="control-group input-email">
		<label class="control-label" for="inputEmail">Email</label>
		<div class="controls">
			<input type="text" name="inputEmail" id="inputEmail" placeholder="Email">
			<span class="help-inline"></span>
		</div>
	</div>
	<div class="control-group input-password">
		<label class="control-label" for="inputPassword">Password</label>
		<div class="controls">
			<input type="password" name="inputPassword" id="inputPassword" placeholder="Password">
			<span class="help-inline"></span>
		</div>
	</div>
	<div class="control-group input-password-re">
		<label class="control-label" for="inputPasswordRe">Retype - Password</label>
		<div class="controls">
			<input type="password" name="inputPasswordRe" id="inputPasswordRe" placeholder="Retype Password">
			<span class="help-inline"></span>
		</div>
	</div>
	<p class="ajax-loader">
		<img src="assets/img/ajax-loader-60x60.gif" id="ajax-loader-register" >
	</p>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Register</button>
		<button type="button" class="btn">Cancel</button>
	</div>
</form>
<script>
$('#form-register').submit(function(e) {
	//alert('test');
	$('#ajax-loader-register').show();
	$.post('users/register-do/', $(this).serialize(), function(data) {
		data = JSON.parse(data);
		status = JSON.stringify(data['status']);
		if (status == 'false') {
			var error = data['error'];
			alert('Sorry, but register fail :( ' + error['errName']);
			if (error['errName']) $('div.input-name').addClass('error').find('.help-inline').html(error['errName']);
			if (error['errEmail']) $('div.input-email').addClass('error').find('.help-inline').html(error['errEmail']);
			if (error['errPassword']) $('div.input-password').addClass('error').find('.help-inline').html(error['errPassword']);
			if (error['errPasswordRe']) $('div.input-password-re').addClass('error').find('.help-inline').html(error['errPasswordRe']);
			if (error['errOther']) $('div.input-name').addClass('error').find('.help-inline').html(error['errName']);
			
		} else {
			//alert('berhasil son...');
			history.pushState(null, null, '/rss-aggregator/');
			location.reload(true);
		}
	});
	$('#ajax-loader-register').hide('slow');
	return false;
});
</script>