<?php

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	include("../php-assets/class.dbconfig.php");

	// Setting up the required connection    
	$con = mysqli_connect("localhost","root","root","kangu-product");

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	mysqli_select_db($con,"test");

	// Collecting all given search variables
	$school = htmlspecialchars($_POST['school']); 
    $price = htmlspecialchars($_POST['price']);
    $spots = htmlspecialchars($_POST['spots']);
  	
  	// Gathering the page numer if pagination element has been clicked
	if(isset($_POST["page"])) {
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)) { 
			die('Invalid page number!'); 
		}
	} else {
		$page_number = 1;
	}
	
	// Calculating the number of pages and the current page position
	$search_results = $mysqli->query("SELECT COUNT(*) FROM tbl_advert WHERE advert_school LIKE '%".$school."%' AND advert_price <= '".$price."' AND advert_spots >= '".$spots."'");
	$get_total_rows = $search_results->fetch_row();
	$total_pages = ceil($get_total_rows[0]/$item_per_page);
	$page_position = (($page_number-1) * $item_per_page);
	
    // Executing the search query
    $raw_results = mysqli_query($con, "SELECT * FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id WHERE advert_school LIKE '%".$school."%' AND advert_price <= '".$price."' AND advert_spots >= '".$spots."' ORDER BY advert_id DESC LIMIT $page_position, $item_per_page");

    // Displaying all adverts that match the defined query
    if($get_total_rows[0] > 0) {
		echo "<div class='large-12 columns'>
				    <div class='large-10 columns'>
				    	<h2>".$get_total_rows[0]." gevonden advertenties</h2>
				    	<hr class='blue-horizontal-line'></hr>
				    </div>

				    <div class='large-2 columns'>
				    	<form action='advert-overview.php' method='post'>
							<select class='search-advert-overview-filter' name='advert-overview-filter' onchange='this.form.submit()'>
								<option selected='selected'>Filter advertenties</option>
								<option value='recent'>Meest recent</option>
								<option value='popular'>Meest populair</option>
								<option value='descending'>Prijs hoog - laag</option>
								<option value='ascending'>Prijs laag - hoog</option>
							</select>
						</form>
				    </div>
				</div>";

        while($results = mysqli_fetch_array($raw_results)) {

        	$shorten = strpos($results['advert_description'], ' ', 145);
			$final_advert_description = substr($results['advert_description'], 0, $shorten)." ...";

            echo "<div class='advert-container end'>
				  	<a href='advert-detail.php?id=".$results['advert_id']."' class='advert-link'>
						<div class='advert'>
			    			<div class='small-12 columns'>
				    			<div class='small-2 columns'>
				    				<img class='advert-profile-image' src='".$results['user_image_path']."'>
				    			</div>
				    			
				    			<div class='small-10 columns'>
					    			<ul class='advert-information-list'>
					    				<li>".$results['user_firstname'].' '.$results['user_lastname']."</li>
					    				<li data-icon='d'>".$results['user_city']."</li>
					    			</ul>
				    			</div>
			    			</div>

							<p class='advert-description'>".$final_advert_description."</p>
			
			    			<div class='small-6 columns'>
				    			<div class='advert-price'>
					    			<p>".$results['advert_price']."</p>
					    			<p>p/u</p>
				    			</div>
				    		</div>

				    		<div class='small-6 columns'>
				    			<div class='advert-spots'>
				    				<p>".$results['advert_spots']."</p>
					    			<p>plaatsen</p>
				    			</div>
				    		</div>
	    	
				    		<p class='advert-school' data-icon='e'>Basisschool ".$results['advert_school']."</p>
			    		</div>
			    	</a>
		    	</div>";
        }
    }
    else {
        echo "<div class='no-search-results-container'><p>Er zijn geen advertenties gevonden</p></div>";
    }

    // Creating the pagination element
	echo '<div class="large-12 columns">';
	echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
	echo '</div>';

	exit;

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

