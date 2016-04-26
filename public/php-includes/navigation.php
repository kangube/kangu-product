<div class="mobile-menu-background"></div>

<div class="mobile-menu-panel">
	<button id="mobile-menu-close-button" class="close-button" aria-label="Close mobile search form" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

	<div class="profile-information">
		<ul>
			<li><img src="<?php echo $userRow['user_image_path']; ?>"></li>
			<li><a href="#"><?php echo $userRow['user_firstname'].' '.$userRow['user_lastname']; ?></a></li>
		</ul>
	</div>

	<div class="create-advert">
		<a href="../pages/advert-create.php">Opvang aanbieden</a>
	</div>

	<div class="menu-links">
		<div><span>Het platform</span></div>
		<ul>
			<li><a href="#">Advertenties</a></li>
			<li><a href="#">Schema</a></li>
			<li><a href="#">Transacties</a></li>
		</ul>
	</div>

	<div class="profile-links">
		<div><span>Jouw profiel</span></div>
		<ul>
			<li><a href="#">Mijn account</a></li>
			<li><a href="../pages/logout.php">Afmelden</a></li>
		</ul>
	</div>
</div>

<div class="top-bar-mobile">
	<span id="top-bar-mobile-menu-button" data-icon="j"></span>
	<span>kangu</span>
	<span data-icon="f"></span>
</div>

<div class="row">
	<div class="large-12 small-centered columns">
		<div class="top-bar" id="top-bar-menu">
			<div class="top-bar-title show-for-medium">kangu</div>

			<div class="top-bar-right">
				<ul class="vertical medium-horizontal menu">
					<li><a href="../pages/advert-create.php" class="provide-services-button">Opvang aanbieden</a></li>
					<li><a href="#">Advertenties</a></li>
					<li><a href="#">Schema</a></li>
					<li><a href="#">Transacties</a></li>
					<li><a href="#" class="show-for-medium" data-icon="g"></a></li>
					<li>
						<ul class="dropdown menu user-dropdown-menu" data-dropdown-menu>
							<li><img class="user-profile-image" src="<?php echo $userRow['user_image_path']; ?>"></li>
							<li>
								<a href="#"><?php echo $userRow['user_firstname'].' '.$userRow['user_lastname']; ?></a>
								<ul class="vertical menu">
									<li><a href="#">Afmelden</a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>