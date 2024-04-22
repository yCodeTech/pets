<nav class="navbar fixed-top">
	<div class="logo navbar-brand">
		<img src="./images/logo_horizontal.png" alt="logo">
	</div>
	
	<?php if (get_server_uri() === "/settings") : ?>
	<h2 class="section-title d-flex align-items-center">
		<i class="fa-solid fa-gear pr-2 settings"></i>
		Settings
	</h2>

	<?php else : ?>
		<a href="/settings" class="settings">
			<i class="fa-solid fa-gear fa-2x"></i>
		</a>

	<?php endif; ?>
</nav>
