<?php

$title = "Are you sure you want to ";
$btn_class = "btn--danger";
$btn_txt = "";

if ($type === "delete_pet") {
	$title .= '<span class="text-danger">delete ' . $postback_value["name"] . '?</span>';
	$form_action = "/delete";
	$btn_txt = "Delete";
	$form_id = "pet_form";
}
elseif ($type === "delete_account") {
	$title .= '<span class="text-danger">delete your account?</span>';
	$btn_txt = "Delete Account";
	$form_action = "/delete";
	$form_id = "pet_form";
}
elseif ($type === "book_vets") {
	$title = "Confirm Your Appointment";
	$btn_txt = "Confirm";
	$btn_class = "btn--success";
	$form_action = "";
	$form_id = "booking_form";

	$surgery_name = $extra["vet_individual"]["surgery"]["name"];
	$surgery_location = $extra["vet_individual"]["surgery"]["address"];
	$vet_name = $extra["vet_individual"]["vet"]["name"];
}
?>

<div class="modal fade" id="<?php echo $type; ?>_confirm" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<?php if ($type === "book_vets") : ?>
				<div class="icon mx-auto my-3">
			<?php include_icon("book_vets"); ?>
				</div>
		<?php endif; ?>
		<div class="modal-header">
			<h5 class="modal-title text-center"><?php echo $title; ?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<?php if ($type === "book_vets") : ?>
		<div class="appointment row-flex-column">
			<div class="appointment__item">
				<i class="fa-regular fa-calendar-days"></i>

				
				<p><?php echo format_date($data["postback_value"]["date"], "l jS F"); ?></p>
			</div>
			<div class="appointment__item">
				<i class="fa-regular fa-clock"></i>
				<p><?php echo format_time($postback_value["time"]); ?></p>
			</div>
			<div class="appointment__item">
				<i class="fa-solid fa-location-dot"></i>
				<p><?php echo $surgery_name . ", " . $surgery_location; ?></p>
			</div>

			<div class="appointment__item vet-and-pets row no-gutters flex-nowrap">

				<div class="vet-selection row no-gutters flex-nowrap">
				<div class="item">
						<div class="row-flex-column">
							<div class="item__photo">
								<i class="fa-solid fa-user fa-2x"></i>
							</div>
							<div class="item__name"><?php echo $vet_name; ?></div>
						</div>
					</div>
				</div>


				<div class="pet-selection row no-gutters flex-nowrap">
			<?php foreach ($extra["pet_details"] as $key => $pet) : ?>
					<div class="item">
						<div class="row-flex-column">
							<div class="item__photo"><?php include_icon("paw"); ?></div>
							<div class="item__name"><?php echo $pet["name"]; ?></div>
						</div>
					</div>
			<?php endforeach; ?>
			</div>


			</div>
		</div>
		<?php endif; ?>

		
		<div class="modal-footer">
			<button type="button" class="btn btn-outline--secondary" data-dismiss="modal">Cancel</button>

			<form action="<?php echo $form_action; ?>" method="post" id="<?php echo $form_id; ?>" class="row-flex-column">

				<?php if ($type === "book_vets") :
					// Somehow store all booking values here in a hidden field ?>
				<?php else : ?>
					<input type="hidden" name="id" value="<?php echo $postback_value["id"]; ?>">
				<?php endif; ?>

				<input type="submit" name="<?php echo $type; ?>" id="<?php echo $type; ?>_btn" class="btn <?php echo $btn_class; ?>" value="<?php echo $btn_txt; ?>">
			</form>
		</div>
		</div>
	</div>
</div>
