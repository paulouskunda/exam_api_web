<?php

/**
* @param $db_link: Connection link to the database
* @param $pupil_id: pupil identification code
* @param $password
* @return error/false/query: return boolean or string of the error 
*/

function pupilLogin($db_link, $pupil_id, $password){
	$find_pupil = "SELECT pa.pupil_name, pa.pupil_intake, pa.pupil_id, pa.pupil_password, ss.school_name as pupil_school  FROM pupils_accounts as pa, schools as ss WHERE pupil_id = '$pupil_id' AND pupil_password = '$password' AND pa.pupil_school  = ss.school_center";
	$pupil_query = mysqli_query($db_link, $find_pupil);

	if (mysqli_num_rows($pupil_query) === 1) {
		# code...
		return $pupil_query;
	} else{
		echo mysqli_error($db_link);
		return false;
	}
}

// results
function checkForResults($db_link, $intake, $pupil_id){
	$check_for_results = "SELECT * FROM results WHERE intake = '$intake' AND pupil_id_num = '$pupil_id'";
	$results_query = mysqli_query($db_link, $check_for_results);

	if (mysqli_num_rows($results_query) > 0) 
		return $results_query;
	else
		return false;
}

function checkGCEResults($db_link, $gce_intake){

}

// pastpapers
function pickMostViewed($db_link){
	$select_top_ten_papers = "SELECT * FROM past_papers ORDER BY paper_count DESC  LIMIT 10";
	$check_paper_count = mysqli_query($db_link, $select_top_ten_papers);
	if(mysqli_num_rows($check_paper_count) > 0){
		return $check_paper_count;
	}else
		return false;
}

function searchForPastPaper($db_link, $search_query){
	$search_paper = "SELECT * FROM past_papers WHERE paper_name LIKE '%$search_query%' OR paper_year LIKE '%$search_query%'";
	$check_paper_query = mysqli_query($db_link, $search_paper);
	if(mysqli_num_rows($check_paper_query) > 0){
		return $check_paper_query;
	}else
		echo mysqli_error($db_link);
		return false;
}

function updateViewedPaperCounter($db_link, $paper_id){
	$updatePaperCount = "UPDATE past_papers SET count ";
}



// Admin based query

function uploadPapersToServer($db_link, $paper_name, $paper_year, $file, $temp_file){
	if (checkIfPaperIspresent($db_link, $paper_name, $paper_year)) {
		return "PAU";
	}else{
		// save the pdf to 
		echo $file;
		$targetDir = "../past_paper/";
		$target = $targetDir.basename($file);

		// rename 
		$getCurrentName = explode(".", $file);
		echo $getCurrentName[1]."<br>";
		$setNewName = str_replace(
			str_split('*?" "\'.<>|'), "-", $paper_name)."-".$paper_year.'.'.end($getCurrentName);
		echo $target."<br>";
		echo $setNewName."<br>";
		$target = $targetDir.$setNewName;


		if (move_uploaded_file($temp_file, $target)) {
			# code...
			// insert into the database
			$insert_query = "INSERT INTO past_papers (paper_name, paper_year, paper_url, paper_count) VALUES ('$paper_name', '$paper_year', '$setNewName', 0)";
			if (mysqli_query($db_link, $insert_query)) {
				return true;
			}else{
				return false;
			}
		} else {
			
			return false;
    	}
	}
}

function checkIfPaperIspresent($db_link, $paper_name, $paper_year){
	$checkMeOut = "SELECT * FROM past_papers WHERE paper_name = '$paper_name' AND paper_year = '$paper_year'";
	$checkQuery = mysqli_query($db_link, $checkMeOut);
	if (mysqli_num_rows($checkQuery) > 0) 
		return true;
	else
		return false;

}


function uploadResultsToServer($db_link, $pupils_results_array){
	$addResults = "INSERT INTO results(pupil_id_num, subject_name, subject_grade, intake, school_center) VALUES ('".$pupils_results_array['pupil_id_num']."',
		'".$pupils_results_array['subject_name']."', '".$pupils_results_array['subject_grade']."', '".$pupils_results_array['intake']."', '".$pupils_results_array['school_center']."') ";
	if (mysqli_query($db_link, $addResults)) {
		# code...
		return true;
	}else{
		return mysqli_error($db_link);
	}
}




function addPupilToServer($db_link, $pupil_array_details){
	$pupil_id = "";
	if(checkTheID($db_link, $pupil_array_details['pupil_id'])){
		return "already_created";
	}else{
		$insert = "INSERT INTO pupils_accounts (pupil_id, pupil_name, pupil_school, pupil_intake, pupil_password) VALUES ('".$pupil_array_details['pupil_id']."', '".$pupil_array_details['pupil_name']."', '".$pupil_array_details['pupil_school']."', '".$pupil_array_details['pupil_intake']."', '".$pupil_array_details['pupil_password']."') ";

		if (mysqli_query($db_link, $insert)) {
			# code...
			return "true";
		}else{
			return mysqli_error($db_link);
		}
	}
}


function checkTheID($db_link, $pupil_id){
	$select_pupil = "SELECT * FROM pupils_accounts WHERE pupil_id = '$pupil_id'";
	if (mysqli_num_rows(mysqli_query($db_link, $select_pupil)) > 0) {
		# code...
		return true;
	}else {
		return false;
	}
}

function addSchool($db_link, $school_name, $school_centre_id, $school_location){

	if (checkSchoolCentre($db_link, $school_centre_id)) {
		return "already_created";
	}else{
		$schoolInform = "INSERT INTO schools (school_center, school_name, school_location) VALUES ('$school_centre_id', '$school_name', '$school_location')";
		if (mysqli_query($db_link, $schoolInform)) {
			# code...
			return true;
		}else{
			return mysqli_error($db_link);
		}
	}
}

function checkSchoolCentre($db_link, $school_centre_id){
	$select_centre = "SELECT * FROM schools WHERE school_center = '$school_centre_id'";

	if (mysqli_num_rows(mysqli_query($db_link, $select_centre)) > 0)
		return true;
	else
		return false;
}




function schoolCentre($db_link){
	$select_centre = "SELECT * FROM schools";

	if (mysqli_num_rows(mysqli_query($db_link, $select_centre)) > 0)

		return mysqli_query($db_link, $select_centre);
	else
		return mysqli_error($db_link);
}

function resultsReverse($db_link){
	$resultsReverse = "SELECT DISTINCT(intake) FROM results ORDER BY r_id DESC";

	if (mysqli_num_rows(mysqli_query($db_link, $resultsReverse)) > 0)

		return mysqli_query($db_link, $resultsReverse);
	else
		return mysqli_error($db_link);
}
function resultsForward($db_link){
	$resultsForward = "SELECT DISTINCT(intake) FROM results ORDER BY r_id ASC";

	if (mysqli_num_rows(mysqli_query($db_link, $resultsForward)) > 0)

		return mysqli_query($db_link, $resultsForward);
	else
		echo mysqli_error($db_link);
		return mysqli_error($db_link);
}

?>
