<?php
session_start();
include('dashboard/includes/db_conn.php');
include('dashboard/includes/functions.php');
$info = $show = '';
    $show = show_company($conn);


?>
    <!doctype html>
    <html lang="en">

    <head>

        <!-- Basic Page Needs
================================================== -->
        <title>Firmen in Lübeck</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
================================================== -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/colors/blue.css">

    </head>

    <body>

        <!-- Wrapper -->
        <div id="wrapper">

            <!-- Header Container
================================================== -->
        <?php include('header.php') ?>
            <!-- Header Container / End -->



            <!-- Content -->

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Registrierte Firmen mit Jobs in Lübeck und Umgebung</h2>

				<!-- Breadcrumbs
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#">Find Work</a></li>
						<li>Browse Companies</li>
					</ul>
				</nav>
        -->

			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">
		
		<div class="col-xl-12">
			<div class="companies-list">
				<?php echo $show; ?>
			</div>
		</div>
	</div>
</div>


<!-- Spacer -->
<div class="margin-top-70"></div>
<!-- Spacer / End-->

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
