<header>
	<nav class="navbar fixed-top" id="mainhead">
		<div class="container">

			<a href="#" class="navbar-brand">
				<img src="../images/logo.png" class="img-fluid logo">
		        <span class="d-none d-md-inline">Intragram</span>
		    </a>


			<ul class="nav ml-auto">
				<?php
				if (isset($_SESSION['user'])) {
				$user = $_SESSION['user'];
				$fname = explode(' ', $user['Name']);
				$fname = $fname[0];
				?>

				<li class="nav-item"><a href="../dashboard/index.php" class="nav-link">
					<i class="fa fa-user"></i>
			        <span class="d-none d-md-inline">Hi, <?php echo $fname;?></span>
			    </a></li>

			    <li class="nav-item"><a href="#" class="nav-link">
					<i class="fa fa-bell"></i>
			        <span class="d-none d-md-inline">Notifications</span>
			    </a></li>

			    <li class="nav-item"><a href="../logout.php" class="nav-link">
					<i class="fa fa-sign-out"></i>
			        <span class="d-none d-md-inline">Log Out</span>
			    </a></li>

			  	<?php }else{ ?>

			  	<li class="nav-item"><a href="../signup.php" class="nav-link">
					<i class="fa fa-user-plus"></i>
			        <span class="d-none d-md-inline"> Sign Up</span>
			    </a></li>

			    <li class="nav-item"><a href="../login.php" class="nav-link">
					<i class="fa fa-sign-in"></i>
			        <span class="d-none d-md-inline"> Log In</span>
			    </a></li>

				<?php
				} ?>
			</ul>
		</div>
	</nav>
</header>