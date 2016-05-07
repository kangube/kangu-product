<?php

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	include("../php-assets/class.dbconfig.php");
  	
	if(isset($_POST["page"])) {
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)) { 
			die('Invalid page number!'); 
		}
	} else {
		$page_number = 1;
	}
	
	$advert_results = $mysqli->query("SELECT COUNT(*) FROM tbl_advert");
	$get_total_rows = $advert_results->fetch_row();
	$total_pages = ceil($get_total_rows[0]/$item_per_page);
	$page_position = (($page_number-1) * $item_per_page);
	
	echo "<div class='large-12 columns'>
			    <div class='large-10 columns'>
			    	<h2>Advertenties</h2>
			    	<hr class='blue-horizontal-line'></hr>
			    </div>

			    <div class='large-2 columns'>
			    	<form class='advert-filter-form' action='advert-overview.php' method='post'>
						<select class='advert-overview-filter' name='advert-overview-filter'>
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
	
	if(!isset($_POST['chosenFilter']))
	{
		$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_id ASC LIMIT $page_position, $item_per_page");
	}
	else if (isset($_POST['chosenFilter'])) {
		switch($_POST['chosenFilter']) {
			// Display the most recently created adverts
			case 'recent':
				$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_id DESC LIMIT $page_position, $item_per_page");
			break;

			// Display the most popular adverts
			case 'popular':
				$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_number_bookings DESC LIMIT $page_position, $item_per_page");
			break;

			// Display all adverts while ordering by an ascending price
			case 'ascending':
				$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_price ASC LIMIT $page_position, $item_per_page");
			break;

			// Display all adverts while ordering by an descending price
			case 'descending':
				$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_price DESC LIMIT $page_position, $item_per_page");
			break;

			// Display all adverts
			default:
			$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_id ASC LIMIT $page_position, $item_per_page");
		}
	}

	$advert_results->execute();
	$advert_results->bind_result($advert_id, $advert_creator, $advert_description, $advert_price, $advert_spots, $advert_school, $user_profile_image, $user_first_name, $user_last_name, $user_city);

	while($advert_results->fetch()) {

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
				    			<p>per kind</p>
			    			</div>
			    		</div>

			    		<div class='small-6 columns'>
			    			<div class='advert-spots'>
			    				<p>".$advert_spots."</p>
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
            $pagination .= '<li class="pagination-previous"><a href="#" data-page="'.$previous.'" title="Previous">Vorige pagina</a></li>';
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
            $pagination .= '<li class="pagination-next"><a href="#" data-page="'.$next.'" title="Next">Volgende pagina</a></li>';
        } else {
            $pagination .= '<li class="pagination-next disabled">Volgende pagina</li>';
        }
        
        $pagination .= '</ul>'; 
    }
    return $pagination;
}

echo "</div>";
?>

