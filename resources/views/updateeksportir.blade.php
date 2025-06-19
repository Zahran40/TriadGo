<div class="container mx-auto p-4 max-w-4xl">   

    <!-- Main Tracking Cards -->
    <div class="space-y-6">
        <!-- Card 1 - In Process -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">Dalam Proses</span>
                    <p class="text-gray-500 text-sm mt-1">#TG789123456</p>
                </div>
                <a href="{{ route('trackingekspor.detail', ['id' => 1]) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                    Detail
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <h2 class="text-xl font-semibold mt-4 mb-2">Pengiriman ke Singapura</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <p class="text-sm text-gray-500">Estimasi Sampai</p>
                    <p class="font-medium">25 Juni 2025</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Terakhir Update</p>
                    <p class="font-medium">19 Jun 2025, 13:30 WIB</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lokasi Terkini</p>
                    <p class="font-medium">Pabean Singapura</p>
                </div>
            </div>
        </div>

        <!-- Card 2 - Completed -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">Selesai</span>
                    <p class="text-gray-500 text-sm mt-1">#TG456789123</p>
                </div>
                <a href="{{ route('trackingekspor.detail', ['id' => 1]) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                    Detail
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <h2 class="text-xl font-semibold mt-4 mb-2">Pengiriman ke Jepang</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <p class="text-sm text-gray-500">Terkirim Pada</p>
                    <p class="font-medium">10 Juni 2025</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Terakhir Update</p>
                    <p class="font-medium">10 Jun 2025, 09:15 WIB</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Diterima Oleh</p>
                    <p class="font-medium">Yamada Taro</p>
                </div>
            </div>
        </div>

        <!-- Card 3 - Waiting -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">Menunggu</span>
                    <p class="text-gray-500 text-sm mt-1">#TG123456789</p>
                </div>
                <a href="{{ route('trackingekspor.detail', ['id' => 1]) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                    Detail
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <h2 class="text-xl font-semibold mt-4 mb-2">Pengiriman ke Amerika</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <p class="text-sm text-gray-500">Estimasi Sampai</p>
                    <p class="font-medium">30 Juni 2025</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Terakhir Update</p>
                    <p class="font-medium">18 Jun 2025, 16:45 WIB</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lokasi Terkini</p>
                    <p class="font-medium">Gudang Jakarta</p>
                </div>
            </div>
        </div>
    </div>

</div>
