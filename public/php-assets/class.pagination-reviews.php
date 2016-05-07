<?php

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	include("../php-assets/class.dbconfig.php");
	include_once("../php-assets/class.vote.php");

	// Processing user vote on a review
    $vote = new Vote();

    if(isset($_POST["ReviewId"])) {
		// Passing data to the vote class for processing
		$vote->UserId = $_POST['UserId'];
		$vote->ReviewId = $_POST['ReviewId'];
		$has_voted = $vote->HasVoted();

		if ($has_voted === false) {
			$vote->Vote();
		}
	}
  	
	if(isset($_POST["page"])) {
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)) { 
			die('Invalid page number!'); 
		}
	} else {
		$page_number = 1;
	}
	
	// Processing the number of reviews of the advert
	$review_results = $mysqli->query("SELECT COUNT(*) FROM tbl_review WHERE fk_advert_id='".$_POST['id']."'");
	$get_total_rows = $review_results->fetch_row();
	$total_pages = ceil($get_total_rows[0]/$item_per_page_reviews);
	$page_position = (($page_number-1) * $item_per_page_reviews);

	if ($get_total_rows[0] == 0) {
		echo "<div class='small-12 columns advert-detail-no-reviews-container'>
				<div class='no-reviews-container'>
					<span class='no-reviews-icon' data-icon='4'></span>
					<p class='no-reviews-title'>Er zijn nog geen reviews geschreven voor deze opvangbiedende ouder.</p>
				</div>
			 </div>";
	}
	else if ($get_total_rows[0] >= 1) {
		// Calculating the average rating of the advert
		$rating_results = $mysqli->query("SELECT AVG(review_rating) AS average_rating, COUNT(review_rating) AS number_ratings FROM tbl_review WHERE fk_advert_id='".$_POST['id']."'");
		$rating_rows = $rating_results->fetch_row();
	    $average_rating = round($rating_rows[0] * 2) / 2;

	    // Processing all of the reviews associated with this advert
		echo "<div class='small-12 columns advert-detail-counter-container'>";
				
				$starNumber = $average_rating;

				for($x=1; $x<=$starNumber; $x++) {
					echo '<span class="rating-star" data-icon="1"></span>';
				}
				if (strpos($starNumber,'.')) {
					echo '<span class="rating-star" data-icon="2"></span>';
					$x++;
				}
				while ($x<=5) {
					echo '<span class="rating-star" data-icon="3"></span>';
					$x++;
				}

		echo "	<span class='advert-detail-counter-ratings'>(".$rating_rows[1]." gebruikers)</span>	
				<p class='advert-detail-counter-reviews' data-icon='l'>".$get_total_rows[0]." geschreven reviews</p>
			  </div>";

		$review_results = $mysqli->query("SELECT review_id, review_description, review_date, review_upvotes, fk_advert_id, fk_user_id, user_firstname, user_lastname, user_image_path FROM tbl_review LEFT JOIN tbl_user ON tbl_review.fk_user_id=tbl_user.user_id WHERE tbl_review.fk_advert_id='".$_POST['id']."' ORDER BY review_upvotes DESC LIMIT $page_position, $item_per_page_reviews");
		
		while ($services_row = $review_results->fetch_array(MYSQLI_ASSOC)) {
			// Processing and shortening the review description
			$shorten = strpos($review_description, ' ', 350);
			$final_review_description = substr($review_description, 0, $shorten)." ...";

			// Processing and reformatting the review-date from numbers to string
			$processed_review_date = explode("-", $services_row['review_date']);
			$review_date_year = $processed_review_date[0];
			$review_date_month = $processed_review_date[1];
			$review_date_day = ltrim($processed_review_date[2], '0');

			$review_date_month = date('F', mktime(0, 0, 0, $review_date_month, 10));
			$months = array('Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December');
			$months_alt = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'December');
			$review_date_month = str_ireplace($months_alt, $months, $review_date_month);

			// Checking if the user has voted on this review
			$user_vote_results = $mysqli->query("SELECT COUNT(*) FROM tbl_upvote WHERE fk_user_id=".$_POST['user_id']." AND fk_review_id=".$services_row['review_id']."");
			$vote_result_row = $user_vote_results->fetch_row();

			echo "

				<div class='small-12 large-6 columns advert-detail-review-container'>
					<div class='advert-detail-review'>
						<form class='vote-review-form' method='post'>
							<ul>
								<li class='review-profile-image'><img src='".$services_row['user_image_path']."' alt='profiel-foto van de ouder'/></li>
				    			<li class='review-profile-name'>".$services_row['user_firstname']." ".$services_row['user_lastname']."</li>
			    			</ul>
				    		<p class='review-description'>".$services_row['review_description']."</p>
				    		<p class='review-date float-left'>".$review_date_day." ".$review_date_month." ".$review_date_year."</p>
				    		<input type='hidden' class='review-id' name='review-id' value='".$services_row['review_id']."'/>

				    		";

				    		if($vote_result_row[0] == 0) {
				    			echo "<button type='button' class='review-vote-button float-right'>
					    			<ul>
						    			<li data-icon='r'></li>
						    			<li>Behulpzaam</li>
					    			</ul>
					    		</button>";
							} else if($vote_result_row[0] == 1) {
							 	echo "<button type='button' class='review-vote-button float-right' disabled>
					    			<ul>
						    			<li data-icon='r'></li>
						    			<li>Behulpzaam</li>
					    			</ul>
					    		</button>";
							}
			echo "
			    		</form>
				    </div>
			    </div>
			";
		}

		echo '<div class="large-12 columns">';
		echo paginate_function($item_per_page_reviews, $page_number, $get_total_rows[0], $total_pages);
		echo '</div>';

		exit;
	}
}

function paginate_function($item_per_page_reviews, $current_page, $total_records, $total_pages) {
    $pagination = '';

    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
        $pagination .= '<ul class="pagination advert-detail-pagination" role="navigation" aria-label="Pagination">';
        
        $right_links    = $current_page + 4;
        $first_link     = true;

        // Page links
        if($current_page > 1){
            for($i = ($current_page-2); $i < $current_page; $i++) {
                if($i > 0){
                    $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
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
                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
            }
        }
        
        $pagination .= '</ul>'; 
    }
    return $pagination;
}

?>