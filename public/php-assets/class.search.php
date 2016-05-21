<?php

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	include("../php-assets/class.dbconfig.php");
  	
  	// Gathering the page numer if pagination element has been clicked
	if(isset($_POST["page"])) {
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)) { 
			die('Invalid page number!');
		}
	} else {
		$page_number = 1;
	}
	
    if(!isset($_POST['chosenFilter'])) {
    	// Collecting all given search variables
		$school = htmlspecialchars($_POST['school']);
		$date = htmlspecialchars($_POST['date']); 
	    $spots = htmlspecialchars($_POST['spots']);

		// Calculating the number of pages and the current page position
		$search_results = $mysqli->query("SELECT COUNT(*) FROM tbl_advert LEFT JOIN tbl_availability ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE advert_status='approved' AND advert_school LIKE '%".$school."%' AND availability_date = '".$date."' AND advert_spots >= '".$spots."'");
		$get_total_rows = $search_results->fetch_row();
		$total_pages = ceil($get_total_rows[0]/$item_per_page);
		$page_position = (($page_number-1) * $item_per_page);

		$search_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city, availability_spots FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id LEFT JOIN tbl_availability ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE advert_status='approved' AND advert_school LIKE '%".$school."%' AND availability_spots >= '".$spots."' AND availability_date = '".$date."' ORDER BY advert_id ASC");
	}
	else if (isset($_POST['chosenFilter'])) {
		// Collecting all given search variables with filter
		$filter_school = htmlspecialchars($_POST['filterSchool']);
		$filter_date = htmlspecialchars($_POST['filterDate']);
	    $filter_spots = htmlspecialchars($_POST['filterSpots']);

		// Calculating the number of pages and the current page position
		$search_results = $mysqli->query("SELECT COUNT(*) FROM tbl_advert LEFT JOIN tbl_availability ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE advert_status='approved' AND advert_school LIKE '%".$filter_school."%' AND availability_date = '".$filter_date."' AND advert_spots >= '".$filter_spots."'");
		$get_total_rows = $search_results->fetch_row();
		$total_pages = ceil($get_total_rows[0]/$item_per_page);
		$page_position = (($page_number-1) * $item_per_page);

		switch($_POST['chosenFilter']) {
			// Display the most recently created adverts
			case 'recent':
				$search_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city, availability_spots FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id LEFT JOIN tbl_availability ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE advert_status='approved' AND advert_school LIKE '%".$filter_school."%' AND availability_spots >= '".$filter_spots."' AND availability_date = '".$filter_date."' ORDER BY advert_id DESC LIMIT $page_position, $item_per_page");
			break;

			// Display the most popular adverts
			case 'popular':
				$search_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city, availability_spots FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id LEFT JOIN tbl_availability ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE advert_status='approved' AND advert_school LIKE '%".$filter_school."%' AND availability_spots >= '".$filter_spots."' AND availability_date = '".$filter_date."' ORDER BY advert_number_bookings DESC LIMIT $page_position, $item_per_page");
			break;

			// Display all adverts while ordering by an ascending price
			case 'ascending':
				$search_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city, availability_spots FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id LEFT JOIN tbl_availability ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE advert_status='approved' AND advert_school LIKE '%".$filter_school."%' AND availability_spots >= '".$filter_spots."' AND availability_date = '".$filter_date."' ORDER BY advert_price ASC LIMIT $page_position, $item_per_page");
			break;

			// Display all adverts while ordering by an descending price
			case 'descending':
				$search_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city, availability_spots FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id LEFT JOIN tbl_availability ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE advert_status='approved' AND advert_school LIKE '%".$filter_school."%' AND availability_spots >= '".$filter_spots."' AND availability_date = '".$filter_date."' ORDER BY advert_price DESC LIMIT $page_position, $item_per_page");
			break;

			// Display all adverts
			default:
			$search_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city, availability_spots FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id LEFT JOIN tbl_availability ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE advert_status='approved' AND advert_school LIKE '%".$filter_school."%' AND availability_spots >= '".$filter_spots."' AND availability_date = '".$filter_date."' ORDER BY advert_id ASC LIMIT $page_position, $item_per_page");
		}
	}

	$search_results->execute();
	$search_results->bind_result($advert_id, $advert_creator, $advert_description, $advert_price, $advert_spots, $advert_school, $user_profile_image, $user_first_name, $user_last_name, $user_city, $availability_spots);

    // Displaying all adverts that match the defined query
    if($get_total_rows[0] > 0) {
		echo "<div class='large-12 columns'>
				    <div class='large-10 columns'>
				    	<h2>".$get_total_rows[0]." gevonden advertenties</h2>
				    	<hr class='blue-horizontal-line'></hr>
				    </div>

				    <div class='large-2 columns'>
				    	<form action='advert-overview.php' method='post'>
							<select class='search-advert-overview-filter' name='search-advert-overview-filter'>
								<option selected='selected'>Filter advertenties</option>
								<option value='recent'>Meest recent</option>
								<option value='popular'>Meest populair</option>
								<option value='descending'>Prijs hoog - laag</option>
								<option value='ascending'>Prijs laag - hoog</option>
							</select>
						</form>
				    </div>
				</div> 

				<div class='large-12 columns'>";

	        while($search_results->fetch()) {

			$shorten = strpos($advert_description, ' ', 145);
			$final_advert_description = substr($advert_description, 0, $shorten)." ...";

			echo "<div class='advert-container end'>
				  	<a href='advert-detail.php?id=".$advert_id."' class='advert-link'>
						<div class='advert'>
			    			<div class='small-12 columns'>
				    			<div class='small-2 columns'>
				    				<img class='advert-profile-image' src='".$user_profile_image."'>
				    			</div>
				    			
				    			<div class='small-10 columns'>
					    			<ul class='advert-information-list'>
					    				<li>".$user_first_name.' '.$user_last_name."</li>
					    				<li data-icon='d'>".$user_city."</li>
					    			</ul>
				    			</div>
			    			</div>

							<p class='advert-description'>".$final_advert_description."</p>
			
			    			<div class='small-6 columns'>
				    			<div class='advert-price'>
					    			<p>".$advert_price."</p>
					    			<p>p/u</p>
				    			</div>
				    		</div>

				    		<div class='small-6 columns'>
				    			<div class='advert-spots'>
				    				<p>".$availability_spots."</p>
					    			<p>plaatsen</p>
				    			</div>
				    		</div>
	    	
				    		<p class='advert-school' data-icon='e'>Basisschool ".$advert_school."</p>
			    		</div>
			    	</a>
		    	</div>";
		}

		echo '<div class="large-12 columns">';
		echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
		echo '</div>';

		exit;
    }
    else {
        echo "<div class='large-12 columns'>
			     <div class='large-12 columns'>
			    	<h2>Advertenties</h2>
			    	<hr class='blue-horizontal-line'></hr>
			     </div>

	        	 <div class='advert-overview-no-search-container'>
	        	 	<div class='no-search-results-container'>
		        		<span class='no-adverts-icon' data-icon='5'></span>
		        	 	<p class='no-adverts-title'>Er zijn geen opvang-advertenties gevonden voor uw zoekcriteria.</p>
		        	 </div>
		         </div>
	         </div>";
    }

}

