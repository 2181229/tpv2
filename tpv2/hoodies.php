<?php
$page = "hoodies";
include('commun/entete.com.php');

// pour commencer, lire et convertir le fichier JSON
$triJson = file_get_contents("data/tri-hoodies.json");
$triHoodies = json_decode($triJson, true);

//////Chercher les options dans la langue affichée
// Initialiser des tableaux vides pour nos données
$optionsTitre = [];
$optionsChoix = [];

// Chercher les titres d'options et les chois d'options dans la langue affichée
// Intialiser des tableaux vides pour nos données
foreach ($triHoodies as $codeOptions => $detailOptions) {
	// Langue par défaut dans le catalogue
	$langueCat = "fr";
	if(isset($detailOptions["nom"][$codeLangue])) {
		$langueCat = $codeLangue;
	}
	$optionsTitre[$codeOptions] = $detailOptions["nom"][$langueCat];
	$optionsChoix = array_merge($optionsChoix, $detailOptions);
}

/*
	Intégration des produits "hoodies"
*/
// A) Lire et convertir le fichier JSON
$tsJson = file_get_contents("data/hoodies.json");
$hoodies = json_decode($tsJson, true);

// B) Chercher les catégories, et les produits, dans la langue affichée
// Intialiser des tableaux vides pour nos données
$categories = []; 
$produits = [];

if(isset($_GET["filtre"])) {
	$valeurFiltre = $_GET["filtre"];// donner la valeur choisie si une option a été sélectionnée
} else {
	$valeurFiltre = "tous";// donner la valeur "tous" si rien n'a été sélectionné parmi les choix donnés
}


// Remplir les tableaux avec les données du fichier JSON
foreach ($hoodies as $codeCat => $detailCat) {
	// Langue par défaut dans le catalogue
	$langueCat = "fr";
	if(isset($detailCat["nom"][$codeLangue])) {
		$langueCat = $codeLangue;
	}
	$categories[$codeCat] = $detailCat["nom"][$langueCat];
	
	if ( $valeurFiltre == "nature" || $valeurFiltre == "sport" || $valeurFiltre == "inusite" || $valeurFiltre == "animaux" ) {
		if ($valeurFiltre == $codeCat) {
			$produits = array_merge($produits, $detailCat["produits"]);
		}
	} else {
		$produits = array_merge($produits, $detailCat["produits"]);
	}
}
// On mélange le tableau des produits
shuffle($produits);

?>
<main class="page-produits page-hoodies">
	<article class="amorce">
		<h1><?= $_["titrePage"]; ?></h1>
		<section class="controle">
			<div class="filtre">
				<form action="hoodies.php" method="get" id="formulaire">
					<label for="filtre"><?= $textes["catalogue"]["filtreEtiquette"]; ?></label>
					<select name="filtre" id="filtre">
						<option value="tous"><?= $textes["catalogue"]["filtreTous"]; ?></option>
						<?php 
							foreach ($categories as $codeCat => $nomCat) :
								if ($valeurFiltre == $codeCat) {
									$selected = "selected";
								} else {
									$selected = "";
								}
							?>
							<option <?= $selected; ?> value="<?= $codeCat; ?>"><?= $nomCat; ?></option>
						<?php endforeach; ?>
					</select>
					<script>
						let formulaireHoodies = document.getElementById("formulaireHoodies");
						let choix = document.getElementById("filtre");
						choix.addEventListener("change", (event) => {
							formulaire.submit();
						});
					</script>
					<noscript><button type="submit">submit</button></noscript>
				</form>
			</div>
			<div class="tri">
				<label for="tri">Trier par : </label>
				<select name="tri" id="tri">
					<?php foreach ($optionsTitre as $optionsTitre => $optionsChoix) : ?>
						<option value="<?= $optionsTitre; ?>"><?= $optionsChoix; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</section>
	</article>
	<article class="principal">
		<?php foreach($produits as $prod) : ?>
			<div class="produit">
				<span class="image">
					<img 
						src="images/produits/teeshirts/<?= $prod["id"]; ?>.webp" 
						alt="<?= $prod["nom"][$langueCat]; ?>"
					>
					<figcaption class="ventes"><?= number_format($prod["ventes"])?></figcaption>
				</span>
				<span class="nom"><?= $prod["nom"][$langueCat]; ?></span>
				<span class="prix"><?= number_format($prod["prix"], 2); ?> $</span>
			</div>
		<?php endforeach; ?>
	</article>
</main>
<?php include('commun/pied2page.com.php'); ?>