# Borne PGA sous WordPress

Le thème `borne-pga` transforme la borne (anciennes pages `index.html` et `dossier.html`)
en site WordPress dont tout le contenu se modifie depuis l'administration.

## Comment le contenu est organisé

| Sur la borne | Dans l'administration WordPress |
|---|---|
| Onglet principal (PENSIONS, SOLDES…) | **Prestations > Rubriques** : nom, ordre, couleurs |
| Sous-onglet (Paiement Pension…) | **Prestations** : titre, texte, photo du guichet |
| Ordre des sous-onglets | Champ **Ordre** de la prestation (panneau « Attributs ») |
| Photo à droite | **Photo du guichet** (image mise en avant) de la prestation |
| Page « Dossiers requis pour mandatement » | Une rubrique « page à part », affichée par le code `[borne_onglets rubrique="dossiers-mandatement"]` |
| Logo, image d'en-tête, titre, pied de page | **Apparence > Personnaliser** (section « Borne PGA ») |
| Liens sous le titre | **Apparence > Menus** |

Une rubrique qui n'a qu'une seule prestation s'affiche sans sous-onglet (ex. VIREMENT REJETE).
Toucher une photo l'affiche en grand.

À la première activation, le thème crée automatiquement les rubriques, les 28 prestations,
les photos, la page « Dossiers requis pour mandatement » et le menu.
**Apparence > Borne PGA** permet de recréer ce qui aurait été supprimé.

## Installer en local

### Option 1 : Docker Desktop

Dans PowerShell, depuis le dossier `wordpress` du dépôt :

```powershell
docker compose up -d
```

Ouvrir http://localhost:8080, suivre l'installation de WordPress (langue : Français),
puis **Apparence > Thèmes** : activer **Borne PGA**.

### Option 2 : XAMPP (ou LocalWP, WAMP)

1. Installer WordPress dans XAMPP (ex. `C:\xampp\htdocs\borne`).
2. Copier le dossier `wordpress\wp-content\themes\borne-pga` du dépôt dans
   `C:\xampp\htdocs\borne\wp-content\themes\`.
3. Dans l'administration : **Apparence > Thèmes** : activer **Borne PGA**.

### Option 3 : envoyer le thème sur un site WordPress existant

Créer le fichier zip du thème, depuis le dossier `wordpress\wp-content\themes` :

```powershell
Compress-Archive -Path borne-pga -DestinationPath borne-pga.zip -Force
```

Puis **Apparence > Thèmes > Ajouter > Téléverser un thème** et choisir `borne-pga.zip`.

## Réglages conseillés après l'activation

- **Réglages > Permaliens** : choisir « Titre de la publication » puis Enregistrer.
- **Réglages > Lecture** : décocher « Demander aux moteurs de recherche de ne pas indexer » seulement si le site est public.

## Fichiers du thème

```
borne-pga/
├── style.css               styles de la borne
├── functions.php           réglages du thème
├── header.php / footer.php en-tête et pied de page
├── front-page.php          accueil : onglets des rubriques
├── index.php               pages, prestation seule, rubrique seule
├── inc/types.php           type « Prestation » et classement « Rubrique »
├── inc/affichage.php       construction des onglets, code [borne_onglets]
├── inc/import.php          import du contenu initial
├── inc/contenu-initial.php textes repris des anciennes pages HTML
└── assets/                 JavaScript des onglets, logo, images à importer
```
