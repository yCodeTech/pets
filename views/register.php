<section id="register" class="access-portal">
	<div class="row no-gutters justify-content-center">
		<?php include_view("components/large_logo"); ?>

		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="register_form" class="row-flex-column">
			<div class="form-group">
				<label for="firstname">Firstname</label>
				<input type="text" name="firstname" id="firstname" value="<?php echo $postback_value["firstname"] ?? ""; ?>">
				<?php echo $errors["firstname"] ?? ""; ?>
			</div>
			<div class="form-group">
				<label for="lastname">Lastname</label>
				<input type="text" name="lastname" id="lastname" value="<?php echo $postback_value["lastname"] ?? ""; ?>">
				<?php echo $errors["lastname"] ?? ""; ?>
			</div>

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
				<div class="alert alert-info mt-3 password-requirements" role="alert">A strong password must include at least:
					<ul class="pl-3 m-0">
						<li>10 characters</li>
						<li>1 uppercase character</li>
						<li>1 lowercase character</li>
						<li>1 number</li>
						<li>A special character</li>
					</ul>
				</div>

				<?php echo $errors["password"] ?? ""; ?>
			</div>
			<div class="form-group d-flex justify-content-center">
				<input type="submit" name="submit" id="register" class="btn btn--primary" value="Register">
			</div>
		</form>

	</div>

</section>
