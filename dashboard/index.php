<?php
session_start();
include('includes/db_conn.php');
include('includes/functions.php');
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    
}else{
    header('location:ad_login.php');
    die();
}
$info = $show = $show1 = $show2 = '';
if (isset($_REQUEST['dlt_id'])) {
    $info = dlt_job($conn);
}
if (isset($_REQUEST['feature'])) {
    $info = change_status($conn);
}
if (isset($_REQUEST['duplicate'])) {
    $info = duplicate_job($conn);
}
if (isset($_REQUEST['status'])) {
    $info = change_status1($conn);
}
if (isset($_REQUEST['add_job'])) {
    $info = add_job($conn);
    // print_r($_REQUEST);
}
$show = ad_show_jobs($conn);
$show1 = show_company_list($conn);
$show2 = '<script>start_dt();</script>';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Dashboard - Jobs Board</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">



    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom styles for this page -->
    <link href="datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <link href="ckeditor.css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="../index.php">Jobs Board</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
       <div class="w-100"></div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="../logout.php">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">
                                <i class="fa fa-search"></i> Jobs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="add_job.php">
                                <i class="fa fa-search"></i> Add Jobs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="company.php">
                                <i class="fa fa-user"></i> Company
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="add_company.php">
                                <i class="fa fa-user"></i> Add Company
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="category.php">
                                <i class="fa fa-bar-chart"></i> Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="add_category.php">
                                <i class="fa fa-bar-chart"></i> Add Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="arbeitszeit.php">
                                <i class="fa fa-clock-o"></i> Arbeitszeit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="add_arbeitszeit.php">
                                <i class="fa fa-clock-o"></i> Add Arbeitszeit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="arbeitsort.php">
                                <i class="fa fa-building"></i> Arbeitsort
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="add_arbeitsort.php">
                                <i class="fa fa-building"></i> Add Arbeitsort
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="my-3">Jobs Posted</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-responsive" id="dataTable" width="100%" cellspacing="0">
                        <thead> 
                            <tr>
                                <th scope="col">Job ID</th>
                                <th scope="col">Firma</th>
                                <th scope="col">Job Titel</th>
                                <th scope="col">Status</th>
                                <th scope="col">Featuring</th>
                                <th scope="col">Duplicate</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th scope="col">Job ID</th>
                                <th scope="col">Firma</th>
                                <th scope="col">Job Titel</th>
                                <th scope="col">Status</th>
                                <th scope="col">Featuring</th>
                                <th scope="col">Duplicate</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php echo $show; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Page level plugins -->
    <script src="datatables/jquery.dataTables.min.js"></script>
    <script src="datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        
    // Call the dataTables jQuery plugin
    function start_dt(){
        $('#dataTable').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    }
    </script>
    <?php echo $show2; ?>
    <script src="dashboard.js"></script>
    
    <script src="ckeditor5/build/ckeditor.js"></script>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form action="index.php" method="get">                
                    <input type="hidden" name="dlt_id" value="0" id="j_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>