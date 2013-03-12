<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>campaign/" class="btn btn-danger pull-right">Back</a></p>
<hr>
<div class="row-fluid">
	<div class="span12">
		<?php $data = $items->row(); ?>
		<form action="<?php echo base_url(); ?>campaign/update/<?php echo $data->id; ?>" method="POST" class="form-horizontal form-add">
			<?php if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); ?>
			<div class="control-group">
				<label class="control-label">Blog Title</label>
				<div class="controls">
					<input type="text" value="<?php echo $data->blog_title; ?>" class="input-large" name="blog-title" />
				</div>				
			</div>
			<div class="control-group">
				<label class="control-label">Blog URL</label>
				<div class="controls">
					<input type="text" value="<?php echo $data->blog_url; ?>" class="input-large" name="blog-url" />
				</div>				
			</div>
			<div class="control-group">
				<label class="control-label">Link Bes-seller RSS</label>
				<div class="controls">
					<input type="text" value="<?php echo $data->link; ?>" class="input-block-level" name="rss" />
				</div>				
			</div>
			<div class="control-group">
				<label class="control-label">Country</label>
				<div class="controls">
					<select name="locale" class="input-medium select-country">
						<option value=""> Select Country</option>
						<?php if ($countries->num_rows() >0) : ?>
							<?php foreach ($countries->result() as $item ) : ?>
								<option value="<?php echo $item->locale; ?>" <?php echo $item->locale == $data->locale ? 'selected' : ''; ?>><?php echo $item->country; ?></option>
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
								<option value="<?php echo $item->public_key; ?>" <?php echo $item->public_key == $data->public_key ? 'selected' : ''; ?>><?php echo $item->public_key; ?></option>
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
								<option value="<?php echo $item->private_key; ?>" <?php echo $item->private_key == $data->private_key ? 'selected' : ''; ?>><?php echo $item->private_key; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>	
				</div>				
			</div>
			<div class="control-group control-sub" style="display:none;">
				<label class="control-label">Email Campaign</label>
				<div class="controls">
					<input name="email" value="<?php echo $data->email; ?>" class="" />
				</div>				
			</div>
			<div class="form-actions">
				<input type="submit" class="btn btn-success" value="Save">
			</div>
		</form>
	</div>
</div>
<script>
$('document').ready(function(){
	$('.disabled').click(function(e) {
		e.preventDefault();
	});
	var trackingId = '<?php echo (isset($data->tracking_id)) ? $data->tracking_id : ''; ?>';
	var category = '<?php echo (isset($data->category)) ? $data->category : ''; ?>';
	$('.select-country').change(function(){
		$('.select-category').empty();
		$('.select-tracking-id').empty();
		var isSelected = '';
		var locale = $(this).val();
		if (locale != ''){
			var url = '<?php echo base_url(); ?>campaign/get-search-index/' + locale;
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: url,
				success: function(data) {
					$.each(data,function(index,value){
						isSelected = (value === category) ? 'selected' : '';
						var opt = '<option value="' + value + '" ' + isSelected + '>' + value + '</option>';
						$('.select-category').append(opt);
					});
				}
			}); //end AJAX
			var url = '<?php echo base_url(); ?>campaign/get-tracking-id/' + locale;
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: url,
				success: function(data) {
					$.each(data,function(index,value){
						isSelected = (value === trackingId) ? 'selected' : '';
						var opt = '<option value="' + value + '" ' + isSelected + '>' + value + '</option>';
						$('.select-tracking-id').append(opt);
					});
				}
			}); //end AJAX
			$('.control-sub').show('slow');
		} else {
			$('.control-sub').hide('slow');
		}
	}); //end change
	$('.select-country').trigger('change');
	
});
</script>