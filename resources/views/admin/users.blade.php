@extends('layouts.admin')

@section('title', 'Daftar Pengguna | Portal Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Daftar Pengguna Aktif</h3>
        <p class="text-muted mb-0 small">Pantau status pendaftaran anggota dan riwayat pelanggan.</p>
    </div>
    <div class="d-flex align-items-center gap-2 bg-dark rounded-pill px-3 py-1" style="border: 1px solid var(--border-color);">
        <i class="bi bi-search text-muted"></i>
        <input type="text" placeholder="Cari nama atau nomor HP..." class="bg-transparent border-0 text-white shadow-none form-control form-control-sm" style="outline: none; box-shadow: none;">
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Kontak Email</th>
                    <th>No. WhatsApp</th>
                    <th>Member Tier</th>
                    <th>Total Poin</th>
                    <th>Bergabung Sejak</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=d4b59d&color=1e1b1a" alt="User" class="rounded-circle" width="40" height="40">
                            <div>
                                <div class="fw-bold text-white">Budi Santoso</div>
                                <div class="small text-muted">Aktivitas terakhir: 2 Hari yll</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-white small">budi.santoso@example.com</td>
                    <td class="text-white small">+62 812-3456-7890</td>
                    <td><span class="badge text-dark" style="background-color: #ffd700;">Gold Member</span></td>
                    <td class="fw-bold text-white">1,250 Pts</td>
                    <td class="text-muted small">01 Jan 2025</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=5c3d2e&color=fff" alt="User" class="rounded-circle" width="40" height="40">
                            <div>
                                <div class="fw-bold text-white">Siti Aminah</div>
                                <div class="small text-muted">Aktivitas terakhir: Hari ini</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-white small">siti.aminah123@example.com</td>
                    <td class="text-white small">+62 878-1234-5678</td>
                    <td><span class="badge text-dark bg-light">Silver Member</span></td>
                    <td class="fw-bold text-white">450 Pts</td>
                    <td class="text-muted small">15 Mar 2025</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Andi+Darmawan&background=d4b59d&color=1e1b1a" alt="User" class="rounded-circle" width="40" height="40">
                            <div>
                                <div class="fw-bold text-white">Andi Darmawan</div>
                                <div class="small text-muted">Aktivitas terakhir: 5 Hari yll</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-white small">andi.d@domain.com</td>
                    <td class="text-white small">+62 856-9876-5432</td>
                    <td><span class="badge text-white" style="background-color: #a87d60;">Bronze Member</span></td>
                    <td class="fw-bold text-white">85 Pts</td>
                    <td class="text-muted small">02 Oct 2025</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
        <span class="text-muted small">Menampilkan 1 hingga 3 dari 124 pengguna</span>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0" data-bs-theme="dark">
                <li class="page-item disabled"><a class="page-link bg-dark text-muted border-secondary" href="#">Sebelumnya</a></li>
                <li class="page-item active"><a class="page-link" style="background-color: var(--admin-accent); color: var(--admin-dark); border-color: var(--admin-accent);" href="#">1</a></li>
                <li class="page-item"><a class="page-link bg-dark text-white border-secondary" href="#">2</a></li>
                <li class="page-item"><a class="page-link bg-dark text-white border-secondary" href="#">3</a></li>
                <li class="page-item"><a class="page-link bg-dark text-white border-secondary" href="#">Selanjutnya</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection
