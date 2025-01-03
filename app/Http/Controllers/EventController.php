<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\EventStoreRequest;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ){}
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return ApiResponse::success(
                $this->eventService->getAll($request->only('sortBy')),
                'Events retrieved successfully'
            );
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventStoreRequest $request
     * @return JsonResponse
     */
    public function store(EventStoreRequest $request): JsonResponse
    {
        try {
            return ApiResponse::success(
                $this->eventService->create($request->validated()),
                'Event created successfully',
                201
            );
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            return ApiResponse::success(
                $this->eventService->getById($id),
                'Event retrieved successfully'
            );
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EventStoreRequest $request
     * @param  string $id
     * @return JsonResponse
     */
    public function update(EventStoreRequest $request, string $id): JsonResponse
    {
        try {
            return ApiResponse::success(
                $this->eventService->update( $request->all(), $id),
                'Event updated successfully'
            );
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->eventService->delete($id);

            return ApiResponse::success(
                [],
                'Event deleted successfully',
                200
            );
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }
}