// Function used to define all separate elements of the pagination
function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
{
    $pagination = '';

    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
        $pagination .= '<ul class="pagination" role="navigation" aria-label="Pagination">';
        
        $right_links    = $current_page + 4; 
        $previous       = $current_page - 1;
        $next           = $current_page + 1;
        $first_link     = true;
        
        // Previous page button
        if($current_page > 1) {
            $pagination .= '<li class="pagination-previous"><a href="" data-page="'.$previous.'" title="Previous">Vorige pagina</a></li>';
        } else {
            $pagination .= '<li class="pagination-previous disabled">Vorige pagina</li>';
        }

        // Page links
        if($current_page > 1){
            for($i = ($current_page-2); $i < $current_page; $i++) {
                if($i > 0){
                    $pagination .= '<li data-page="'.$i.'" title="Page'.$i.'">'.$i.'</li>';
                }
            }
            $first_link = false;
        }
        
		if($first_link) {
			$pagination .= '<li class="first current">'.$current_page.'</li>';
		} else if($current_page == $total_pages) {
			$pagination .= '<li class="last current">'.$current_page.'</li>';
		} else {
			$pagination .= '<li class="current">'.$current_page.'</li>';
		}
        
        for($i = $current_page+1; $i < $right_links ; $i++) {

            if($i<=$total_pages) {
                $pagination .= '<li data-page="'.$i.'" title="Page '.$i.'">'.$i.'</li>';
            }
        }

        // Next page button
        if($current_page < $total_pages) {
            $pagination .= '<li class="pagination-next"><a href="" data-page="'.$next.'" title="Next">Volgende pagina</a></li>';
        } else {
            $pagination .= '<li class="pagination-next disabled">Volgende pagina</li>';
        }
        
        $pagination .= '</ul>'; 
    }
    return $pagination;
}

echo "</div>";
?>

