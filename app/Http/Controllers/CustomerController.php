<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Response;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\RequestResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Requests\Customer\RequestRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomerController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CustomerResource::collection(Customer::all());
    }

    /**
     * @param StoreRequest $request
     * @return CustomerResource
     */
    public function store(StoreRequest $request): CustomerResource
    {
        $customer = new Customer($request->validated());
        $customer->save();

        return new CustomerResource($customer);
    }

    /**
     * @param CommentRequest $request
     * @param Customer $customer
     * @return CommentResource
     */
    public function addComment(CommentRequest $request, Customer $customer): CommentResource
    {
        $comment = $customer->comments()->create($request->all());


        return new CommentResource($comment);
    }

    /**
     * @param RequestRequest $request
     * @param Customer $customer
     * @return RequestResource
     */
    public function addRequest(RequestRequest $request, Customer $customer): RequestResource
    {
        $request = $customer->requests()->create($request->all());

        return new RequestResource($request);
    }

    /**
     * @param Customer $customer
     * @return CustomerResource
     */
    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer);
    }

    /**
     * @param UpdateRequest $request
     * @param Customer $customer
     * @return CustomerResource
     */
    public function update(UpdateRequest $request, Customer $customer): CustomerResource
    {
        $customer->update($request->validated());

        return new CustomerResource($customer);
    }

    /**
     * @param Customer $customer
     * @return Response
     */
    public function destroy(Customer $customer): Response
    {
        $customer->delete();

        return response()->noContent();
    }
}
