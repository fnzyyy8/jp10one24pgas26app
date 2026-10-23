@echo off

title Dashboard Jargas

echo =====================================
echo        DASHBOARD JARGAS
echo =====================================
echo.

echo Starting application...
docker compose up -d --build

echo.
echo =====================================
echo Dashboard Jargas is running
echo =====================================
echo.
echo Open:
echo http://localhost:8000
echo.

start http://localhost:8000

pause
