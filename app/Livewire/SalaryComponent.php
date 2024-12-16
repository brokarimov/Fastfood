<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Salary;
use Carbon\Carbon;
use Livewire\Component;

class SalaryComponent extends Component
{
    public $attandances, $salaries, $paySalary, $comment;
    public $employees, $employee, $employeeSalary;
    public $statistics = null;
    public $bonus = null, $sum = 0;
    public $date;
    public $dates = [];
    public $activePayment = null;
    public $workedSalary;
    public function mount()
    {
        $this->attandances = Attendance::all();
        $this->employees = Employee::all();
        $this->salaries = Salary::all();
        $this->getDate();
    }
    public function render()
    {
        return view('livewire.salary-component')->layout('components.layouts.admin');
    }

    public function getDate()
    {
        if (!$this->date) {
            $startOfMonth = Carbon::parse(today())->startOfMonth();
            $endOfMonth = Carbon::parse(today())->endOfMonth();
        }

        $startOfMonth = Carbon::parse($this->date)->startOfMonth();
        $endOfMonth = Carbon::parse($this->date)->endOfMonth();

        $this->dates = [];
        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $this->dates[] = $date->format('Y-m-d');
        }
    }
    public function findEmployee()
    {
        $this->statistics = Attendance::where('employee_id', $this->employee)->get();
        $this->employeeSalary = Employee::where('id', $this->employee)->first();
    }
    public function giveBonus()
    {
        $employee = Employee::where('id', $this->employee)->first();
        if ($employee->user->role == 'waiter') {
            $orders = Order::where('status', 4)
                ->whereHas('waiterOrder', function ($query) use ($employee) {
                    $query->where('employee_id', $employee->id);
                })
                ->get();
        }
        if ($this->bonus != null) {
            foreach ($orders as $order) {

                $this->sum += ($order->summ * $this->bonus);
            }
        }
    }

    public function payment(Employee $employee, int $salary)
    {
        $this->workedSalary = $salary;
        $this->activePayment = $employee;
        $this->mount();
    }
    public function close()
    {
        $this->activePayment = null;
        $this->comment = '';
        $this->paySalary = '';
        $this->mount();
    }

    public function pay()
    {
        if ($this->workedSalary > $this->paySalary) {
            $salary = $this->workedSalary - $this->paySalary;
            if ($this->date == null) {
                Salary::create([
                    'employee_id' => $this->activePayment->id,
                    'salary_type' => $this->activePayment->salary_type,
                    'date' => today(),
                    'salary' => $this->activePayment->salary,
                    'given' => $this->paySalary,
                    'remainder' => $salary,
                ]);
            } else {
                Salary::create([
                    'employee_id' => $this->activePayment->id,
                    'salary_type' => $this->activePayment->salary_type,
                    'date' => $this->date,
                    'salary' => $this->activePayment->salary,
                    'given' => $this->paySalary,
                    'remainder' => $salary,
                ]);
            }
            $this->close();
        } else {
            $this->comment = 'Quantity is very much!';
            
        }
        
    }
}
