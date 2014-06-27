<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>backend/browse-node-id/add/" class="btn btn-danger pull-right">Add Node</a></p>
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
				<td>Search Index Value</td>
				<td>CA</td>
				<td>CN</td>
				<td>DE</td>
				<td>ES</td>
				<td>FR</td>
				<td>IT</td>
				<td>JP</td>
				<td>UK</td>
				<td>US</td>
				<td>action</td>
			</tr>	
		</thead>
		<tbody>
			<?php foreach ($items->result() as $item) : ?>
			<tr>
				<td><?php echo $item->name; ?></td>
				<td><?php echo $item->CA; ?></td>
				<td><?php echo $item->CN; ?></td>
				<td><?php echo $item->DE; ?></td>
				<td><?php echo $item->ES; ?></td>
				<td><?php echo $item->FR; ?></td>
				<td><?php echo $item->IT; ?></td>
				<td><?php echo $item->JP; ?></td>
				<td><?php echo $item->UK; ?></td>
				<td><?php echo $item->US; ?></td>
				<td><a href="<?php echo base_url(); ?>backend/browse-node-id/edit/<?php echo $item->name; ?>" class="label label-warning">edit</span></td>
			</tr>	
			<?php endforeach; ?>
		</tbody>
		</table>
		<?php else : ?>
			<div class="alert alert-warning">Upss, no record found. Maybe you want to <a href="<?php echo base_url(); ?>backend/browse-node-id/add/">add one</a>.</div>
		<?php endif; ?>
	</div>
</div>