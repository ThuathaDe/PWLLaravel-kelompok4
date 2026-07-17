@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('nav-info', 'Dashboard Admin')

@section('content')
    <p class="font-mono-label text-xs mb-1" style="color: var(--mustard-dark);">PESANAN MASUK</p>
    <h1 class="font-marker text-2xl mb-6">Monitoring Real-time</h1>

    <a href="{{ route('admin.produk.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Lihat Daftar Produk 
    </a>
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
                    tombol = `<button onclick="ubahStatus(${p.id}, 'proses')" class="btn-mustard px-3 py-1 rounded text-sm font-medium">Proses</button>`;
                } else if (p.status === 'proses') {
                    tombol = `<button onclick="ubahStatus(${p.id}, 'selesai')" class="btn-clay px-3 py-1 rounded text-sm font-medium">Tandai Selesai</button>`;
                }

                return `
                    <div class="border rounded-lg p-4 shadow bg-white">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Meja ${p.nomor_meja}</span>
                            <span class="font-mono-label text-xs px-2 py-1 rounded" style="background: var(--paper); border: 1px solid var(--paper-line); color: var(--ink-soft);">${p.status.toUpperCase()}</span>
                        </div>

                        <div class="text-xs mb-2 flex justify-between" style="color: var(--ink-soft);">
                            <span>Masuk ${p.dibuat_pukul}</span>
                            <span style="color: var(--clay-dark); font-weight: 600;">Estimasi ${p.estimasi_selesai_pukul} (${p.estimasi_menit} mnt)</span>
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
