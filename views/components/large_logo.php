<div class="logo-container">
	<div class="logo">
		<img src="./images/logo.png" alt="logo">
	</div>
	<?php if (in_array(get_server_uri(), ["/login", "/register"])) : ?>
		<a href="/access_portal" class="go-back">
			<i class="fa-solid fa-arrow-left-long"></i>
			<span>Back</span>
		</a>
	<?php endif; ?>
</div>
