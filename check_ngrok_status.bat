@echo off
echo =====================================
echo     NGROK STATUS CHECKER
echo =====================================
echo.

echo 1. Checking if ngrok is running...
tasklist | findstr ngrok
if %errorlevel% equ 0 (
    echo ✅ Ngrok is running
) else (
    echo ❌ Ngrok is not running
    echo To start ngrok: C:\Users\ASUS\AppData\Local\ngrok\ngrok.exe http 80 --host-header=triadgo.test
    pause
    exit
)
echo.

echo 2. Checking current ngrok URL...
powershell -Command "try { $response = Invoke-WebRequest -Uri 'http://localhost:4040/api/tunnels' -UseBasicParsing | ConvertFrom-Json; $url = $response.tunnels[0].public_url; Write-Host '✅ Current URL:' $url; Write-Host '📋 Callback URL:' ($url + '/midtrans/callback') } catch { Write-Host '❌ Cannot get ngrok URL' }"
echo.

echo 3. Testing callback endpoint...
powershell -Command "try { $url = (Invoke-WebRequest -Uri 'http://localhost:4040/api/tunnels' -UseBasicParsing | ConvertFrom-Json).tunnels[0].public_url; Invoke-WebRequest -Uri ($url + '/midtrans/callback') -Method POST -ContentType 'application/json' -Body '{\"test\": \"data\"}' -Headers @{'ngrok-skip-browser-warning' = 'any'} -ErrorAction SilentlyContinue; Write-Host '✅ Callback endpoint is accessible' } catch { Write-Host '❌ Cannot test callback endpoint' }"
echo.

echo 4. Quick access commands:
echo - Open ngrok dashboard: start http://localhost:4040
echo - Laravel logs: Get-Content "c:\laragon\www\TriadGo\storage\logs\laravel.log" -Tail 10
echo.

echo =====================================
echo Remember to update Midtrans dashboard
echo with current ngrok URL if it changed!
echo =====================================
pause
