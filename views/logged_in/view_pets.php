<section id="view_pets" class="logged-in fixed-bars-offset">

	<div class="pets row-flex-column py-5">
		<?php foreach ($pets as $pet) : ?>
			<a href="/pet_profile?id=<?php echo $pet["id"]; ?>" class="pet">
				<div class="row align-items-center mx-auto position-relative">
					<div class="pet__photo">
			<?php if ($pet["photo"]) : ?>
							<img src="<?php echo get_uploads_dir() . $pet["photo"]; ?>">
			<?php else : ?>
				<?php include_icon("paw"); ?>
			<?php endif; ?>
					</div>
					<div class="pet__content col row-flex-column py-3">
						<div class="row no-gutters align-items-center justify-content-between">
							<h1 class="pet__content__name"><?php echo $pet["name"]; ?></h1>
							<div class="pet__content__gender"><?php echo get_gender_icon($pet["gender"]); ?></div>
						</div>
						<div class="row no-gutters align-items-center justify-content-between">
							<div class="pet__content__breed"><?php echo $pet["breed"]; ?></div>
							<div class="pet__content__age"><?php echo $pet["age"];?> years old</div>
						</div>
					</div>
				</div>
			</a>

		
		
		<?php endforeach; ?>
	</div>

	<?php if (isset($_SESSION["deleted_pet"])) : ?>
		<div class="alert alert-success mx-auto px-3 text-center alert-dismissible fixed-bottom deleted-pet" role="alert">
		<?php echo $_SESSION["deleted_pet"]; ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<i class="fa-solid fa-xmark"></i>
			</button>
		</div>
		<?php unset($_SESSION['deleted_pet']); ?>
	<?php endif;?>

</section>
