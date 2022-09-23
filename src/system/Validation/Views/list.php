<?php if (! empty($errors)) : ?>
	<div class="errors" role="alert">
		<ul>
		<?php foreach ($errors as $error) : ?>
			<?= esc($error) ?><br>
		<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>
