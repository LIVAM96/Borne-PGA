<?php
/**
 * Type de contenu « Prestation » et classement « Rubrique ».
 *
 * - Une rubrique = un onglet principal (PENSIONS, SOLDES...).
 * - Une prestation = un sous-onglet de cette rubrique.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'borne_pga_enregistrer_types' );

function borne_pga_enregistrer_types() {
	register_post_type(
		'prestation',
		array(
			'labels'        => array(
				'name'               => 'Prestations',
				'singular_name'      => 'Prestation',
				'menu_name'          => 'Prestations',
				'add_new'            => 'Ajouter',
				'add_new_item'       => 'Ajouter une prestation',
				'edit_item'          => 'Modifier la prestation',
				'new_item'           => 'Nouvelle prestation',
				'view_item'          => 'Voir la prestation',
				'search_items'       => 'Rechercher une prestation',
				'not_found'          => 'Aucune prestation',
				'not_found_in_trash' => 'Aucune prestation dans la corbeille',
				'all_items'          => 'Toutes les prestations',
				'featured_image'     => 'Photo du guichet',
				'set_featured_image' => 'Choisir la photo du guichet',
				'remove_featured_image' => 'Retirer la photo du guichet',
			),
			'public'        => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-id-alt',
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
			'has_archive'   => false,
			'rewrite'       => array( 'slug' => 'prestation' ),
		)
	);

	register_taxonomy(
		'rubrique',
		'prestation',
		array(
			'labels'            => array(
				'name'          => 'Rubriques',
				'singular_name' => 'Rubrique',
				'menu_name'     => 'Rubriques',
				'all_items'     => 'Toutes les rubriques',
				'edit_item'     => 'Modifier la rubrique',
				'add_new_item'  => 'Ajouter une rubrique',
				'new_item_name' => 'Nom de la nouvelle rubrique',
				'search_items'  => 'Rechercher une rubrique',
				'not_found'     => 'Aucune rubrique',
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'rubrique' ),
		)
	);
}

/* -------------------------------------------------------------------------
 * Réglages d'une rubrique : ordre, couleurs, affichage sur l'accueil.
 * ---------------------------------------------------------------------- */

function borne_pga_reglages_rubrique( $term_id ) {
	$ordre   = get_term_meta( $term_id, 'borne_ordre', true );
	$accueil = get_term_meta( $term_id, 'borne_accueil', true );

	return array(
		'ordre'   => in_array( $ordre, array( '', false ), true ) ? 99 : (int) $ordre,
		'accueil' => in_array( $accueil, array( '', false ), true ) ? true : (bool) $accueil,
		'debut'   => get_term_meta( $term_id, 'borne_couleur_debut', true ) ?: '#f0f0f0',
		'fin'     => get_term_meta( $term_id, 'borne_couleur_fin', true ) ?: '#e0e0e0',
		'texte'   => get_term_meta( $term_id, 'borne_couleur_texte', true ) ?: '#333333',
	);
}

function borne_pga_champs_rubrique( $reglages, $mode ) {
	$lignes = array(
		array(
			'Ordre d\'affichage',
			'<input type="number" name="borne_ordre" id="borne_ordre" value="' . esc_attr( $reglages['ordre'] ) . '" min="0" style="width:6em">',
			'Les onglets sont rangés du plus petit au plus grand.',
		),
		array(
			'Afficher sur l\'accueil',
			'<label><input type="checkbox" name="borne_accueil" value="1" ' . checked( $reglages['accueil'], true, false ) . '> Onglet de la page d\'accueil de la borne</label>',
			'Décochez pour une rubrique affichée sur une page à part (ex. « Dossiers requis pour mandatement »), avec le code <code>[borne_onglets rubrique="slug-de-la-rubrique"]</code> dans la page.',
		),
		array(
			'Couleurs de l\'onglet',
			'<label>Début du dégradé <input type="color" name="borne_couleur_debut" value="' . esc_attr( $reglages['debut'] ) . '" style="width:4em"></label> '
			. '<label>Fin du dégradé <input type="color" name="borne_couleur_fin" value="' . esc_attr( $reglages['fin'] ) . '" style="width:4em"></label> '
			. '<label>Texte <input type="color" name="borne_couleur_texte" value="' . esc_attr( $reglages['texte'] ) . '" style="width:4em"></label>',
			'',
		),
	);

	foreach ( $lignes as $ligne ) {
		list( $titre, $champ, $aide ) = $ligne;
		$aide = $aide ? '<p class="description">' . $aide . '</p>' : '';
		if ( 'ajout' === $mode ) {
			echo '<div class="form-field"><label>' . esc_html( $titre ) . '</label>' . $champ . $aide . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput
		} else {
			echo '<tr class="form-field"><th scope="row">' . esc_html( $titre ) . '</th><td>' . $champ . $aide . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
	}
}

add_action(
	'rubrique_add_form_fields',
	function () {
		borne_pga_champs_rubrique( borne_pga_reglages_rubrique( 0 ), 'ajout' );
	}
);

add_action(
	'rubrique_edit_form_fields',
	function ( $term ) {
		borne_pga_champs_rubrique( borne_pga_reglages_rubrique( $term->term_id ), 'modification' );
	}
);

add_action( 'created_rubrique', 'borne_pga_enregistrer_reglages_rubrique' );
add_action( 'edited_rubrique', 'borne_pga_enregistrer_reglages_rubrique' );

function borne_pga_enregistrer_reglages_rubrique( $term_id ) {
	// Le formulaire de WordPress a déjà vérifié le jeton de sécurité.
	if ( ! current_user_can( 'manage_categories' ) || ! isset( $_POST['borne_couleur_debut'] ) ) {
		return;
	}

	update_term_meta( $term_id, 'borne_ordre', absint( $_POST['borne_ordre'] ?? 99 ) );
	update_term_meta( $term_id, 'borne_accueil', empty( $_POST['borne_accueil'] ) ? 0 : 1 );

	foreach ( array( 'debut', 'fin', 'texte' ) as $cle ) {
		$couleur = sanitize_hex_color( wp_unslash( $_POST[ 'borne_couleur_' . $cle ] ?? '' ) );
		if ( $couleur ) {
			update_term_meta( $term_id, 'borne_couleur_' . $cle, $couleur );
		}
	}
}

/* Colonne « Ordre » dans la liste des rubriques. */
add_filter(
	'manage_edit-rubrique_columns',
	function ( $colonnes ) {
		$colonnes['borne_ordre'] = 'Ordre';
		return $colonnes;
	}
);

add_filter(
	'manage_rubrique_custom_column',
	function ( $contenu, $colonne, $term_id ) {
		if ( 'borne_ordre' === $colonne ) {
			$reglages = borne_pga_reglages_rubrique( $term_id );
			$contenu  = (int) $reglages['ordre'] . ( $reglages['accueil'] ? '' : ' (page à part)' );
		}
		return $contenu;
	},
	10,
	3
);

/* Colonne « Ordre » dans la liste des prestations, triée par rubrique puis ordre. */
add_filter(
	'manage_prestation_posts_columns',
	function ( $colonnes ) {
		$colonnes['borne_ordre'] = 'Ordre';
		return $colonnes;
	}
);

add_action(
	'manage_prestation_posts_custom_column',
	function ( $colonne, $post_id ) {
		if ( 'borne_ordre' === $colonne ) {
			echo (int) get_post_field( 'menu_order', $post_id );
		}
	},
	10,
	2
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'prestation' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', 'menu_order title' );
			$query->set( 'order', 'ASC' );
		}
	}
);
