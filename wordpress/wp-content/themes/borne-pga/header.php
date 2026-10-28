<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site">
	<?php $image_entete = get_header_image(); ?>
	<header class="entete"<?php echo $image_entete ? ' style="background-image:url(' . esc_url( $image_entete ) . ')"' : ''; ?>>
		<a class="entete__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'medium', false, array( 'class' => 'logo' ) ); ?>
			<?php else : ?>
				<img class="logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-tresor.png' ); ?>" alt="Logo Trésor">
			<?php endif; ?>
		</a>
		<div class="entete__contenu">
			<p class="entete__titre"><?php echo esc_html( get_theme_mod( 'borne_titre', borne_pga_titre_par_defaut() ) ); ?></p>
			<nav class="entete__menu" aria-label="Menu principal">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'principal',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => 'borne_pga_menu_par_defaut',
					)
				);
				?>
			</nav>
		</div>
	</header>
	<main class="contenu" id="contenu">
