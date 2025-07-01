<?php

namespace App\Repositories;

use App\Exceptions\AccessDeniedException;
use App\Http\Requests\AvailableCarsRequest;
use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

//Could implement CarRepositoryInterface, but I didn't want to waste time on this, but it's here for reference
class CarRepository {
    private const ALLOWED_SORT_FIELDS = ['brand', 'model', 'year', 'comfort_category_id'];
    private const MAX_PER_PAGE = 100;
    private const DEFAULT_PER_PAGE = 10;

    public function getAvailableCars(AvailableCarsRequest $request, array $allowedCategoryIds): \Illuminate\Pagination\LengthAwarePaginator {
        $query = $this->buildBaseQuery($allowedCategoryIds);

        $this->applyFilters($query, $request, $allowedCategoryIds);
        $this->applySorting($query, $request);

        return $query->paginate($this->getPerPage($request));
    }

    private function buildBaseQuery(array $allowedCategoryIds): Builder {
        return Car::with([
            'driver:id,first_name,last_name,phone',
            'comfortCategory:id,name,level,description'
        ])
            ->where('is_active', true)
            ->whereIn('comfort_category_id', $allowedCategoryIds);
    }

    private function applyFilters(Builder $query, AvailableCarsRequest $request, array $allowedCategoryIds): void {
        $this->applyTextFilter($query, 'model', $request->model);
        $this->applyTextFilter($query, 'brand', $request->brand);
        $this->applyComfortCategoryFilter($query, $request, $allowedCategoryIds);
        $this->applyComfortLevelFilter($query, $request);
        $this->applyAvailabilityFilter($query, $request);
    }

    private function applyTextFilter(Builder $query, string $field, ?string $value): void {
        if (filled($value)) {
            $query->where($field, 'LIKE', "%{$value}%");
        }
    }

    private function applyComfortCategoryFilter(Builder $query, AvailableCarsRequest $request, array $allowedCategoryIds): void {
        if (!$request->filled('comfort_category_id')) {
            return;
        }

        $categoryId = $request->comfort_category_id;

        if (!in_array($categoryId, $allowedCategoryIds)) {
            throw new AccessDeniedException('У вас нет доступа к этой категории комфорта');
        }

        $query->where('comfort_category_id', $categoryId);
    }

    private function applyComfortLevelFilter(Builder $query, AvailableCarsRequest $request): void {
        if ($request->filled('comfort_level')) {
            $query->whereHas('comfortCategory', fn($q) => $q->where('level', $request->comfort_level));
        }
    }

    private function applyAvailabilityFilter(Builder $query, AvailableCarsRequest $request): void {
        if (!$request->filled('start_datetime') || !$request->filled('end_datetime')) {
            return;
        }

        $query->whereNotExists(function ($subQuery) use ($request) {
            $subQuery->select(DB::raw(1))
                ->from('bookings')
                ->whereColumn('bookings.car_id', 'cars.id')
                ->whereNotIn('bookings.status', ['cancelled', 'rejected'])
                ->where('start_datetime', '<', $request->end_datetime)
                ->where('end_datetime', '>', $request->start_datetime);
        });
    }

    private function applySorting(Builder $query, AvailableCarsRequest $request): void {
        $sortBy = $request->get('sort_by', 'brand');
        $sortOrder = $request->get('sort_order', 'asc');

        if (!in_array($sortBy, self::ALLOWED_SORT_FIELDS)) {
            return;
        }

        if ($sortBy === 'comfort_category_id') {
            $query->join('comfort_categories', 'cars.comfort_category_id', '=', 'comfort_categories.id')
                ->orderBy('comfort_categories.level', $sortOrder)
                ->select('cars.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
    }

    private function getPerPage(AvailableCarsRequest $request): int {
        return min($request->get('per_page', self::DEFAULT_PER_PAGE), self::MAX_PER_PAGE);
    }
}
