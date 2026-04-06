@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Manajemen Alat</h1>
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAlat">
            <i class="fas fa-plus-circle me-2"></i>Tambah Alat
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Gambar</th>
                            <th>Kode</th>
                            <th>Nama Alat</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tools as $tool)
                        <tr>
                            <td>
                                @if($tool->image)
                                    <img src="{{ asset('storage/' . $tool->image) }}" width="50" class="rounded shadow-sm">
                                @else
                                    <span class="badge bg-secondary text-white">No Image</span>
                                @endif
                            </td>
                            <td><code>{{ $tool->code }}</code></td>
                            <td class="fw-bold">{{ $tool->name }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $tool->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td>{{ $tool->stock }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $tool->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.tools.destroy', $tool->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus alat ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $tool->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('admin.tools.update', $tool->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
                                    @csrf @method('PUT')
                                    <div class="modal-header bg-warning text-white border-0">
                                        <h5 class="modal-title fw-bold">Edit Alat: {{ $tool->name }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Kategori</label>
                                                <select name="category_id" class="form-select" required>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $tool->category_id == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Kode Alat</label>
                                                <input type="text" name="code" class="form-control" value="{{ $tool->code }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nama Alat</label>
                                            <input type="text" name="name" class="form-control" value="{{ $tool->name }}" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Stok</label>
                                                <input type="number" name="stock" class="form-control" value="{{ $tool->stock }}" required>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <label class="form-label fw-bold">Foto Baru (Opsional)</label>
                                                <input type="file" name="image" class="form-control">
                                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label fw-bold">Deskripsi</label>
                                            <textarea name="description" class="form-control" rows="3">{{ $tool->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning px-4 shadow-sm text-white">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada data alat yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAlat" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.tools.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
            @csrf
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold">Tambah Alat Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Alat</label>
                        <input type="text" name="code" class="form-control" placeholder="Contoh: ALT-001" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Alat</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Stok</label>
                        <input type="number" name="stock" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Foto Alat</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Alat</button>
            </div>
        </form>
    </div>
</div>
@endsection