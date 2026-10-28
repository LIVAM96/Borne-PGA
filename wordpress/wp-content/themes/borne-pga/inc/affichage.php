<?php
/**
 * Affichage des onglets (rubriques) et sous-onglets (prestations).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rubriques de premier niveau, rangées selon leur ordre.
 *
 * @param bool|null $accueil true : seulement celles de l'accueil ; null : toutes.
 * @return WP_Term[]
 */
function borne_pga_rubriques( $accueil = true ) {
	$rubriques = get_terms(
		array(
			'taxonomy'   => 'rubrique',
			'parent'     => 0,
			'hide_empty' => true,
		)
	);
	if ( is_wp_error( $rubriques ) ) {
		return array();
	}

	if ( null !== $accueil ) {
		$rubriques = array_filter(
			$rubriques,
			function ( $rubrique ) use ( $accueil ) {
				return borne_pga_reglages_rubrique( $rubrique->term_id )['accueil'] === $accueil;
			}
		);
	}

	usort(
		$rubriques,
		function ( $a, $b ) {
			return borne_pga_reglages_rubrique( $a->term_id )['ordre'] <=> borne_pga_reglages_rubrique( $b->term_id )['ordre'];
		}
	);

	return $rubriques;
}

/**
 * Prestations publiées d'une rubrique, dans l'ordre choisi (attribut « Ordre »).
 *
 * @return WP_Post[]
 */
function borne_pga_prestations( WP_Term $rubrique ) {
	return get_posts(
		array(
			'post_type'      => 'prestation',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery
				array(
					'taxonomy'         => 'rubrique',
					'terms'            => $rubrique->term_id,
					'include_children' => false,
				),
			),
		)
	);
}

/**
 * Style CSS (couleurs) d'une rubrique.
 *
 * @param string $suffixe '' pour l'onglet lui-même, '-rubrique' pour une série entière.
 */
function borne_pga_style_couleurs( WP_Term $rubrique, $suffixe = '' ) {
	$r = borne_pga_reglages_rubrique( $rubrique->term_id );
	return sprintf( '--onglet-debut%4$s:%1$s;--onglet-fin%4$s:%2$s;--onglet-texte%4$s:%3$s', $r['debut'], $r['fin'], $r['texte'], $suffixe );
}

/**
 * Affiche une série d'onglets.
 *
 * @param array  $onglets Liste de [ 'id' => ..., 'titre' => ..., 'style' => ..., 'contenu' => callable ].
 * @param string $niveau  'principal', 'secondaire' ou 'rubrique'.
 * @param string $style_serie Couleurs communes à toute la série (niveau 'rubrique').
 */
