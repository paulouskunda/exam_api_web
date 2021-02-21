<?php
require_once '../connection.php';
	require_once '../function.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <meta charset="utf-8">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <!-- DataTables Select JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <style type="text/css">
    	#chart {
		  max-width: 100%;
		}
    </style>

</head>
<body>
	    <?php require_once './header.php'; ?>
	    <div class="container">
	    		    		<br>
	    	<div class="row">
				    	<div class="col-md-12">
				    			    		<h4 style="text-align: center">Filter Graph</h4>

					    	<form method="POST">
						    	<select class="form-control" name="startYear">
						    		<?php
						    			$getForward = resultsForward($db_link);


										while ($rows = mysqli_fetch_assoc($getForward)) {
											echo "<option value='".$rows['intake']."'>".$rows['intake']."</option>";
										}
									?>
						    	</select><br>
						    	<select class="form-control" name="endYear">
						    		<?php
										$getReverse = resultsReverse($db_link);

										while ($rows = mysqli_fetch_assoc($getReverse)) {
											echo "<option value='".$rows['intake']."'>".$rows['intake']."</option>";
										}
									?>
						    	</select><br>

					    	<input class="btn btn-success" type="submit" name="submit_filter" value="Filter">
					    </form>
				    	</div>
				    <?php
				    	$yearOneValue = 2020;
				    	$yearTwoValue = 2019;
				    	if (isset($_POST['submit_filter'])) {
				    		# code...
				    		$startYear = mysqli_real_escape_string($db_link, $_POST['startYear']);
				    		$endYear = mysqli_real_escape_string($db_link, $_POST['endYear']);

				    		if ($startYear === $endYear) {
				    				echo "<script> swal ( 'Warning',
						                'Please ensure that years are different',
						                'warning'
						              )
						              </script>";
				    		}else {
				    			$yearOneValue = $startYear;
				    			$yearTwoValue = $endYear;
				    		}
				    	}
				    	$yearOne = mysqli_query($db_link, "SELECT SUM(subject_grade) AS GRADE, intake FROM `results` WHERE intake = '$yearOneValue'");
				    	$yearTwo = mysqli_query($db_link,"SELECT SUM(subject_grade) AS GRADE, intake FROM `results` WHERE intake = '$yearTwoValue'");

				    	$totalOne = "";
				    	$totalTwo = "";

				    	while ($rows = mysqli_fetch_assoc($yearOne)) {
				    		$totalOne = $rows['GRADE'];
				    	}

				    	while($rows = mysqli_fetch_assoc($yearTwo)) {
				    		$totalTwo = $rows['GRADE'];
				    	}

				    ?>
				    <hr/><br>
				    <div class="col-md-8">
				    	<h3 style="text-align: center;">Perfomance Graph </h3><br/>

				    	<br><br>
				    	<div  id="chart"></div>
					</div>
		</div>
	    </div>
	    
	<script type="text/javascript">
		var options = {
		  chart: {
		    type: 'bar'
		  },
		  series: [{
		    name: 'Total Points',
		    data: [<?php echo $totalOne;?>, <?php echo $totalTwo;?>]
		  }],
		  xaxis: {
		    categories: [<?php echo $yearOneValue; ?>, <?php echo $yearTwoValue; ?>]
		  }
}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
	</script>
</body>
</html>