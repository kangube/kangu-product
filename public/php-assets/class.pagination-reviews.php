<?php

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	
	include("../php-assets/class.dbconfig.php");
  	
	if(isset($_POST["page"])) {
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)) { 
			die('Invalid page number!'); 
		}
	} else {
		$page_number = 1;
	}
	
	
	$review_results = $mysqli->query("SELECT COUNT(*) FROM tbl_review");
	$get_total_rows = $review_results->fetch_row();
	$total_pages = ceil($get_total_rows[0]/$item_per_page_reviews);
	$page_position = (($page_number-1) * $item_per_page_reviews);
	

	$review_exist = 'true';
	if ($review_exist == 'true') 
	{	
		$review_results = $mysqli->prepare("SELECT review_id, review_description, review_date, fk_advert_id, fk_user_id, user_firstname, user_lastname, user_image_path FROM tbl_review LEFT JOIN tbl_user ON tbl_review.fk_user_id=tbl_user.user_id WHERE tbl_review.fk_advert_id=".$_GET['id']." LIMIT $page_position, $item_per_page_reviews");
		$review_results->execute();
		$review_results->bind_result($review_id, $review_description, $review_date, $fk_advert_id, $fk_user_id, $user_firstname, $user_lastname, $user_image_path);


		while($review_results->fetch()) {
			// Processing and shortening the review description
			$shorten = strpos($review_description, ' ', 350);
			$final_review_description = substr($review_description, 0, $shorten)." ...";

			// Processing and reformating the review-date from numbers to string
			$processed_review_date = explode("-", $review_date);
			$review_date_year = $processed_review_date[0];
			$review_date_month = $processed_review_date[1];
			$review_date_day = $processed_review_date[2];

			$review_date_month = date('F', mktime(0, 0, 0, $review_date_month, 10));
			$months = array('Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December');
			$months_alt = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'December');
			$review_date_month = str_ireplace($months_alt, $months, $review_date_month);

			echo "

				<div class='small-12 large-6 columns advert-detail-review-container'>
					<div class='advert-detail-review'>
						<ul>
							<li class='review-profile-image'><img src='".$user_image_path."' alt='profiel-foto van de ouder'/></li>
			    			<li class='review-profile-name'>".$user_firstname." ".$user_lastname."</li>
		    			</ul>

			    		<p class='review-description'>".$review_description."</p>

			    		<p class='review-date float-left'>".$review_date_day." ".$review_date_month." ".$review_date_year."</p>

			    		<button class='review-vote-button float-right'>
			    			<ul>
				    			<li data-icon='r'></li>
				    			<li>Behulpzaam</li>
			    			</ul>
			    		</button>
				    </div>
			    </div>
			";
		}

		echo '<div class="large-12 columns">';
		echo paginate_function($item_per_page_reviews, $page_number, $get_total_rows[0], $total_pages);
		echo '</div>';

		exit;
	}
	else {
		echo '<p></p>';
	}
}

function paginate_function($item_per_page_reviews, $current_page, $total_records, $total_pages)
{
    $pagination = '';

    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
        $pagination .= '<ul class="pagination pagination-style" role="navigation" aria-label="Pagination">';
        
        $right_links    = $current_page + 4;
        $first_link     = true;

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
        
        $pagination .= '</ul>'; 
    }
    return $pagination;
}

?>