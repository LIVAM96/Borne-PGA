@echo off
REM Lance recuperer-merge.ps1 par double-clic (contourne la politique d'execution)
powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0recuperer-merge.ps1" %*
pause
