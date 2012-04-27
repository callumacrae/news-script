<?php include(HEADER) ?>

<h1>Login</h1>
<p>&nbsp</p>

<form class="form-horizontal" action="account.php?mode=login" method="post">
	<fieldset>
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
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Login</button>
			<button type="reset" class="btn">Reset</button>
		</div>
	</fieldset>
</form>

<?php include(FOOTER) ?>