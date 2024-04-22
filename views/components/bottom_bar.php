<nav class="bottom-bar navbar navbar-light bg-light fixed-bottom justify-content-around row no-gutters w-100">
		<a href="/view_pets" class="bottom-bar__btn text-center<?php echo active_page("view_pets"); ?>">
			<?php include_icon("view_pets"); ?>
			<div>View Pets</div>
		</a>
		
		<?php if (get_server_uri() === "/view_pets") : ?>
			<a href="/add_pet" class="bottom-bar__fab text-center">
				<i class="fa-solid fa-plus fa-2x"></i>
			</a>
		<?php endif; ?>

		<a href="/book_vets" class="bottom-bar__btn text-center<?php echo active_page("book_vets"); ?>">
			<?php include_icon("book_vets"); ?>
			<div>Book Vets</div>
		</a>
</nav>
