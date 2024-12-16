<div>
    @if ($activePayment == null)
    <h1>Salary</h1>

    <input type="date" class="form-control" wire:model="date" wire:change="getDate">
    <h3 class="mt-2 text-primary">
        {{ $date ? \Carbon\Carbon::parse($date)->isoFormat('MMMM YYYY') : \Carbon\Carbon::today()->isoFormat('MMMM YYYY') }}
    </h3>

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


                    $baseSalary = $employee->salary;
                    $latePenaltyRate = $baseSalary / $employee->monthly_time;
                    $extraBonusRate = $baseSalary / $employee->monthly_time;

                    $salary = $baseSalary
                    - ($latePenaltyRate * abs($sumOfAllLates))
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
                        <td>${{ number_format($salary, 2, '.', ',') }}</td>

                        @if ($salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->isNotEmpty())
                        <td>${{ $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->sum('given') }}</td>
                        <td>${{ $salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->last()->remainder }}</td>
                        @else
                        <td>0</td>
                        <td>0</td>
                        @endif

                        <td>
                            <button class="btn btn-primary"
                                wire:click="payment({{ $employee->id }}, {{$salaries->where('employee_id', $employee->id)->whereIn('date', $dates)->first()->remainder ??$salary}})">
                                Pay
                            </button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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