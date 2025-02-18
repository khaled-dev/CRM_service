<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionHandler;
use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Http\Resources\ContactResource;
use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
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
     *
     *     @OA\Parameter(
     *         name="account",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index(Account $account): array
    {
        return $this->generateResponse(
            ContactResource::collection(
                $account->contacts()->get()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/accounts/{account}/contacts",
     *     tags={"Contacts"},
     *     summary="Create contact",
     *
     *     @OA\Parameter(
     *         name="account",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                  @OA\Property(property="name", type="string", description="The deal_value of the opportunity", maxLength=255),
     *                  @OA\Property(property="email", type="string", description="The probability of the opportunity", maxLength=255),
     *                  @OA\Property(property="phone", type="string", description="The source of the opportunity", maxLength=255),
     *                  @OA\Property(property="position", type="string", description="The stage of the opportunity", maxLength=255),
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(StoreRequest $request, Account $account): array
    {
        $contact = $account->contacts()->create($request->validated());

        return $this->generateResponse(
            new ContactResource($contact)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/accounts/{account}/contacts/{contact}",
     *     tags={"Contacts"},
     *     summary="Show opportunity",
     *
     *     @OA\Parameter(name="account", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="contact", in="path", required=true, @OA\Schema(type="string")),
     *
     *     @OA\Response(response=200, description="Request Successful"),
     *     @OA\Response(response=404, description="Page Not Found")
     * )
     */
    public function show(Account $account, Contact $contact): JsonResponse|array
    {
        $is_exists = $account->contacts()->find($contact->getId());

        if (! $is_exists) {
            return ExceptionHandler::pageNotFound();
        }

        return $this->generateResponse(
            new ContactResource($contact)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/accounts/{account}/contacts/{contact}",
     *     tags={"Contacts"},
     *     summary="Update contact",
     *
     *     @OA\Parameter(name="account", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="contact", in="path", required=true, @OA\Schema(type="string")),
     *
     *     @OA\RequestBody(
     *         required=false,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                  @OA\Property(property="name", type="string", description="The deal_value of the opportunity", maxLength=255),
     *                  @OA\Property(property="email", type="string", description="The probability of the opportunity", maxLength=255),
     *                  @OA\Property(property="phone", type="string", description="The source of the opportunity", maxLength=255),
     *                  @OA\Property(property="position", type="string", description="The stage of the opportunity", maxLength=255),
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Account $account, Contact $contact): JsonResponse|array
    {
        $is_exists = $account->contacts()->find($contact->getId());

        if (! $is_exists) {
            return ExceptionHandler::pageNotFound();
        }

        $contact->update($request->validated());

        return $this->generateResponse(
            new ContactResource($contact)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/accounts/{account}/contacts/{contact}",
     *     tags={"Contacts"},
     *     summary="Delete contact",
     *
     *     @OA\Parameter(name="account", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="contact", in="path", required=true, @OA\Schema(type="string")),
     *
     *     @OA\Response(response=200, description="Request Successful"),
     *     @OA\Response(response=404, description="Page Not Found")
     * )
     */
    public function destroy(Account $account, Contact $contact): JsonResponse|array
    {
        $is_exists = $account->contacts()->find($contact->getId());

        if (! $is_exists) {
            return ExceptionHandler::pageNotFound();
        }

        $contact->delete();

        return $this->generateResponse(
            []
        );
    }
}
