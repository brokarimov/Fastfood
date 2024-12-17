<div>
    @if ($activePayment == null)
    <div class="d-flex mb-2 mt-2">
        <h1 class="mx-2">Salary</h1>
        <button class="btn btn-primary mx-2" wire:click="{{$salaryTypeActive == false ? 'salaryTypeMixed': 'salaryTypeFixed'}}">{{$salaryTypeActive == false ? 'Mixed': 'Fixed'}}</button>
    </div>
    <input type="date" class="form-control" wire:model="date" wire:change="getDate">
    <h3 class="mt-2 text-primary">
        {{ $date ? \Carbon\Carbon::parse($date)->isoFormat('MMMM YYYY') : \Carbon\Carbon::today()->isoFormat('MMMM YYYY') }}
    </h3>
    @if ($salaryTypeActive == false)


    <div class="row">
        <div class="col-12">

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Salary type</th>
                        <th>Salary</th>
                        <th>Monthly work time</th>
                        <th>Worked hours</th>
                        <th>Worked salary</th>
                        <th>Given</th>
                        <th>Remainder</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    @if ($employee->salary_type == 'fixed')
                    @php
                    $sumOfAllLates = 0;
                    $sumOfExtraMinutes = 0;

                    foreach ($attandances->where('employee_id', $employee->id)->whereIn('date', $dates) as $attendance) {
                    $startTime = \Carbon\Carbon::parse($attendance->start_time);
                    $dayStart = \Carbon\Carbon::parse($employee->day_start);

                    if ($startTime > $dayStart) {
                    $minutesLate = $startTime->diffInMinutes($dayStart);
                    $sumOfAllLates += $minutesLate;
                    }

                    $extraHours = $attendance->time - $employee->daily_time;
                    $sumOfExtraMinutes += $extraHours * 60;
                    }


                    $baseSalary = $employee->salary / $employee->monthly_time * round($attandances->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('time')) ;

                    $latePenaltyRate = $baseSalary / $employee->monthly_time;
                    $extraBonusRate = $baseSalary / $employee->monthly_time;

                    $salary = $baseSalary
                    - $latePenaltyRate
                    @endphp
                    <tr>
                        <td>{{ $employee->user->name }}</td>

                        <td>{{$employee->salary_type}}</td>
                        <td>{{$employee->salary}}</td>
                        <td>{{$employee->monthly_time}} hours</td>
                        <td>
                            <p class="{{round($attandances->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('time')) < $employee->monthly_time ? 'text-danger' : 'text-success'}}">
                                {{round($attandances->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('time'))}}
                            </p>
                        </td>
                        <td>
                            ${{ number_format($salary, 2, '.', ',') }}

                        </td>

                        @if ($salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->isNotEmpty())
                        <td>${{ $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') }}</td>
                        <td>${{ $salary - $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') }}</td>
                        @else
                        <td>0</td>
                        <td>0</td>
                        @endif

                        <td>
                            <button class="btn btn-primary"
                                wire:click="payment({{ $employee->id }}, {{$salary - $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') ??$salary}})">
                                Pay
                            </button>

                        </td>
                    </tr>
                    @endif

                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @else
    <div class="row">
        <div class="col-12">

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Salary type</th>
                        <th>Salary</th>
                        <th>Monthly work time</th>
                        <th>Worked hours</th>
                        <th>Bonus</th>
                        <th>Worked salary</th>
                        <th>Given</th>
                        <th>Remainder</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    @if ($employee->salary_type == 'mixed')
                    @php
                    $sumOfAllLates = 0;
                    $sumOfExtraMinutes = 0;

                    foreach ($attandances->where('employee_id', $employee->id)->whereIn('date', $dates) as $attendance) {
                    $startTime = \Carbon\Carbon::parse($attendance->start_time);
                    $dayStart = \Carbon\Carbon::parse($employee->day_start);

                    if ($startTime > $dayStart) {
                    $minutesLate = $startTime->diffInMinutes($dayStart);
                    $sumOfAllLates += $minutesLate;
                    }

                    $extraHours = $attendance->time - $employee->daily_time;
                    $sumOfExtraMinutes += $extraHours * 60;
                    }


                    $baseSalary = $employee->salary / $employee->monthly_time * round($attandances->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('time')) ;


                    $latePenaltyRate = $baseSalary / $employee->monthly_time;
                    $extraBonusRate = $baseSalary / $employee->monthly_time;

                    $salary = $baseSalary
                    - $latePenaltyRate
                    @endphp

                    <tr>
                        <td>{{ $employee->user->name }}</td>

                        <td>{{$employee->salary_type}}</td>
                        <td>{{$employee->salary}}</td>
                        <td>{{$employee->monthly_time}} hours</td>
                        <td>
                            <p class="{{round($attandances->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('time')) < $employee->monthly_time ? 'text-danger' : 'text-success'}}">
                                {{round($attandances->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('time'))}}
                            </p>
                        </td>
                        <td>
                            <select class="form-control"
                                wire:model="bonuses.{{ $employee->id }}"
                                wire:change="giveBonus({{ $employee->id }})">
                                <option value="{{null}}">Select bonus</option>
                                <option value="0.1">10%</option>
                                <option value="0.2">20%</option>
                                <option value="0.3">30%</option>
                            </select>

                        </td>
                        @php
                        $employeeBonus = $this->bonuses[$employee->id] ?? 0; // Fetch bonus for this specific employee
                        $employeeSum = 0;

                        if ($employeeBonus > 0) {
                        if ($employee->user->role == 'waiter') {
                        $orders = \App\Models\Order::where('status', 4)
                        ->whereHas('waiterOrder', function ($query) use ($employee, $dates) {
                        $query->where('employee_id', $employee->id)
                        ->whereIn('date', $dates);
                        })->get();

                        foreach ($orders as $order) {
                        $employeeSum += ($order->summ * $employeeBonus);
                        }
                        } elseif ($employee->user->role == 'manager') {
                        $attendances = \App\Models\Attendance::where('employee_id', $employee->id)
                        ->pluck('date')
                        ->toArray();

                        $filteredDates = array_intersect($attendances, $dates);

                        $employeeSum = \App\Models\Order::where('status', 4)
                        ->whereHas('waiterOrder', function ($query) use ($filteredDates) {
                        $query->whereIn('date', $filteredDates);
                        })->sum('summ') * $employeeBonus;
                        }
                        }

                        $salary += $employeeSum; // Add this employee-specific bonus to their salary
                        @endphp

                        <td>
                            @php
                            if ($salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') && $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('remainder')){
                            $salary = $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') + $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->last()->remainder;
                            }

                            @endphp
                            ${{ number_format($salary, 2, '.', ',') }}
                        </td>

                        @if ($salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->isNotEmpty())
                        <td>${{ $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') }}</td>
                        <td>${{ $salary - $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') }}</td>
                        @else
                        <td>0</td>
                        <td>0</td>
                        @endif

                        <td>
                            <button class="btn btn-primary"
                                wire:click="payment({{ $employee->id }}, {{$salary - $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') ?? $salary}})">
                                Pay
                            </button>

                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @endif


    @else
    <button class="btn btn-primary mt-2" wire:click="close">Close</button>
    <h1>{{$activePayment->user->name}}</h1>
    <h4>Salary: ${{$workedSalary}}</h4>
    <div class="col-4">
        <input type="text" class="form-control" placeholder="Salary" wire:model="paySalary">
        @if ($comment)
        <span class="text-danger">{{$comment}}</span><br>
        @endif
        <button class="btn btn-primary mt-2" wire:click="pay">Pay</button>
    </div>
    @endif
</div>