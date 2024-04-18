/**
 * Keep label at the top if there's text in the input.
 */
$("input").on("focusout", function () {
	const $label = $(this).siblings("label");
	if (!$(this).is("#birthday")) {
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

// On first load.
$(function () {
	$("input:not(.form-check-input)").each(function () {
		setTimeout(() => {
			if ($(this).val() != "" || $(this).is("#birthday")) {
				$(this).siblings("label").addClass("label-top");
			}
		}, 10);
	});
});
