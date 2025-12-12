<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMS Mini - Jawara Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto Mono', monospace; background-color: #1a202c; color: #e2e8f0; }
        .glass { background: rgba(45, 55, 72, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="p-6 min-h-screen">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
            <div>
                <h1 class="text-3xl font-bold text-orange-500">📦 GUDANG SYSTEM</h1>
                <p class="text-gray-400 text-sm">Warehouse Management v1.0</p>
            </div>
            <div class="text-right">
                <span class="bg-gray-800 text-gray-300 px-3 py-1 rounded text-xs border border-gray-600">
                    SERVER: {{ request()->server('SERVER_ADDR') }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-900 border border-green-500 text-green-300 p-3 rounded mb-4 text-sm font-bold">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-900 border border-red-500 text-red-300 p-3 rounded mb-4 text-sm font-bold">❌ {{ session('error') }}</div>
        @endif

        <div class="glass p-6 rounded-lg mb-8 shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-gray-300 border-l-4 border-orange-500 pl-3">Input Barang Masuk</h2>
            <form action="{{ route('products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Nama Barang (ex: Kabel LAN)" class="p-2 bg-gray-800 border border-gray-600 rounded text-white focus:border-orange-500 outline-none" required>
                <input type="text" name="location" placeholder="Lokasi Rak (ex: A-12)" class="p-2 bg-gray-800 border border-gray-600 rounded text-white focus:border-orange-500 outline-none" required>
                <input type="number" name="stock" placeholder="Stok Awal" class="p-2 bg-gray-800 border border-gray-600 rounded text-white focus:border-orange-500 outline-none" required>
                <button type="submit" class="bg-orange-600 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded transition">
                    + SIMPAN
                </button>
            </form>
        </div>

        <div class="glass rounded-lg overflow-hidden shadow-lg">
            <table class="w-full text-left">
                <thead class="bg-gray-800 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">Nama Barang</th>
                        <th class="p-4 text-center">Stok Saat Ini</th>
                        <th class="p-4 text-center">Aksi Cepat</th>
                        <th class="p-4 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($products as $item)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="p-4 font-bold text-orange-400">{{ $item->location }}</td>
                        <td class="p-4 font-bold">{{ $item->name }}</td>
                        <td class="p-4 text-center">
                            <span class="text-2xl font-bold {{ $item->stock == 0 ? 'text-red-500' : 'text-white' }}">
                                {{ $item->stock }}
                            </span>
                        </td>
                        <td class="p-4 text-center flex justify-center gap-2">
                            <form action="{{ route('products.stock', $item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="out">
                                <button class="w-8 h-8 bg-red-900 border border-red-600 text-red-400 rounded hover:bg-red-700 font-bold">-</button>
                            </form>
                            <form action="{{ route('products.stock', $item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="in">
                                <button class="w-8 h-8 bg-green-900 border border-green-600 text-green-400 rounded hover:bg-green-700 font-bold">+</button>
                            </form>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('products.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?');">
                                @csrf @method('DELETE')
                                <button class="text-xs text-gray-500 hover:text-red-400 underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500 italic">Belum ada barang di gudang. Silakan input di atas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>