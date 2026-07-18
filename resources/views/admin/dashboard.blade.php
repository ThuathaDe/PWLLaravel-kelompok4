@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('nav-info', 'Dashboard Admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <p class="font-mono-label text-xs mb-1" style="color: var(--mustard-dark);">PESANAN MASUK</p>
        <h1 class="font-marker text-2xl">Monitoring Real-time</h1>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pesanan.buat') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-semibold text-sm">
            + Buat Pesanan
        </a>
        <a href="{{ route('admin.produk.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-semibold text-sm">
            Lihat Daftar Produk
        </a>
    </div>
</div>

<div id="daftar-pesanan" class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <p style="color: var(--ink-soft);">Memuat data pesanan...</p>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function renderPesanan(list) {
        const container = document.getElementById('daftar-pesanan');

        if (list.length === 0) {
            container.innerHTML = '<p style="color: var(--ink-soft);">Tidak ada pesanan aktif saat ini.</p>';
            return;
        }

        container.innerHTML = list.map(p => {
            const items = p.items.map(i => `<li>${i.nama_produk} x${i.jumlah}</li>`).join('');
            const totalFormatted = Number(p.total_harga).toLocaleString('id-ID');

            let tombolStatus = '';
            if (p.status === 'pending') {
                tombolStatus = `<button onclick="ubahStatus(${p.id}, 'proses')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">Proses</button>`;
            } else if (p.status === 'proses') {
                tombolStatus = `<button onclick="ubahStatus(${p.id}, 'selesai')" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-semibold">Tandai Selesai</button>`;
            }

            // Tombol Bayar HILANG total jika status sudah 'paid'
            let tombolBayar = '';
            if (p.status_pembayaran !== 'paid') {
                tombolBayar = `
                    <a href="/admin/pesanan/${p.id}/bayar" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm font-semibold inline-block text-center text-white">
                        Bayar Langsung
                    </a>
                `;
            }

            let tombolAksi = [tombolBayar, tombolStatus].filter(Boolean).join('');
            const editAttr = p.status === 'selesai' ? 'style="pointer-events:none;opacity:0.5;"' : '';

            return `
                <div class="border rounded-lg p-4 shadow bg-white flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-bold text-xl text-gray-800">Meja ${p.nomor_meja}</span>
                            <span class="text-sm px-3 py-1 rounded font-semibold bg-yellow-100 text-yellow-800">${p.status}</span>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-700">Pembayaran</span>
                            <span class="text-sm px-3 py-0.5 rounded font-semibold ${p.status_pembayaran === 'paid' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'}">
                                ${p.status_pembayaran}
                            </span>
                        </div>

                        <div class="text-xs mb-3 space-y-1 bg-gray-50 p-2 rounded text-gray-600">
                            <p>Tanggal Pesan : ${p.tanggal_pesan} | Masuk : ${p.dibuat_pukul}</p>
                            <p class="font-semibold text-amber-700">
                                Estimasi : ${p.estimasi_selesai_pukul} (${p.estimasi_menit} mnt)
                            </p>
                            ${p.tanggal_bayar ? `<p class="text-green-600 font-medium">Dibayar: ${p.tanggal_bayar}</p>` : ''}
                            ${p.uang_kembalian && p.uang_kembalian > 0 ? `<p class="text-blue-600 font-medium">Kembalian: Rp${Number(p.uang_kembalian).toLocaleString('id-ID')}</p>` : ''}
                        </div>

                        <ul class="text-sm mb-4 list-disc list-inside text-gray-700">${items}</ul>
                    </div>

                    <div>
                        <p class="font-bold text-base mb-3 border-t pt-2 text-gray-900">Total: Rp${totalFormatted}</p>
                        <div class="flex gap-2 flex-wrap">
                            ${tombolAksi}
                            <a href="/admin/pesanan/${p.id}/edit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded text-sm font-semibold" ${editAttr}>Edit</a>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function muatPesanan() {
        fetch('{{ route("admin.dashboard.data") }}')
            .then(res => res.json())
            .then(data => renderPesanan(data))
            .catch(err => console.error('Gagal memuat data:', err));
    }

    function ubahStatus(id, status) {
        fetch(`/admin/pesanan/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ status }),
        })
        .then(res => res.json())
        .then(() => muatPesanan())
        .catch(err => console.error('Gagal ubah status:', err));
    }

    muatPesanan();
    setInterval(muatPesanan, 5000); // Polling otomatis setiap 5 detik
</script>
@endsection
