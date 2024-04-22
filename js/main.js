/**
 * Keep label at the top if there's text in the input.
 */
$("input:not(.no-label-top)").on("focusout", function () {
	const $label = $(this).siblings("label");
	if (!$(this).is("[type=date]") && !$(this).is("[type=number]") && !$(this).is("[type=time]")) {
		if ($(this).val() != "") {
			$label.addClass("label-top");
		} else {
			$label.removeClass("label-top");
		}
	}
});

/**
 * Show/hide password
 */
$(".show-password").on("click", function () {
	const $label = $(this).siblings("label");

	const $password_input = $(this).siblings("input");

	const type = $password_input.prop("type") === "password" ? "text" : "password";
	$password_input.attr("type", type);

	$(this).find("i").toggleClass("fa-eye-slash").toggleClass("fa-eye");
});

/**
 * Book Vets
 *
 * Change staff based on the selected surgery name
 */
$("#vet_form #surgery").on("change", function () {
	let surgery = $(this).find("option:selected").text();

	$("#vet_staff .vet-selection").addClass("d-none");

	if (surgery != "None") {
		surgery = surgery.split(",")[0].replace(" ", "_");
		$("#vet_staff").find(`#${surgery}`).removeClass("d-none");
	}
});

// On first load.
$(function () {
	$("input:not(.form-check-input):not([type='checkbox']):not(.no-label-top)").each(function () {
		setTimeout(() => {
			if ($(this).val() != "" || $(this).is("[type=date]") || $(this).is("[type=number]") || $(this).is("[type=time]")) {
				$(this).siblings("label").addClass("label-top");
			}
		}, 10);
	});

	$("#vet_staff .vet-selection").each(function () {
		let surgery = $("#vet_form #surgery").find("option:selected").text();

		if (surgery != "None") {
			surgery = surgery.split(",")[0].replace(" ", "_");
			$("#vet_staff").find(`#${surgery}`).removeClass("d-none");
		}
	});

	/**
	 * If the toggle container is clicked, toggle it's input on/off.
	 */
	$(".toggle-container").on("click", function () {
		const $input = $(this).find("input");
		if ($input.is(":checked")) {
			$input.attr("checked", false);
		} else {
			$input.attr("checked", true);
		}
	});
});
