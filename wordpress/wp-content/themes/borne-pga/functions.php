<?php
/**
 * Thème Borne PGA — Paierie Générale d'Antananarivo.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BORNE_PGA_VERSION', '1.0.0' );

require get_template_directory() . '/inc/types.php';
require get_template_directory() . '/inc/affichage.php';
require get_template_directory() . '/inc/import.php';

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 160,
				'width'       => 160,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
		add_theme_support(
			'custom-header',
			array(
				'default-image' => get_template_directory_uri() . '/assets/images/entete.jpg',
				'width'         => 1600,
				'height'        => 656,
				'flex-height'   => true,
				'flex-width'    => true,
				'header-text'   => false,
			)
		);
		register_default_headers(
			array(
				'pga' => array(
					'url'           => '%s/assets/images/entete.jpg',
					'thumbnail_url' => '%s/assets/images/entete.jpg',
					'description'   => 'Paierie Générale d\'Antananarivo',
				),
			)
		);
		register_nav_menus( array( 'principal' => 'Menu principal (en-tête)' ) );
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'borne-pga', get_stylesheet_uri(), array(), BORNE_PGA_VERSION );
		wp_enqueue_script( 'borne-pga-onglets', get_template_directory_uri() . '/assets/js/onglets.js', array(), BORNE_PGA_VERSION, true );
	}
);

/* -------------------------------------------------------------------------
 * Personnaliser : titre de l'en-tête et texte du pied de page.
 * ---------------------------------------------------------------------- */

function borne_pga_titre_par_defaut() {
	return 'Bienvenue à la PAIERIE GÉNÉRALE D\'ANTANANARIVO';
}

function borne_pga_pied_par_defaut() {
	return '© {annee} Direction de la Comptabilité Publique. Tous droits réservés.';
}

add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->add_section(
			'borne_pga',
			array(
				'title'    => 'Borne PGA',
				'priority' => 30,
			)
		);

		$wp_customize->add_setting(
			'borne_titre',
			array(
				'default'           => borne_pga_titre_par_defaut(),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'borne_titre',
			array(
				'label'   => 'Titre de l\'en-tête',
				'section' => 'borne_pga',
			)
		);

		$wp_customize->add_setting(
			'borne_pied',
			array(
				'default'           => borne_pga_pied_par_defaut(),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'borne_pied',
			array(
				'label'       => 'Texte du pied de page',
				'description' => '{annee} est remplacé par l\'année en cours.',
				'section'     => 'borne_pga',
			)
		);
	}
);

/** Menu par défaut tant qu'aucun menu n'est choisi dans Apparence > Menus. */
function borne_pga_menu_par_defaut() {
	echo '<ul class="menu"><li><a href="' . esc_url( home_url( '/' ) ) . '">Prestations du PGA</a></li>';
	$page = get_page_by_path( 'dossiers-mandatement' );
	if ( $page && 'publish' === $page->post_status ) {
		echo '<li><a href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( get_the_title( $page ) ) . '</a></li>';
	}
	echo '</ul>';
}
