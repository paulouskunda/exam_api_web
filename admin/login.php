<?php
// Include config file
require_once "../connection.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
         // Prepare a select statement
        $sql = "SELECT * FROM admin WHERE username = '$username'";
        
        
        $results = mysqli_query($db_link, $sql);

            if (mysqli_num_rows($results) > 0) {
                # code...

                while ($rows = mysqli_fetch_assoc($results)) {
                    # code...

                    if ($password == $rows['password']) {
                        # code...
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $username;   
                                                 
                        
                        // Redirect user to welcome page
                        header("location: index.php");
                    }else {
                        $username_err = "Wrong Password or Username";
                    }
                }
      }
    }  
}
?>
 
<!DOCTYPE html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">
<head>
    <title>PupilRMS</title>

    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="assets/css/index.css" th:href="@{assets/css/index.css}">

</head>
<body>
    <div class="modal-dialog text-center">
                    <h3 style="color: white">PUPIL RMS</h3>

        <div class="col-sm-8 main-section">
            <div class="modal-content">
                <div class="col-12 user-img">
                    <img src="img/user.png" th:src="@{/img/user.png}"/>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                    <!-- Change the error messages -->
                    <span class="help-block" style="color: white;"><?php echo $password_err; ?></span>
                    <span class="help-block" style="color: white;"><?php echo $username_err; ?></span>

                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" id="user-group" >
                    <input type="text" placeholder="Username" name="username" class="form-control" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" id="contrasena-group">
                       
                        <input placeholder="Password" type="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Login </button>
                </form>
               
            </div>
        </div>
    </div>
</body>
</html>