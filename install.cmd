@echo off

REM Set the panel path as the subdirectory "panel" in the same directory as the script
set "PANEL_PATH=%~dp0panel"

REM Set the API path as the subdirectory "API" in the same directory as the script
set "API_PATH=%~dp0API"

REM Download and extract PHP
echo Installing PHP...
curl -o php.zip -L https://windows.php.net/downloads/releases/php-8.2.6-nts-Win32-vs16-x64.zip
powershell -command "Expand-Archive -Path 'php.zip' -DestinationPath 'php' -Force"

REM Start API in a separate console window
echo Starting API...
start "" /B php/php.exe "%API_PATH%\api.php"

REM Start panel in a separate console window
echo Starting panel...
start "" /B php/php.exe -S localhost:80 -t "%PANEL_PATH%"

echo Installation completed!
pause