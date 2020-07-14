<!DOCTYPE html>
<html>
<head>
	<!-- META-TAGS -->
	<title>Authentication layout</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/bulma-rtl.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/authentication.css') ?>">

	<!-- JS -->
	<script src="<?= base_url('public/js/landing.js') ?>" defer></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>
</head>

<body dir="RTL">

	<!-- Wrapper -->
	<div id="wrapper">
		<div class="container">
			<?= $this->renderSection('wrapper') ?>
		</div>
	</div>

</body>
</html>