<?php

namespace App\Http\Controllers;

use App\Http\Requests\Activity\StoreRequest;
use App\Http\Requests\Activity\UpdateRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Activities", description="Operations about Activities")
 */
class ActivityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/activities",
     *     tags={"Activities"},
     *     summary="List activities",
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index(): array
    {
        return $this->generateResponse(
            ActivityResource::collection(
                Activity::all()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/activities",
     *     tags={"Activities"},
     *     summary="Create activity",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                  @OA\Property(property="contact_id", type="string", description="The contact_id of the activity", maxLength=255),
     *                  @OA\Property(property="outcome", type="string", description="The outcome of the activity", maxLength=255),
     *                  @OA\Property(property="date", type="string", description="The date of the activity", maxLength=255),
     *                  @OA\Property(property="note", type="string", description="note added on the activity", maxLength=255),
     *                  @OA\Property(property="type", type="string", description="the type of the activity", enum={"call", "email", "meeting", "demonstration"}),
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(StoreRequest $request): array
    {
        $activity = new Activity($request->validated());
        $activity->save();

        return $this->generateResponse(
            new ActivityResource($activity)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/activities/{id}",
     *     tags={"Activities"},
     *     summary="Show activity",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(response=200, description="Request Successful"),
     *     @OA\Response(response=404, description="Page Not Found")
     * )
     */
    public function show(Activity $activity): array
    {
        return $this->generateResponse(
            new ActivityResource($activity)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/activities/{id}",
     *     tags={"Activities"},
     *     summary="Update activity",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=false,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                  @OA\Property(property="contact_id", type="string", description="The contact_id of the activity", maxLength=255),
     *                  @OA\Property(property="outcome", type="string", description="The outcome of the activity", maxLength=255),
     *                  @OA\Property(property="date", type="string", description="The date of the activity", maxLength=255),
     *                  @OA\Property(property="note", type="string", description="note added on the activity", maxLength=255),
     *                  @OA\Property(property="type", type="string", description="the type of the activity", enum={"call", "email", "meeting", "demonstration"}),
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Activity $activity): array
    {
        $activity->update($request->validated());

        return $this->generateResponse(
            new ActivityResource($activity)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/activities/{id}",
     *     tags={"Activities"},
     *     summary="Delete activity",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(response=200, description="Request Successful"),
     *     @OA\Response(response=404, description="Page Not Found")
     * )
     */
    public function destroy(Activity $activity): array
    {
        $activity->delete();

        return $this->generateResponse(
            []
        );
    }
}
