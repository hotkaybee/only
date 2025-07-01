<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AccessDeniedException;
use App\Exceptions\EmployeeNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableCarsRequest;
use App\Services\AvailableCarService;
use Illuminate\Http\JsonResponse;

class AvailableCarsController extends Controller
{
    public function __construct(
        private readonly AvailableCarService $carService
    ) {}

    public function index(AvailableCarsRequest $request): JsonResponse
    {
        try {
            $result = $this->carService->getAvailableCars($request);
            return response()->json($result);
        } catch (EmployeeNotFoundException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        } catch (AccessDeniedException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 403);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при получении списка автомобилей',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

}
