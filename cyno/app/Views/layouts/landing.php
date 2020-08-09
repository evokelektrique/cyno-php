<!DOCTYPE html>
<html>

<head>
	<!-- META-TAGS -->
	<title>Landing layout</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/bulma-rtl.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/reset.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/landing.css') ?>">

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("apple-touch-icon.png") ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("favicon-32x32.png") ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("favicon-16x16.png") ?>">
	<link rel="manifest" href="<?= base_url("site.webmanifest") ?>">
	<link rel="mask-icon" href="<?= base_url("safari-pinned-tab.svg") ?>" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#2b5797">
	<meta name="theme-color" content="#ffffff">
	
	<!-- JS -->
	<script type="text/javascript" src="<?= base_url('public/js/scripts.js') ?>" defer="" data-turbolinks-track="reload"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>
</head>

<body dir="RTL">

	<!-- Wrapper -->
	<div id="wrapper">
		<?= $this->renderSection('wrapper') ?>
	</div>

</body>

</html>