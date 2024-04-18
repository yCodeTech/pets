<section id="add_pets" class="logged-in fixed-bars-offset pet">

	<div class="pet__photo-container">
		<div class="pet__photo mx-auto">
			<?php include_icon("paw"); ?>
		</div>
	</div>
	<div class="content container py-3 px-4">
		<div class="cancel row no-gutters justify-content-end">
			<a href="/view_pets">
				<i class="fa-solid fa-xmark fa-3x px-2"></i>
			</a>
		</div>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="pet_form" class="row-flex-column mt-5">

			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" id="name" value="<?php echo $postback_value["name"] ?? ""; ?>">
				<?php echo $errors["name"] ?? ""; ?>
			</div>
			<div class="form-group">
				<label for="nickname">Nickname</label>
				<input type="text" name="nickname" id="nickname" value="<?php echo $postback_value["nickname"] ?? ""; ?>">
				<?php echo $errors["nickname"] ?? ""; ?>
			</div>

			<h3 class="section-title">Basic Info</h3>

			<div class="form-group">
				<label for="species">Species</label>
				<input type="text" name="species" id="species" value="<?php echo $postback_value["species"] ?? ""; ?>">
				<?php echo $errors["species"] ?? ""; ?>
			</div>
			<div class="form-group">
				<label for="breed">Breed</label>
				<input type="text" name="breed" id="breed" value="<?php echo $postback_value["breed"] ?? ""; ?>">
				<?php echo $errors["breed"] ?? ""; ?>
			</div>


			<div class="gender-container mx-auto">
				<div class="input-title">Gender</div>

				<div class="form-group">

					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="gender" id="gender-male" value="male">

						<label class="form-check-label d-flex align-items-center px-1" for="gender-male">
							Male <i class="fa-solid fa-mars ml-2"></i>
						</label>
					</div>
					<div class="form-check form-check-inline mr-0">
						<input class="form-check-input" type="radio" name="gender" id="gender-female" value="female">

						<label class="form-check-label d-flex align-items-center px-1" for="gender-female">
							Female <i class="fa-solid fa-venus ml-2"></i>
						</label>
					</div>
				</div>
				<?php echo $errors["gender"] ?? ""; ?>
			</div>

			<div class="form-group">
				<label for="weight">Weight</label>
				<input type="number" name="weight" id="weight" value="<?php echo $postback_value["weight"] ?? "0"; ?>" min="0">
				<span class="suffix">kg</span>
				<?php echo $errors["weight"] ?? ""; ?>
			</div>
			<div class="form-group">
				<label for="colour">Colour</label>
				<input type="text" name="colour" id="colour" value="<?php echo $postback_value["colour"] ?? ""; ?>">
				<?php echo $errors["colour"] ?? ""; ?>
			</div>

			<div class="form-group">
				<label for="habitat">Habitat</label>
				<input type="text" name="habitat" id="habitat" value="<?php echo $postback_value["habitat"] ?? ""; ?>">
				<?php echo $errors["habitat"] ?? ""; ?>
			</div>

			<div class="form-group">
				<label for="birthday">Birthday</label>
				<input type="date" name="birthday" id="birthday" value="<?php echo $postback_value["birthday"] ?? ""; ?>">
				<?php echo $errors["birthday"] ?? ""; ?>
			</div>

			<h3 class="section-title">Extra Info</h3>
			<div class="form-group row justify-content-between">
				<?php
				echo display_toggle_input("Overweight");
				echo display_toggle_input("House-trained");
				echo display_toggle_input("Neutered");
				echo display_toggle_input("Had babies");
				?>
			</div>

			<h3 class="section-title">Diet</h3>






			<div class="form-group d-flex justify-content-center">
				<input type="submit" name="submit" id="add" class="btn" value="Add">
			</div>

		</form>

	</div>
	
</section>
