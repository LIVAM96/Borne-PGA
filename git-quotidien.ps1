<#
.SYNOPSIS
    Routine Git quotidienne pour Borne-PGA : fetch, add, commit, merge, push.

.DESCRIPTION
    1. Se place sur la branche de travail (feature/Liva-dev par défaut)
    2. git fetch : récupère les nouveautés du dépôt distant
    3. git add + git commit : enregistre votre travail (s'il y a des modifications)
    4. git merge origin/main : met votre branche à jour avec main
    5. git push : envoie votre branche sur GitHub
    6. (option -MergeMain) fusionne votre branche dans main et pousse main

.PARAMETER Message
    Message du commit. S'il est absent, le script le demande
    (Entrée = "Travail du <date>").

.PARAMETER MergeMain
    Fusionne aussi la branche de travail dans main et pousse main.

.PARAMETER Branche
    Branche de travail (par défaut : feature/Liva-dev).

.EXAMPLE
    .\git-quotidien.ps1
.EXAMPLE
    .\git-quotidien.ps1 -Message "Ajout page contact"
.EXAMPLE
    .\git-quotidien.ps1 -Message "Version finale" -MergeMain
#>
param(
    [string]$Message,
    [switch]$MergeMain,
    [string]$Branche = "feature/Liva-dev"
)

$ErrorActionPreference = "Stop"
$BranchePrincipale = "main"

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

# Se placer dans le dossier du dépôt (là où se trouve ce script)
Set-Location -Path $PSScriptRoot

if (-not (Get-Command git -ErrorAction SilentlyContinue)) {
    Write-Host "Git n'est pas installé ou pas dans le PATH." -ForegroundColor Red
    exit 1
}

# 1. Branche de travail
Etape "Branche de travail : $Branche"
$brancheActuelle = (git rev-parse --abbrev-ref HEAD).Trim()
if ($brancheActuelle -ne $Branche) {
    git show-ref --verify --quiet "refs/heads/$Branche"
    if ($LASTEXITCODE -eq 0) {
        Git-Run checkout $Branche
    } else {
        Git-Run fetch origin $Branche
        Git-Run checkout -b $Branche --track "origin/$Branche"
    }
}

# 2. Fetch
Etape "Récupération des nouveautés (git fetch)"
Git-Run fetch origin --prune

# 3. Add + commit
Etape "Ajout des fichiers modifiés (git add)"
Git-Run add -A

git diff --cached --quiet
if ($LASTEXITCODE -ne 0) {
    git status --short
    if (-not $Message) {
        $Message = Read-Host "Message du commit (Entrée = message automatique)"
    }
    if (-not $Message) {
        $Message = "Travail du $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
    }
    Etape "Commit : $Message"
    Git-Run commit -m $Message
} else {
    Write-Host "Aucune modification à enregistrer."
}

# 4. Mise à jour avec origin/<branche> puis origin/main
git show-ref --verify --quiet "refs/remotes/origin/$Branche"
if ($LASTEXITCODE -eq 0) {
    Etape "Mise à jour avec origin/$Branche"
    Git-Run merge --no-edit "origin/$Branche"
}
Etape "Mise à jour avec $BranchePrincipale (git merge origin/$BranchePrincipale)"
Git-Run merge --no-edit "origin/$BranchePrincipale"

# 5. Push de la branche de travail
Etape "Envoi sur GitHub (git push)"
Git-Run push -u origin $Branche

# 6. Option : fusion dans main
if ($MergeMain) {
    Etape "Fusion de $Branche dans $BranchePrincipale"
    Git-Run checkout $BranchePrincipale
    Git-Run merge --ff-only "origin/$BranchePrincipale"
    Git-Run merge --no-ff --no-edit $Branche
    Git-Run push origin $BranchePrincipale
    Git-Run checkout $Branche
}

Write-Host "`nTerminé avec succès." -ForegroundColor Green
git log --oneline -5
