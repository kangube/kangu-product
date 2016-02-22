<?php

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	
	include("../php-assets/class.dbconfig.php");
  	
	if(isset($_POST["page"])) {
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)){die('Invalid page number!'); }
	} else {
		$page_number = 1;
	}
	
	
	$advert_results = $mysqli->query("SELECT COUNT(*) FROM tbl_advert");
	$get_total_rows = $advert_results->fetch_row();
	$total_pages = ceil($get_total_rows[0]/$item_per_page);
	$page_position = (($page_number-1) * $item_per_page);
	

	$test = 'true';
	if ($test == 'true') 
	{	
		
		$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_id ASC LIMIT $page_position, $item_per_page");
		$advert_results->execute();
		$advert_results->bind_result($advert_id, $advert_creator, $description, $advert_price, $advert_spots, $advert_school, $user_profile_image, $user_first_name, $user_last_name, $user_city);


		while($advert_results->fetch()) {

			$shorten = strpos($description, ' ', 125);
			$advert_description = substr($description, 0, $shorten);

			echo "<div class='advert-container end'>
				  	<a href='advertdetail.php?id=".$advert_id."' class='advert-link'>
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

							<p class='advert-description'>".$advert_description."</p>
			
			    			<div class='small-6 columns'>
				    			<div class='advert-price'>
					    			<p>".$advert_price."</p>
					    			<p>p/u</p>
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

		echo '<div align="center">';
		/* We call the pagination function here to generate Pagination link for us. 
		As you can see I have passed several parameters to the function. */
		echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
		echo '</div>';
		
		exit;
	}
	else {
		echo 'nee';
	}
}

function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
{
    $pagination = '';
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
        $pagination .= '<ul class="pagination">';
        
        $right_links    = $current_page + 3; 
        $previous       = $current_page - 3;
        $next           = $current_page + 1;
        $first_link     = true;
        
        if($current_page > 1){
			$previous_link = ($previous==0)? 1: $previous;
            //$pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
            //$pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
                for($i = ($current_page-2); $i < $current_page; $i++) {
                    if($i > 0){
                        $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                    }
                }   
            $first_link = false;
        }
        
        if($first_link) {
            $pagination .= '<li class="first active">'.$current_page.'</li>';
        } else if($current_page == $total_pages) {
            $pagination .= '<li class="last active">'.$current_page.'</li>';
        } else {
            $pagination .= '<li class="active">'.$current_page.'</li>';
        }
                
        for($i = $current_page+1; $i < $right_links ; $i++) {
            if($i<=$total_pages) {
                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
            }
        }
        if($current_page < $total_pages){ 
				$next_link = ($i > $total_pages) ? $total_pages : $i;
                //$pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
                //$pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
        }
        
        $pagination .= '</ul>'; 
    }
    return $pagination;
}

?>

