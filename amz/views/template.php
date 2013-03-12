<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>NANO/Computer/Corner | RSS Aggregator</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- CSS -->
		<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- Le javascript -->
		<script src="<?php echo base_url(); ?>assets/js/jquery.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-transition.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-alert.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-modal.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-dropdown.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-scrollspy.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-tab.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-tooltip.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-popover.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-button.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-collapse.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-carousel.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-typeahead.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/ico/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/ico/favicon.png">
	</head>
	<body>
    <div id="wrap">
		<!-- Begin page content -->
		<div class="container">
			<ul class="nav nav-pills pull-right">
				<?php if ( ! ($this->session->userdata('user_name'))) : ?>
				<li>
					<a href="<?php echo base_url(); ?>users/login/">login</a>
				</li>
				<li>
					<a href="<?php echo base_url(); ?>users/register/">register</a>
				</li>
				<?php else : ?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						main menu
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url(); ?>campaign-blogger/" >campaign blogger</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>campaign-wordpress/" >campaign wordpress</a>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						account
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url(); ?>users/<?php echo $this->session->userdata('user_id'); ?>" >profile</a>
						</li>
						<?php if ($this->session->userdata('user_level') === 'admin') : ?>
						<li>
							<a href="<?php echo base_url(); ?>backend/" >backend</a>
						</li>
						<?php endif; ?>
						<li>
							<a href="<?php echo base_url(); ?>users/logout">logout</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>
			</ul>
			<div class="page-header">
			<h1>AmazeON | <?php echo $this->session->userdata('user_name') ? 'Dashboard' : ''; ?></h1>
			</div>
			<?php if ($this->router->fetch_class() === 'backend') : ?>
				<?php $this->load->view('backend/index'); ?>	
			<?php else : ?>
				<?php $this->load->view($page); ?>
			<?php endif; ?>
		</div>
		<div id="push"></div>
    </div>
    <div id="footer">
		<div class="container">
			<div class="row-fluid">
				<div class="span4">
					<h4>NANO/Computer/Corner</h4>
					<ul class="unstyled">
						<li><a href="<?php echo base_url(); ?>about-us/" >About Us</a></li>
						<li><a href="<?php echo base_url(); ?>history/" >History</a></li>
						<li><a href="<?php echo base_url(); ?>contact/" >Contact</a></li>
					</ul>
				</div>
				<div class="span2">
					<h4>Service</h4>
					<ul class="unstyled">
						<li><a href="<?php echo base_url(); ?>service/seo/" >SEO Campaign</a></li>
						<li><a href="<?php echo base_url(); ?>service/web-deveopment/" >Web Developer</a></li>
						<li><a href="<?php echo base_url(); ?>service/online-shop/" >Online Shop</a></li>
					</ul>
				</div>
				<div class="span2">
					<h4>Account</h4>
					<ul class="unstyled">
						<li><a href="<?php echo base_url(); ?>users/login" >My Account</a></li>
					</ul>
				</div>
				<div class="span4">
					<h4 class="pull-right">Find Us</h4>
				</div>
			</div>
			<p class="muted credit pull-right">NANO/Computer/Corner . <a href="http://setoelkahfi.web.id">Seto El Kahfi</a></p>
		</div>
    </div>
	</body>
</html>