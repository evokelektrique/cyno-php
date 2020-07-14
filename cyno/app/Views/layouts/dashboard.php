<!DOCTYPE html>
<html>
<head>
	<title>Dashboard layout</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/all.css')?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/bulma-rtl.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('public/css/dashboard.css')?>">

	<?= csrf_meta() ?>

	<script type="text/javascript">
	let ROUTES  = {
	root                             : '<?= base_url(route_to('root')) ?>',
	dashboard                        : '<?= base_url(route_to('dashboard')) ?>',
	dashboard_shared_create          : '<?= base_url(route_to('dashboard_shared_create')) ?>',
	dashboard_shared_update          : '<?= base_url(route_to('dashboard_shared_update')) ?>',
	dasbhoard_folder_create          : '<?= base_url(route_to('dashboard_folder_create')) ?>',
	dashboard_shared_decryption_bytes: '<?= base_url(route_to('dashboard_shared_decryption_bytes')) ?>',
	dashboard_shared_get_bytes       : '<?= base_url(route_to('dashboard_shared_get_bytes')) ?>',
	dashboard_validation             : '<?= base_url(route_to('dashboard_validation')) ?>',
	dashboard_password_create        : '<?= base_url(route_to('dashboard_password_create')) ?>',
	}	
	// console.log(STATICS);
	</script>
	<script type="text/javascript" src="<?= base_url('public/js/sodium.js')?>"  async data-turbolinks-track="reload"></script>
	<script type="text/javascript" src="<?= base_url('public/js/cyno.js')?>"  defer="" data-turbolinks-track="reload"></script>
	<script type="text/javascript" src="<?= base_url('public/js/scripts.js')?>"  defer="" data-turbolinks-track="reload"></script>

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