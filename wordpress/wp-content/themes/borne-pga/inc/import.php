<?php
/**
 * Import du contenu initial à l'activation du thème.
 *
 * L'import ne se fait qu'une fois. Il ne crée que ce qui manque : une rubrique,
 * une prestation ou une page déjà présente (même slug) n'est jamais écrasée.
 * Pour le relancer : Apparence > Borne PGA > « Importer le contenu initial ».
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_switch_theme', 'borne_pga_import_auto' );

function borne_pga_import_auto() {
	if ( ! get_option( 'borne_pga_importe' ) ) {
		borne_pga_importer();
	}
}

/**
 * Crée rubriques, prestations, images, page « Dossiers » et menu.
 *
 * @return array Nombre d'éléments créés par type.
 */
function borne_pga_importer() {
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Le type et la taxonomie doivent exister, même si l'import tourne avant 'init'.
	if ( ! taxonomy_exists( 'rubrique' ) ) {
		borne_pga_enregistrer_types();
	}

	$donnees = require get_template_directory() . '/inc/contenu-initial.php';
	$bilan   = array(
		'rubriques'   => 0,
		'prestations' => 0,
		'pages'       => 0,
	);

	foreach ( $donnees as $r ) {
		$terme = get_term_by( 'slug', $r['slug'], 'rubrique' );
		if ( ! $terme ) {
			$cree = wp_insert_term( $r['nom'], 'rubrique', array( 'slug' => $r['slug'] ) );
			if ( is_wp_error( $cree ) ) {
				continue;
			}
			$terme_id = $cree['term_id'];
			update_term_meta( $terme_id, 'borne_ordre', $r['ordre'] );
			update_term_meta( $terme_id, 'borne_accueil', $r['accueil'] ? 1 : 0 );
			update_term_meta( $terme_id, 'borne_couleur_debut', $r['couleurs'][0] );
			update_term_meta( $terme_id, 'borne_couleur_fin', $r['couleurs'][1] );
			update_term_meta( $terme_id, 'borne_couleur_texte', $r['couleurs'][2] );
			++$bilan['rubriques'];
		} else {
			$terme_id = $terme->term_id;
		}

		foreach ( $r['prestations'] as $ordre => $p ) {
			$slug = sanitize_title( $r['slug'] . '-' . $p['titre'] );
			if ( get_page_by_path( $slug, OBJECT, 'prestation' ) ) {
				continue;
			}

			$contenu = preg_replace_callback(
				'/\{image:([^}]+)\}/',
				function ( $m ) {
					$id = borne_pga_importer_image( $m[1] );
					return $id ? wp_get_attachment_image( $id, 'large', false, array( 'class' => 'prestation__image' ) ) : '';
				},
				trim( $p['contenu'] )
			);

			$post_id = wp_insert_post(
				array(
					'post_type'    => 'prestation',
					'post_status'  => 'publish',
					'post_title'   => $p['titre'],
					'post_name'    => $slug,
					'post_content' => $contenu,
					'menu_order'   => $ordre + 1,
				)
			);
			if ( ! $post_id || is_wp_error( $post_id ) ) {
				continue;
			}
			wp_set_object_terms( $post_id, array( (int) $terme_id ), 'rubrique' );

			if ( ! empty( $p['image'] ) ) {
				$image_id = borne_pga_importer_image( $p['image'] );
				if ( $image_id ) {
					set_post_thumbnail( $post_id, $image_id );
				}
			}
			++$bilan['prestations'];
		}

		if ( ! empty( $r['page'] ) && ! get_page_by_path( $r['slug'] ) ) {
			wp_insert_post(
				array(
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_title'   => $r['page'],
					'post_name'    => $r['slug'],
					'post_content' => '<!-- wp:shortcode -->[borne_onglets rubrique="' . $r['slug'] . '"]<!-- /wp:shortcode -->',
				)
			);
			++$bilan['pages'];
		}
	}

	borne_pga_creer_menu();

	if ( ! get_option( 'borne_pga_importe' ) ) {
		update_option( 'blogname', 'Paierie Générale d\'Antananarivo' );
		update_option( 'blogdescription', 'Prestations du PGA' );
	}
	update_option( 'borne_pga_importe', time() );
	flush_rewrite_rules();

	return $bilan;
}

/**
 * Copie une image de assets/import/ dans la médiathèque (une seule fois par fichier).
 *
 * @return int ID de la pièce jointe, 0 en cas d'échec.
 */
