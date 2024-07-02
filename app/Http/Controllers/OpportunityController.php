<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Opportunity;
use Illuminate\Http\Response;
use App\Http\Resources\LeadResource;
use App\Http\Resources\OpportunityResource;
use App\Http\Requests\Opportunity\StoreRequest;
use App\Http\Requests\Opportunity\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OpportunityController extends Controller
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
     * @return OpportunityResource
     */
    public function store(StoreRequest $request): OpportunityResource
    {
        $lead = new Opportunity($request->validated());
        $lead->save();

        return new OpportunityResource($lead);
    }

    /**
     * @param Opportunity $opportunity
     * @return OpportunityResource
     */
    public function show(Opportunity $opportunity): OpportunityResource
    {
        return new OpportunityResource($opportunity);
    }

    /**
     * @param UpdateRequest $request
     * @param Opportunity $opportunity
     * @return OpportunityResource
     */
    public function update(UpdateRequest $request, Opportunity $opportunity): OpportunityResource
    {
        $opportunity->update($request->validated());

        return new OpportunityResource($opportunity);
    }

    /**
     * @param Opportunity $opportunity
     * @return Response
     */
    public function destroy(Opportunity $opportunity): Response
    {
        $opportunity->delete();

        return response()->noContent();
    }
}
