<!-- filepath: c:\laragon\www\TriadGo\resources\views\invoice.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_id }} - TriadGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'triad-blue': '#1e3a8a',
                        'triad-green': '#059669',
                        'triad-orange': '#f97316', 
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 p-4">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-triad-blue to-triad-green text-white p-8">
            <div class="flex justify-between items-start">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('tglogo.png') }}" alt="Logo" class="h-16 w-16 mr-2" style="width: 100px; height: 100px" />
                    <div class="ml-4">
                        <h2 class="text-3xl font-bold">INVOICE</h2>
                        <p class="text-blue-100 mt-1 text-lg">Invoice #{{ $order->order_id }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-lg font-medium text-blue-100">TriadGo Global Trade Solutions</div>
                    <p class="text-blue-100 mt-2">Jl. Sudirman No. 123</p>
                    <p class="text-blue-100">Jakarta 12345, Indonesia</p>
                    <p class="text-blue-100">Phone: +62 21 123-4567</p>
                    <p class="text-blue-100">Email: admin@triadgo.com</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div>
                    <h3 class="text-xl font-bold text-triad-blue mb-4 border-b-2 border-triad-orange pb-2">Bill To:</h3>
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl border-l-4 border-triad-green">
                        <p class="font-bold text-gray-800 text-lg">{{ $order->full_name }}</p>
                        <p class="text-gray-600 mt-1">{{ $order->email }}</p>
                        <p class="text-gray-600">{{ $order->address }}</p>
                        <p class="text-gray-600">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                        <p class="text-gray-600">{{ $order->country }}</p>
                        <p class="text-gray-600 mt-2">Phone: {{ $order->phone }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-triad-blue mb-4 border-b-2 border-triad-orange pb-2">Invoice Details:</h3>
                    <div class="bg-gradient-to-br from-triad-blue/5 to-triad-green/5 p-6 rounded-xl border-l-4 border-triad-blue">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Invoice Date:</span>
                                <span class="font-bold text-gray-800">{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Due Date:</span>
                                <span class="font-bold text-gray-800">{{ $order->created_at->addDays(14)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Payment Method:</span>
                                <span class="font-bold text-gray-800">{{ ucfirst($order->payment_method ?? 'Midtrans') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-medium">Status:</span>
                                @php
                                    $statusColor = match($order->status) {
                                        'paid' => 'from-triad-green to-green-600',
                                        'pending' => 'from-triad-orange to-yellow-500',
                                        'failed' => 'from-red-500 to-red-600',
                                        'cancelled' => 'from-gray-500 to-gray-600',
                                        default => 'from-triad-orange to-yellow-500'
                                    };
                                @endphp
                                <span class="bg-gradient-to-r {{ $statusColor }} text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-10">
                <h3 class="text-xl font-bold text-triad-blue mb-6 border-b-2 border-triad-orange pb-2">Order Items:</h3>
                <div class="overflow-x-auto rounded-xl shadow-lg">
                    <table class="w-full border-collapse bg-white">
                        <thead>
                            <tr class="bg-gradient-to-r from-triad-blue to-triad-green text-white">
                                <th class="px-6 py-4 text-left font-bold">Product</th>
                                <th class="px-6 py-4 text-center font-bold">Qty</th>
                                <th class="px-6 py-4 text-right font-bold">Unit Price</th>
                                <th class="px-6 py-4 text-right font-bold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->cart_items as $index => $item)
                                @php
                                    $itemTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                    $hoverClass = match($index % 3) {
                                        0 => 'hover:bg-triad-blue/5',
                                        1 => 'hover:bg-triad-green/5',
                                        2 => 'hover:bg-triad-orange/5',
                                        default => 'hover:bg-gray-50'
                                    };
                                    $totalClass = match($index % 3) {
                                        0 => 'text-triad-blue',
                                        1 => 'text-triad-green', 
                                        2 => 'text-triad-orange',
                                        default => 'text-gray-800'
                                    };
                                @endphp
                                <tr class="border-b border-gray-200 {{ $hoverClass }} transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="font-medium text-gray-800">{{ $item['name'] ?? 'Product' }}</div>
                                            @if(isset($item['description']) && $item['description'])
                                                <div class="text-sm text-gray-500 mt-1">{{ $item['description'] }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-600">{{ $item['quantity'] ?? 1 }}</td>
                                    <td class="px-6 py-4 text-right text-gray-800">
                                        {{ $order->currency === 'IDR' ? 'Rp ' : '$' }}{{ number_format($item['price'] ?? 0, $order->currency === 'IDR' ? 0 : 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold {{ $totalClass }}">
                                        {{ $order->currency === 'IDR' ? 'Rp ' : '$' }}{{ number_format($itemTotal, $order->currency === 'IDR' ? 0 : 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end mb-10">
                <div class="w-full md:w-1/2">
                    <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-xl shadow-lg border-2 border-gray-200">
                        <div class="space-y-4">
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600 font-medium">Subtotal:</span>
                                <span class="font-bold text-gray-800">{{ $order->formatted_total }}</span>
                            </div>
                            @if($order->shipping_cost > 0)
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600 font-medium">Shipping:</span>
                                <span class="font-bold text-gray-800">
                                    {{ $order->currency === 'IDR' ? 'Rp ' : '$' }}{{ number_format($order->shipping_cost, $order->currency === 'IDR' ? 0 : 2) }}
                                </span>
                            </div>
                            @endif
                            @if($order->tax_amount > 0)
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600 font-medium">Tax:</span>
                                <span class="font-bold text-gray-800">
                                    {{ $order->currency === 'IDR' ? 'Rp ' : '$' }}{{ number_format($order->tax_amount, $order->currency === 'IDR' ? 0 : 2) }}
                                </span>
                            </div>
                            @endif
                            @if($order->discount_amount > 0)
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600 font-medium">Discount:</span>
                                <span class="font-bold text-red-600">
                                    -{{ $order->currency === 'IDR' ? 'Rp ' : '$' }}{{ number_format($order->discount_amount, $order->currency === 'IDR' ? 0 : 2) }}
                                </span>
                            </div>
                            @endif
                            <div class="border-t-2 border-triad-orange pt-4">
                                <div class="flex justify-between">
                                    <span class="text-2xl font-bold text-gray-800">Grand Total:</span>
                                    <span class="text-2xl font-bold text-triad-blue">
                                        {{ $order->formatted_total }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8 p-8 bg-gradient-to-r from-triad-blue/10 to-triad-green/10 rounded-xl border-l-4 border-triad-orange">
                <h3 class="text-xl font-bold text-triad-blue mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-triad-green" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 114 0 2 2 0 01-4 0zm8-1a1 1 0 100 2 1 1 0 000-2z"/>
                    </svg>
                    Payment Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <p class="text-gray-700"><strong class="text-triad-blue">Order ID:</strong> {{ $order->order_id }}</p>
                        <p class="text-gray-700"><strong class="text-triad-blue">Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'Midtrans') }}</p>
                        @if($order->payment_gateway_order_id)
                        <p class="text-gray-700"><strong class="text-triad-blue">Gateway Order ID:</strong> {{ $order->payment_gateway_order_id }}</p>
                        @endif
                        @if($order->payment_gateway_transaction_id)
                        <p class="text-gray-700"><strong class="text-triad-blue">Transaction ID:</strong> {{ $order->payment_gateway_transaction_id }}</p>
                        @endif
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-700"><strong class="text-triad-green">Currency:</strong> {{ $order->currency }}</p>
                        <p class="text-gray-700"><strong class="text-triad-green">Order Date:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                        @if($order->payment_completed_at)
                        <p class="text-gray-700"><strong class="text-triad-green">Payment Date:</strong> {{ $order->payment_completed_at->format('d M Y H:i') }}</p>
                        @endif
                        @if($order->notes)
                        <p class="text-gray-700"><strong class="text-triad-green">Notes:</strong> {{ $order->notes }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t-2 border-gray-200">
                <div class="text-center">
                    <div class="flex justify-center items-center mb-4">
                        <img src="{{ asset('tglogo.png') }}" alt="Logo" class="h-8 w-8 mr-2" style="width: 32px; height: 32px" />
                        <h4 class="text-2xl font-bold text-triad-blue mr-1">Triad</h4>
                        <h4 class="text-2xl font-bold text-triad-orange">Go</h4>
                    </div>
                    <p class="text-gray-600 mb-3 text-lg">Thank you for choosing TriadGo for your global trade needs!</p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200 no-print">
            <div class="flex justify-center space-x-4">
                <button onclick="window.print()" 
                        class="bg-gradient-to-r from-triad-blue to-triad-green hover:from-triad-blue/80 hover:to-triad-green/80 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg transform hover:scale-105">
                    🖨️ Print Invoice
                </button>
                <button onclick="window.history.back()" 
                        class="bg-gradient-to-r from-triad-orange to-yellow-500 hover:from-triad-orange/80 hover:to-yellow-500/80 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg transform hover:scale-105">
                    ⬅️ Back
                </button>
            </div>
        </div>
    </div>

   <style>
    @media print {
        body { 
            background: white !important; 
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .no-print { 
            display: none !important; 
        }
        .shadow-lg, .shadow-xl {
            box-shadow: none !important;
        }
        
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .bg-gradient-to-r {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .text-white {
            color: white !important;
        }
        
        .text-triad-blue {
            color: #1e3a8a !important;
        }
        
        .text-triad-orange {
            color: #f97316 !important;
        }
        
        .text-triad-green {
            color: #059669 !important;
        }
        
        .bg-gradient-to-r.from-triad-blue.to-triad-green {
            background: linear-gradient(to right, #1e3a8a, #059669) !important;
            -webkit-print-color-adjust: exact !important;
        }
        
        thead tr {
            background: linear-gradient(to right, #1e3a8a, #059669) !important;
            -webkit-print-color-adjust: exact !important;
        }
        
        .border-triad-orange {
            border-color: #f97316 !important;
        }
        
        .border-triad-green {
            border-color: #059669 !important;
        }
        
        .border-triad-blue {
            border-color: #1e3a8a !important;
        }
    }

    @page {
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
        print-color-adjust: exact;
    }
</style>
</body>
</html>