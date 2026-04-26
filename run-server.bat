@echo off
cd /d "%~dp0"

start "NPM Dev" cmd /k "npm run dev"
start "Laravel Server" cmd /k "php artisan serve"

echo Servers started!
echo Laravel: http://127.0.0.1:8000
echo Press any key to close this window...
pause >nul
