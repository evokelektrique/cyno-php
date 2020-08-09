<!DOCTYPE html>
<html>

<head>
	<title>Dashboard layout</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Css -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/all.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/bulma-rtl.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/dashboard.css') ?>">

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("apple-touch-icon.png") ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("favicon-32x32.png") ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("favicon-16x16.png") ?>">
	<link rel="manifest" href="<?= base_url("site.webmanifest") ?>">
	<link rel="mask-icon" href="<?= base_url("safari-pinned-tab.svg") ?>" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#2b5797">
	<meta name="theme-color" content="#ffffff">
	
	<?= csrf_meta() ?>

	<!-- Js -->
	<script type="text/javascript">
		let ROUTES = {
			root: '<?= base_url(route_to('root')) ?>',
			dashboard: '<?= base_url(route_to('dashboard')) ?>',
			dashboard_shared_create: '<?= base_url(route_to('dashboard_shared_create')) ?>',
			dashboard_shared_update: '<?= base_url(route_to('dashboard_shared_update')) ?>',
			dasbhoard_folder_create: '<?= base_url(route_to('dashboard_folder_create')) ?>',
			dashboard_shared_decryption_bytes: '<?= base_url(route_to('dashboard_shared_decryption_bytes')) ?>',
			dashboard_shared_get_bytes: '<?= base_url(route_to('dashboard_shared_get_bytes')) ?>',
			dashboard_validation: '<?= base_url(route_to('dashboard_validation')) ?>',
			dashboard_password_create: '<?= base_url(route_to('dashboard_password_create')) ?>',
			dashboard_password_update: '<?= base_url(route_to('dashboard_password_update')) ?>',
		}
		// console.log(STATICS);
	</script>
	<script type="text/javascript" src="<?= base_url('public/js/sodium.js') ?>" async data-turbolinks-track="reload"></script>
	<!-- <script type="text/javascript" src="<?= base_url('public/js/papaparse.min.js') ?>" async data-turbolinks-track="reload"></script> -->
	<script type="text/javascript" src="<?= base_url('public/js/cyno.js') ?>" defer="" data-turbolinks-track="reload"></script>
	<script type="text/javascript" src="<?= base_url('public/js/scripts.js') ?>" defer="" data-turbolinks-track="reload"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>

</head>

<body dir="RTL" class="is-clipped">

	<!-- Wrapper -->
	<div id="wrapper">
		<div class="container">
			<?= $this->renderSection('wrapper') ?>
		</div>
	</div>

</body>

</html>