<?php

namespace App\Repositories;

use App\Models\Employee;

//Could implement EmployeeRepositoryInterface, but I didn't want to waste time on this, so it's here for reference
class EmployeeRepository {
    public function findActiveWithComfortCategories(int $employeeId): ?Employee {
        return Employee::with('position.comfortCategories')
            ->where('id', $employeeId)
            ->where('is_active', true)
            ->first();
    }
}
