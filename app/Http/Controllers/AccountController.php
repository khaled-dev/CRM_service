<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Response;
use App\Http\Resources\AccountResource;
use App\Http\Requests\Account\StoreRequest;
use App\Http\Requests\Account\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AccountController extends Controller
{

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return AccountResource::collection(Account::all());
    }

    /**
     * @param StoreRequest $request
     * @return AccountResource
     */
    public function store(StoreRequest $request): AccountResource
    {
        $lead = new Account($request->validated());
        $lead->save();

        return new AccountResource($lead);
    }

    /**
     * @param Account $account
     * @return AccountResource
     */
    public function show(Account $account): AccountResource
    {
        return new AccountResource($account);
    }

    /**
     * @param UpdateRequest $request
     * @param Account $account
     * @return AccountResource
     */
    public function update(UpdateRequest $request, Account $account): AccountResource
    {
        $account->update($request->validated());

        return new AccountResource($account);
    }

    /**
     * @param Account $account
     * @return Response
     */
    public function destroy(Account $account): Response
    {
        $account->delete();

        return response()->noContent();
    }
}
