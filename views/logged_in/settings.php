<section id="settings" class="logged-in fixed-bars-offset py-4">
	<a href="<?php echo back(); ?>" class="go-back">
		<i class="fa-solid fa-arrow-left-long"></i>
		<span>Back</span>
	</a>

	<div class="row-flex-column mt-5">
		<div class="user p-4 d-flex justify-content-between">
			<span><?php echo "$firstname $lastname"; ?></span>
		</div>

		<div class="logout d-flex justify-content-center mt-3">
		<a href="/logout" class="btn btn-outline--secondary">Logout</a>
		</div>

		<div class="d-flex justify-content-center delete-account">
			<button type="button" class="btn btn--danger" data-toggle="modal" data-target="#delete_account_confirm">Delete Account</button>
		</div>
	</div>
	


</section>
<?php include_view("components/modal", ["type" => "delete_account", "postback_value" => $data]); ?>
