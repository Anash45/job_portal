<?php
session_start();
include('dashboard/includes/db_conn.php');
include('dashboard/includes/functions.php');

$info = $show = $show1 = $show2 = $show3 = '';
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
$show1 = show_company_list($conn);
$show2 = show_category_list($conn);
$show3 = show_arbeitszeit_list($conn);
$show4 = show_arbeitsort_list($conn);
?>
<?php 

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
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
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Custom styles for this template -->
    <link href="dashboard/dashboard.css" rel="stylesheet">
    <link href="dashboard/ckeditor.css" rel="stylesheet">
</head>

<body>

    <!-- <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">Jobs Board</a>
                <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
       <div class="w-100"></div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="logout.php">Sign out</a>
            </div>
        </div>
    </header> -->

    <div class="container-fluid">
        <div class="row">
            <!-- <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">
                                <i class="fa fa-search"></i> Jobs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="add_job.php">
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
            </nav> -->

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mx-auto">
                <div class="row mx-0">
                    <div class="form-box">
                        <h2 class="my-3">Add New Job</h2>
                        <?php echo $info; ?>
                            <form class="row g-3 needs-validation job-form" novalidate method="post" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Job Titel</label>
                                    <input type="text" class="form-control" name="title"  id="input1">
                                </div>
                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Category</label>
                                    <div class="card check-box p-2">
                                        <?php echo $show2; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Arbeitszeit</label>
                                    <div class="card check-box p-2">
                                        <?php echo $show3; ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Arbeitsort</label>
                                    <div class="card check-box p-2">
                                        <?php echo $show4; ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="input4" class="form-label">Beschreibung</label>
                                    <textarea name="job_desc"  id="input4" rows="5" class="form-control editor"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="input6" class="form-label">Bewerbungsformular </label>
                                    <input type="url" class="form-control" name="app_link"  id="input6">
                                </div>
                                <div class="col-md-6">
                                    <label for="input10" class="form-label">Job Created </label>
                                    <input type="date" class="form-control" name="date"  id="input10" value="<?php echo $today; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="input7" class="form-label">Bewerbungsfrist </label>
                                    <input type="date" class="form-control" name="end_date"  id="input7">
                                </div>
                                <div class="col-12">
                                    <label for="input5" class="form-label">Bewerbung </label>
                                    <textarea name="application"  id="input5" rows="5" class="form-control editor2"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="input91" class="form-label">Select Firma</label>
                                    <select name="c_id" id="input91" class="form-control">
                                        <option value="0" selected disabled>Select an existing company</option>
                                        <?php echo $show1; ?>
                                    </select>
                                </div>
                               
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="add_job">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="dashboard/dashboard.js"></script>
    
    <script src="dashboard/ckeditor5/build/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('.editor'), {

                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'alignment',
                        '|',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                language: 'en',
                licenseKey: '',



            })
            .then(editor => {
                window.editor = editor;




            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                console.warn('Build id: owipsa40u3ib-arqte6vddhph');
                console.error(error);
            });
            
        ClassicEditor
            .create(document.querySelector('.editor2'), {

                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'alignment',
                        '|',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                language: 'en',
                licenseKey: '',



            })
            .then(editor2 => {
                window.editor2 = editor2;




            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                console.warn('Build id: owipsa40u3ib-arqte6vddhph');
                console.error(error);
            });
            $("#input10").datepicker("setDate", new Date());
    </script>
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