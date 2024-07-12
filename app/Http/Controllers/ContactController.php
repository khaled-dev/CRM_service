<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Resources\ContactResource;
use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Contacts", description="Operations about contact")
 */
class ContactController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/accounts/{account}/contacts",
     *     tags={"Contacts"},
     *     summary="List contacts",
     *     @OA\Parameter(
     *         name="account",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index(Account $account): AnonymousResourceCollection
    {
        return ContactResource::collection($account->contacts()->get());
    }

    /**
     * @OA\Post(
     *     path="/api/accounts/{account}/contacts",
     *     tags={"Contacts"},
     *     summary="Create contact",
     *     @OA\Parameter(
     *         name="account",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="name", type="string", description="The deal_value of the opportunity", maxLength=255),
     *                  @OA\Property(property="email", type="string", description="The probability of the opportunity", maxLength=255),
     *                  @OA\Property(property="phone", type="string", description="The source of the opportunity", maxLength=255),
     *                  @OA\Property(property="position", type="string", description="The stage of the opportunity", maxLength=255),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(StoreRequest $request, Account $account): ContactResource
    {
        $contact = $account->contacts()->create($request->validated());

        return new ContactResource($contact);
    }

    /**
     * @OA\Get(
     *     path="/api/accounts/{account}/contacts/{contact}",
     *     tags={"Contacts"},
     *     summary="Show opportunity",
     *     @OA\Parameter(name="account", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="contact", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Request Successful"),
     *     @OA\Response(response=404, description="Page Not Found")
     * )
     */
    public function show(Account $account, Contact $contact): ContactResource|JsonResponse
    {
        $is_exists = $account->contacts()->find($contact->getId());

        if (! $is_exists) {
            return response()->json([
                'success' => 'false',
                'message' => 'Page Not Found',
            ], 404);
        }

        return new ContactResource($contact);
    }

    /**
     * @OA\Put(
     *     path="/api/accounts/{account}/contacts/{contact}",
     *     tags={"contacts"},
     *     summary="Update contact",
     *     @OA\Parameter(name="account", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="contact", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="name", type="string", description="The deal_value of the opportunity", maxLength=255),
     *                  @OA\Property(property="email", type="string", description="The probability of the opportunity", maxLength=255),
     *                  @OA\Property(property="phone", type="string", description="The source of the opportunity", maxLength=255),
     *                  @OA\Property(property="position", type="string", description="The stage of the opportunity", maxLength=255),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Account $account, Contact $contact): ContactResource|JsonResponse
    {
        $is_exists = $account->contacts()->find($contact->getId());

        if (! $is_exists) {
            return response()->json([
                'success' => 'false',
                'message' => 'Page Not Found',
            ], 404);
        }

        $contact->update($request->validated());

        return new ContactResource($contact);
    }

    /**
     * @OA\Delete(
     *     path="/api/accounts/{account}/contacts/{contact}",
     *     tags={"contacts"},
     *     summary="Delete contact",
     *     @OA\Parameter(name="account", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="contact", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Request Successful"),
     *     @OA\Response(response=404, description="Page Not Found")
     * )
     */
    public function destroy(Account $account,Contact $contact): Response|JsonResponse
    {
        $is_exists = $account->contacts()->find($contact->getId());

        if (! $is_exists) {
            return response()->json([
                'success' => 'false',
                'message' => 'Page Not Found',
            ], 404);
        }

        $contact->delete();

        return response()->noContent();
    }
}
