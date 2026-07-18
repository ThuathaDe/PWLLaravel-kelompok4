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

    
    <br><br>
    
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

                let tombol = '';
                if (p.status === 'pending') {
                    tombol = `<button onclick="ubahStatus(${p.id}, 'proses')" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Proses</button>`;
                } else if (p.status === 'proses') {
                    tombol = `<button onclick="ubahStatus(${p.id}, 'selesai')" class="bg-green-500 text-white px-3 py-1 rounded text-sm">Tandai Selesai</button>`;
                }

                return `
                    <div class="border rounded-lg p-4 shadow bg-white">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold">Meja ${p.nomor_meja}</span>
                            <span class="text-sm px-2 py-1 rounded bg-yellow-200">${p.status}</span>
                        </div>

                        <div class="text-xs mb-2" style="color: var(--ink-soft);">
                        <p>Tanggal Pesan : ${p.tanggal_pesan}</p>
                        <p>Masuk : ${p.dibuat_pukul}</p>
                        <p style="color: var(--clay-dark); font-weight:600;">
                        Estimasi : ${p.estimasi_selesai_pukul} (${p.estimasi_menit} mnt)
                        </p>
                        </div>

                        <ul class="text-sm mb-3" style="color: var(--ink-soft);">${items}</ul>
                        <p class="font-semibold mb-2">Total: Rp${totalFormatted}</p>
                        ${tombol}
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
        setInterval(muatPesanan, 5000);
    </script>
@endsection
