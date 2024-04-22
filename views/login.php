<section id="login" class="access-portal">
	<div class="row no-gutters justify-content-center">
		<?php include_view("components/large_logo"); ?>

		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="login_form" class="row-flex-column">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" id="email" value="<?php echo $postback_value["email"] ?? ""; ?>">
				<?php echo $errors["email"] ?? ""; ?>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" value="<?php echo $postback_value["password"] ?? ""; ?>">
				
				<div class="show-password">
					<i class="fa-solid fa-eye"></i>
				</div>

				<?php echo $errors["password"] ?? ""; ?>

				<div class="forgot-password">
					<a href="">Forgot password?</a>
				</div>

				<?php echo $errors["login"] ?? ""; ?>

			</div>

			<div class="form-group d-flex justify-content-center">
				<input type="submit" name="submit" id="login" class="btn btn--primary" value="Login">
			</div>
		</form>
	</div>
</section>
