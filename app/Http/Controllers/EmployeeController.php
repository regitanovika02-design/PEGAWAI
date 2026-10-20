<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->get();
        $departments = Department::all();
        return view('employees.index', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|gt:0',
            'joined_at' => 'required|date',
        ], [
            'name.required' => 'Nama pegawai tidak boleh kosong.',
            'department_id.required' => 'Departemen wajib dipilih.',
            'department_id.exists' => 'Departemen tidak valid.',
            'position.required' => 'Jabatan tidak boleh kosong.',
            'salary.required' => 'Gaji tidak boleh kosong.',
            'salary.gt' => 'Gaji harus berupa angka lebih besar dari nol.',
            'joined_at.required' => 'Tanggal bergabung tidak boleh kosong.',
            'joined_at.date' => 'Format tanggal bergabung tidak valid.',
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|gt:0',
            'joined_at' => 'required|date',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}