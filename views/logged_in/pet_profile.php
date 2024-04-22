<section id="pet_profile" class="logged-in fixed-bars-offset pet">

	<div class="pet__photo-container">
		<div class="pet__photo mx-auto">
			<?php include_icon("paw"); ?>
		</div>
	</div>
	<div class="content container">
		<div class="row no-gutters justify-content-end">
			<a href="/edit_pet?id=<?php echo $pet["id"]; ?>" class="edit-btn">
				<i class="fa-solid fa-pen fa-2x"></i>
			</a>
		</div>

		<div class="name row-flex-column align-items-center pt-3 px-5">
			<?php echo $pet["name"]; ?>
			<div class="nickname">
				<?php echo $pet["nickname"] ?? ""; ?>
			</div>
		</div>

		<h3 class="section-title mt-5">Basic Info</h3>

		<div class="items row mt-4 justify-content-around">
			<div class="item row-flex-column align-items-center">
				<h4>Species</h4>
				<p><?php echo $pet["species"]; ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Breed</h4>
				<p><?php echo $pet["breed"]; ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Gender</h4>
				<p><?php echo get_gender_icon($pet["gender"]); ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Weight</h4>
				<p><?php echo (float) number_format($pet["weight"], 2); ?>kg</p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Colour</h4>
				<p><?php echo $pet["colour"]; ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Habitat</h4>
				<p><?php echo $pet["habitat"]; ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Birthday</h4>
				<p><?php echo $pet["birthday_formatted"]; ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Age</h4>
				<p><?php echo $pet["age"]; ?></p>
			</div>	

		</div>


		<h3 class="section-title mt-5">Extra Info</h3>

		<div class="items row mt-4 justify-content-around">
			<div class="item row-flex-column align-items-center">
				<h4>Overweight</h4>
				<p><?php echo get_boolean_icon($pet["overweight"]); ?></p>
			</div>
			<div class="item row-flex-column align-items-center">
				<h4>House-trained</h4>
				<p><?php echo get_boolean_icon($pet["house_trained"]); ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Neutered</h4>
				<p><?php echo get_boolean_icon($pet["neutered"]); ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Had Babies</h4>
				<p><?php echo get_boolean_icon($pet["had_babies"]); ?></p>
			</div>	
		</div>

		<h3 class="section-title mt-5">Diet</h3>

		<div class="items row mt-4 justify-content-around">
			<div class="item row-flex-column align-items-center">
				<h4>Wet Food</h4>
				<p><?php echo $pet["wet_food"]; ?></p>
			</div>
			<div class="item row-flex-column align-items-center">
				<h4>Dry Food</h4>
				<p><?php echo $pet["dry_food"]; ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Treats</h4>
				<p><?php echo $pet["treats"]; ?></p>
			</div>	
			<div class="item row-flex-column align-items-center">
				<h4>Special Requirements</h4>
				<p><?php echo $pet["special_requirements"]; ?></p>
			</div>	
		</div>


		<h3 class="section-title mt-5">Current 3 or Past Prescriptions</h3>
		<div class="items row mt-4 justify-content-center">
			<div class="placeholder"></div>
			<div class="placeholder"></div>
			<div class="placeholder"></div>
			<a href="/prescriptions?id=<?php echo $pet["id"]; ?>" class="btn btn--primary">View All Prescriptions</a>
			
		</div>

		<h3 class="section-title mt-5">Medical History</h3>
		<div class="items row mt-4 justify-content-center">
			<div class="item placeholder"></div>
			<div class="item placeholder"></div>
			<div class="item placeholder"></div>
			<a href="/medical_history?id=<?php echo $pet["id"]; ?>" class="btn btn--primary">View Full Vet's Record</a>
		</div>


	</div>
</section>
