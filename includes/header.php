<header>
	<nav class="navbar fixed-top" id="mainhead">
		<div class="container">

			<a href="index.php" class="navbar-brand">
				<img src="./images/logo.png" class="img-fluid logo">
		        <span class="d-none d-md-inline">Intragram</span>
		    </a>


			<ul class="nav ml-auto">
				<?php
				if (isset($_SESSION['user'])) {
				$user = $_SESSION['user'];
				$fname = explode(' ', $user['Name']);
				$fname = $fname[0];
				?>

				<li class="nav-item"><a href="./profile.php" class="nav-link">
					<i class="fa fa-user fa-2x fa-fw " data-toggle="tooltip" title="Profile"></i>
			        <span class="d-none d-md-inline">Hi, <?php echo $fname;?></span>
			    </a></li>

			    <li class="nav-item"><a href="#" class="nav-link">
					<i class="fa fa-bell fa-2x fa-fw" data-toggle="tooltip" title="Notifications"></i>
			        <span class="d-none d-md-inline">Notifications</span>
			    </a></li>

			    <li class="nav-item"><a href="./logout.php" class="nav-link">
					<i class="fa fa-sign-out fa-2x fa-fw" data-toggle="tooltip" title="Log Out"></i>
			        <span class="d-none d-md-inline">Log Out</span>
			    </a></li>

			  	<?php }else{ ?>

			  	<li class="nav-item"><a href="./signup.php" class="nav-link">
					<i class="fa fa-user-plus fa-2x fa-fw" data-toggle="tooltip" title="Sign Up"></i>
			        <span class="d-none d-md-inline"> Sign Up</span>
			    </a></li>

			    <li class="nav-item"><a href="./login.php" class="nav-link">
					<i class="fa fa-sign-in fa-2x fa-fw" data-toggle="tooltip" title="Log In"></i>
			        <span class="d-none d-md-inline" data-toggle="tooltip" title="Log In"> Log In</span>
			    </a></li>

				<?php
				} ?>
			</ul>
		</div>
	</nav>
</header>

