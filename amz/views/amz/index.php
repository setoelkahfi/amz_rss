<form action="" method="" id="form-rss">
	<?php 
		if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg');
	?>
	<p class="lead"><?php echo $title; ?></p>
	<div class="row-fluid">
		<div class="span12">
			<input id="rss-link" name="inputRss" class="input-xxlarge" type="text" placeholder="Your RSS link service">	<button type="submit" class="btn btn-primary btn-get-rss">Get it!</button>
					<div class="row-fluid">
						<div class="span6 offset3 ajax-loader">
							<img src="assets/img/ajax-loader-60x60.gif" id="ajax-loader">
						</div>
					</div>
					<div class="row-fluid">
						<div class="span12 ajax-content">
							
						</div>
					</div>
				</div>
			</div>
			</form>
			<div class="row-fluid">
				<div class="span4 well">
					<h4>Robust Apps.</h4>
					<p>This is the ready-use application for you who wants to be able to read an rss feed from your favorite website.</p> 
				</div>
				<div class="span4 well">
					<h4>Free Srvc.</h4>
					<p>This is the ready-use application for you who wants to be able to read an rss feed from your favorite website.</p> 
				</div>
				<div class="span4 well">
					<h4>Yet Smpl.</h4>
					<p>This is the ready-use application for you who wants to be able to read an rss feed from your favorite website.</p> 
				</div>
			</div>
		</div>
		<div id="push"></div>