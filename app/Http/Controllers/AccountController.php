<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use App\Http\Resources\AccountResource;
use App\Http\Requests\Account\StoreRequest;
use App\Http\Requests\Account\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     *     @OA\Response(
     *         response=200,
     *         description="Request Successful",
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return AccountResource::collection(Account::all());
    }

    /**
     * @OA\Post(
     *     path="/api/accounts",
     *     tags={"Accounts"},
     *     summary="Create account",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="name", type="string", description="The name of the account", maxLength=255),
     *                  @OA\Property(property="industry", type="string", description="The industry of the account", maxLength=255),
     *                  @OA\Property(property="annual_revenue", type="string", description="The annual revenue of the account", maxLength=255),
     *                  @OA\Property(property="status", type="string", description="he status of the account", enum={"active", "inactive"}),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="User created successfully"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(StoreRequest $request): AccountResource
    {
        $lead = new Account($request->validated());
        $lead->save();

        return new AccountResource($lead);
    }

    /**
     * @OA\Get(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Show account",
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
    public function show(Account $account): AccountResource
    {
        return new AccountResource($account);
    }

    /**
     * @OA\Put(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Update account",
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
     *                  @OA\Property(property="name", type="string", description="The name of the account", maxLength=255),
     *                  @OA\Property(property="industry", type="string", description="The industry of the account", maxLength=255),
     *                  @OA\Property(property="annual_revenue", type="string", description="The annual revenue of the account", maxLength=255),
     *                  @OA\Property(property="status", type="string", description="he status of the account", enum={"active", "inactive"}),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="User created successfully"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Account $account): AccountResource
    {
        $account->update($request->validated());

        return new AccountResource($account);
    }

    /**
     * @OA\Delete(
     *     path="/api/accounts/{id}",
     *     tags={"Accounts"},
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
    public function destroy(Account $account): Response
    {
        $account->delete();

        return response()->noContent();
    }
}
