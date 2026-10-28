<?php
/**
 * Gabarit général : pages, articles, prestation seule, rubrique seule.
 */

get_header();

if ( is_tax( 'rubrique' ) ) :
	$rubrique = get_queried_object();
	?>
	<div class="page-entete"><h1><?php echo esc_html( $rubrique->name ); ?></h1></div>
	<?php
	borne_pga_afficher_rubrique( $rubrique );

elseif ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<div class="page-entete"><h1><?php the_title(); ?></h1></div>
		<?php
		if ( 'prestation' === get_post_type() ) {
			borne_pga_afficher_prestation( get_post() );
			echo '<p><a class="bouton-retour" href="' . esc_url( home_url( '/' ) ) . '">Retour aux prestations</a></p>';
		} else {
			echo '<div class="page-texte">';
			the_content();
			echo '</div>';
		}
	endwhile;

else :
	?>
	<div class="page-entete"><h1>Page introuvable</h1></div>
	<p><a class="bouton-retour" href="<?php echo esc_url( home_url( '/' ) ); ?>">Retour aux prestations</a></p>
	<?php
endif;

get_footer();
