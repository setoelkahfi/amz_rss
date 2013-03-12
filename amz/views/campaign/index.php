<p class="lead"><?php echo $title; ?><a href="<?php echo base_url(); ?>campaign/add/" class="btn btn-danger pull-right">Add Champaign</a></p>
<hr>
<div class="row-fluid">
	<div class="span12">
		<?php 
			if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); 
		?>
		<?php if ($items->num_rows() > 0) : ?>
		<table class="table table-campaign">
		<thead>
			<tr>
				<td>No</td>
				<td>Blog Title</td>
				<td>Locale</td>
				<td>Category</td>
				<td>Status</td>
				<td>action</td>
			</tr>	
		</thead>
		<tbody>
			<?php $no =1; ?>
			<?php foreach ($items->result() as $item) : ?>
			<tr>
				<td><?php echo $no; ?></td>
				<td class="<?php echo $item->id; ?>"><?php echo (strlen($item->blog_title) > 30) ? substr($item->blog_title,0,30).'[..]' : $item->blog_title; ?></td>
				<td><?php echo $item->locale; ?></td>
				<td><?php echo $item->category; ?></td>
				<td><a href="<?php echo base_url(); ?>campaign/update/<?php echo $item->id; ?>/<?php echo $item->status; ?>" class="status-trigger"><i class="<?php echo $item->status == '1' ? 'icon-pause' : 'icon-play'; ?>"></i></a></td>
				<td><a href="<?php echo base_url(); ?>campaign/edit/<?php echo $item->id; ?>"><i class="icon-pencil"></i></a> <a href="<?php echo base_url(); ?>campaign/delete/<?php echo $item->id; ?>" class="delete-trigger"><i class="icon-remove"></i></a></td>
			</tr>
			<tr class="row-sub-campaign">
				<td colspan="6">
				</td>
			</tr>
			<?php $no++; ?>
			<?php endforeach; ?>
		</tbody>
		</table>
		<?php else : ?>
			<div class="alert alert-warning">Upss, no record found. Maybe you want to <a href="<?php echo base_url(); ?>campaign/add/">add one</a>.</div>
		<?php endif; ?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	var baseURL = '<?php echo base_url(); ?>';
	$('.table-campaign tbody tr td:nth-child(2)').toggle(function(){
		//alert('row clicked!');
		$('.row-sub-campaign').slideUp('slow');
		$(this).parent().next('.row-sub-campaign').slideDown('slow');
		var id = $(this).attr('class');
		//alert('row clicked id ' + id
		var url = baseURL + 'campaign/detail/'+id;
		$.get(url,{},function(data){
			data = JSON.parse(data);
			//alert(data['status']);
			var html = '<form class="form-horizontal">';
			if (data['status'] === true){
				//alert(data['data']['title']);
				html += '<div class="control-group"><label class="control-label">Blog Title</label><div class="controls">'+data['data']['title']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">Blog URL</label><div class="controls">'+data['data']['url']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">RSS Link</label><div class="controls">'+data['data']['link']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">Locale</label><div class="controls">'+data['data']['locale']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">Category</label><div class="controls">'+data['data']['category']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">Tracking ID</label><div class="controls">'+data['data']['tracking_id']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">Public Key</label><div class="controls">'+data['data']['public_key']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">Private Key</label><div class="controls">'+data['data']['private_key']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">Email</label><div class="controls">'+data['data']['email']+'</div></div>';
				html += '<div class="control-group"><label class="control-label">Status</label><div class="controls">'+data['data']['status']+'</div></div>';
				html += '</form>';
				$('.row-sub-campaign td').empty().html(html);
			} else {
				alert('Sorry, I\'m confuse :(');
			}
		});
	},function(){
		$(this).parent().next('.row-sub-campaign').slideUp('slow');
	});
	
	$('.status-trigger').click(function(){
		var trigger = $(this);
		$.post(trigger.attr('href'),{},function(data){
			var lastIndexOf = trigger.attr('href').lastIndexOf('/');
			var str = trigger.attr('href').substring(0, lastIndexOf);
			//alert('URL ' + trigger.attr('href'));
			data = JSON.parse(data);
			if (data['status']===true){
				//alert('Status new ' + data['status_new']);
				var newClass = (data['status_new'] === '1') ? 'icon-pause' : 'icon-play';
				trigger.attr('href',str+'/'+ data['status_new'])
				.children()
				.removeClass('icon-play icon-pause')
				.addClass(newClass);
				trigger.parents('tr').children(':first-child').next().trigger('click');
			}else{
				alert('Sorry, error occured ');
			}
		});
		return false;
	});
});
</script>