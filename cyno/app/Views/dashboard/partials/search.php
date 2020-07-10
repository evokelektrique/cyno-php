
<!-- Search -->
<form action="<?= base_url(route_to('dashboard_search')) ?>" method="get" accept-charset="utf-8">
	<div class="field has-addons my-5">
		<div class="control">
			<span class="select">
				<select name="type">
					<option value="password" <?= (isset($type) && $type === 'password') ? 'selected' : ''; ?>>
						<?= lang('cyno.password') ?>
					</option>
					<option value="website" <?= (isset($type) && $type === 'website') ? 'selected' : ''; ?>>
						<?= lang('cyno.website') ?>
					</option>
				</select>
			</span>
		</div>			
		<div class="control is-expanded">
			<input class="input is-fullwidth" type="text" name="q" value="<?= (!empty($query)) ? $query : '' ?>" placeholder="<?= lang('cyno.search') ?>">
		</div>
		<div class="control">
			<input type="submit" class="button is-primary" value="<?= lang('cyno.search') ?>" />
		</div>
	</div>
</form>