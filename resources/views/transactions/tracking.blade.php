<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lacak Paket - Order #{{ $order->order_id }} | TriadGO</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', Arial, sans-serif;
            min-height: 100vh;
            padding: 20px 10px;
        }

        .tracking-container {
            max-width: 700px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
            padding: 50px 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .tracking-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .tracking-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            margin-bottom: 10px;
        }

        .tracking-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .order-info {
            background: #f8fafc;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 40px;
            border: 1px solid #e2e8f0;
        }

        .order-info-title {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 20px;
            display: block;
            font-size: 1.3rem;
            text-align: center;
        }

        .order-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .order-detail-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .order-detail-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .order-detail-value {
            color: #1f2937;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .status-section {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
        }

        .tracking-status-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 30px;
            text-align: center;
        }

        .timeline {
            position: relative;
            margin-left: 80px;
            padding-left: 0;
        }

        .ocean-wave {
            position: absolute;
            left: -80px;
            top: 0;
            bottom: 0;
            width: 80px;
            height: 100%;
            z-index: 0;
        }

        .timeline-step {
            position: relative;
            margin-bottom: 40px;
            min-height: 60px;
            padding: 20px 25px;
            background: #f8fafc;
            border-radius: 16px;
            border-left: 4px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .timeline-step.active {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-left-color: #3b82f6;
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }

        .timeline-step.completed {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border-left-color: #10b981;
        }

        .timeline-step:last-child {
            margin-bottom: 0;
        }

        .timeline-step-title {
            font-weight: 700;
            color: #2563eb;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .timeline-step-title.gray {
            color: #6b7280;
        }

        .timeline-step-title.completed {
            color: #059669;
        }

        .timeline-step-date {
            color: #64748b;
            font-size: 1rem;
            font-weight: 500;
        }

        .timeline-step-date.gray {
            color: #a1a1aa;
        }

        .timeline-step-desc {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 8px;
            font-style: italic;
        }

        .cruise-ship {
            position: absolute;
            left: -80px;
            z-index: 10;
            width: 64px;
            height: 64px;
            animation: shipFloat 3s infinite ease-in-out;
            transition: top 1s ease-in-out;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        @keyframes shipFloat {
            0%, 100% {
                transform: translateY(0) rotate(-2deg);
            }
            50% {
                transform: translateY(-8px) rotate(2deg);
            }
        }

        @keyframes waveFlow {
            0% {
                d: path("M0,20 Q20,0 40,20 T80,20 L80,100 L0,100 Z");
            }
            50% {
                d: path("M0,10 Q20,30 40,10 T80,10 L80,100 L0,100 Z");
            }
            100% {
                d: path("M0,20 Q20,0 40,20 T80,20 L80,100 L0,100 Z");
            }
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: #dcfce7;
            color: #065f46;
        }

        .status-active {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-pending {
            background: #f3f4f6;
            color: #6b7280;
        }

        .progress-bar {
            position: absolute;
            left: -78px;
            top: 0;
            width: 6px;
            background: linear-gradient(to bottom, #10b981, #3b82f6, #e5e7eb);
            border-radius: 3px;
            height: 100%;
        }

        .back-button {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(75, 85, 99, 0.3);
            color: white;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .tracking-container {
                margin: 10px;
                padding: 30px 20px;
            }
            
            .timeline {
                margin-left: 60px;
            }
            
            .ocean-wave {
                left: -60px;
                width: 60px;
            }
            
            .cruise-ship {
                left: -60px;
                width: 48px;
                height: 48px;
            }

            .order-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="tracking-container">
        <a href="{{ route('transactions.show', $order->order_id) }}" class="back-button">
            ← Kembali ke Detail Order
        </a>

        <div class="tracking-header">
            <div class="tracking-title">🚢 Lacak Pengiriman</div>
            <div class="tracking-subtitle">Lacak kiriman Anda melintasi lautan</div>
        </div>
        
        <div class="order-info">
            <div class="order-info-title">📦 Informasi Pesanan</div>
            <div class="order-details">
                <div class="order-detail-item">
                    <div class="order-detail-label">Order ID</div>
                    <div class="order-detail-value">#{{ $order->order_id }}</div>
                </div>
                <div class="order-detail-item">
                    <div class="order-detail-label">Invoice</div>
                    <div class="order-detail-value">{{ $order->invoice_code ?? 'INV' . $order->order_id }}</div>
                </div>
                <div class="order-detail-item">
                    <div class="order-detail-label">Nomor Resi</div>
                    <div class="order-detail-value">{{ $order->tracking_number ?? 'TG' . $order->order_id }}</div>
                </div>
                <div class="order-detail-item">
                    <div class="order-detail-label">Status Pembayaran</div>
                    <div class="order-detail-value">
                        <span class="status-badge {{ $order->status == 'paid' ? 'status-completed' : 'status-pending' }}">
                            {{ $order->status == 'paid' ? 'Lunas' : 'Menunggu' }}
                        </span>
                    </div>
                </div>
                <div class="order-detail-item">
                    <div class="order-detail-label">Total Nilai</div>
                    <div class="order-detail-value">${{ number_format($order->total_amount, 2) }}</div>
                </div>
                <div class="order-detail-item">
                    <div class="order-detail-label">Tanggal Order</div>
                    <div class="order-detail-value">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
                </div>
            </div>
        </div>
        
        <div class="status-section">
            <div class="tracking-status-title">📍 Status Pengiriman</div>
            <div class="timeline" id="timeline">
                <div class="progress-bar"></div>
                <svg class="ocean-wave" viewBox="0 0 80 400" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="oceanGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#60a5fa" />
                            <stop offset="50%" stop-color="#3b82f6" />
                            <stop offset="100%" stop-color="#1e40af" />
                        </linearGradient>
                        <filter id="wave-shadow">
                            <feDropShadow dx="2" dy="2" stdDeviation="3" flood-opacity="0.3"/>
                        </filter>
                    </defs>
                    <path d="M0,20 Q20,0 40,20 T80,20 L80,400 L0,400 Z" 
                          fill="url(#oceanGrad)" 
                          filter="url(#wave-shadow)"
                          opacity="0.8">
                        <animate attributeName="d" 
                                 values="M0,20 Q20,0 40,20 T80,20 L80,400 L0,400 Z;
                                         M0,10 Q20,30 40,10 T80,10 L80,400 L0,400 Z;
                                         M0,20 Q20,0 40,20 T80,20 L80,400 L0,400 Z" 
                                 dur="4s" 
                                 repeatCount="indefinite"/>
                    </path>
                </svg>
                
                <div id="cruiseShip" class="cruise-ship" style="top: 20px;">
                    <svg viewBox="0 0 64 64" width="64" height="64" fill="none">
                        <!-- Ship Shadow -->
                        <ellipse cx="32" cy="58" rx="24" ry="6" fill="rgba(59, 130, 246, 0.3)" />
                        
                        <!-- Ship Hull -->
                        <path d="M8 42 L56 42 Q52 52 32 54 Q12 52 8 42 Z" 
                              fill="#1e293b" 
                              stroke="#0f172a" 
                              stroke-width="2" />
                        
                        <!-- Ship Deck -->
                        <rect x="12" y="36" width="40" height="6" rx="3" 
                              fill="#3b82f6" 
                              stroke="#1e40af" 
                              stroke-width="1.5" />
                        
                        <!-- Containers -->
                        <rect x="14" y="28" width="8" height="8" rx="2" 
                              fill="#fbbf24" 
                              stroke="#d97706" 
                              stroke-width="1.5" />
                        <rect x="24" y="26" width="8" height="10" rx="2" 
                              fill="#f87171" 
                              stroke="#dc2626" 
                              stroke-width="1.5" />
                        <rect x="34" y="27" width="8" height="9" rx="2" 
                              fill="#34d399" 
                              stroke="#059669" 
                              stroke-width="1.5" />
                        <rect x="44" y="29" width="6" height="7" rx="2" 
                              fill="#60a5fa" 
                              stroke="#2563eb" 
                              stroke-width="1.5" />
                        
                        <!-- Ship Bridge -->
                        <rect x="48" y="18" width="6" height="12" rx="2" 
                              fill="#1e40af" 
                              stroke="#1e3a8a" 
                              stroke-width="1.5" />
                        
                        <!-- Smoke Stack -->
                        <rect x="50" y="12" width="2" height="8" rx="1" fill="#374151" />
                        
                        <!-- Smoke Clouds -->
                        <circle cx="51" cy="10" r="2" fill="#cbd5e1" opacity="0.8">
                            <animate attributeName="opacity" values="0.8;0.4;0.8" dur="2s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="53" cy="8" r="1.5" fill="#e2e8f0" opacity="0.6">
                            <animate attributeName="opacity" values="0.6;0.2;0.6" dur="2.5s" repeatCount="indefinite"/>
                        </circle>
                        
                        <!-- Ship Windows -->
                        <circle cx="51" cy="24" r="1.5" fill="#fef3c7" opacity="0.9" />
                        <rect x="15" y="46" width="2" height="1" rx="0.5" fill="#fff" opacity="0.8" />
                        <rect x="20" y="46" width="2" height="1" rx="0.5" fill="#fff" opacity="0.8" />
                        <rect x="25" y="46" width="2" height="1" rx="0.5" fill="#fff" opacity="0.8" />
                        <rect x="30" y="46" width="2" height="1" rx="0.5" fill="#fff" opacity="0.8" />
                        <rect x="35" y="46" width="2" height="1" rx="0.5" fill="#fff" opacity="0.8" />
                        <rect x="40" y="46" width="2" height="1" rx="0.5" fill="#fff" opacity="0.8" />
                        
                        <!-- Ship Flag -->
                        <polygon points="54,18 58,18 58,22 54,20" fill="#dc2626" opacity="0.9">
                            <animateTransform attributeName="transform" 
                                              type="rotate" 
                                              values="0 56 20;5 56 20;-5 56 20;0 56 20" 
                                              dur="3s" 
                                              repeatCount="indefinite"/>
                        </polygon>
                    </svg>
                </div>
                  @php
                    // Definisikan tahapan pengiriman berdasarkan status order
                    // Default ke step 1 (proses) jika pesanan sudah dibayar
                    $currentStep = 1; // Mulai dari step 1 karena pesanan sudah paid
                    $shippingStatus = $order->shipping_status ?? 'processing';
                    
                    switch($shippingStatus) {
                        case 'pending':
                            $currentStep = 0;
                            break;
                        case 'processing':
                            $currentStep = 1;
                            break;
                        case 'shipped':
                            $currentStep = 2;
                            break;
                        case 'in_transit':
                            $currentStep = 3;
                            break;
                        case 'delivered':
                            $currentStep = 4;
                            break;
                        default:
                            $currentStep = 1; // Default untuk paid orders
                            break;
                    }
                    
                    $steps = [
                        [
                            'title' => '🏭 Order Diterima di Gudang',
                            'date' => $order->created_at->format('d M Y, H:i') . ' WIB',
                            'desc' => 'Pesanan Anda telah diterima dan sedang dipersiapkan',
                            'status' => 0
                        ],
                        [
                            'title' => '📋 Verifikasi & Packing',
                            'date' => $order->created_at->addHours(2)->format('d M Y, H:i') . ' WIB',
                            'desc' => 'Produk sedang diverifikasi dan dikemas dengan aman',
                            'status' => 1
                        ],
                        [
                            'title' => '🛃 Proses Bea Cukai',
                            'date' => $order->created_at->addDay()->format('d M Y, H:i') . ' WIB',
                            'desc' => 'Paket sedang dalam proses pemeriksaan bea cukai',
                            'status' => 2
                        ],
                        [
                            'title' => '🌊 Pengiriman Laut ke Negara Tujuan',
                            'date' => $order->created_at->addDays(2)->format('d M Y, H:i') . ' WIB',
                            'desc' => 'Paket telah dimuat ke kapal kargo menuju negara tujuan',
                            'status' => 3
                        ],
                        [
                            'title' => '📦 Paket Sampai di Tujuan',
                            'date' => 'Perkiraan: ' . $order->created_at->addDays(7)->format('d M Y'),
                            'desc' => 'Paket telah sampai dan siap untuk diterima',
                            'status' => 4
                        ]
                    ];
                @endphp

                @foreach($steps as $index => $step)
                    <div class="timeline-step {{ $index < $currentStep ? 'completed' : ($index == $currentStep ? 'active' : '') }}">
                        <div class="timeline-step-title {{ $index < $currentStep ? 'completed' : ($index > $currentStep ? 'gray' : '') }}">
                            {{ $step['title'] }}
                        </div>
                        <div class="timeline-step-date {{ $index > $currentStep ? 'gray' : '' }}">
                            {{ $step['date'] }}
                        </div>
                        <div class="timeline-step-desc">{{ $step['desc'] }}</div>
                        <span class="status-badge {{ $index < $currentStep ? 'status-completed' : ($index == $currentStep ? 'status-active' : 'status-pending') }}">
                            {{ $index < $currentStep ? 'Selesai' : ($index == $currentStep ? 'Sedang Diproses' : 'Menunggu') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.timeline-step');
            const cruiseShip = document.getElementById('cruiseShip');
            const currentStep = {{ $currentStep }};

            function updateShipPosition() {
                if (currentStep < steps.length && currentStep >= 0) {
                    const step = steps[currentStep];
                    const top = step.offsetTop - 20;
                    cruiseShip.style.top = top + 'px';
                }
            }

            // Set posisi kapal berdasarkan step saat ini
            updateShipPosition();
            
            // Update posisi saat window resize
            window.addEventListener('resize', updateShipPosition);
        });
    </script>
</body>
</html>
