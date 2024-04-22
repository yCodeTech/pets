<section id="book_vets" class="logged-in fixed-bars-offset">

	<h3 class="section-title pt-5">Book an appointment</h3>

	<form action="<?php echo get_server_uri(); ?>" method="post" id="vet_form" class="row-flex-column mt-5">
		<div class="form-group">
			<label for="surgery" class="surgery">Choose a surgery</label>
			<select name="surgery" id="surgery" class="custom-select">
				<option selected value="">None</option>
				<?php
				$surgery_val = $postback_value["surgery"] ?? "";

				if ($surgeries) {
					foreach ($surgeries as $surgery) {?>
						<option value="<?php echo $surgery["id"]; ?>" <?php echo is_selected($surgery["id"], $surgery_val); ?>><?php echo $surgery["name"] . ", " . $surgery["address"]; ?></option>
					<?php }
				}
				?>
			</select>
			<?php echo $errors["surgery"] ?? ""; ?>
		</div>

		<div class="form-group" id="vet_staff">
			<h3 class="input-title">Choose a vet</h3>

			<?php if ($vets) : ?>
				<?php foreach ($vets as $surgery => $staff) : ?>
				<div class="row no-gutters vet-selection d-none" id="<?php echo $surgery; ?>">

					<?php foreach ($staff as $key => $vet) : ?>
						<div class="item form-check">

						<?php $vet_val = $postback_value["vet"] ?? ""; ?>
						
							<input type="radio" name="vet" id="vet_<?php echo $vet["name"]; ?>" value="<?php echo $vet["id"]; ?>" class="form-check-input no-label-top" <?php echo is_checked($vet["id"], $vet_val); ?>>

							<label for="vet_<?php echo $vet["name"]; ?>" class="form-check-label row-flex-column no-label-top">
								<div class="item__photo">
									<i class="fa-solid fa-user fa-2x"></i>
								</div>
								<div class="item__name"><?php echo $vet["name"]; ?></div>
							</label>

						</div>
						
					<?php endforeach; ?>
				</div>

				<?php endforeach; ?>
			<?php endif; ?>

			<?php echo $errors["vet"] ?? ""; ?>
		</div>
		<div class="form-group">
			<label for="pet" class="input-title">Choose your pet to be seen</label>
			<p class="note">Select as many as needed</p>

			<div class="pet-selection row no-gutters">
				<?php foreach ($pets as $pet) : ?>
					<div class="item form-check">

					<?php $pet_val = $postback_value["pet"] ?? ""; ?>

						<input type="checkbox" name="pet[]" id="pet_<?php echo $pet["name"]; ?>" value="<?php echo $pet["id"]; ?>" class="form-check-input no-label-top" <?php echo is_checked($pet["id"], $pet_val); ?>>

						<label for="pet_<?php echo $pet["name"]; ?>" class="form-check-label row-flex-column no-label-top">
							<div class="item__photo"><?php include_icon("paw"); ?></div>
							<div class="item__name"><?php echo $pet["name"]; ?></div>
						</label>

					</div>
					
				<?php endforeach; ?>
			</div>
			<?php echo $errors["pet"] ?? ""; ?>
		</div>

		<div class="form-group">
			<label for="date" class="input-title">Choose a date</label>
			<input type="date" name="date" id="date" value="<?php echo $postback_value["date"] ?? ""; ?>" max="9999-12-31">
			<?php echo $errors["date"] ?? ""; ?>
		</div>
		<div class="form-group">
			<label for="time" class="input-title">Choose a Time</label>
			<input type="time" name="time" id="time" value="<?php echo $postback_value["time"] ?? ""; ?>">
			<?php echo $errors["time"] ?? ""; ?>
		</div>


		<div class="form-group d-flex justify-content-center">
			<input type="submit" name="submit" id="book" class="btn btn--primary" value="Book">
		</div>

	</form>
</section>

<?php if (isset($confirm_booking)) :
	include_view("components/modal", ["type" => "book_vets", "postback_value" => $data["postback_value"], "extra" => $extra]);
	?>

<script>setTimeout(()=>jQuery('#book_vets_confirm').modal("show"), 10);</script>

<?php endif; ?>
