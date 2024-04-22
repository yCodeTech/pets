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
		<div class="appointment">
			<div><?php echo $extra["formatted_booking_date"]; ?></div>
			<div><?php echo $postback_value["time"]; ?></div>
			<div><?php echo $postback_value["surgery"]; ?></div>

			<div class="row">
				<div class="vet"><?php echo $postback_value["vet"]; ?></div>
				<div class="pets-selected">
			<?php
			foreach ($extra["pet_details"] as $key => $value) {
				echo $value["name"];
			}
			?>
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
