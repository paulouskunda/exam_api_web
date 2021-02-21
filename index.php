<?php
	  /*
	*  This file processes requests and provides data from the db to the mobile application.
	*/
	
   
    require_once 'connection.php';
    require_once 'function.php';


    // function validating all the paramters are available
	// we will pass the required parameters to this function 
	function isTheseParametersAvailable($params){
		//assuming all parameters are available 
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		//if parameters are missing 
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
			//displaying error
			echo json_encode($response);
			
			//stopping further execution
			die();
		}
	}

	$response = array();

	//if it is an api call 
	//that means a get parameter named api call is set in the URL 
	//and with this parameter we are concluding that it is an api call
	if(isset($_GET['apicall'])){
		switch ($_GET['apicall']) {


			//if the api call value is 'login'
            //we will check if the users exists in the database and log them in or ask them to sign up of they don't
			case 'login':
				# code...
				isTheseParametersAvailable(array('pupil_id', 'password'));
				$pupil_id = mysqli_real_escape_string($db_link, $_POST['pupil_id']);
    	        $password = mysqli_real_escape_string($db_link, $_POST['password']);

    	         if(isset($pupil_id, $password)){

					//uploading file and storing it to database as well 
	                $check_out_login = pupilLogin($db_link, $pupil_id, $password);
	                // echo #;
	                if (!$check_out_login) {
	                	# code...
	                    $response['error'] = true;
	                    $response['message'] = $check_out_login.' Pupil ID or Password is Wrong!';
	                }else{
	                	// create an inner array
	                	$pupil_details = array();

	                	while ( $rows = mysqli_fetch_assoc($check_out_login)) {
	                		$pupil_array = array();
	                		$pupil_array['pupil_name'] = $rows['pupil_name'];
	                		$pupil_array['pupil_school'] = $rows['pupil_school'];
	                		$pupil_array['pupil_intake'] = $rows['pupil_intake'];

	                		array_push($pupil_details, $pupil_array);
	                	}

	                	$response['error'] = false;
	                	$response['message'] = $pupil_details;
	                }
                }
				break;
			case 'check_results':
				
				isTheseParametersAvailable(array('intake', 'pupil_id'));
				$intake = mysqli_real_escape_string($db_link, $_POST['intake']);
				$pupil_id = mysqli_real_escape_string($db_link, $_POST['pupil_id']);

				if (isset($intake)) {
					$check_results = checkForResults($db_link, $intake, $pupil_id);

					if ($check_results === false) {
						$response['error'] = true;
						$response['message'] = "No records";
					}else{
						$results_array = array();

						while ($rows = mysqli_fetch_assoc($check_results)){
							$results_array_ = array();
							$results_array_['subject_name'] = $rows['subject_name'];
							$results_array_['subject_grade'] = $rows['subject_grade'];

							array_push($results_array, $results_array_);

						}
						$response['error'] = false;
						$response['message'] = $results_array;
					}
				

				}else{
					$response['error'] = true;
					$response['message'] = "No records";
				}

				break;

			case 'topTen':
				$topTen = pickMostViewed($db_link);
				if (!$topTen) {
					# code...
	                    $response['error'] = true;
	                    $response['top_past_papers'] = 'System has no papers';
				}else{
					$paper_array = array();

					while ($rows = mysqli_fetch_assoc($topTen)) {
						$past_array = array();
						$past_array['pp_id'] = $rows['pp_id'];
						$past_array['paper_name'] = $rows['paper_name'];
						$past_array['paper_year'] = $rows['paper_year'];
						$past_array['paper_url'] = "past_paper/".$rows['paper_url'];
						array_push($paper_array, $past_array);
					}

					$response['error'] = false;
					$response['top_past_papers'] = $paper_array;
				}

				break;

			case 'searchPastPaper':
				isTheseParametersAvailable(array('searchQuery'));
				$searchQuery = mysqli_real_escape_string($db_link, $_POST['searchQuery']);
				if(isset($searchQuery)){
					$searchResults = searchForPastPaper($db_link, $searchQuery);

					if (!$searchResults) {
						$response['error'] = true;
						$response['search_results'] = "Sorry no paper found related to ".$searchQuery;
					}else{
						$search_array = array();

						while ($rows = mysqli_fetch_assoc($searchResults)) {
							$inner_search_array = array();
							$inner_search_array['pp_id'] = $rows['pp_id'];
							$inner_search_array['paper_name'] = $rows['paper_name'];
							$inner_search_array['paper_year'] = $rows['paper_year'];
							$inner_search_array['paper_url'] = "past_paper/".$rows['paper_url'];

							array_push($search_array, $inner_search_array);
						}

						$response['error'] = false;
						$response['search_results'] = $search_array;
					}
				}else {
					$response['error'] = true;
					$response['search_results'] = "Sorry no paper found related to ".$searchQuery;
				}

				break;
			default:
				# code...
				break;
		}
	}else{
		//if it is not api call 
		//pushing appropriate values to response array 
		$response['error'] = true; 
		$response['message'] = 'Invalid API Call';
	}
	//displaying the response in json structure 
    echo json_encode($response, JSON_PRETTY_PRINT);
	
	

?>
