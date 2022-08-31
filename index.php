<?php
session_start();
include('dashboard/includes/db_conn.php');
include('dashboard/includes/functions.php');
$info = $show = '';
$show = array('','');
    $show = show_jobs($conn);

?>
<!doctype html>
<html lang="de">
<head>

<!-- Basic Page Needs
================================================== -->
<title>Jobs in Lübeck - Stellenanzeigen</title>
<meta charset="utf-8">
<meta name="description" content="Das Job Portal mit Stellenanzeigen aus Lübeck und Umgebung.">
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
<div class="clearfix"></div>
<!-- Header Container / End -->



<!-- Intro Banner
================================================== -->
<!-- add class "disable-gradient" to enable consistent background overlay -->
<div class="intro-banner" data-background-image="images/home-background.jpg">
	<div class="container">

		<!-- Intro Headline -->
		<div class="row">
			<div class="col-md-12">
				<div class="banner-headline">
					<h3>
						<strong>Das Job Portal aus Lübeck.</strong>
						<br>
						<span>Für eure <strong class="color">Stellenangebote in Lübeck</strong> und Umgebung.</span>
					</h3>
				</div>
			</div>
		</div>

		<!-- Search Bar -->
		<div class="row">
			<div class="col-md-12">
				<div class="intro-banner-search-form margin-top-95">
					<form action="suche.php" method="get" class="intro-banner-search-form">
						<!-- Search Field -->
						<div class="intro-search-field">
							<label for ="intro-keywords" class="field-title ripple-effect">Welches Job Stichwort? Oder welcher Ort?</label>

							<input id="intro-keywords" name="q" type="text" placeholder="Stichwort eingeben und Suchen klicken">
						</div>

						<!-- Button -->
						<div class="intro-search-button">
							<button class="button ripple-effect" type="submit">Suchen</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Stats -->


	</div>
</div>


<!-- Content
================================================== -->
<!-- Category Boxes -->
<div class="section margin-top-65">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">

				<div class="section-headline centered margin-bottom-15">
					<h3>Stellenanzeige schalten - Jetzt das Startangebot nutzen!</h3>
				</div>

				<p  style="text-align: center;">Für die ersten 50 Stellenanzeigen haben wir ein super Angebot!</p>

        <center><br>
        <a href="inserat.php" class="button ripple-effect" >Mehr Bewerber erhalten!</a><br><br>
        <p><b>Aktuell wird sehr stark nach:</b> Büro, Verkauf, Minijob, Fahrer, Erzieher, Pflege, Reinigung, Verkäufer und Lager <b>gesucht.</b></p>
      </center>

			</div>
		</div>
	</div>
</div>
<!-- Category Boxes / End -->


<!-- Features Jobs -->
<div class="section gray margin-top-45 padding-top-65 padding-bottom-75">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">

				<!-- Section Headline -->
				<div class="section-headline margin-top-0 margin-bottom-35">
					<h3>Premium Jobs aus Lübeck und Umgebung</h3>
					<a href="suche.php" class="headline-link">Mehr Jobs suchen</a>
				</div>

				<!-- Jobs Container -->
				<div class="listings-container compact-list-layout margin-top-35">

                <?php echo $show[1]; ?>

				</div>

				<!-- Section Headline -->
				<div class="section-headline margin-top-35 margin-bottom-35">
					<h3>Neue Jobs in Lübeck</h3>
					<a href="suche.php" class="headline-link">Mehr Jobs suchen</a>
				</div>

				<!-- Jobs Container -->
				<div class="listings-container compact-list-layout margin-top-35">

                <?php echo $show[0]; ?>

				</div>
				<!-- Jobs Container / End -->

			</div>
		</div>
	</div>
</div>
<!-- Featured Jobs / End -->

<div class="section margin-top-65">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">

				<div class="section-headline centered margin-bottom-15">
					<h3>Stellenanzeige schalten - Jetzt das Startangebot nutzen!</h3>
				</div>

				<p  style="text-align: center;">Für die ersten 50 Stellenanzeigen haben wir ein super Angebot!</p>

        <center>
        <a href="inserat.php" class="button ripple-effect" >Mehr Bewerber erhalten!</a>
      </center>

			</div>
		</div>
	</div>
</div>
<br><br>
<!-- Category Boxes / End -->

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
	    setTimeout(function(){
	        $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
	    }, 300);
	}

</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initAutocomplete"></script>

</body>
</html>
