	</main>
	<footer class="pied">
		<p><?php echo esc_html( str_replace( '{annee}', wp_date( 'Y' ), get_theme_mod( 'borne_pied', borne_pga_pied_par_defaut() ) ) ); ?></p>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
