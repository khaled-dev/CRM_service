<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\Response;
use App\Http\Resources\ContactResource;
use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactController extends Controller
{

    /**
     * @param Account $account
     * @return AnonymousResourceCollection
     */
    public function index(Account $account): AnonymousResourceCollection
    {
        return ContactResource::collection($account->contacts()->get());
    }

    /**
     * @param StoreRequest $request
     * @param Account $account
     * @return ContactResource
     */
    public function store(StoreRequest $request, Account $account): ContactResource
    {
        $contact = $account->contacts()->create($request->validated());

        return new ContactResource($contact);
    }

    /**
     * @param Account $account
     * @param Contact $contact
     * @return ContactResource
     */
    public function show(Account $account, Contact $contact): ContactResource
    {
        // TODO: check contract belongs to account
        return new ContactResource($contact);
    }

    /**
     * @param UpdateRequest $request
     * @param Account $account
     * @param Contact $contact
     * @return ContactResource
     */
    public function update(UpdateRequest $request, Account $account, Contact $contact): ContactResource
    {
        // TODO: check contract belongs to account
        $contact->update($request->validated());

        return new ContactResource($contact);
    }

    /**
     * @param Account $account
     * @param Contact $contact
     * @return Response
     */
    public function destroy(Account $account,Contact $contact): Response
    {
        // TODO: check contract belongs to account

        $contact->delete();

        return response()->noContent();
    }
}
