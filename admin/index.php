<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
	
	require_once '../connection.php';
	require_once '../function.php';
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
    exit;
}
	if (isset($_POST['submit'])) {
		# code...
		$file = $_FILES['paper_file']['name'];
		$temp = $_FILES['paper_file']['tmp_name'];
		$paper_entry = mysqli_real_escape_string($db_link, $_POST['paper_name']);
		$paper_intake = mysqli_real_escape_string($db_link, $_POST['paper_year']);

		// replace with api call

		// function call
		$fucCall = uploadPapersToServer($db_link, $paper_entry, $paper_intake, $file, $temp);
		echo $fucCall;
		if ($fucCall === "PAU") {
			echo "<script> swal ( 'warning',
                'Sorry, Paper Already Exisits',
                'warning'
              )
              </script>";
		}else if ($fucCall === true){
			echo "<script> swal ( 'Success',
                'Paper Successfully Added',
                'success'
              )
              </script>";
		}
		// else {
		// 	echo "An error was encounted";
		// }

	} else if (isset($_POST['submit_pupil'])) {
		# code...
		$pupil_name = mysqli_real_escape_string($db_link, $_POST['pupil_name']);
		$pupil_school = mysqli_real_escape_string($db_link, $_POST['pupil_school']);
		$pupil_intake = mysqli_real_escape_string($db_link, $_POST['pupil_intake']);
		$pupil_password = mysqli_real_escape_string($db_link, $_POST['pupil_password']);
		$pupil_id = mysqli_real_escape_string($db_link, $_POST['pupil_id']);

		$pupil_array = array('pupil_id' => $pupil_id,
							 'pupil_name' => $pupil_name, 
							 'pupil_school' => $pupil_school,
							 'pupil_intake' => $pupil_intake,
							 'pupil_password' => $pupil_password
							);
		$acc = addPupilToServer($db_link, $pupil_array);
		echo $acc;
		if ($acc === 'already_created') {
			# code...
			echo "<script> swal ( 'warning',
                'Pupil Alread Exisits',
                'warning'
              )
              </script>";
			echo "Created - Here";

		}else if ($acc === 'true') {
			# code...
			 echo "<script> swal ( 'Success',
                'Pupil Successfully Added',
                'success'
              )
              </script>";
		}

	}else if (isset($_POST['submit_school'])) {
		# code...
		$school_name = mysqli_real_escape_string($db_link, $_POST['school_name']);
		$school_id = mysqli_real_escape_string($db_link, $_POST['school_id']);
		$school_location = mysqli_real_escape_string($db_link, $_POST['school_location']);

		$backFrom = addSchool($db_link, $school_name, $school_id, $school_location);

		if ($backFrom === 'already_created') {
			echo "Already in the system";
			echo "<script> swal ( 'Warning',
                'School Already in the System',
                'warning'
              )
              </script>";
		}else if ($backFrom === true) {
			echo "<script> swal ( 'Success',
                'School Successfully Added',
                'success'
              )
              </script>";
		}
		// else{
		// 	echo "Error";
		// }
	}else if (isset($_POST['submit_csv'])) {
		# code...
		$file = $_FILES['excel_or_csv']['name'];
		$intake = $_POST['intake_year'];
		$temp_file = $_FILES['excel_or_csv']['tmp_name'];

		$target = "./move/".basename($file);
		// move the csv file to the server
		if(move_uploaded_file($temp_file, $target)){
			// echo "string";
		}else{
			echo mysqli_error($db_link);
		}

		$row = 1;
		// open the file with fopen function of PHP
		if (($handle = fopen("move/{$file}", "r")) !== FALSE) {
		    while (($data = fgetcsv($handle)) !== FALSE) {
		        $num = count($data);
		        // check if we current on the header and skip it
		      	if ($row != 1) {
		      		
		      		// create an array
		        	$results_array = array('pupil_id_num' => $data[1],
		        							'subject_name' => $data[2],
		        							'subject_grade' => $data[3],
		        							'intake' => $data[4],
		        							'school_center' => $data[5]);
		        	$uploadResultsToServer = uploadResultsToServer($db_link, $results_array);

		        	// if we encounter an error, break the code
		        	// create a roll back from this point and delete anything
		        	// trans
		        	// if (!$uploadResultsToServer) {
		        	// 	echo "Something went bad";
		        	// 	break;
		        	// }
		      	}
		 
		       $row++;

		    }
		    fclose($handle);
		    echo "<script> swal ( 'Success',
                'Reading file and Uploaded Successful',
                'success'
              )
              </script>";
		}

		
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PUPILRMS DASHBOARD - ADMIN</title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <!-- DataTables Select JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>

