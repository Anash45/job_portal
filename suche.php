<?php
session_start();
include('dashboard/includes/db_conn.php');
include('dashboard/includes/functions.php');
$info = $show = $show1 = $show7 = $show8 = $show9 = $show10 = $show11 = $show12 = $q = '';
$show = $show1 = array('', '', '');

if (isset($_REQUEST['q']) && (!isset($_REQUEST['cat_id']) && !isset($_REQUEST['arb_id']) && !isset($_REQUEST['sort_id']))) {
    $show = search_jobs($conn);
    // print("Search");
} elseif (isset($_REQUEST['q']) || isset($_REQUEST['cat_id']) || isset($_REQUEST['arb_id']) || isset($_REQUEST['sort_id'])) {
    $show1 = filter_search($conn);
    // print("Filter");
} else {
    $show = search_jobs($conn);
}


$show10 = show_category_list2($conn);
$show11 = show_arbeitszeit_list2($conn);
$show12 = show_arbeitsort_list2($conn);
$q = '';
if (isset($_REQUEST['q'])) {
    $q = $_REQUEST['q'];
}
?>
<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
================================================== -->
    <title>Jobsuche in Lübeck - HL-live.de</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
================================================== -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/colors/blue.css">

</head>

<body>

    <!-- Wrapper -->
    <div id="wrapper" class="section gray">

        <!-- Header Container
================================================== -->
        <?php include('header.php') ?>
        <!-- Header Container / End -->


        <div class="margin-top-90"></div>
        <!-- Content -->
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="sidebar-container">

                        <form action="suche.php" method="get">

                            <!-- Keywords -->
                            <div class="sidebar-widget">
                                <h3>Job Suchbegriff</h3>
                                <div class="keywords-container">
                                    <div class="keyword-input-container">
                                        <input type="text" class="keyword-input" name="q" value="<?php echo $q; ?>" placeholder="Job Titel" />
                                    </div>
                                    <div class="keywords-list">
                                        <!-- keywords go here -->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="sidebar-widget">
                                <button class="button ripple-effect button-sliding-icon" style="width: 90%;" type="submit">Suche <i class="icon-feather-arrow-right"></i></button>
                                <!-- <button class="button ripple-effect gray button-sliding-icon margin-right-10" type="reset">Reset <i class="icon-feather-arrow-right"></i></button> -->
                            </div>
                            <!-- Arbeitsort -->
                            <div class="sidebar-widget">
                                <h3>Arbeitsort</h3>
                                <select class="selectpicker" multiple data-selected-text-format="count" data-size="7" title="Alle Orte" name="sort_id[]">
                                    <?php echo $show12; ?>
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="sidebar-widget">
                                <h3>Branche</h3>
                                <select class="selectpicker" multiple data-selected-text-format="count" data-size="7" title="Alle Branchen" name="cat_id[]">
                                    <?php echo $show10; ?>
                                </select>
                            </div>

                            <!-- Arbeitszeit -->
                            <div class="sidebar-widget">
                                <h3>Arbeitszeit</h3>

                                <div class="switches-list">
                                    <?php echo $show11; ?>
                                </div>

                            </div>



                        </form>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 content-left-offset">

                    <h3 class="page-title">Job Suchergebnis <?php echo $q; ?></h3>



                    <div class="listings-container compact-list-layout margin-top-15">

                        <?php echo $show[1] ?>
                        <?php echo $show[0] ?>
                        <?php echo $show1[1] ?>
                        <?php echo $show1[0] ?>
                    </div>


                    <!-- Pagination -->
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Pagination -->
                            <div class="pagination-container margin-top-60 margin-bottom-60">
                                <nav class="pagination">
                                    <ul>
                                        <!-- <li class="pagination-arrow"><a href="#"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li> -->
                                        <?php echo $show1[2];
                                        echo $show[2]; ?>
                                        <!-- <li class="pagination-arrow"><a href="#"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li> -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination / End -->

                </div>
            </div>
        </div>

        <!-- Content / End -->

        <!-- Footer
================================================== -->
        <?php include('footer.php') ?>
        <!-- Footer / End -->

    </div>
    <!-- Wrapper / End -->


    <!-- Scripts
================================================== -->
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery-migrate-3.3.2.min.js"></script>
    <script src="js/mmenu.min.js"></script>
    <script src="js/tippy.all.min.js"></script>
    <script src="js/simplebar.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/snackbar.js"></script>
    <script src="js/clipboard.min.js"></script>
    <script src="js/counterup.min.js"></script>
    <script src="js/magnific-popup.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/custom.js"></script>

    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
    <script>
        // Snackbar for user status switcher
        $('#snackbar-user-status label').click(function() {
            Snackbar.show({
                text: 'Your status has been changed!',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#383838'
            });
        });
    </script>


    <!-- Google Autocomplete -->
    <script>
        function initAutocomplete() {
            var options = {
                types: ['(cities)'],
                // componentRestrictions: {country: "us"}
            };

            var input = document.getElementById('autocomplete-input');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
        }

        // Autocomplete adjustment for homepage
        if ($('.intro-banner-search-form')[0]) {
            setTimeout(function() {
                $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
            }, 300);
        }
    </script>

    <!-- Google API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initAutocomplete"></script>

</body>

</html>