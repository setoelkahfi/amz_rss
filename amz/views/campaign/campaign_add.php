<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>campaign/" class="btn btn-danger pull-right">Back</a></p>
<hr>
<div class="row-fluid">
	<div class="span12">
		<form action="<?php echo base_url(); ?>campaign/save" method="POST" class="form-horizontal form-add">
			<?php 
				if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); 
			?>
			<div class="control-group">
				<label class="control-label">Blog Title</label>
				<div class="controls">
					<input type="text" class="input-large" name="blog-title" placeholder="Blog title" />
				</div>				
			</div>
			<div class="control-group">
				<label class="control-label">Blog URL</label>
				<div class="controls">
					<input type="text" class="input-large" name="blog-url" placeholder="Blog url" />
				</div>				
			</div>
			<div class="control-group">
				<label class="control-label">Link Bes-seller RSS</label>
				<div class="controls">
					<input type="text" class="input-block-level" name="rss" placeholder="Best-sellerrss link" />
				</div>				
			</div>
			<div class="control-group">
				<label class="control-label">Country</label>
				<div class="controls">
					<select name="locale" class="input-medium select-country">
						<option value=""> Select Country</option>
						<?php if ($items->num_rows() >0) : ?>
							<?php foreach ($items->result() as $item ) : ?>
								<option value="<?php echo $item->locale; ?>"><?php echo $item->country; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>	
				</div>				
			</div>
			<div class="control-group control-sub" style="display:none;">
				<label class="control-label">Search Index Values</label>
				<div class="controls">
					<select name="category" class="input-medium select-category">
					</select>	
				</div>				
			</div>
			<div class="control-group control-sub" style="display:none;">
				<label class="control-label">Tracking ID</label>
				<div class="controls">
					<select name="tracking-id" class="select-tracking-id">
					</select>	
				</div>				
			</div>
			<div class="control-group control-sub" style="display:none;">
				<label class="control-label">Public Key</label>
				<div class="controls">
					<select name="public-key" class="">
						<?php if ($api_keys->num_rows() >0) : ?>
							<?php foreach ($api_keys->result() as $item ) : ?>
								<option value="<?php echo $item->public_key; ?>"><?php echo $item->public_key; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>	
				</div>				
			</div>
			<div class="control-group control-sub" style="display:none;">
				<label class="control-label">Private Key</label>
				<div class="controls">
					<select name="private-key" class="input-xxlarge">
						<?php if ($api_keys->num_rows() >0) : ?>
							<?php foreach ($api_keys->result() as $item ) : ?>
								<option value="<?php echo $item->private_key; ?>"><?php echo $item->private_key; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>	
				</div>				
			</div>
			<div class="control-group control-sub" style="display:none;">
				<label class="control-label">Email Campaign</label>
				<div class="controls">
					<input name="email" class="input-medium" />
				</div>				
			</div>
			<div class="form-actions">
				<input type="submit" class="btn btn-success" value="Save">
			</div>
		</form>
	</div>
</div>
<script>
	/**
	 * Campaign section
	 *
	 * Handle nested select between locale and category
	 *
	 */
$('document').ready(function(){
	$('.disabled').click(function(e) {
		e.preventDefault();
	});
	$('.select-country').change(function(){
		$('.select-category').empty();
		$('.select-tracking-id').empty();
		var locale = $(this).val();
		if (locale != ''){
			var url = 'http://localhost/amazon/campaign/get-search-index/' + locale;
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: url,
				success: function(data) {
					$.each(data,function(index,value){
						var opt = $('<option />');
						opt.val(value);
						opt.text(value);						
						$('.select-category').append(opt);
					});
				}
			}); //end AJAX
			var url = 'http://localhost/amazon/campaign/get-tracking-id/' + locale;
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: url,
				success: function(data) {
					$.each(data,function(index,value){
						var opt = $('<option />');
						opt.val(value);
						opt.text(value);						
						$('.select-tracking-id').append(opt);
					});
				}
			}); //end AJAX
			$('.control-sub').show('slow');
		} else {
			$('.control-sub').hide('slow');
		}
	}); //end change
});
</script>