<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>backend/search-index/" class="btn btn-danger pull-right">Back</a></p>
<hr>
<div class="row-fluid">
	<div class="span12">
		<form action="<?php echo base_url(); ?>backend/search-index/edit/save/" method="POST" class="form-horizontal form-add">
			<?php 
				if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); 
			?>
			<?php foreach ($items as $item) : ?>
			<div class="control-group">
				<label class="control-label">Name</label>
				<div class="controls">
					<input type="text" class="input-medium" name="name" value="<?php echo $item->name; ?>" />
					<input type="hidden" class="input-medium" name="name_" value="<?php echo $item->name; ?>" />
				</div>				
			</div>
			<div class="control-group">
				<label class="control-label">Availability</label>
				<div class="controls">
					<label class="checkbox inline">
						<input type="checkbox" name="CA" value="1" <?php echo ($item->CA) ? 'checked' : ''; ?>> CA
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="CN" value="1" <?php echo ($item->CN) ? 'checked' : ''; ?>> CN
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="DE" value="1" <?php echo ($item->DE) ? 'checked' : ''; ?>> DE
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="ES" value="1" <?php echo ($item->ES) ? 'checked' : ''; ?>> ES
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="FR" value="1" <?php echo ($item->FR) ? 'checked' : ''; ?>> FR
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="IT" value="1" <?php echo ($item->IT) ? 'checked' : ''; ?>> IT
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="JP" value="1" <?php echo ($item->JP) ? 'checked' : ''; ?>> JP
					</label></br>
					<label class="checkbox inline">
						<input type="checkbox" name="UK" value="1" <?php echo ($item->UK) ? 'checked' : ''; ?>> UK
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="US" value="1" <?php echo ($item->US) ? 'checked' : ''; ?>> US
					</label>
					<a href="#" class="check-all pull-right">check all</a>
					
				</div>				
			</div>
			<div class="form-actions">
				<input type="submit" class="btn btn-success" value="Save">
			</div>
			<?php //else : ?>
				<!--<div class="alert alert-warning flash">Upss, error occured! There's no data for that name.</div>-->
			<?php endforeach; ?>
		</form>
	</div>
</div>
		