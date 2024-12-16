<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Employee;
use Livewire\Component;

class SalaryComponent extends Component
{
    public $attandances;
    public $employees, $employee, $employeeSalary;
    public $statistics = null;
    public function mount()
    {
        $this->attandances = Attendance::all();
        $this->employees = Employee::all();
    }
    public function render()
    {
        return view('livewire.salary-component')->layout('components.layouts.admin');
    }
    public function findEmployee()
    {
        $this->statistics = Attendance::where('employee_id', $this->employee)->get();
        $this->employeeSalary = Employee::where('id', $this->employee)->first();
    }
}
