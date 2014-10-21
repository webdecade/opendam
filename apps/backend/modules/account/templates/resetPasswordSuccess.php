<div class="container">
	<div id="user-password" class="row">
		<form class="span6 offset3" method="post">
			<?php echo $form["_csrf_token"]->render(); ?>

			<div class="header clearfix">
				<h3><?php echo __("Please enter your new password")?></h3>
			</div>

			<div class="body">
				<div class="controls">
					<?php echo $form["password"]->render(); ?>
					<?php echo $form["password"]->renderError(); ?>
				</div>

				<?php echo $form["confirm_password"]->render(); ?>
				<?php echo $form["confirm_password"]->renderError(); ?>
				
				<button class="button btnBS"><?php echo __("Save")?></button>
			</div>
		</form>
	</div>
</div>