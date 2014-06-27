<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>backend/browse-node-id/" class="btn btn-danger pull-right">Back</a></p>
<hr>
<div class="row-fluid">
	<div class="span12">
		<form action="<?php echo base_url(); ?>backend/browse-node-id/edit/save/" method="POST" class="form-horizontal form-add">
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
					<input type="text" class="input-medium" name="CA" placeholder="Browse node id" />
					<span class="help-inline">
						CA
					</span></br>
					<input type="text" class="input-medium" name="CN" placeholder="Browse node id" />
					<span class="help-inline">
						CN
					</span></br>
					<input type="text" class="input-medium" name="DE" placeholder="Browse node id" />
					<span class="help-inline">
						DE
					</span></br>
					<input type="text" class="input-medium" name="ES" placeholder="Browse node id" />
					<span class="help-inline">
						ES
					</span></br>
					<input type="text" class="input-medium" name="FR" placeholder="Browse node id" />
					<span class="help-inline">
						FR
					</span></br>
					<input type="text" class="input-medium" name="IT" placeholder="Browse node id" />
					<span class="help-inline">
						IT
					</span></br>
					<input type="text" class="input-medium" name="JP" placeholder="Browse node id" />
					<span class="help-inline">
						JP
					</span></br>
					<input type="text" class="input-medium" name="UK" placeholder="Browse node id" />
					<span class="help-inline">
						UK
					</span></br>
					<input type="text" class="input-medium" name="US" placeholder="Browse node id" />
					<span class="help-inline">
						US
					</span>	
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
		