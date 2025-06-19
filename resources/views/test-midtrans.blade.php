<!DOCTYPE html>
<html>
<head>
    <title>Midtrans Connection Test - TriadGo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .card { background: white; border-radius: 15px; padding: 30px; margin: 20px 0; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .header { text-align: center; color: white; padding: 40px 0 20px; }
        .header h1 { margin: 0; font-size: 2.5em; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
        .config-info { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .test-button { width: 100%; padding: 15px; margin: 10px 0; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-primary:hover { background: #0056b3; transform: translateY(-2px); }
        .btn-success:hover { background: #1e7e34; transform: translateY(-2px); }
        .result { margin: 20px 0; padding: 20px; border-radius: 10px; display: none; }
        .result.success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .result.error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .loading { text-align: center; padding: 20px; }
        .spinner { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .links { margin-top: 20px; }
        .links a { display: inline-block; margin: 5px 10px; padding: 8px 16px; background: #17a2b8; color: white; text-decoration: none; border-radius: 5px; }
        .config-item { display: flex; justify-content: space-between; margin: 10px 0; padding: 10px; background: white; border-radius: 5px; }
        .status-indicator { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 8px; }
        .status-ok { background: #28a745; }
        .status-error { background: #dc3545; }
        .status-warning { background: #ffc107; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Midtrans Connection Test</h1>
            <p>Testing koneksi dan konfigurasi Midtrans untuk TriadGo</p>
        </div>
        
        <div class="card">
            <h2>📋 Current Configuration</h2>
            <div class="config-info">
                <div class="config-item">
                    <span><strong>Server Key:</strong></span>
                    <span>
                        @if(config('midtrans.server_key'))
                            <span class="status-indicator status-ok"></span>
                            {{ substr(config('midtrans.server_key'), 0, 15) }}...
                        @else
                            <span class="status-indicator status-error"></span>
                            NOT SET
                        @endif
                    </span>
                </div>
                <div class="config-item">
                    <span><strong>Client Key:</strong></span>
                    <span>
                        @if(config('midtrans.client_key'))
                            <span class="status-indicator status-ok"></span>
                            {{ substr(config('midtrans.client_key'), 0, 15) }}...
                        @else
                            <span class="status-indicator status-error"></span>
                            NOT SET
                        @endif
                    </span>
                </div>
                <div class="config-item">
                    <span><strong>Environment:</strong></span>
                    <span>
                        <span class="status-indicator status-{{ config('midtrans.is_production', false) ? 'warning' : 'ok' }}"></span>
                        {{ config('midtrans.is_production', false) ? 'PRODUCTION' : 'SANDBOX' }}
                    </span>
                </div>
                <div class="config-item">
                    <span><strong>Dashboard URL:</strong></span>
                    <span>
                        <a href="{{ config('midtrans.is_production', false) ? 'https://dashboard.midtrans.com' : 'https://dashboard.sandbox.midtrans.com' }}" target="_blank">
                            {{ config('midtrans.is_production', false) ? 'dashboard.midtrans.com' : 'dashboard.sandbox.midtrans.com' }}
                        </a>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>🧪 Connection Tests</h2>
            
            <button class="test-button btn-primary" onclick="testConnection()">
                1️⃣ Test API Connection
            </button>
            
            <button class="test-button btn-success" onclick="createTestTransaction()">
                2️⃣ Create Test Transaction & Check Dashboard
            </button>
            
            <div id="loading" class="loading" style="display: none;">
                <div class="spinner"></div>
                <p>Testing connection...</p>
            </div>
            
            <div id="result" class="result"></div>
        </div>
        
        <div class="card">
            <h2>📚 Quick Links</h2>
            <div class="links">
                <a href="{{ url('/') }}">← Back to TriadGo</a>
                <a href="{{ config('midtrans.is_production', false) ? 'https://dashboard.midtrans.com' : 'https://dashboard.sandbox.midtrans.com' }}" target="_blank">
                    Open Midtrans Dashboard
                </a>
                <a href="https://docs.midtrans.com/" target="_blank">Midtrans Docs</a>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('result').style.display = 'none';
        }
        
        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
        }
        
        function showResult(success, message, details = null) {
            hideLoading();
            const resultDiv = document.getElementById('result');
            resultDiv.className = `result ${success ? 'success' : 'error'}`;
            
            let html = `<h3>${success ? '✅' : '❌'} ${message}</h3>`;
            
            if (details) {
                if (typeof details === 'object') {
                    html += '<pre style="background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;">' + JSON.stringify(details, null, 2) + '</pre>';
                } else {
                    html += `<p>${details}</p>`;
                }
            }
            
            resultDiv.innerHTML = html;
            resultDiv.style.display = 'block';
        }
        
        function testConnection() {
            showLoading();
            
            fetch('/test-midtrans-api', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    test_type: 'connection'
                })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data.success, data.message, data.details);
            })
            .catch(error => {
                showResult(false, 'Network Error', error.message);
            });
        }
        
        function createTestTransaction() {
            showLoading();
            
            fetch('/test-midtrans-api', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    test_type: 'transaction'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = `
                        <h3>✅ Test Transaction Created Successfully!</h3>
                        <div style="background: #e9ecef; padding: 15px; border-radius: 5px; margin: 15px 0;">
                            <p><strong>Order ID:</strong> <code>${data.details.order_id}</code></p>
                            <p><strong>Snap Token:</strong> <code>${data.details.snap_token.substring(0, 30)}...</code></p>
                        </div>
                        
                        <h4>🔍 Check Dashboard:</h4>
                        <p><strong>1. Open dashboard dan login dengan akun Midtrans Anda</strong></p>
                        <p><strong>2. Pergi ke menu "Transactions"</strong></p>
                        <p><strong>3. Cari Order ID: <code>${data.details.order_id}</code></strong></p>
                        
                        <div class="links">
                            <a href="${data.details.dashboard_url}" target="_blank">
                                🔗 Open Midtrans Dashboard
                            </a>
                            <a href="${data.details.payment_url}" target="_blank">
                                💳 Open Payment Page (Test)
                            </a>
                        </div>
                        
                        <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin-top: 15px;">
                            <p><strong>💡 Next Steps:</strong></p>
                            <ol>
                                <li>Klik "Open Midtrans Dashboard" di atas</li>
                                <li>Login dengan akun sandbox Midtrans Anda</li>
                                <li>Pergi ke menu "Transactions"</li>
                                <li>Cari transaksi dengan Order ID: <strong>${data.details.order_id}</strong></li>
                                <li>Jika muncul = koneksi berhasil! ✅</li>
                                <li>Jika tidak muncul = ada masalah koneksi ❌</li>
                            </ol>
                        </div>
                    `;
                    
                    const resultDiv = document.getElementById('result');
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = html;
                    resultDiv.style.display = 'block';
                } else {
                    showResult(false, data.message, data.details);
                }
            })
            .catch(error => {
                showResult(false, 'Network Error', error.message);
            });
        }
        
        // Auto check configuration on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Midtrans Test Page Loaded');
            console.log('Server Key:', '{{ substr(config("midtrans.server_key", "NOT_SET"), 0, 10) }}...');
            console.log('Environment:', '{{ config("midtrans.is_production", false) ? "PRODUCTION" : "SANDBOX" }}');
        });
    </script>
</body>
</html>
