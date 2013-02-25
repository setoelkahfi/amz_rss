<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>NANO/Computer/Corner | RSS Aggregator</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- CSS -->
		<link href="assets/css/bootstrap.css" rel="stylesheet">
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="../assets/ico/favicon.png">
	</head>
	<body>
    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">
		<!-- Begin page content -->
		<div class="container">
			<ul class="nav nav-pills pull-right">
			<?php if ( ! isset($_SESSION['user_name'])) : ?>
				<li>
					<a href="#!Login" class="modal-trigger">login</a>
				</li>
				<li>
					<a href="#!Register"  class="modal-trigger" >register</a>
				</li>
			<?php else : ?>
				<li>
					<a href="logout/" >logout</a>
				</li>
				<li>
					<a href="account/" >account</a>
				</li>
			<?php endif; ?>
			</ul>
			<div class="page-header">
			<h1>AmazeON</h1>
			</div>
			<?php $this->load->view($page); ?>
    </div>
    <div id="footer">
		<div class="container">
			<p class="muted credit">NANO/Computer/Corner . <a href="http://setoelkahfi.web.id">Seto El Kahfi</a></p>
		</div>
    </div>
	<!-- Modal -->
	<div id="form-show" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="form-title">Modal header</h3>
		</div>
		<div class="modal-body">
		</div>
	</div>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/common.js"></script>
	</body>
</html>