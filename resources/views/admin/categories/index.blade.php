@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Manajemen Kategori</h1>
        <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="8%">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $cat)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><span class="fw-bold text-dark">{{ $cat->name }}</span></td>
                            <td class="text-muted">{{ $cat->description ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-warning btn-sm text-white shadow-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit{{ $cat->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-white border-0">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-edit me-2"></i>Edit Kategori
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">Nama Kategori</label>
                                                <input type="text" name="name" class="form-control form-control-lg" value="{{ $cat->name }}" required>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-bold text-secondary">Deskripsi</label>
                                                <textarea name="description" class="form-control" rows="4">{{ $cat->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-3">
                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning text-white px-4 shadow-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Nama Kategori</label>
                        <input type="text" name="name" class="form-control form-control-lg" placeholder="Contoh: Laptop" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold text-secondary">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail kategori ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection