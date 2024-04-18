<nav class="navbar fixed-top navbar-light bg-light">
	<div class="logo navbar-brand">
		<img src="./images/default_logo_image.png" alt="logo">
		<span>Pets</span>
	</div>
	
	<?php if (get_server_uri() === "/settings") : ?>
	<h2 class="section-title d-flex align-items-center">
		<i class="fa-solid fa-gear pr-2"></i>
		Settings
	</h2>

	<?php else : ?>
		<a href="/settings">
			<i class="fa-solid fa-gear fa-2x"></i>
		</a>

	<?php endif; ?>
</nav>
