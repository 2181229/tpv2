<?php
/*
	Déterminer les langues disponibles.
*/
// 1) Créer un tableau des langues disponibles
$languesDispos = [];
// 2) Parcourir le dossier 'i18n' qui contient les fichiers de textes
$contenuDossierI18n = scandir("i18n");
foreach ($contenuDossierI18n as $nomFichier) {
	// Conserver les fichiers de textes uniquement
	if($nomFichier != '.' && $nomFichier!='..') {
		// On enlève ".json" du nom du fichier
		$codeEtNom = substr($nomFichier, 0, -5);
		// On scinde le restant au tiret (-)
		$codeEtNomTableau = explode("-", $codeEtNom);
		// On cherche le code de langue et le nom de langue
		//  dans le tableau résultant.
		$code = $codeEtNomTableau[0];
		$nom = $codeEtNomTableau[1];
		// On stocke le nom de la langue dans le tableau $languesDispos
		// dans l'étiquette correspondant au code de cette langue.
		$languesDispos[$code] = $nom;
	}
}

/*
	Intégration du fichier de textes JSON
*/
// Étape 1 : Langue par défaut
$codeLangue = "fr";

// Étape 2 : L'utilisateur a déjà choisi une langue dans le passé : dans ce cas
// ce choix a été sauvegardé dans un témoin HTTP, donc il suffit de le lire
if(isset($_COOKIE["langueChoisie"]) 
			&& isset($languesDispos[$_COOKIE["langueChoisie"]])) {
	// Alors, on change la variable langue pour qu'elle ait la valeur du cookie
	$codeLangue = $_COOKIE["langueChoisie"];
}
// Étape 3 : L'utilisateur a changé de langue explicitement en cliquant
// un des boutons de langue
if(isset($_GET["lan"]) && isset($languesDispos[$_GET["lan"]])) {
	// La langue est maintenant la valeur du paramètre 'lan'
	$codeLangue =  $_GET["lan"];
	// ***ET*** on conserve ce choix dans un témoin HTTP (HTTP Cookie)
	setcookie("langueChoisie", $codeLangue, time()+3600*24*90);
}

$textesJson = file_get_contents("i18n/" . $codeLangue . "-" 
								. $languesDispos[$codeLangue] . ".json");
$textes = json_decode($textesJson, true);

/* 
	On définit quelques variables pratiques à utiliser pour intégrer les textes 
	des différentes parties.
*/
// Les textes spécifique à une page 
$_ = $textes[$page];
// Les textes de l'entête commune à toutes les pages
$_ent = $textes["entete"];
 // Les textes du pied de page commun à toutes les pages
$_pp = $textes["pp"];
?>
<!DOCTYPE html>
<html lang="<?= $codeLangue; ?>">

<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;900&family=Noto+Serif:ital,wght@0,400;0,900;1,400&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>teeTIM // <?= $_['metaTitre']; ?></title>
	<meta name="description" content="<?= $_['metaDesc']; ?>">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="icon" type="image/png" href="images/favicon.png" />
</head>

<body>
	<div class="conteneur">
		<header>
			<nav class="barre-haut">
				<!-- Répéter une balise A pour chaque langue disponible -->
				<?php foreach($languesDispos as $code => $nom) : ?>
					<a 
						title="<?= mb_strtoupper($nom); ?>"
						href="?lan=<?= $code; ?>" 
						class="<?php if($codeLangue==$code) {echo "actif";} ?>"
					><?= $code; ?></a>
				<?php endforeach; ?>
			</nav>
			<nav class="barre-logo">
				<label for="cc-btn-responsive" class="material-icons burger">menu</label>
				<a class="logo" href="index.php"><img src="images/logo.png" alt="<?= $_ent["altLogo"]; ?>"></a>
				<a class="material-icons panier" href="panier.php">shopping_cart</a>
				<input class="recherche" type="search" name="motscles" placeholder="<?= $_ent["placeholderRecherche"]; ?>">
			</nav>
			<input type="checkbox" id="cc-btn-responsive">
			<nav class="principale">
				<label for="cc-btn-responsive" class="menu-controle material-icons">close</label>
				<a href="teeshirts.php" class="<?= $page == 'teeshirts' ? 'actif' : ''; ?>"><?= $_ent["menuTeeshirts"]; ?></a>
				<a href="casquettes.php" class="<?= $page == 'casquettes' ? 'actif' : ''; ?>"><?= $_ent["menuCasquettes"]; ?></a>
				<a href="hoodies.php" class="<?= $page == 'hoodies' ? 'actif' : ''; ?>"><?= $_ent["menuHoodies"]; ?></a>
				<span class="separateur"></span>
				<a href="aide.php" class="<?= $page == 'aide' ? 'actif' : ''; ?>"><?= $_ent["menuAide"]; ?></a>
				<a href="apropos.php" class="<?= $page == 'apropos' ? 'actif' : ''; ?>"><?= $_ent["menuAPropos"]; ?></a>
			</nav>
		</header>