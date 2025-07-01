<?php

namespace App\Services;

use App\Exceptions\EmployeeNotFoundException;
use App\Http\Requests\AvailableCarsRequest;
use App\Http\Resources\AvailableCarResource;
use App\Models\Employee;
use App\Repositories\CarRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\Auth;

readonly class AvailableCarService {
    public function __construct(
        private EmployeeRepository $employeeRepository,
        private CarRepository $carRepository
    ) {
    }

    public function getAvailableCars(AvailableCarsRequest $request): array {
        $employee = $this->getActiveEmployee();
        $allowedCategoryIds = $this->getAllowedComfortCategories($employee);

        if (empty($allowedCategoryIds)) {
            return $this->buildEmptyResponse($employee);
        }

        $cars = $this->carRepository->getAvailableCars($request, $allowedCategoryIds);

        return $this->buildSuccessResponse($cars, $employee);
    }

    /**
     * @throws EmployeeNotFoundException
     */
    private function getActiveEmployee(): Employee {
        $user = Auth::user();
        $employee = $this->employeeRepository->findActiveWithComfortCategories($user->employee_id);

        if (!$employee) {
            throw new EmployeeNotFoundException('Сотрудник не найден или неактивен');
        }

        return $employee;
    }

    private function getAllowedComfortCategories(Employee $employee): array {
        return $employee->position->comfortCategories->pluck('id')->toArray();
    }

    private function buildEmptyResponse(Employee $employee): array {
        return [
            'success' => true,
            'data' => [],
            'message' => 'Для вашей должности не настроен доступ к автомобилям',
            'employee_info' => $this->buildEmployeeInfo($employee)
        ];
    }

    private function buildSuccessResponse($cars, Employee $employee): array {
        return [
            'success' => true,
            'data' => AvailableCarResource::collection($cars->items()),
            'meta' => $this->buildPaginationMeta($cars),
            'employee_info' => $this->buildEmployeeInfo($employee)
        ];
    }

    private function buildPaginationMeta($cars): array {
        return [
            'current_page' => $cars->currentPage(),
            'from' => $cars->firstItem(),
            'last_page' => $cars->lastPage(),
            'per_page' => $cars->perPage(),
            'to' => $cars->lastItem(),
            'total' => $cars->total(),
        ];
    }

    private function buildEmployeeInfo(Employee $employee): array {
        return [
            'position' => $employee->position->name,
            'allowed_comfort_categories' => $employee->position->comfortCategories->map(fn($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'level' => $category->level
            ])
        ];
    }
}
