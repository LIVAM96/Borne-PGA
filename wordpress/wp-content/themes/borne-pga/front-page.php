<?php
/**
 * Accueil de la borne : une rubrique par onglet, une prestation par sous-onglet.
 */

get_header();

// Texte facultatif placé au-dessus des onglets, si une page d'accueil statique est choisie.
if ( 'page' === get_option( 'show_on_front' ) ) {
	while ( have_posts() ) {
		the_post();
		if ( get_the_content() ) {
			echo '<div class="page-texte">';
			the_content();
			echo '</div>';
		}
	}
}
?>
<h1 class="screen-reader-text">Prestations du PGA</h1>
<?php
borne_pga_afficher_accueil();

get_footer();
