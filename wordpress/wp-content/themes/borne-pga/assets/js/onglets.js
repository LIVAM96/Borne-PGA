/**
 * Onglets et sous-onglets de la borne, et agrandissement des photos.
 * Chaque série d'onglets ([data-onglets]) fonctionne indépendamment des autres.
 */
( function () {
	'use strict';

	function ongletsDe( serie ) {
		return Array.prototype.filter.call(
			serie.querySelector( '.onglets__barre' ).children,
			function ( el ) { return el.getAttribute( 'role' ) === 'tab'; }
		);
	}

	function activer( onglet, majAdresse ) {
		var serie = onglet.closest( '[data-onglets]' );
		ongletsDe( serie ).forEach( function ( autre ) {
			var actif = autre === onglet;
			autre.setAttribute( 'aria-selected', actif ? 'true' : 'false' );
			autre.tabIndex = actif ? 0 : -1;
			document.getElementById( autre.getAttribute( 'aria-controls' ) ).hidden = ! actif;
		} );

		if ( majAdresse && window.history.replaceState ) {
			window.history.replaceState( null, '', '#' + onglet.getAttribute( 'aria-controls' ) );
		}
	}

	document.querySelectorAll( '[data-onglets]' ).forEach( function ( serie ) {
		var onglets = ongletsDe( serie );

		onglets.forEach( function ( onglet, i ) {
			onglet.addEventListener( 'click', function () {
				activer( onglet, true );
			} );

			// Flèches gauche/droite, Début et Fin pour passer d'un onglet à l'autre.
			onglet.addEventListener( 'keydown', function ( e ) {
				var cible = null;
				if ( e.key === 'ArrowRight' ) { cible = onglets[ ( i + 1 ) % onglets.length ]; }
				if ( e.key === 'ArrowLeft' ) { cible = onglets[ ( i - 1 + onglets.length ) % onglets.length ]; }
				if ( e.key === 'Home' ) { cible = onglets[ 0 ]; }
				if ( e.key === 'End' ) { cible = onglets[ onglets.length - 1 ]; }
				if ( cible ) {
					e.preventDefault();
					activer( cible, true );
					cible.focus();
				}
			} );
		} );
	} );

	// Ouvrir directement l'onglet indiqué dans l'adresse (ex. #prestation-12),
	// ainsi que l'onglet parent qui le contient.
	function ouvrirDepuisAdresse() {
		var id = decodeURIComponent( window.location.hash.slice( 1 ) );
		var panneau = id && document.getElementById( id );
		if ( ! panneau || panneau.getAttribute( 'role' ) !== 'tabpanel' ) {
			return;
		}
		var a_ouvrir = [];
		while ( panneau ) {
			if ( panneau.getAttribute( 'role' ) === 'tabpanel' ) {
				a_ouvrir.unshift( document.getElementById( 'onglet-' + panneau.id ) );
			}
			panneau = panneau.parentElement;
		}
		a_ouvrir.forEach( function ( onglet ) {
			if ( onglet ) { activer( onglet, false ); }
		} );
	}
	ouvrirDepuisAdresse();
	window.addEventListener( 'hashchange', ouvrirDepuisAdresse );

	// Visionneuse : toucher une photo d'une prestation l'affiche en grand.
	var visionneuse = document.createElement( 'div' );
	visionneuse.className = 'visionneuse';
	visionneuse.hidden = true;
	visionneuse.setAttribute( 'role', 'dialog' );
	visionneuse.setAttribute( 'aria-modal', 'true' );
	visionneuse.setAttribute( 'aria-label', 'Photo agrandie' );
	visionneuse.innerHTML = '<button type="button" class="visionneuse__fermer" aria-label="Fermer">&times;</button><img alt="">';
	document.body.appendChild( visionneuse );

	var grande = visionneuse.querySelector( 'img' );
	var precedent = null;

	function fermer() {
		visionneuse.hidden = true;
		grande.removeAttribute( 'src' );
		if ( precedent ) { precedent.focus(); }
	}

	document.addEventListener( 'click', function ( e ) {
		var img = e.target.closest( '.prestation img' );
		if ( img ) {
			precedent = img;
			grande.src = img.getAttribute( 'data-zoom' ) || img.currentSrc || img.src;
			grande.alt = img.alt;
			visionneuse.hidden = false;
			visionneuse.querySelector( 'button' ).focus();
		} else if ( ! visionneuse.hidden && visionneuse.contains( e.target ) ) {
			fermer();
		}
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' && ! visionneuse.hidden ) { fermer(); }
	} );
}() );
