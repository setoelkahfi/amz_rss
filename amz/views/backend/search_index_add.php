<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>backend/search-index/" class="btn btn-danger pull-right">Back</a></p>
<hr>
<div class="row-fluid">
	<div class="span12">
		<form action="<?php echo base_url(); ?>backend/search-index/save" method="POST" class="form-horizontal form-add">
			<?php 
				if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); 
			?>
			<div class="control-group">
				<label class="control-label">Name</label>
				<div class="controls">
					<input type="text" class="input-medium" name="name" placeholder="Search index value" />
				</div>				
			</div>
			<div class="control-group">
				<label class="control-label">Availability</label>
				<div class="controls">
					<label class="checkbox inline">
						<input type="checkbox" name="CA" value="1"> CA
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="CN" value="1"> CN
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="DE" value="1"> DE
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="ES" value="1"> ES
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="FR" value="1"> FR
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="IT" value="1"> IT
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="JP" value="1"> JP
					</label></br>
					<label class="checkbox inline">
						<input type="checkbox" name="UK" value="1"> UK
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="US" value="1"> US
					</label>
					<a href="#" class="check-all pull-right">check all</a>
					
				</div>				
			</div>
			<div class="form-actions">
				<input type="submit" class="btn btn-success" value="Save">
			</div>
		</form>
	</div>
</div>
		