@echo off
REM Lance git-quotidien.ps1 par double-clic (contourne la politique d'execution)
powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0git-quotidien.ps1" %*
pause
