<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>setcal<?= $page_title ?></title>

	<link href="../assets/css/bootstrap.css" rel="stylesheet">
	<style type="text/css">
		body {
			padding-top: 60px;
			padding-bottom: 40px;
		}
	</style>
	<?php if ($responsive): ?><link href="../assets/css/bootstrap-responsive.css" rel="stylesheet"><?php endif ?>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="index.php"><?= Config::get('site_name') ?></a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="active"><a href="index.php">Home</a></li>
						<li><a href="#">More links here...</a></li>
					</ul>
					<form class="navbar-search" action="">
						<input type="text" class="search-query span2" placeholder="Search">
					</form>
					<ul class="nav pull-right">
<?php if ($logged): ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $username ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="user.php?mode=view&id=<?= $userid ?>">Profile</a></li>
								<li><a href="user.php?mode=settings">Settings</a></li>
								<li class="divider"></li>
								<li><a href="account.php?mode=logout">Logout</a></li>
							</ul>
						</li>
<?php else: ?>
						<li><a href="account.php?mode=login">Login</a></li>
						<li><a href="account.php?mode=register">Register</a></li>
<?php endif ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