function borne_pga_afficher_serie( array $onglets, $niveau, $style_serie = '' ) {
	if ( ! $onglets ) {
		return;
	}
	?>
	<div class="onglets onglets--<?php echo esc_attr( $niveau ); ?>" data-onglets<?php echo $style_serie ? ' style="' . esc_attr( $style_serie ) . '"' : ''; ?>>
		<div class="onglets__barre" role="tablist">
			<?php foreach ( $onglets as $i => $onglet ) : ?>
				<button type="button" role="tab" class="onglet"
					id="onglet-<?php echo esc_attr( $onglet['id'] ); ?>"
					aria-controls="<?php echo esc_attr( $onglet['id'] ); ?>"
					aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
					tabindex="<?php echo 0 === $i ? '0' : '-1'; ?>"
					<?php echo $onglet['style'] ? 'style="' . esc_attr( $onglet['style'] ) . '"' : ''; ?>>
					<?php echo esc_html( $onglet['titre'] ); ?>
				</button>
			<?php endforeach; ?>
		</div>
		<?php foreach ( $onglets as $i => $onglet ) : ?>
			<div role="tabpanel" class="panneau" tabindex="0"
				id="<?php echo esc_attr( $onglet['id'] ); ?>"
				aria-labelledby="onglet-<?php echo esc_attr( $onglet['id'] ); ?>"
				<?php echo 0 === $i ? '' : 'hidden'; ?>>
				<?php call_user_func( $onglet['contenu'] ); ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/** Une prestation : texte à gauche, photo du guichet à droite. */
function borne_pga_afficher_prestation( WP_Post $prestation, $avec_titre = false ) {
	$a_photo = has_post_thumbnail( $prestation );
	?>
	<article class="prestation<?php echo $a_photo ? ' prestation--photo' : ''; ?>">
		<div class="prestation__texte">
			<?php if ( $avec_titre ) : ?>
				<h3 class="prestation__titre"><?php echo esc_html( get_the_title( $prestation ) ); ?></h3>
			<?php endif; ?>
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput -- contenu filtré par WordPress.
			echo apply_filters( 'the_content', $prestation->post_content );
			?>
			<?php if ( current_user_can( 'edit_post', $prestation->ID ) ) : ?>
				<p class="prestation__modifier"><a href="<?php echo esc_url( get_edit_post_link( $prestation ) ); ?>">Modifier cette prestation</a></p>
			<?php endif; ?>
		</div>
		<?php if ( $a_photo ) : ?>
			<figure class="prestation__photo">
				<?php
				echo get_the_post_thumbnail(
					$prestation,
					'large',
					array(
						'data-zoom' => esc_url( get_the_post_thumbnail_url( $prestation, 'full' ) ),
						'loading'   => 'lazy',
					)
				);
				?>
			</figure>
		<?php endif; ?>
	</article>
	<?php
}

/** Contenu d'un onglet de rubrique : la prestation seule, ou des sous-onglets. */
function borne_pga_afficher_contenu_rubrique( WP_Term $rubrique ) {
	$prestations = borne_pga_prestations( $rubrique );

	if ( 1 === count( $prestations ) ) {
		borne_pga_afficher_prestation( $prestations[0], true );
		return;
	}

	borne_pga_afficher_serie( borne_pga_onglets_prestations( $prestations, '' ), 'secondaire' );
}

/** Transforme des prestations en onglets. */
function borne_pga_onglets_prestations( array $prestations, $style ) {
	$onglets = array();
	foreach ( $prestations as $prestation ) {
		$onglets[] = array(
			'id'      => 'prestation-' . $prestation->ID,
			'titre'   => get_the_title( $prestation ),
			'style'   => $style,
			'contenu' => function () use ( $prestation ) {
				borne_pga_afficher_prestation( $prestation );
			},
		);
	}
	return $onglets;
}

/** Onglets de toutes les rubriques de l'accueil (page d'accueil de la borne). */
function borne_pga_afficher_accueil() {
	$onglets = array();
	foreach ( borne_pga_rubriques( true ) as $rubrique ) {
		$onglets[] = array(
			'id'      => 'rubrique-' . $rubrique->slug,
			'titre'   => $rubrique->name,
			'style'   => borne_pga_style_couleurs( $rubrique ),
			'contenu' => function () use ( $rubrique ) {
				borne_pga_afficher_contenu_rubrique( $rubrique );
			},
		);
	}

	if ( ! $onglets ) {
		echo '<p class="borne-vide">Aucune prestation publiée pour le moment. Ajoutez-en depuis l\'administration : <em>Prestations &gt; Ajouter</em>.</p>';
		return;
	}

	borne_pga_afficher_serie( $onglets, 'principal' );
}

/** Une seule rubrique, ses prestations en onglets principaux (ex. dossiers de mandatement). */
function borne_pga_afficher_rubrique( WP_Term $rubrique ) {
	$prestations = borne_pga_prestations( $rubrique );
	borne_pga_afficher_serie( borne_pga_onglets_prestations( $prestations, '' ), 'principal onglets--rubrique', borne_pga_style_couleurs( $rubrique, '-rubrique' ) );
}

/**
 * Code court à placer dans une page :
 * [borne_onglets]                                   → les onglets de l'accueil
 * [borne_onglets rubrique="dossiers-mandatement"]   → une rubrique en onglets
 */
add_shortcode(
	'borne_onglets',
	function ( $atts ) {
		$atts = shortcode_atts( array( 'rubrique' => '' ), $atts, 'borne_onglets' );

		ob_start();
		if ( $atts['rubrique'] ) {
			$rubrique = get_term_by( 'slug', sanitize_title( $atts['rubrique'] ), 'rubrique' );
			if ( $rubrique ) {
				borne_pga_afficher_rubrique( $rubrique );
			} elseif ( current_user_can( 'edit_pages' ) ) {
				echo '<p class="borne-vide">Rubrique « ' . esc_html( $atts['rubrique'] ) . ' » introuvable.</p>';
			}
		} else {
			borne_pga_afficher_accueil();
		}
		return ob_get_clean();
	}
);
