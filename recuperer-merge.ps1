<#
.SYNOPSIS
    Récupère la branche de travail, la fusionne dans main en local, puis change de branche.

.DESCRIPTION
    1. git fetch : récupère les nouveautés de GitHub
    2. Met à jour la branche de travail locale (feature/Liva-dev) avec GitHub
    3. Met à jour main local avec origin/main, puis y fusionne la branche de travail
    4. Change de branche (retour sur feature/Liva-dev par défaut)
    Rien n'est envoyé sur GitHub, sauf avec l'option -Push.

.PARAMETER Branche
    Branche de travail à récupérer (par défaut : feature/Liva-dev).

.PARAMETER Destination
    Branche sur laquelle se placer à la fin (par défaut : la branche de travail).

.PARAMETER Push
    Pousse aussi main sur GitHub après la fusion.

.EXAMPLE
    .\recuperer-merge.ps1
.EXAMPLE
    .\recuperer-merge.ps1 -Destination main
.EXAMPLE
    .\recuperer-merge.ps1 -Push
#>
param(
    [string]$Branche = "feature/Liva-dev",
    [string]$Destination,
    [switch]$Push
)

$ErrorActionPreference = "Stop"
$BranchePrincipale = "main"
if (-not $Destination) { $Destination = $Branche }

function Etape($texte) { Write-Host "`n==> $texte" -ForegroundColor Cyan }

function Git-Run {
    # Exécute une commande git et arrête le script en cas d'échec
    & git @args
    if ($LASTEXITCODE -ne 0) {
        Write-Host "`nERREUR : 'git $($args -join ' ')' a échoué." -ForegroundColor Red
        Write-Host "Corrigez le problème (ex. conflit), puis relancez le script." -ForegroundColor Yellow
        exit 1
    }
}

function Aller-Sur($nom) {
    # Se place sur une branche locale, en la créant depuis origin si besoin
    git show-ref --verify --quiet "refs/heads/$nom"
    if ($LASTEXITCODE -eq 0) {
        Git-Run checkout $nom
    } else {
        Git-Run checkout -b $nom --track "origin/$nom"
    }
}

# Se placer dans le dossier du dépôt (là où se trouve ce script)
Set-Location -Path $PSScriptRoot

if (-not (Get-Command git -ErrorAction SilentlyContinue)) {
    Write-Host "Git n'est pas installé ou pas dans le PATH." -ForegroundColor Red
    exit 1
}

# Refuser de changer de branche avec du travail non enregistré
if (git status --porcelain) {
    git status --short
    Write-Host "`nVous avez des modifications non enregistrées." -ForegroundColor Red
    Write-Host "Faites un commit (ou lancez git-quotidien) avant ce script." -ForegroundColor Yellow
    exit 1
}

# 1. Fetch
Etape "Récupération des nouveautés (git fetch)"
Git-Run fetch origin --prune

# 2. Branche de travail à jour
Etape "Mise à jour de $Branche depuis GitHub"
Aller-Sur $Branche
git show-ref --verify --quiet "refs/remotes/origin/$Branche"
if ($LASTEXITCODE -eq 0) {
    Git-Run merge --no-edit "origin/$Branche"
}

# 3. Fusion dans main local
Etape "Mise à jour de $BranchePrincipale depuis GitHub"
Aller-Sur $BranchePrincipale
Git-Run merge --no-edit "origin/$BranchePrincipale"

Etape "Fusion de $Branche dans $BranchePrincipale (local)"
Git-Run merge --no-ff --no-edit $Branche

if ($Push) {
    Etape "Envoi de $BranchePrincipale sur GitHub (git push)"
    Git-Run push origin $BranchePrincipale
}

# 4. Changement de branche
Etape "Changement de branche : $Destination"
Aller-Sur $Destination

Write-Host "`nTerminé avec succès. Branche actuelle : $Destination" -ForegroundColor Green
git log --oneline --graph -5
