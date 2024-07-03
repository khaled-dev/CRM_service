<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Response;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\Activity\StoreRequest;
use App\Http\Requests\Activity\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ActivityController extends Controller
{
    /**
     * @param Activity $activity
     * @return AnonymousResourceCollection
     */
    public function index(Activity $activity): AnonymousResourceCollection
    {
        return ActivityResource::collection($activity->all());
    }

    /**
     * @param StoreRequest $request
     * @return ActivityResource
     */
    public function store(StoreRequest $request): ActivityResource
    {
        $activity = new Activity($request->validated());

        return new ActivityResource($activity);
    }

    /**
     * @param Activity $activity
     * @return ActivityResource
     */
    public function show(Activity $activity): ActivityResource
    {
        return new ActivityResource($activity);
    }

    /**
     * @param UpdateRequest $request
     * @param Activity $activity
     * @return ActivityResource
     */
    public function update(UpdateRequest $request, Activity $activity): ActivityResource
    {
        $activity->update($request->validated());

        return new ActivityResource($activity);
    }

    /**
     * @param Activity $activity
     * @return Response
     */
    public function destroy(Activity $activity): Response
    {
        $activity->delete();

        return response()->noContent();
    }
}
