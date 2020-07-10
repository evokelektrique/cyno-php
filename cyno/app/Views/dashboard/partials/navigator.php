
<!-- Navigator -->
<div class="container pb-5">
	<div class="is-pulled-right">
		<?php 
			$router = service('router'); 
			switch ($router->controllerName()) {
				case '\App\Controllers\Dashboard': // List Folder
					echo "<h1>".lang('cyno.dashboard')."</h1>";
					break;

				case '\App\Controllers\Folders': // Index Folder
					echo "<h1>".lang('cyno.passwords')."</h1>";
					break;

				// case 'edit':
				// 	echo "<h1>".lang('cyno.edit_folder')."</h1>";
				// 	break;
					
				default:
					break;
			}
		?>
	</div>
	<div class="is-pulled-left">
		<button id="new_password_button" class="button is-small is-primary">
			<span class="icon is-pulled-right">
				<i class="fas fa-plus"></i>
			</span>
			<span><?= lang('cyno.new_password') ?></span>
		</button>
		<button id="new_folder_button" class="button is-small is-primary">
			<span class="icon is-pulled-right">
				<i class="fas fa-plus"></i>
			</span>
			<span><?= lang('cyno.new_folder') ?></span>
		</button>
	</div>

	<div class="is-clearfix"></div>

	<!-- Search -->
	<form action="<?= base_url(route_to('dashboard_search')) ?>" method="get" accept-charset="utf-8">
		<div class="field has-addons my-5">
			<div class="control">
				<span class="select">
					<select name="type">
						<option value="password" selected=""><?= lang('cyno.password') ?></option>
						<option value="website"><?= lang('cyno.website') ?></option>
					</select>
				</span>
			</div>			
			<div class="control is-expanded">
				<input class="input is-fullwidth" type="text" name="q" placeholder="<?= lang('cyno.search') ?>">
			</div>
			<div class="control">
				<input type="submit" class="button is-primary" value="<?= lang('cyno.search') ?>" />
			</div>
		</div>
	</form>

</div>