<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\StoreRequest;
use App\Http\Requests\Account\UpdateRequest;
use App\Http\Requests\AssignRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Accounts", description="Operations about accounts")
 */
class AccountController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/accounts",
     *     tags={"Accounts"},
     *     summary="List accounts",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Request Successful",
     *     )
     * )
     */
    public function index(): array
    {
        return $this->generateResponse(
            AccountResource::collection(
                Account::all()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/accounts",
     *     tags={"Accounts"},
     *     summary="Create account",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *
     *                  @OA\Property(property="name", type="string", description="The name of the account", maxLength=255),
     *                  @OA\Property(property="industry", type="string", description="The industry of the account", maxLength=255),
     *                  @OA\Property(property="annual_revenue", type="string", description="The annual revenue of the account", maxLength=255),
     *                  @OA\Property(property="status", type="string", description="he status of the account", enum={"active", "inactive"}),
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="User created successfully"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(StoreRequest $request): array
    {
        $lead = new Account($request->validated());
        $lead->save();

        return $this->generateResponse(
            new AccountResource($lead)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/accounts/{id}/assign",
     *     tags={"Accounts"},
     *     summary="Assign User to the account",
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
     *                  @OA\Property(property="user_id", type="string", description="The user assigned to the account", maxLength=255)
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function assignUser(AssignRequest $request, Account $account): array
    {
        $account->assignedTo()->associate($request->toArray()['user_id']);
        $account->save();

        return $this->generateResponse(
            new AccountResource($account)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Show account",
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
    public function show(Account $account): array
    {
        return $this->generateResponse(
            new AccountResource($account)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Update account",
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
     *                  @OA\Property(property="name", type="string", description="The name of the account", maxLength=255),
     *                  @OA\Property(property="industry", type="string", description="The industry of the account", maxLength=255),
     *                  @OA\Property(property="annual_revenue", type="string", description="The annual revenue of the account", maxLength=255),
     *                  @OA\Property(property="status", type="string", description="he status of the account", enum={"active", "inactive"}),
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(response="201", description="User created successfully"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Account $account): array
    {
        $account->update($request->validated());

        return $this->generateResponse(
            new AccountResource($account)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Delete account",
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
    public function destroy(Account $account): array
    {
        $account->delete();

        return $this->generateResponse(
            []
        );
    }
}
