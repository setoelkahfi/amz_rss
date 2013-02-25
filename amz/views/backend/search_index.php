<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>backend/search-index/add/" class="btn btn-danger pull-right">Add Index</a></p>
<hr>
<div class="row-fluid">
	<div class="span12">
		<?php 
			if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); 
		?>
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
			<?php foreach ($items as $item) : ?>
			<tr>
				<td><?php echo $item->name; ?></td>
				<td><?php echo $item->CA ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><?php echo $item->CN ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><?php echo $item->DE ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><?php echo $item->ES ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><?php echo $item->FR ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><?php echo $item->IT ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><?php echo $item->JP ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><?php echo $item->UK ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><?php echo $item->US ? '<i class="icon-ok"></i>' : ''; ?></td>
				<td><a href="<?php echo base_url(); ?>backend/search-index/edit/<?php echo $item->name; ?>" class="label label-warning">edit</span></td>
			</tr>	
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
</div>
		