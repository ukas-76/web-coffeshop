@extends('layouts.admin')

@section('title', 'Daftar Pesanan | Portal Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Daftar Pesanan</h3>
        <p class="text-muted mb-0 small">Kelola seluruh transaksi pesanan (Delivery/Pick-up).</p>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select bg-dark text-white border-0 shadow-none" style="border: 1px solid var(--border-color) !important;">
            <option value="all">Semua Status</option>
            <option value="pending">Diproses</option>
            <option value="completed">Selesai</option>
        </select>
        <button class="btn btn-admin btn-sm px-3 rounded-pill text-nowrap"><i class="bi bi-funnel me-1"></i> Filter</button>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal & Waktu</th>
                    <th>Pelanggan</th>
                    <th>Jenis Pesanan</th>
                    <th>Total Transaksi</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold text-white">#ORD-9021</td>
                    <td class="text-muted small">26 Apr 2026, 14:30</td>
                    <td>
                        <div class="fw-bold text-white">Bapak Budi Santoso</div>
                        <div class="small text-muted">+62 812-3456-7890</div>
                    </td>
                    <td><span class="badge bg-secondary">Pick-up</span></td>
                    <td class="fw-bold">Rp 150.000</td>
                    <td><span class="badge-status badge-completed">Selesai</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary ms-1"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-white">#ORD-9022</td>
                    <td class="text-muted small">26 Apr 2026, 15:05</td>
                    <td>
                        <div class="fw-bold text-white">Ibu Siti Aminah</div>
                        <div class="small text-muted">+62 878-1234-5678</div>
                    </td>
                    <td><span class="badge bg-info text-dark">Delivery</span></td>
                    <td class="fw-bold">Rp 85.000</td>
                    <td><span class="badge-status badge-pending">Diproses</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary ms-1"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-white">#ORD-9023</td>
                    <td class="text-muted small">26 Apr 2026, 15:45</td>
                    <td>
                        <div class="fw-bold text-white">Andi Darmawan</div>
                        <div class="small text-muted">+62 856-9876-5432</div>
                    </td>
                    <td><span class="badge bg-secondary">Pick-up</span></td>
                    <td class="fw-bold">Rp 210.000</td>
                    <td><span class="badge-status badge-completed">Selesai</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary ms-1"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-white">#ORD-9024</td>
                    <td class="text-muted small">26 Apr 2026, 16:10</td>
                    <td>
                        <div class="fw-bold text-white">Maya Sari</div>
                        <div class="small text-muted">+62 811-2233-4455</div>
                    </td>
                    <td><span class="badge bg-info text-dark">Delivery</span></td>
                    <td class="fw-bold">Rp 45.000</td>
                    <td><span class="badge-status badge-pending">Diproses</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary ms-1"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold text-white">#ORD-9025</td>
                    <td class="text-muted small">26 Apr 2026, 16:30</td>
                    <td>
                        <div class="fw-bold text-white">Rizky Aditya</div>
                        <div class="small text-muted">+62 813-5566-7788</div>
                    </td>
                    <td><span class="badge bg-secondary">Pick-up</span></td>
                    <td class="fw-bold">Rp 120.000</td>
                    <td><span class="badge-status badge-pending">Diproses</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary ms-1"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
        <span class="text-muted small">Menampilkan 1 hingga 5 dari 45 pesanan</span>
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
