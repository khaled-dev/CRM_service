<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\RequestResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Requests\Customer\RequestRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(name="Customers", description="Operations about customers")
 */
class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/customers",
     *     tags={"Customers"},
     *     summary="List customers",
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return CustomerResource::collection(Customer::all());
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     tags={"Customers"},
     *     summary="Create customer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="name", type="string", description="The name of the customer", maxLength=255),
     *                  @OA\Property(property="company_name", type="string", description="The company_name of the customer", maxLength=255),
     *                  @OA\Property(property="address", type="string", description="The address of the customer", maxLength=255),
     *                  @OA\Property(property="phone", type="string", description="The phone of the customer", maxLength=255),
     *                  @OA\Property(property="email", type="string", description="the email of the customer", maxLength=255),
     *                  @OA\Property(property="country", type="string", description="the country of the customer", maxLength=255),
     *                  @OA\Property(property="status", type="string", description="the status of the customer", enum={"potential", "current"}),
     *                  @OA\Property(property="type", type="string", description="the type of the customer", maxLength=255),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(StoreRequest $request): CustomerResource
    {
        $customer = new Customer($request->validated());
        $customer->save();

        return new CustomerResource($customer);
    }

    /**
     * @OA\Post(
     *     path="/api/customers/{id}/comments",
     *     tags={"Customers"},
     *     summary="Create comment on a customer",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="comment", type="string", description="The comment on the customer", maxLength=255)
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function addComment(CommentRequest $request, Customer $customer): CommentResource
    {
        $comment = $customer->comments()->create($request->all());

        return new CommentResource($comment);
    }

    /**
     * @OA\Post(
     *     path="/api/customers/{id}/requests",
     *     tags={"Customers"},
     *     summary="Create request on a customer",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              properties={
     *                  @OA\Property(property="request", type="string", description="The request on the customer", maxLength=255)
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function addRequest(RequestRequest $request, Customer $customer): RequestResource
    {
        $request = $customer->requests()->create($request->all());

        return new RequestResource($request);
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     tags={"Customers"},
     *     summary="Show activity",
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
    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer);
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     tags={"Customers"},
     *     summary="Update customer",
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
     *                  @OA\Property(property="name", type="string", description="The name of the customer", maxLength=255),
     *                  @OA\Property(property="company_name", type="string", description="The company_name of the customer", maxLength=255),
     *                  @OA\Property(property="address", type="string", description="The address of the customer", maxLength=255),
     *                  @OA\Property(property="phone", type="string", description="The phone of the customer", maxLength=255),
     *                  @OA\Property(property="email", type="string", description="the email of the customer", maxLength=255),
     *                  @OA\Property(property="country", type="string", description="the country of the customer", maxLength=255),
     *                  @OA\Property(property="status", type="string", description="the status of the customer", enum={"potential", "current"}),
     *                  @OA\Property(property="type", type="string", description="the type of the customer", maxLength=255),
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request Successful"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(UpdateRequest $request, Customer $customer): CustomerResource
    {
        $customer->update($request->validated());

        return new CustomerResource($customer);
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     tags={"Customers"},
     *     summary="Delete customer",
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
    public function destroy(Customer $customer): Response
    {
        $customer->delete();

        return response()->noContent();
    }
}