</head>
<body>
    <?php require_once './header.php'; ?>

    
    <div class="container">
    	
    	<br/>
    	
	 	<button class="btn btn-secondary w-100 p-3"  type="button" data-toggle="collapse" data-target="#addSchool" aria-expanded="true" aria-controls="collapseExample">
			Add School
		 </button>
		
    	<div class="row">
    		
	 		 <div class="collapse col-md-12" id="addSchool">
	 		 	<div class="col-md-12">
	    			<h2>Add School</h2>
	    			<hr/>
					<form method="POST">
						<label>School Name</label>
						<input required class="form-control" type="text" name="school_name" placeholder="School Name" /><br>
						<label>School Center Number</label>
						<input required class="form-control" type="text" name="school_id" placeholder="School Center Number" /><br>
						<label>School Location</label>
						<input required class="form-control" type="text" name="school_location" placeholder="School Location" /><br>
						<input type="submit" name="submit_school" class="btn btn-primary" value="Add School" />
					</form>
	    		</div>
	 		 </div>
	 	</div>
	 	<br>
    	 <button class="btn btn-dark w-100 p-3"  type="button" data-toggle="collapse" data-target="#addPupil" aria-expanded="true" aria-controls="collapseExample">
			Add Pupil
		 </button>
		 <div class="row">
		 <div class="collapse col-md-12" id="addPupil">
		 	<div class="col-md-12">
    			<h2>Add Pupil</h2>
    			<hr/>

					<form method="POST" class="form-group">
						<label>Pupil Full Name</label>
						<input required type="text" class="form-control" name="pupil_name" placeholder="Name"><br />
						<label>Pick School</label>
						<select name="pupil_school" class="form-control">
							<?php
								$getSchools = schoolCentre($db_link);

								while ($rows = mysqli_fetch_assoc($getSchools)) {
									echo "<option value='".$rows['school_center']."'>".$rows['school_name']."</option>";
								}
							?>
						</select><br>
						<label>Pupil Intake</label>
						<input required class="form-control" type="text" name="pupil_intake" placeholder="intake"><br />
						<label>Set Password</label>
						<input required class="form-control" type="password" name="pupil_password"placeholder="password" ><br />
						<label>Pupil ID Number</label>
						<input required class="form-control" type="number" name="pupil_id" placeholder="id"><br />
						<input class="btn btn-primary"  type="submit" name="submit_pupil" value="Add Pupil" />
					</form>
    		</div>
		 </div>

    		
    	</div>
    	<br>
    	 <button class="btn btn-success w-100 p-3"  type="button" data-toggle="collapse" data-target="#addResults" aria-expanded="true" aria-controls="collapseExample">
			Upload Results
		 </button>
    	<div class="row">
    		<div class="collapse col-md-12" id="addResults">
	    		<div class="col-md-12">
	    			<h2>Upload Results</h2>
	    			<hr/>
					<form enctype="multipart/form-data" method="POST">
						<label>Results Intake</label>
						<input required class="form-control" type="text" name="intake_year" placeholder="intake_year" /><br>
						<label>Upload Results <sup>CSV Format</sup></label>
						<input required class="form-control" type="file" name="excel_or_csv" accept=".csv" /><br>
						<input type="submit" class="btn btn-grey" value="Upload CSV" name="submit_csv">

					</form>
	    		</div>
    		</div>
    	</div>
    	  <br>
    	 <button class="btn btn-primary w-100 p-3"  type="button" data-toggle="collapse" data-target="#addPaper" aria-expanded="true" aria-controls="collapseExample">
			Upload Past Paper
		 </button>
		 <div class="row">
		 	<div class="collapse col-md-12" id="addPaper">
			 	<div class="col-md-12">
	    			<h2>Add Past Paper</h2>
	    			<hr/>

					<form enctype="multipart/form-data" method="POST">
						<label>Paper Name</label>
						<input required class="form-control" type="text" name="paper_name" /><br>
						<label>Paper Year</label>
						<input required class="form-control" type="text" name="paper_year" /><br>
						<label>Upload the Paper <sup>PDF - Format</sup></label>
						<input class="form-control" type="file" accept=".pdf" name="paper_file"><br>
						<input required type="submit" class="btn btn-grey" value="Upload Past Paper" name="submit">
					</form>	
	    		</div>
		 	</div>
    	
    	</div>
    	<br>
    </div>









</body>
</html>