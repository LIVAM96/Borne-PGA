<?php
/**
 * Contenu initial de la borne, repris des anciennes pages index.html et dossier.html.
 * Il n'est utilisé qu'une fois, à l'activation du thème (voir inc/import.php).
 * Ensuite, tout se modifie depuis l'administration : Prestations et Rubriques.
 *
 * 'image'     : photo affichée à droite (image mise en avant), prise dans assets/import/.
 * {image:x}   : dans un contenu, insère l'image assets/import/x à cet endroit.
 * 'couleurs'  : début du dégradé, fin du dégradé, couleur du texte de l'onglet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	/* ------------------------------------------------------------------ */
	array(
		'nom'     => 'PENSIONS',
		'slug'    => 'pensions',
		'ordre'   => 1,
		'accueil' => true,
		'couleurs' => array( '#667eea', '#764ba2', '#ffffff' ),
		'prestations' => array(
			array(
				'titre'   => 'Paiement Pension',
				'image'   => 'caisse.jpg',
				'contenu' => '
<p><strong>Veuillez vous rendre à la caisse 01 à 12</strong></p>
<p><strong>Pièces à fournir pour un retrait à la caisse :</strong></p>
<ul>
<li>01- Titre pension (moins de 3 mois)</li>
<li>02- Carte d\'identité Nationale (CIN) originale et moins de 20 ans</li>
<li><em>03- (Présence obligatoire du titulaire lors du paiement)</em></li>
</ul>',
			),
			array(
				'titre'   => 'Paiement des Derniers Arriérés',
				'image'   => 'caisse.jpg',
				'contenu' => '
<p><strong>Veuillez vous rendre à la caisse 01 à 12</strong></p>
<p><strong>Pièces à fournir pour un retrait à la caisse (DERNIERS ARRÉRAGES) :</strong></p>
<ul>
<li>01- Acte de décès (original)</li>
<li>02- Acte de notoriété (original)</li>
<li>03- Copie légalisée de la CIN de tous les héritiers (pour les héritiers de plus de 21 ans)</li>
<li>04- Ordonnance de tutelle en provenance du Tribunal (exigé pour les héritiers de moins de 21 ans)</li>
<li>05- Acte de naissance moins de 3 mois (exigé pour les héritiers mineurs)</li>
<li>06- Acte de décès d\'un héritier (exigé en cas d\'héritier décédé)</li>
<li>07- (procuration et certificat de vie requis si un héritier est absent)</li>
</ul>',
			),
			array(
				'titre'   => 'Changement de Localité',
				'image'   => '',
				'contenu' => '
<p><strong>Veuillez vous rendre à la Porte 07</strong></p>
<p><em>(Information spécialement destinée aux assignés à Analamanga)</em></p>
<p><strong>Documents à fournir :</strong></p>
<ul>
<li>01- Photocopie CIN (légalisée)</li>
<li>02- Bulletin de pension</li>
<li>03- Certificat de vie (moins de 3 mois)</li>
<li>04- Un formulaire est à remplir (Changement de localité ou Changement d\'assignation)</li>
</ul>
<p><em>Ces dossiers sont à déposer au Service Pension à Ampefiloha à la fin (Immeuble Fiaro, escalier à 2ème étage)</em></p>',
			),
			array(
				'titre'   => 'Récupération Avis de Crédit',
				'image'   => 'avis_credit.jpg',
				'contenu' => '
<p><strong>Veuillez vous rendre à la Porte 07</strong></p>
<p><em>(Uniquement destiné aux assignés à PGA)</em></p>
<p><em>Récupération d\'avis de crédit au moment de la réception du certificat de vie (Tous les 3 mois)</em></p>
<p><strong>Documents à fournir :</strong></p>
<ul>
<li>1- La CIN (Carte d\'Identité Nationale)</li>
<li>2- La carte de pension</li>
</ul>',
			),
			array(
				'titre'   => 'Réception de Certificat de Vie',
				'image'   => 'certif_vie.jpg',
				'contenu' => '
<p><strong>Documents à fournir :</strong></p>
<ul>
<li>Dépôt d\'un certificat de vie tous les trois mois, mais en présence physique du bénéficiaire tous les six mois (Fin mai et Fin novembre). Le certificat de vie est délivré par le Fokontany avec deux témoins, et aussi délivré par le bureau de Commune.</li>
<li>Munir de CIN du Bénéficiaire avec Carte pension (originaux)</li>
<li>En général, pendant les trois derniers jours du mois cité ci-dessous (jours ouvrables) :</li>
<li>(Fin février, fin mai, fin août, fin novembre)</li>
</ul>',
			),
			array(
				'titre'   => 'Remboursement frais médicaux',
				'image'   => 'caisse.jpg',
				'contenu' => '
<p><strong>Veuillez vous rendre à la caisse 11</strong></p>
<p><strong>Pièces à fournir pour un retrait à la caisse :</strong></p>
<ul>
<li>01- Bon de Caisse</li>
<li>02- Carte d\'identité Nationale (CIN) (originale)</li>
<li>03- (Présence obligatoire lors du paiement)</li>
</ul>',
			),
		),
	),

	/* ------------------------------------------------------------------ */
	array(
		'nom'     => 'SOLDES',
		'slug'    => 'soldes',
		'ordre'   => 2,
		'accueil' => true,
		'couleurs' => array( '#f093fb', '#f5576c', '#ffffff' ),
		'prestations' => array(
			array(
				'titre'   => 'Paiement Solde',
				'image'   => 'pga_caisse.jpg',
				'contenu' => '
<p><strong>Veuillez vous rendre à la caisse 01 à 12</strong></p>
<p><strong>Pièces à fournir pour un retrait à la caisse :</strong></p>
<ul>
<li>01- Bon de Caisse</li>
<li>02- Carte d\'identité Nationale (CIN) originale et moins de 3 mois</li>
<li><em>03- (Présence obligatoire lors du paiement)</em></li>
</ul>',
			),
			array(
				'titre'   => 'Paiement des Derniers Arriérés',
				'image'   => 'caisse_pga.jpg',
				'contenu' => '
<p><strong>Veuillez vous rendre à la caisse 01 à 12</strong></p>
<p><strong>Pièces à fournir pour un retrait à la caisse (DERNIERS ARRÉRAGES) :</strong></p>
<ul>
<li>1- Acte de décès (original)</li>
<li>2- Acte de notoriété (original)</li>
<li>3- Le Bon de Caisse au nom de l\'agent décédé doit être approuvé au SONACO Ambanidia pour modifier le Bénéficiaire au nom des Héritiers</li>
<li>4- Copie légalisée de la CIN de tous les héritiers</li>
<li>5- (procuration et certificat de vie requis si un héritier est absent)</li>
</ul>',
			),
			array(
				'titre'   => 'Autres',
				'image'   => 'porte7.jpg',
				'contenu' => '
<p><strong>Récupération de BC, Indemnités ou autres avec Bordereaux d\'envoi provenant d\'un autre Poste Comptable. Veuillez vous rendre à la Porte 07.</strong></p>',
			),
		),
	),

	/* ------------------------------------------------------------------ */
	array(
		'nom'     => 'VERSEMENT',
		'slug'    => 'versement',
		'ordre'   => 3,
		'accueil' => true,
		'couleurs' => array( '#28a745', '#20c997', '#ffffff' ),
		'prestations' => array(
			array(
				'titre'   => 'Versement de Validation de service',
				'image'   => 'caisse_recette.jpg',
				'contenu' => '
<p><strong>Veuillez vous rendre à la caisse Recette</strong></p>
<p><strong>Pièces à fournir :</strong></p>
<p>Un (1) exemplaire Original et trois (3) exemplaires de la photocopie Certifiée de :</p>
<ul>
<li>01- L\'Avis d\'Émission d\'Ordre de recette</li>
<li>02- L\'Ordre de recette</li>
<li>03- L\'État de décompte</li>
</ul>
<p><strong>Les Photocopies sont à certifier auprès du Service de la Validation des Services Précaires</strong></p>
<p><strong>(DIRECTION DE LA SOLDE ET DES PENSIONS)</strong></p>',
			),
			array(
				'titre'   => 'Versement des Droits de Délivrance de Visa de Séjour et de la Carte de Résident',
				'image'   => 'caisse_recette.jpg',
				'contenu' => '
<h4>VERSEMENT DES DROITS DE DÉLIVRANCE DE VISA DE SÉJOUR ET DE CARTE DE RÉSIDENT</h4>
<p><strong>Veuillez vous rendre à la Caisse Recette</strong></p>
<p><strong>Pièces à fournir :</strong></p>
<ul>
<li>Lettre de Notification originale avec la Signature et le Cachet rouge du MINISTERE DE L\'INTERIEUR ET DE LA DECENTRALISATION (MID)</li>
<li>État de Décompte du Droit de visa et de la Carte de Séjour Original</li>
<li>Passeport du Propriétaire</li>
<li>CIN ou PASSEPORT du Déclarant</li>
<li>Lettre de Procuration au Déclarant pour plus de 2 personnes sauf si pour des personnes de la même famille</li>
</ul>
<p><strong>En cas de Paiement par Virement Bancaire :</strong></p>
<ul>
<li>Copie de l\'Ordre de Virement</li>
<li>Copie de l\'Avis de Débit</li>
<li>Copie de l\'Etat décadaire fourni par le MID (Paiement en Euro)</li>
</ul>
<p><strong>En cas de Paiement par Chèque :</strong></p>
<p>Le Chèque de Banque est le seul accepté.</p>',
			),
			array(
				'titre'   => 'Versement des Droits de Passeport',
				'image'   => 'caisse_recette.jpg',
				'contenu' => '
<h4>VERSEMENT DES DROITS DE PASSEPORT</h4>
<p><strong>Veuillez vous rendre à la Caisse Recette</strong></p>
<p><strong>Pièces à fournir :</strong></p>
<ul>
<li>01- Avis de Paiement venant du MINISTERE DE LA SECURITE PUBLIQUE (MSP)</li>
<li>02- CIN ou PASSEPORT du PROPRIÉTAIRE (PHOTOCOPIE ou ORIGINALE)</li>
<li>03- Si Enfant/Mineur : Photocopie de l\'Acte de Naissance</li>
<li>04- CIN ou PASSEPORT du DÉCLARANT</li>
</ul>',
			),
			array(
				'titre'   => 'Versement du reste de la Caisse d\'avance',
				'image'   => 'caisse_recette.jpg',
				'contenu' => '
<h4>VERSEMENT DU RESTE DE LA CAISSE D\'AVANCES</h4>
<p><strong>Veuillez vous rendre à la Caisse Recette</strong></p>
<p><strong>Pièces à fournir :</strong></p>
<ul>
<li>01- Photocopie de l\'OP Certifié par l\'ORDSEC</li>
<li>02- Bordereau d\'Emploi de Fonds d\'Avances signé par L\'ORDSEC et le Régisseur</li>
<li>03- Fiche de recette à retirer auprès de la porte 109 PGA</li>
</ul>',
			),
			array(
				'titre'   => 'Versement sur Soldes et Indemnités',
				'image'   => 'caisse_recette.jpg',
				'contenu' => '
<h4>VERSEMENT SUR SOLDE ET INDEMNITÉ</h4>
<p><strong>Veuillez vous rendre à la Caisse Recette</strong></p>
<p><strong>Pièces à fournir :</strong></p>
<ul>
<li>01- Ordre de Recette signé par l\'ORDSEC, avec le motif de Reversement Bien défini</li>
<li>02- État de Reversement signé par le Billeteur</li>
<li>03- État émargé Original et Photocopie certifiée par l\'ORDSEC</li>
<li>04- Photocopie du Bulletin de Solde si Reversement sur Solde</li>
</ul>',
			),
		),
	),

	/* ------------------------------------------------------------------ */
	array(
		'nom'     => 'VIREMENT REJETE',
		'slug'    => 'virement-rejete',
		'ordre'   => 4,
		'accueil' => true,
		'couleurs' => array( '#f0f0f0', '#e0e0e0', '#333333' ),
		'prestations' => array(
			array(
				'titre'   => 'Virement Rejeté',
				'image'   => '109.jpg',
				'contenu' => '
<p><strong>Motif : Rejet de virement (salaire / pension / facture)</strong></p>
<p><strong>Veuillez vous rendre à la Porte 109</strong></p>
<p><strong>Pièces à fournir :</strong></p>
<ul>
<li>Avis de crédit</li>
<li>Relevé d\'Identité Bancaire (RIB)</li>
<li>Photocopie de la Carte d\'Identité Nationale (CIN) dûment légalisée</li>
<li>Certificat administratif</li>
</ul>
<p><strong>Procédure :</strong></p>
<p>La PGA délivrera un acte de renseignement à déposer auprès de la SONACO.</p>
<p>Après dépôt et traitement du dossier, celui-ci devra être retourné à la PGA en vue de la reprise de l\'opération de virement bancaire.</p>',
			),
		),
	),

	/* ------------------------------------------------------------------ */
	array(
		'nom'     => 'REGIE D\'AVANCE',
		'slug'    => 'regie-avance',
		'ordre'   => 5,
		'accueil' => true,
		'couleurs' => array( '#f0f0f0', '#e0e0e0', '#333333' ),
		'prestations' => array(
			array(
				'titre'   => 'DEMANDE DE CAISSE D\'AVANCE',
				'image'   => '105.jpg',
				'contenu' => '
<h4>Veuillez vous rendre à <strong>la Porte 105</strong></h4>
<p><strong>Documents requis pour la Caisse d\'Avance (à partir de la 2e avance) :</strong></p>
<ul>
<li>Bordereau d\'Ordre de Paiement (BOP) signé par ORDSEC ex</li>
<li>Ordre de Paiement (OP) signé par ORDSEC 2 ex</li>
<li>Avis de crédit (AC) signé par ORDSEC 1 ex</li>
<li>Photocopie TEF comptable certifiée par ORDSEC 1 ex</li>
<li>Demande d\'Avance de Fonds (DAF) signé par ORDSEC et le Régisseur 2 ex</li>
<li>• Et visé par CF si montant est supérieur à 2.500.000 Ar</li>
<li>• Sans visa du CF si CHED [Eau et électricité, téléphone, internet, frais de déplacement (vol aérien, billet d\'une agence de voyage)] et pour les autres comptes dont le montant est inférieur ou égal à 2.500.000 Ar mais avec double signature de l\'Ordsec.</li>
<li>Certificat d\'Engagement (CE) signé par ORDSEC 2 ex</li>
<li>Copie certifiée par ORDSEC de tous les Arrêtés :</li>
<li>• Création de régie d\'Avance 1 ex</li>
<li>• Nomination du Régisseur 1 ex</li>
<li>• Mise en place de fonds pour MDG et MFA 1 ex</li>
<li>• Dernier Quitus (copie certifiée par le Payeur Général ou Fondé de pouvoirs) 1 ex</li>
<li>et/ou certificat de non régisseur signé par l\'Ordsec.</li>
<li>(sans Quitus à partir de la 3e avance)</li>
<li>Etat d\'emploi paraphé par le Fondé de Pouvoirs de la dernière régularisation 1 ex</li>
</ul>',
			),
			array(
				'titre'   => 'DEMANDE DE QUITTANCE',
				'image'   => '109.jpg',
				'contenu' => '
<h4>Veuillez vous rendre <strong>à la Porte 109</strong></h4>
<p><strong>Documents à fournir pour la Demande de Quitus :</strong></p>
<ol>
<li>01 - État d\'Emploi récapitulé, signé par l\'ORDSEC et le Régisseur 2 ex (en date du 31 Décembre 202x) mentionnant :
<ul>
<li>• Code Régisseur</li>
<li>• Code SOA et imputation budgétaire</li>
<li>• Nature de la dépense</li>
<li>• Montant et référence du mandatement de la régularisation (s\'il y a IMP, séparez les montants de l\'IMP 8% et le 92%)</li>
<li>• Total des montants (OP-Régularisation-Reste)</li>
<li>• Référence de la quittance de reversement reliquat</li>
</ul>
</li>
<li>02 - Photocopie certifiée à la PGA de la Quittance de versement (reliquat/IMP) 1 ex</li>
<li>03 - Photocopie certifiée par l\'Ordsec de tous les Arrêtés (création, nomination, mise en place) 1 ex</li>
<li>04 - État d\'emploi paraphé par le Fondé de Pouvoirs de la dernière régularisation 1 ex</li>
</ol>',
			),
			array(
				'titre'   => 'VERSEMENT DU RESTE DE LA CAISSE D\'AVANCE',
				'image'   => 'porte7.jpg',
				'contenu' => '
<h4>Veuillez vous rendre à <strong>la Caisse Recette</strong></h4>
<ol>
<li>Photocopie de l\'OP Certifié par l\'ORDSEC</li>
<li>Bordereau d\'Emploi de Fonds d\'Avances signé par L\'ORDSEC et le Régisseur</li>
<li>Fiche de recette à retirer auprès de la porte 109 PGA</li>
</ol>
{image:109.jpg}',
			),
		),
	),

	/* ------------------------------------------------------------------ */
	array(
		'nom'     => 'CONSULTATION DES DOSSIERS',
		'slug'    => 'consultation-dossiers',
		'ordre'   => 6,
		'accueil' => true,
		'couleurs' => array( '#f6d365', '#fda085', '#333333' ),
		'prestations' => array(
			array(
				'titre'   => 'Situation pour Acteur Budgétaire',
				'image'   => 'salohy1.jpg',
				'contenu' => '
<p><strong>Veuillez cliquer sur le lien suivant :</strong></p>
<p><a href="https://app.tresorpublic.mg:12000/salohy/index.php/site/login" target="_blank" rel="noopener">https://app.tresorpublic.mg:12000/salohy/index.php/site/login</a></p>
<p>Sélectionnez ensuite votre rôle, puis consultez votre situation dans le menu « Situation de paiement » ou « Situation des crédits ».</p>',
			),
			array(
				'titre'   => 'Situation pour le Public / Usagers',
				'image'   => 'situation.jpg',
				'contenu' => '
<p><strong>Consultation des Situations</strong></p>
<p>Cliquez sur <a href="https://app.tresorpublic.mg:12000/info/" target="_blank" rel="noopener">https://app.tresorpublic.mg:12000/info/</a>, puis procédez à l\'authentification.</p>',
			),
		),
	),

	/* ------------------------------------------------------------------ */
	array(
		'nom'     => 'Dossiers requis pour mandatement',
		'slug'    => 'dossiers-mandatement',
		'ordre'   => 10,
		'accueil' => false,
		'couleurs' => array( '#3498db', '#2980b9', '#ffffff' ),
		'page'    => 'Dossiers requis pour mandatement',
		'prestations' => array(
			array(
				'titre'   => 'Derniers arrérages',
				'contenu' => '
<h3>Dossier requis au caisse :</h3>
<ul>
<li>Demande (enfant)</li>
<li>Acte de décès (2 Originales + 1 photocopie)</li>
<li>Acte de Notoriété (02 exemplaires)</li>
<li>Si enfant mineur : + 02 Ordonnance de tutelle</li>
<li>En cas de décès d\'un enfant : + 02 Actes de décès enfant et acte de notoriété</li>
<li>Dernier Titre de paiement de pension (Original + photocopie)</li>
</ul>',
			),
			array(
				'titre'   => 'Secours décès',
				'contenu' => '
<h3>Documents à fournir :</h3>
<ul>
<li>Demande (Veuf/ve)</li>
<li>Acte de décès (Original + Photocopie)</li>
<li>Acte de mariage</li>
<li>Certificat de non séparation du corps et de non divorce</li>
<li>Bulletin de pension (Original + Photocopie)</li>
<li>Photocopie CIN du/de la veuf(ve)</li>
</ul>
<h4>Adresse de la demande :</h4>
<p>À l\'attention de Madame le Chef de Service des secours au décès et des oppositions</p>',
			),
			array(
				'titre'   => 'Pensionné(e) décédé(e)',
				'contenu' => '
<h3>Documents à fournir :</h3>
<ul>
<li>Demande (Veuf/ve)</li>
<li>Acte de décès (Original + Photocopie)</li>
<li>Acte de mariage</li>
<li>Certificat de non séparation du corps et de non divorce</li>
<li>Bulletin de pension (Photocopie)</li>
<li>Photocopie CIN du/de la veuf(ve)</li>
<li>Acte de naissance des enfants</li>
<li>Acte de naissance du/de la veuf(ve)</li>
<li>Certificat de vie des enfants mineurs (FKT)</li>
</ul>
<h4>Note importante :</h4>
<p>Tous les documents originaux seront restitués après vérification. Les photocopies doivent être certifiées conformes aux originaux.</p>',
			),
			array(
				'titre'   => 'Pensions de veuvage, agent décédé en activité',
				'contenu' => '
<h3>Documents à fournir :</h3>
<ul>
<li>Demande</li>
<li>Acte de décès (2 exemplaires)</li>
<li>Dernier bulletin de solde</li>
<li>Photocopie CIN (4 exemplaires)</li>
<li>Acte de mariage</li>
<li>Certificat de non séparation du corps et de non divorce</li>
<li>Acte de naissance du/de la veuf(ve)</li>
<li>Relevé de service (Visé FOP)</li>
<li>Validation (déclaration recette, état de décompte, ordre de recette)</li>
<li>Certificat de cessation de paiement</li>
<li>Acte de naissance des enfants</li>
<li>Certificat de Vie collectif des enfants</li>
<li>État signalétique de service militaire</li>
</ul>',
			),
			array(
				'titre'   => 'Changement de carte de pension',
				'contenu' => '
<h3>Documents requis :</h3>
<h4>CHANGEMENT DE CARTE DE PENSION</h4>
<ul>
<li>Demande</li>
<li>Bulletin de pension</li>
<li>Photocopie CIN</li>
<li>Ancienne carte / Déclaration de perte auprès de la gendarmerie ou de la Police nationale</li>
</ul>
<h4>CHANGEMENT D\'ASSIGNATION</h4>
<ul>
<li>Imprimé (Alaina any amin\'ny Perception)</li>
<li>Bulletin de pension</li>
<li>Photocopie CIN</li>
</ul>
<h4>MAJORATION PR ENFANTS</h4>
<ul>
<li>Imprimé MAE</li>
<li>Bulletin de pension</li>
<li>Photocopie CIN</li>
</ul>',
			),
			array(
				'titre'   => 'Changement de localité',
				'contenu' => '
<h3>Documents requis :</h3>
<ul>
<li>Un (01) Certificat de vie du pensionné</li>
<li>Un (01) certificat de résidence du pensionné</li>
<li>Une (01) photocopie certifiée conforme à l\'original de la CIN du pensionné</li>
<li>Une (01) photocopie certifiée conforme à l\'original de la carte pension</li>
<li>Une (01) photocopie du dernier bulletin de pension perçu</li>
<li>Formulaire de demande de changement d\'assignation complété et signé par le chef de Poste Comptable payeur</li>
</ul>',
			),
			array(
				'titre'   => 'Paiement en numéraire ou virement bancaire',
				'contenu' => '
<h3>Documents requis :</h3>
<ul>
<li>Un (01) Relevé d\'Identité Bancaire d\'un compte ouvert au nom du pensionné</li>
<li>Un (01) Certificat de vie du pensionné</li>
<li>Une (01) photocopie certifiée conforme à l\'original de la CIN du pensionné</li>
<li>Une (01) photocopie certifiée conforme à l\'original de la carte pension</li>
<li>Une (01) photocopie du dernier bulletin de pension perçu</li>
<li>Formulaire de demande de changement d\'assignation complété et signé par le chef de Poste Comptable payeur</li>
</ul>
<h4>Important :</h4>
<p>Pour les virements bancaires, veuillez fournir un RIB à jour.</p>',
			),
			array(
				'titre'   => 'Paiement au profit d\'un mandataire',
				'contenu' => '
<h3>Pièces justificatives requises :</h3>
<ul>
<li>Ordonnance sur requête délivrée par le Tribunal de Première Instance ou acte notarié authentique</li>
</ul>
<h4>A chaque paiement à la caisse, les pièces justificatives suivantes sont à produire :</h4>
<h5>Un (01) certificat de vie (C2V) du mandant :</h5>
<ul class="liste-tirets">
<li>- Validité de 48 heures pour un C2V délivré à Analamanga</li>
<li>- 72 heures pour un C2V délivré en provinces</li>
<li>- Un (01) mois pour un C2V délivré à l\'étranger</li>
</ul>
<h5>Pour les C2V délivrés par le Chef Fokontany, deux (02) témoins sont exigés avec :</h5>
<ul class="liste-tirets">
<li>- Nom et prénom</li>
<li>- Numéro CIN avec date de délivrance et duplicata</li>
<li>- Adresse</li>
<li>- Signature</li>
</ul>
<h5>Autres pièces requises :</h5>
<ul class="liste-tirets">
<li>- Une (01) photocopie certifiée conforme à l\'original de la CIN du mandant</li>
<li>- Une (01) photocopie certifiée conforme à l\'original de la CIN du mandataire</li>
</ul>',
			),
		),
	),
);
