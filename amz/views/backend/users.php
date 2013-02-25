<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>backend/users/add/" class="btn btn-danger pull-right">Add User</a></p>
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
				<td>Name</td>
				<td>Email</td>
				<td>Account Number</td>
				<td>Action</td>
			</tr>	
		</thead>
		<tbody>
			<?php $no = 1; ?>
			<?php foreach ($items->result() as $item) : ?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $item->user_name; ?></td>
				<td><?php echo $item->user_email; ?></td>
				<td><?php echo '12'; ?></td>
				<td><a href="<?php echo base_url(); ?>backend/users/edit/<?php echo $item->user_id; ?>" class="label label-warning">edit</a><a href="<?php echo base_url(); ?>backend/users/delete/<?php echo $item->user_id; ?>" class="label label-danger">delete</a></td>
			</tr>
			<?php $no++; ?>
			<?php endforeach; ?>
		</tbody>
		</table>
		<?php else : ?>
			<div class="alert alert-warning">Upss, no record found. Maybe you want to <a href="<?php echo base_url(); ?>backend/browse-node-id/add/">add one</a>.</div>
		<?php endif; ?>
	</div>
</div>