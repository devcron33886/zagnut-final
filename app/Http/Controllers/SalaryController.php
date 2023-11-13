<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Scopes\WorkScope;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function __invoke()
    {
        $employees = Employee::with('works')->paginate(30);
        // Calculate the sum of salaries for each employee
        $employeeSalaries = [];
        foreach ($employees as $employee) {
            $totalSalary = $employee->works()->withoutGlobalScope(WorkScope::class)->sum('payout');
            $employeeSalaries[$employee->id] = $totalSalary;
        }
        $total=Work::withoutGlobalScope(WorkScope::class)->sum('payout');

        return view('salaries.index', ['employees' => $employees, 'employeeSalaries' => $employeeSalaries,'total'=>$total]);
        return view('saralies.index');
    }
}
