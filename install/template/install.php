<?php include(HEADER) ?>

<div class="page-header">
	<h1>Installation</h1>
</div>

<form class="form-horizontal" action="index.php?step=1" method="post">
	<fieldset>
		<legend>Admin account</legend>
<?php if ($error): ?>
		<div class="control-group">
			<div class="controls">
				<p><?= $error ?></p>
			</div>
		</div>
<?php endif ?>
		<div class="control-group">
			<label class="control-label" for="user">Username</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="user" name="user" value="<?= $user ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pass">Password</label>
			<div class="controls">
				<input type="password" class="input-xlarge" id="pass" name="pass">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pass_confirm">Password confirm</label>
			<div class="controls">
				<input type="password" class="input-xlarge" id="pass_confirm" name="pass_confirm">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">Email</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="email" name="email" value="<?= $email ?>">
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Register</button>
			<button type="reset" class="btn">Reset</button>
		</div>
	</fieldset>
</form>


<?php include(FOOTER) ?>
