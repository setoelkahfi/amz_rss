<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>champaign/add/" class="btn btn-danger pull-right">Add Champaign</a></p>
<hr>
<div class="row-fluid">
	<div class="span12">
		<?php 
			if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); 
		?>
		<?php if ($items->num_rows() > 0) : ?>
		<table class="table">
		<thead>
			<tr>
				<td>No</td>
				<td>Link</td>
				<td>Category</td>
				<td>Email</td>
				<td>action</td>
			</tr>	
		</thead>
		<tbody>
			<?php $no =1; ?>
			<?php foreach ($items->result() as $item) : ?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $item->champaign_link; ?></td>
				<td><?php echo $item->champaign_category; ?></td>
				<td><?php echo $item->champaign_email; ?></td>
				<td><a href="<?php echo base_url(); ?>champaign/edit/<?php echo $item->champaign_id; ?>" class="label label-warning">edit</span></td>
			</tr>	
			<?php endforeach; ?>
		</tbody>
		</table>
		<?php else : ?>
			<div class="alert alert-warning">Upss, no record found. Maybe you want to <a href="<?php echo base_url(); ?>champaign/add/">add one</a>.</div>
		<?php endif; ?>
	</div>
</div>