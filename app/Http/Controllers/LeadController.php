<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lead\AssiginRequest;
use App\Models\Lead;
use Illuminate\Http\Response;
use App\Http\Resources\LeadResource;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\RequestResource;
use App\Http\Resources\CommentResource;
use App\Http\Requests\Lead\StoreRequest;
use App\Http\Requests\Lead\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LeadController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return LeadResource::collection(Lead::all());
    }

    /**
     * @param StoreRequest $request
     * @return LeadResource
     */
    public function store(StoreRequest $request): LeadResource
    {
        $lead = new Lead($request->validated());
        $lead->save();

        return new LeadResource($lead);
    }

    /**
     * @param AssiginRequest $request
     * @param Lead $lead
     * @return LeadResource
     */
    public function assignUser(AssiginRequest $request, Lead $lead): LeadResource
    {
        $lead->assignedTo()->associate($request->toArray()['user_id']);
        $lead->save();

        return new LeadResource($lead);
    }

    /**
     * @param CommentRequest $request
     * @param Lead $lead
     * @return CommentResource
     */
    public function addComment(CommentRequest $request, Lead $lead): CommentResource
    {
        $comment = $lead->comments()->create($request->all());

        return new CommentResource($comment);
    }

    /**
     * @param Lead $lead
     * @return LeadResource
     */
    public function show(Lead $lead): LeadResource
    {
        return new LeadResource($lead);
    }

    /**
     * @param UpdateRequest $request
     * @param Lead $lead
     * @return LeadResource
     */
    public function update(UpdateRequest $request, Lead $lead): LeadResource
    {
        $lead->update($request->validated());

        return new LeadResource($lead);
    }

    /**
     * @param Lead $lead
     * @return Response
     */
    public function destroy(Lead $lead): Response
    {
        $lead->delete();

        return response()->noContent();
    }
}
