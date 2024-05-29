<?php

namespace App\Livewire\Employee;

use App\Models\documents_type;
use App\Models\employees;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search;
    public $sort = 'id';
    public $direction = 'desc';

    public $documents_type;

    public $openCreate = false;
    public $employeeCreate = [
        'full_name' => "",
        'document_number' => "",
        'phone' => "",
        'email' => "",
        'birthdate' => "",
        'sex' => "",
        'nationality' => "",
        'address' => "",
        'role' => "",
        'state' => "",
        'document_type_id' => ""
    ];

    public $openEdit = false;
    public $employeeEditId = "";
    public $employeeEdit = [
        'full_name' => "",
        'document_number' => "",
        'phone' => "",
        'email' => "",
        'birthdate' => "",
        'sex' => "",
        'nationality' => "",
        'address' => "",
        'role' => "",
        'state' => "",
        'document_type_id' => ""
    ];

    public function mount()
    {
        $this->documents_type = documents_type::all();
    }
    public function render()
    {
        $employees = employees::where('full_name', 'like', '%' . $this->search . '%')
            ->orWhere('document_number', 'like', '%' . $this->search . '%')
            ->orWhere('phone', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('address', 'like', '%' . $this->search . '%')
            ->orWhere('role', 'like', '%' . $this->search . '%')
            ->orWhere('nationality', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate(10, pageName: 'pageEmloyees');
        return view('livewire.employee.employee', compact('employees'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
                $this->render();
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
    public function save()
    {
        $employees = employees::create([
            'full_name' => $this->employeeCreate['full_name'],
            'document_number' => $this->employeeCreate['document_number'],
            'phone' => $this->employeeCreate['phone'],
            'email' => $this->employeeCreate['email'],
            'birthdate' => $this->employeeCreate['birthdate'],
            'sex' => $this->employeeCreate['sex'],
            'nationality' => $this->employeeCreate['nationality'],
            'address' => $this->employeeCreate['address'],
            'role' => $this->employeeCreate['role'],
            'state' => "A",
            'document_type_id' => $this->employeeCreate['document_type_id']
        ]);
        $this->resetPage(pageName: 'pageEmloyees');
        $this->openCreate = false;
        $this->reset(['employeeCreate', 'openCreate']);
    }
    public function edit($employeeId)
    {
        $this->openEdit = true;

        $this->employeeEditId = $employeeId;

        $employee = employees::find($employeeId);

        $this->employeeEdit['full_name'] = $employee->full_name;
        $this->employeeEdit['document_number'] = $employee->document_number;
        $this->employeeEdit['phone'] = $employee->phone;
        $this->employeeEdit['email'] = $employee->email;
        $this->employeeEdit['birthdate'] = $employee->birthdate;
        $this->employeeEdit['sex'] = $employee->sex;
        $this->employeeEdit['nationality'] = $employee->nationality;
        $this->employeeEdit['address'] = $employee->address;
        $this->employeeEdit['role'] = $employee->role;
        $this->employeeEdit['document_type_id'] = $employee->document_type_id;
    }
    public function update()
    {
        $employee = employees::find($this->employeeEditId);

        $employee->update([
            'full_name' => $this->employeeEdit['full_name'],
            'document_number' => $this->employeeEdit['document_number'],
            'phone' => $this->employeeEdit['phone'],
            'email' => $this->employeeEdit['email'],
            'birthdate' => $this->employeeEdit['birthdate'],
            'sex' => $this->employeeEdit['sex'],
            'nationality' => $this->employeeEdit['nationality'],
            'address' => $this->employeeEdit['address'],
            'role' => $this->employeeEdit['role'],
            'document_type_id' => $this->employeeEdit['document_type_id']
        ]);

        $this->reset(['employeeEditId', 'employeeEdit', 'openEdit']);
    }
}
