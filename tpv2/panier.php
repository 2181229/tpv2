<?php
$page = "panier";
include('commun/entete.com.php');
?>
<main class="page-panier">
    <article class="amorce">
		<h1><?= $_["titrePage"]; ?></h1>
	</article>
	<article class="principal">
		<div class="articleAchatUn">
            <div class="premiereRangee">
                <img 
                    src="images/produits/teeshirts/ts0004.webp" 
                    alt="monstre douillet"
                >
                <p class="nomArticle">Monstre douillet</p>
            </div>
            <div class="deuxiemeRangee">
                <div class="carreVert"><!-- mettre le carré vert dedans --></div>
                <p>M</p>
                <p class="nombre">5</p>
                <p>29.50 $</p>
            </div>
        </div>
        <div class="articleAchatDeux">
            <div class="premiereRangee">
                <img 
                    src="images/produits/teeshirts/ts0005.webp" 
                    alt="Bleu comme une orange"
                >
                <p class="nomArticle">Bleu comme une orange</p>
            </div>
            <div class="deuxiemeRangee">
                <div class="carreRose"><!-- mettre le carré rose dedans --></div>
                <p>XS</p>
                <p class="nombre">2</p>
                <p>19.99 $</p>
            </div>
        </div>
	</article>
    <article class="infosAchat">
        <p><?= $_["nombreArticles"]; ?></p>
        <p><?= $_["total"]; ?></p>
        <button><?= $_["confirmation"]; ?></button>
    </article>
</main>
<?php include('commun/pied2page.com.php'); ?>