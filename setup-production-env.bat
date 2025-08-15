@echo off
echo ===========================================
echo ABUMART PRODUCTION ENVIRONMENT SETUP
echo ===========================================
echo.
echo This script will copy the production environment template to .env
echo.
echo IMPORTANT: You must edit the .env file with your actual values!
echo.
pause

echo Copying production environment template...
copy "env.production.template" ".env"

if %errorlevel% equ 0 (
    echo.
    echo SUCCESS: .env file created from template
    echo.
    echo NEXT STEPS:
    echo 1. Edit the .env file with your actual production values
    echo 2. Replace all 'your-*' placeholders with real credentials
    echo 3. Never commit .env to version control
    echo 4. Test your configuration locally before deploying
    echo.
    echo The .env file is now ready for customization
) else (
    echo.
    echo ERROR: Failed to create .env file
    echo Please check if env.production.template exists
)

echo.
pause