function borne_pga_importer_image( $fichier ) {
	static $deja = array();
	if ( isset( $deja[ $fichier ] ) ) {
		return $deja[ $fichier ];
	}

	$existant = get_posts(
		array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'numberposts' => 1,
			'fields'      => 'ids',
			'meta_key'    => '_borne_pga_source', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'  => $fichier, // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
	if ( $existant ) {
		return $deja[ $fichier ] = (int) $existant[0];
	}

	$source = get_template_directory() . '/assets/import/' . basename( $fichier );
	if ( ! is_readable( $source ) ) {
		return $deja[ $fichier ] = 0;
	}

	$envoi = wp_upload_bits( basename( $fichier ), null, file_get_contents( $source ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( ! empty( $envoi['error'] ) ) {
		return $deja[ $fichier ] = 0;
	}

	$type = wp_check_filetype( $envoi['file'] );
	$id   = wp_insert_attachment(
		array(
			'post_mime_type' => $type['type'],
			'post_title'     => ucfirst( str_replace( array( '_', '-' ), ' ', pathinfo( $fichier, PATHINFO_FILENAME ) ) ),
			'post_status'    => 'inherit',
		),
		$envoi['file']
	);
	if ( ! $id || is_wp_error( $id ) ) {
		return $deja[ $fichier ] = 0;
	}

	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $envoi['file'] ) );
	update_post_meta( $id, '_borne_pga_source', $fichier );

	return $deja[ $fichier ] = (int) $id;
}

/** Menu « Principal » : accueil de la borne + pages des rubriques à part. */
function borne_pga_creer_menu() {
	$emplacements = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $emplacements['principal'] ) && wp_get_nav_menu_object( $emplacements['principal'] ) ) {
		return;
	}

	$menu_id = wp_create_nav_menu( 'Menu de la borne' );
	if ( is_wp_error( $menu_id ) ) {
		$menu    = wp_get_nav_menu_object( 'Menu de la borne' );
		$menu_id = $menu ? $menu->term_id : 0;
	} else {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => 'Prestations du PGA',
				'menu-item-url'    => home_url( '/' ),
				'menu-item-status' => 'publish',
			)
		);
		$page = get_page_by_path( 'dossiers-mandatement' );
		if ( $page ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $page->post_title,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $page->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
			);
		}
	}

	if ( $menu_id ) {
		$emplacements['principal'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $emplacements );
	}
}

/* -------------------------------------------------------------------------
 * Page Apparence > Borne PGA : relancer l'import si besoin.
 * ---------------------------------------------------------------------- */

add_action(
	'admin_menu',
	function () {
		add_theme_page( 'Borne PGA', 'Borne PGA', 'edit_theme_options', 'borne-pga', 'borne_pga_page_reglages' );
	}
);

function borne_pga_page_reglages() {
	$bilan = null;
	if ( isset( $_POST['borne_pga_importer'] ) && check_admin_referer( 'borne_pga_importer' ) ) {
		$bilan = borne_pga_importer();
	}
	?>
	<div class="wrap">
		<h1>Borne PGA</h1>
		<?php if ( $bilan ) : ?>
			<div class="notice notice-success"><p>
				Import terminé : <?php echo (int) $bilan['rubriques']; ?> rubrique(s),
				<?php echo (int) $bilan['prestations']; ?> prestation(s),
				<?php echo (int) $bilan['pages']; ?> page(s) créée(s).
			</p></div>
		<?php endif; ?>

		<h2>Gérer le contenu</h2>
		<ul style="list-style:disc;padding-left:2em">
			<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=prestation' ) ); ?>">Prestations</a> : une prestation = un sous-onglet (texte + photo du guichet). Le champ « Ordre » règle sa position.</li>
			<li><a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=rubrique&post_type=prestation' ) ); ?>">Rubriques</a> : une rubrique = un onglet principal (ordre, couleurs, affichage sur l'accueil).</li>
			<li><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>">Personnaliser</a> : logo, image d'en-tête, titre et pied de page.</li>
		</ul>

		<h2>Contenu initial</h2>
		<p>Recrée ce qui manque parmi les rubriques, prestations et pages d'origine (ce qui existe déjà n'est pas modifié).</p>
		<form method="post">
			<?php wp_nonce_field( 'borne_pga_importer' ); ?>
			<?php submit_button( 'Importer le contenu initial', 'secondary', 'borne_pga_importer', false ); ?>
		</form>
	</div>
	<?php
}
