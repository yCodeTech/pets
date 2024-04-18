<section id="settings" class="logged-in fixed-bars-offset py-4">
	<a href="<?php echo back(); ?>" class="go-back">
		<i class="fa-solid fa-arrow-left-long"></i>
		<span>Back</span>
	</a>

	<div class="row-flex-column">


		<div class="user my-5 p-4 d-flex justify-content-between">
			<span><?php echo "$firstname $lastname"; ?></span>
			<a href="/logout" class="logout">Logout</a>
			
		</div>


		<div class="delete-account my-5 p-4 d-flex justify-content-center">
			<a href="/delete_account" class="btn btn--danger">Delete my account</a>
			
		</div>
	</div>
	


</section>
