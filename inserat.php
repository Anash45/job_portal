<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>Inserat</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/blue.css">

</head>
<body class="gray">

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include('header.php') ?>
<!-- Header Container / End -->

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">

				<h2>Stellenanzeige inserieren</h2>
				<br>
				Sie möchten eine Stellenanzeige schalten? Das geht ganz einfach! <br>
	Schreiben Sie uns bitte eine E-Mail an jobs@hl-live.de mit ihren Kontaktdaten, wir rufen Sie dann zurück!
	<br>Ihr Ansprechpartner ist Herr Rabe.
	</p>

			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">

		<div class="col-xl-12">

			<!-- Pricing Plans Container -->
			<div class="pricing-plans-container">

				<!-- Plan -->
				<div class="pricing-plan">
					<h3>Job Anzeige</h3>
					<p class="margin-top-10">Standard Job Anzeige</p>
					<div class="pricing-plan-label billed-monthly-label"><strong>299€</strong></div>
					<div class="pricing-plan-features">
						<strong>Vorteile</strong>
						<ul>
							<li>1 Stellenanzeige</li>
							<li>1 Firmenseite</li>
							<li>30 Tage Laufzeit</li>
						</ul>
					</div>
					<a href="mailto:jobs@hl-live.de?subject=Job%20Anzeige" class="button full-width margin-top-20">E-Mail Anfrage</a>
				</div>

				<!-- Plan -->
				<div class="pricing-plan recommended">
					<div class="recommended-badge">Start Angebot</div>
					<h3>First 50 Angebot</h3>
					<p class="margin-top-10">Für die ersten 50 Stellenanzeigen.</p>
					<div class="pricing-plan-label billed-monthly-label"><strong>249€</strong></div>

					<div class="pricing-plan-features">
						<strong>Vorteile</strong>
						<ul>
							<li>1 Stellenanzeige</li>
							<li>1 Firmenseite</li>
							<li>60 Tage Laufzeit</li>
						</ul>
					</div>
					<a href="mailto:jobs@hl-live.de?subject=Start%20Angebot" class="button full-width margin-top-20">E-Mail Anfrage</a>
				</div>

				<!-- Plan -->
				<div class="pricing-plan">
					<h3>Premium Job Anzeige</h3>
					<p class="margin-top-10">Längere Laufzeit und ganz oben mit dabei!</p>
					<div class="pricing-plan-label billed-monthly-label"><strong>499€</strong></div>
					<div class="pricing-plan-features">
						<strong>Vorteile</strong>
						<ul>
							<li>1 Stellenanzeige</li>
							<li>1 Firmenseite</li>
							<li>45 Tage Laufzeit</li>
							<li>Optisch hervorgehoben</li>
							<li>Oben in Suchergebnissen</li>
						</ul>
					</div>
					<a href="mailto:jobs@hl-live.de?subject=Premium%20Anzeige" class="button full-width margin-top-20">E-Mail Anfrage</a>
				</div>
			</div><br>
Alle Preise Nettopreis zzgl. 19% Mehrwertsteuer.
Mehrere Stellenanzeigen, größere oder Kombipakete auf Anfrage.
		</div>

	</div>
</div>


<div class="margin-top-70"></div>

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

</body>
</html>
