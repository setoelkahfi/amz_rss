<?php if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); ?>
	<?php foreach ($items->result() as $item) : ?>
	<p class="lead"><?php echo $item->user_name; ?></p>
	<div class="row-fluid">
		<div class="span12">
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4 well">
			<h4>Stat.</h4>
			<p>This is the ready-use application for you who wants to be able to read an rss feed from your favorite website.</p> 
		</div>
		<div class="span4 well">
			<h4>RSS.</h4>
			<p>This is the ready-use application for you who wants to be able to read an rss feed from your favorite website.</p> 
		</div>
		<div class="span4 well">
			<h4>New.</h4>
			<p>This is the ready-use application for you who wants to be able to read an rss feed from your favorite website.</p> 
		</div>
	</div>
	<?php endforeach; ?>
</div>
<div id="push"></div>