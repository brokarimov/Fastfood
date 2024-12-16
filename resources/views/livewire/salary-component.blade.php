<div>
    <h1>Salary</h1>
    <div class="row">
        <div class="col-12">
            <div class="col-4">
                <select wire:model="employee" wire:change="findEmployee" class="form-control">
                    <option value="{{null}}">Select Employee</option>
                    @foreach ($employees as $employee)
                    <option value="{{$employee->id}}">{{$employee->user->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="col-4">
                @if (!empty($statistics))

                @php
                $sumOfAllLates = 0;
                $sumOfExtraMinutes = 0
                @endphp

                @foreach ($statistics as $statistic)

                @php
                $startTime = \Carbon\Carbon::parse($statistic->start_time);
                $dayStart = \Carbon\Carbon::parse($employeeSalary->day_start);




                if($dayStart < $startTime)
                    {
                    $minutesLate=$startTime->diffInMinutes($dayStart);
                    $sumOfAllLates += $minutesLate;
                    }

                    $extraHours = $statistic->time - $employeeSalary->daily_time;
                    if($extraHours > 0)
                    {
                    $sumOfExtraMinutes += $extraHours * 60;
                    }else{
                    $sumOfExtraMinutes += $extraHours * 60;
                    }
                    @endphp

                    @endforeach
                    @if ($employeeSalary)
                    <h3>All lates: {{round($sumOfAllLates)}}</h3>
                    <h3>Extra Minutes: {{round($sumOfExtraMinutes)}}</h3>

                    @if ($employeeSalary->salary_type == 'fixed')
                    @php
                    $baseSalary = 2000000;
                    $latePenaltyRate = $baseSalary / $employeeSalary->monthly_time;
                    $extraBonusRate = $baseSalary / $employeeSalary->monthly_time;

                    $salary = $baseSalary
                    - ($latePenaltyRate * abs($sumOfAllLates))
                    + ($extraBonusRate * round($sumOfExtraMinutes));
                    @endphp

                    <h1>Salary: {{ number_format($salary, 2, '.', ',') }}</h1>


                    @else
                    <h1>Salary: 0</h1>
                    @endif
                    @endif

                    @endif

            </div>
        </div>
    </div>
</div>