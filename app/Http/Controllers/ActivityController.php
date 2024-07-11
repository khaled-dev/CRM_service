<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Response;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\Activity\StoreRequest;
use App\Http\Requests\Activity\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return ActivityResource::collection(Activity::all());
    }

    /**
     * @OA\Post(
     *     path="/api/activities",
     *     tags={"Activities"},
     *     summary="Create activity",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="contract_id", type="string", description="The contract_id of the activity", maxLength=255),
     *                  @OA\Property(property="outcome", type="string", description="The outcome of the activity", maxLength=255),
     *                  @OA\Property(property="date", type="string", description="The date of the activity", maxLength=255),
     *                  @OA\Property(property="note", type="string", description="note added on the activity", maxLength=255),
     *                  @OA\Property(property="type", type="string", description="the type of the activity", enum={"call", "email", "meeting", "demonstration"}),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(StoreRequest $request): ActivityResource
    {
        $activity = new Activity($request->validated());
        $activity->save();

        return new ActivityResource($activity);
    }

    /**
     * @OA\Get(
     *     path="/api/activities/{id}",
     *     tags={"Activities"},
     *     summary="Show activity",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Request Successful"),
     *     @OA\Response(response=404, description="Page Not Found")
     * )
     */
    public function show(Activity $activity): ActivityResource
    {
        return new ActivityResource($activity);
    }

    /**
     * @OA\Put(
     *     path="/api/activities/{id}",
     *     tags={"Activities"},
     *     summary="Update activity",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="contract_id", type="string", description="The contract_id of the activity", maxLength=255),
     *                  @OA\Property(property="outcome", type="string", description="The outcome of the activity", maxLength=255),
     *                  @OA\Property(property="date", type="string", description="The date of the activity", maxLength=255),
     *                  @OA\Property(property="note", type="string", description="note added on the activity", maxLength=255),
     *                  @OA\Property(property="type", type="string", description="the type of the activity", enum={"call", "email", "meeting", "demonstration"}),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Activity $activity): ActivityResource
    {
        $activity->update($request->validated());

        return new ActivityResource($activity);
    }

    /**
     * @OA\Delete(
     *     path="/api/activities/{id}",
     *     tags={"Activities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Request Successful"),
     *     @OA\Response(response=404, description="Page Not Found")
     * )
     */
    public function destroy(Activity $activity): Response
    {
        $activity->delete();

        return response()->noContent();
    }
}
