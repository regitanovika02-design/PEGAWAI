@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0 fw-bold text-dark">Daftar Departemen</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            + Tambah Departemen
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 10%;">ID</th>
                    <th style="width: 45%;">Nama Departemen</th>
                    <th style="width: 25%;">Jumlah Pegawai</th>
                    <th style="width: 20%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                <tr>
                    <td><span class="fw-bold">#{{ $dept->id }}</span></td>
                    <td>{{ $dept->name }}</td>
                    <td>
                        <span class="badge bg-secondary rounded-pill px-3 py-2">
                            {{ $dept->employees_count ?? 0 }} Orang
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning me-1 text-white" data-bs-toggle="modal" data-bs-target="#editModal{{ $dept->id }}">
                            Edit
                        </button>
                        <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus departemen ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $dept->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('departments.update', $dept->id) }}" method="POST">
                            @csrf 
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Departemen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Departemen</label>
                                        <input type="text" name="name" class="form-control" value="{{ $dept->name }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Belum ada data departemen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Departemen Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Departemen</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Keuangan, Pemasaran" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection