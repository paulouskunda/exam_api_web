            
            <!-- Some js imports -->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/bsadmin.js"></script>

            <!-- some cdn imports  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    
             <!--Some css imports  -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="./assets/css/bsadmin.css">

<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle text-light mr-3"><i class="fa fa-bars"></i></a>

    <a class="navbar-brand" href="#"><i class="fa fa-code-branch"></i> ExamAPI </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                    <i class="fa fa-user"></i> Admin
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="logout.php"> Log out <i class="fa fa-fw fa-sign-out-alt"></i></a>
                    <!-- <a class="dropdown-item" href="#">Another</a> -->
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="d-flex">
    <nav class="sidebar bg-dark">
        <ul class="list-unstyled">
            <li><a href="index.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
            <!-- <li><a href="#"><i class="fa fa-fw fa-link"></i> Sidebar Link</a></li> -->
<!--              <li>
                <a href="#submenu2" data-toggle="collapse"><i class="fa fa-fw fa-angle-right"></i> System Functionality</a>
                <ul id="submenu2" class="list-unstyled collapse">
                    <li><a href="">Billing</a></li>
                    
                </ul>
            </li> -->
             
             <li>
                <a href="#submenu3" data-toggle="collapse"><i class="fa fa-fw fa-angle-right"></i> Analysis</a>
                <ul id="submenu3" class="list-unstyled collapse">
                    <li><a href="performance.php">Performance</a></li>
               
                </ul>
            </li>              
            
              <li>

                <?php
                    //counts home boy
                // $rt = mysqli_query($db_link,"SELECT * FROM tblcomplaints WHERE  status is null");
                // $num1 = mysqli_num_rows($rt);
                // $status="in Process";                   
                // $q2 = mysqli_query($db_link,"SELECT * FROM tblcomplaints WHERE status='$status'");
                // $num2 = mysqli_num_rows($q2);
                // $status="Closed";                   
                // $q3 = mysqli_query($db_link,"SELECT * FROM tblcomplaints WHERE status='$status'");
                // $num3 = mysqli_num_rows($q3);
                ?>


             
            </li>            
        </ul>
    </nav>