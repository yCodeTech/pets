<section id="access_portal" class="access-portal">
	<div class="row no-gutters justify-content-center align-content-center flex-column">
		<?php include_view("components/large_logo"); ?>

		<div class="btns row-flex-column">
			<a href="/login" class="btn btn--large btn--primary" id="login_btn">Login</a>
			<a href="/register" class="btn btn--large btn--secondary" id="register_btn">Register</a>
		</div>
	</div>

	<?php if (isset($_SESSION["loggedout"]) || isset($_SESSION["deleted_account"])) : ?>
		<div class="alert alert-success m-0 px-3 text-center alert-dismissible fixed-bottom loggedout" role="alert">
		<?php if (isset($_SESSION["loggedout"])) :?>
		You've been logged out.
		<?php endif; ?>
		
		<?php if (isset($_SESSION["deleted_account"])) {
			echo $_SESSION["deleted_account"];
		}?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<i class="fa-solid fa-xmark"></i>
			</button>
		</div>
	<?php endif;?>
	<?php session_unset(); ?>

</section>
