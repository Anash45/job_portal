<?php
session_start();
include('includes/db_conn.php');
include('includes/functions.php');
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    
}else{
    header('location:ad_login.php');
    die();
}
$info = $show = '';
if (isset($_REQUEST['dlt_id'])) {
    $info = dlt_company($conn);
}
if (isset($_REQUEST['duplicate'])) {
    $info = duplicate_company($conn);
}
if (isset($_REQUEST['add_company'])) {
    $info = add_company($conn);
    // print_r($_FILES);
}
$show = ad_show_company($conn);
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
                            <a class="nav-link" aria-current="page" href="index.php">
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
                            <a class="nav-link active" aria-current="page" href="add_company.php">
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
                <div class="row mx-0">
                    <div class="form-box">
                        <h2 class="my-3">Add New Firma</h2>
                        <?php echo $info; ?>
                            <form class="row g-3 needs-validation job-form" novalidate method="post" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <label for="input5" class="form-label">Firma</label>
                                    <input type="text" class="form-control" name="company"  id="input5">
                                </div>
                                <div class="col-12">
                                    <label for="input7" class="form-label">Beschreibung</label>
                                    <textarea name="desc"  id="input7" rows="5" class="form-control editor2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="input6" class="form-label">Firmensitz</label>
                                    <input type="text" class="form-control" name="place"  id="input6">
                                </div>
                                <div class="col-md-6">
                                    <label for="input8" class="form-label">Ansprechpartner </label>
                                    <input type="text" class="form-control" name="name"  id="input8">
                                </div>
                                <div class="col-md-6">
                                    <label for="input9" class="form-label">Karriereseite </label>
                                    <input type="url" class="form-control" name="apply"  id="input9">
                                </div>
                                <div class="col-md-6">
                                    <label for="input10" class="form-label">Telefon </label>
                                    <input type="tel" class="form-control" name="phone"  id="input10">
                                </div>
                                <div class="col-md-6">
                                    <label for="input11" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email"  id="input11">
                                </div>
                                <div class="col-md-6">
                                    <label for="input12" class="form-label">Webseite</label>
                                    <input type="url" class="form-control" name="website"  id="input12">
                                </div>
                                <div class="col-md-6">
                                    <label for="input14" class="form-label">Instagram</label>
                                    <input type="url" class="form-control" name="instagram"  id="input14">
                                </div>
                                <div class="col-md-6">
                                    <label for="input15" class="form-label">Facebook</label>
                                    <input type="url" class="form-control" name="facebook"  id="input15">
                                </div>
                                <div class="col-md-6">
                                    <label for="input16" class="form-label">Youtube</label>
                                    <input type="url" class="form-control" name="youtube"  id="input16">
                                </div>
                                <div class="col-md-6">
                                    <label for="input13" class="form-label">Logo</label>
                                    <input type="file" class="form-control" name="c_logo"  id="input13">
                                </div>
                           
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="add_company">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="dashboard.js"></script>
    
    <script src="ckeditor5/build/ckeditor.js"></script>
    <script>
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
    </script>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form action="company.php" method="get">                
                    <input type="hidden" name="dlt_id" value="0" id="c_id">
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