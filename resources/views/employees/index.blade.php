@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0 fw-bold text-dark">Daftar Pegawai</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            + Tambah Pegawai
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Departemen</th>
                    <th>Jabatan</th>
                    <th>Gaji</th>
                    <th>Tanggal Bergabung</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                <tr>
                    <td class="fw-semibold">{{ $emp->name }}</td>
                    <td>
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill">
                            {{ $emp->department->name ?? '-' }}
                        </span>
                    </td>
                    <td>{{ $emp->position }}</td>
                    <td class="fw-bold text-success">
                        Rp {{ number_format($emp->salary, 0, ',', '.') }}
                    </td>
                    <td>{{ $emp->joined_at }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning me-1 text-white" data-bs-toggle="modal" data-bs-target="#editModal{{ $emp->id }}">
                            Edit
                        </button>
                        <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pegawai ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $emp->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('employees.update', $emp->id) }}" method="POST">
                            @csrf 
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Pegawai</label>
                                        <input type="text" name="name" class="form-control" value="{{ $emp->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Departemen</label>
                                        <select name="department_id" class="form-select" required>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}" {{ $emp->department_id == $dept->id ? 'selected' : '' }}>
                                                    {{ $dept->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" name="position" class="form-control" value="{{ $emp->position }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Gaji (Nominal Angka, Misal: 6000000)</label>
                                        <input type="number" name="salary" class="form-control" value="{{ (int)$emp->salary }}" min="1" step="1" placeholder="6000000" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Bergabung</label>
                                        <input type="date" name="joined_at" class="form-control" value="{{ $emp->joined_at }}" required>
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
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data pegawai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pegawai Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Pegawai</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Prasetyo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Departemen</label>
                        <select name="department_id" class="form-select" required>
                            <option value="">-- Pilih Departemen --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="position" class="form-control" placeholder="Contoh: Staff Keuangan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gaji (Isi Angka Tanpa Titik/Koma)</label>
                        <input type="number" name="salary" class="form-control" placeholder="Contoh: 6000000" min="1" step="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Bergabung</label>
                        <input type="date" name="joined_at" class="form-control" required>
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