<?php $section_id = str_contains(get_server_uri(), "/edit_pet") ? "edit_pet" : "add_pet"; ?>

<section id="<?php echo $section_id; ?>" class="logged-in fixed-bars-offset pet">

	<div class="pet__photo-container">
		<div class="pet__photo mx-auto">
			<?php include_icon("paw"); ?>
		</div>
	</div>
	<div class="content container">
		<div class="cancel row no-gutters justify-content-end">
			<a href="<?php echo $go_back_url ?? "/view_pets"; ?>">
				<i class="fa-solid fa-xmark fa-3x px-2"></i>
			</a>
		</div>

		<form action="<?php echo get_server_uri(); ?>" method="post" id="pet_form" class="row-flex-column mt-5">

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

				<?php $gender_value = $postback_value["gender"] ?? ""; ?>

					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="gender" id="gender-male" value="male" <?php echo is_checked("male", $gender_value); ?>>

						<label class="form-check-label d-flex align-items-center px-1" for="gender-male">
							Male <i class="fa-solid fa-mars ml-2"></i>
						</label>
					</div>
					<div class="form-check form-check-inline mr-0">
						<input class="form-check-input" type="radio" name="gender" id="gender-female" value="female" <?php echo is_checked("female", $gender_value); ?>>

						<label class="form-check-label d-flex align-items-center px-1" for="gender-female">
							Female <i class="fa-solid fa-venus ml-2"></i>
						</label>
					</div>
				</div>
				<?php echo $errors["gender"] ?? ""; ?>
			</div>

			<div class="form-group">
				<label for="weight">Weight</label>
				<input type="number" name="weight" id="weight" value="<?php echo $postback_value["weight"] ?? ""; ?>" min="0" placeholder="0" step=".01">
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
				<input type="date" name="birthday" id="birthday" value="<?php echo $postback_value["birthday"] ?? ""; ?>" max="9999-12-31">
				<?php echo $errors["birthday"] ?? ""; ?>
			</div>

			<h3 class="section-title">Extra Info</h3>
			<div class="form-group row justify-content-between">
				<?php
				echo display_toggle_input("Overweight", $postback_value["overweight"] ?? "");
				echo display_toggle_input("House-trained", $postback_value["house_trained"] ?? "");
				echo display_toggle_input("Neutered", $postback_value["neutered"] ?? "");
				echo display_toggle_input("Had babies", $postback_value["had_babies"] ?? "");
				?>
			</div>

			<h3 class="section-title">Diet</h3>

			<div class="form-group">
				<label for="wet_food">Wet Food</label>
				<input type="text" name="wet_food" id="wet_food" value="<?php echo $postback_value["wet_food"] ?? ""; ?>">
				<?php echo $errors["wet_food"] ?? ""; ?>
			</div>

			<div class="form-group">
				<label for="dry_food">Dry Food</label>
				<input type="text" name="dry_food" id="dry_food" value="<?php echo $postback_value["dry_food"] ?? ""; ?>">
				<?php echo $errors["dry_food"] ?? ""; ?>
			</div>

			<div class="form-group">
				<label for="treats">Treats</label>
				<input type="text" name="treats" id="treats" value="<?php echo $postback_value["treats"] ?? ""; ?>">
				<?php echo $errors["treats"] ?? ""; ?>
			</div>

			<div class="form-group">
				<label for="special_requirements">Special Requirements</label>
				<input type="text" name="special_requirements" id="special_requirements" value="<?php echo $postback_value["special_requirements"] ?? ""; ?>">
				<?php echo $errors["special_requirements"] ?? ""; ?>
			</div>


			<?php if (str_contains(get_server_uri(), "/edit_pet")) : ?>
				<input type="hidden" name="id" value="<?php echo $pet_id; ?>">
			<?php endif; ?>

			<div class="row-flex-column">
				<div class="form-group d-flex justify-content-center">
					<?php $btn_txt = str_contains(get_server_uri(), "/edit_pet") ? "Update" : "Add"; ?>
					<input type="submit" name="submit" id="add" class="btn btn--primary" value="<?php echo $btn_txt; ?>">
				</div>

				<div class="form-group d-flex justify-content-center cancel">
					<a href="<?php echo $go_back_url ?? "/view_pets"; ?>" class="btn btn-outline--secondary">Cancel</a>
				</div>
			</div>

			
		</form>

		<?php if (str_contains(get_server_uri(), "/edit_pet")) : ?>
			<div class="form-group d-flex justify-content-center delete-pet">
				<button type="button" class="btn btn--danger" data-toggle="modal" data-target="#delete_pet_confirm">Delete Pet</button>
			</div>
		<?php endif; ?>
			
		</div>
		
	</section>
	<?php
	if (str_contains(get_server_uri(), "/edit_pet")) {
		include_view("components/modal", ["type" => "delete_pet", "postback_value" => $data["postback_value"]]);
	}
	?>
