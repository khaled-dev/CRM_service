<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\Lead\StoreRequest;
use App\Http\Requests\Lead\UpdateRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Leads", description="Operations about leads")
 */
class LeadController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/leads",
     *     tags={"Leads"},
     *     summary="List leads",
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index(): array
    {
        return $this->generateResponse(
            LeadResource::collection(
                Lead::all()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/leads",
     *     tags={"Leads"},
     *     summary="Create lead",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                  @OA\Property(property="email", type="string", description="The email of the lead", maxLength=255),
     *                  @OA\Property(property="phone", type="string", description="The phone of the lead", maxLength=255),
     *                  @OA\Property(property="source", type="string", description="The source of the lead", enum={"website", "referral", "event"}),
     *                  @OA\Property(property="interest_level", type="string", description="The interest level of the lead", enum={"high", "medium", "low"}),
     *                  @OA\Property(property="status", type="string", description="the status of the lead", enum={"new", "contacted", "qualified", "lost"}),
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
        $lead = new Lead($request->validated());
        $lead->save();

        return $this->generateResponse(
            new LeadResource($lead)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/leads/{id}/assign",
     *     tags={"Leads"},
     *     summary="Assign User to the lead",
     *
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                  @OA\Property(property="user_id", type="string", description="The user assigned to the lead", maxLength=255)
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function assignUser(AssignRequest $request, Lead $lead): array
    {
        $lead->assignedTo()->associate($request->toArray()['user_id']);
        $lead->save();

        return $this->generateResponse(
            new LeadResource($lead)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/leads/{id}/comments",
     *     tags={"Leads"},
     *     summary="Create comment on a lead",
     *
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                  @OA\Property(property="comment", type="string", description="The comment on the lead", maxLength=255)
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function addComment(CommentRequest $request, Lead $lead): array
    {
        $comment = $lead->comments()->create($request->all());

        return $this->generateResponse(
            new CommentResource($comment)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/leads/{id}",
     *     tags={"Leads"},
     *     summary="Show lead",
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
    public function show(Lead $lead): array
    {
        return $this->generateResponse(
            new LeadResource($lead)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/leads/{id}",
     *     tags={"Leads"},
     *     summary="Update lead",
     *
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=false,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                   @OA\Property(property="email", type="string", description="The email of the lead", maxLength=255),
     *                   @OA\Property(property="phone", type="string", description="The phone of the lead", maxLength=255),
     *                   @OA\Property(property="source", type="string", description="The source of the lead", enum={"website", "referral", "event"}),
     *                   @OA\Property(property="interest_level", type="string", description="The interest level of the lead", enum={"high", "medium", "low"}),
     *                   @OA\Property(property="status", type="string", description="the status of the lead", enum={"new", "contacted", "qualified", "lost"}),
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Lead $lead): array
    {
        $lead->update($request->validated());

        return $this->generateResponse(
            new LeadResource($lead)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/leads/{id}",
     *     tags={"Leads"},
     *     summary="Delete lead",
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
    public function destroy(Lead $lead): array
    {
        $lead->delete();

        return $this->generateResponse(
            []
        );
    }
}
