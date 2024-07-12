<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use OpenApi\Annotations as OA;
use App\Http\Resources\OpportunityResource;
use App\Http\Requests\Opportunity\StoreRequest;
use App\Http\Requests\Opportunity\UpdateRequest;

/**
 * @OA\Tag(name="Opportunities", description="Operations about opportunity")
 */
class OpportunityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/opportunities",
     *     tags={"Opportunities"},
     *     summary="List opportunities",
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index(): array
    {
        return $this->generateResponse(
            OpportunityResource::collection(
                Opportunity::all()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/opportunities",
     *     tags={"Opportunities"},
     *     summary="Create opportunity",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="deal_value", type="integer", description="The deal_value of the opportunity", maxLength=10),
     *                  @OA\Property(property="probability", type="string", description="The probability of the opportunity", maxLength=255),
     *                  @OA\Property(property="close_date", type="string", description="The source of the opportunity", maxLength=255),
     *                  @OA\Property(property="stage", type="string", description="The stage of the opportunity", enum={"qualification", "needs analysis", "proposal", "negotiation", "won", "lost"}),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(StoreRequest $request): array
    {
        $lead = new Opportunity($request->validated());
        $lead->save();

        return $this->generateResponse(
            new OpportunityResource($lead)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/opportunities/{id}",
     *     tags={"Opportunities"},
     *     summary="Show opportunity",
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
    public function show(Opportunity $opportunity): array
    {
        return $this->generateResponse(
            new OpportunityResource($opportunity)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/opportunities/{id}",
     *     tags={"Opportunities"},
     *     summary="Update opportunity",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="deal_value", type="integer", description="The deal_value of the opportunity", maxLength=10),
     *                  @OA\Property(property="probability", type="string", description="The probability of the opportunity", maxLength=255),
     *                  @OA\Property(property="close_date", type="string", description="The source of the opportunity", maxLength=255),
     *                  @OA\Property(property="stage", type="string", description="The stage of the opportunity", enum={"qualification", "needs analysis", "proposal", "negotiation", "won", "lost"}),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Opportunity $opportunity): array
    {
        $opportunity->update($request->validated());

        return $this->generateResponse(
            new OpportunityResource($opportunity)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/opportunities/{id}",
     *     tags={"Opportunities"},
     *     summary="Delete opportunity",
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
    public function destroy(Opportunity $opportunity): array
    {
        $opportunity->delete();

        return $this->generateResponse(
            []
        );
    }
}
