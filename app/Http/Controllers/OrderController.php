<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('client')->get(); // We receive all orders together with their customers

        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var  $validatedData
         * exists:clients,id - Checks that client_id matches an existing client,
         * preventing errors if no such client exists.
         */
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id', // The client's D must exist
            'description' => 'required|string',
            'status' => 'sometimes|string|in:pending,completed',
        ]);

        $order = Order::create($validatedData);

        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /** @var  $order
         *we use findOrFail - if the client with the specified id is not found,
         * Laravel will automatically return a 404 error, which simplifies exception handling.
         */
        $order = Order::with('orders')->findOrFail($id); //We find the Order by ID or return an error

        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id); // We find  order

        // We update the order's data after verification
        /** @var  $validatedData
         *sometimes|required - means that this field is not required to be sent,
         * but if it is, it must meet the validation rules
         */
        $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:clients,email,'.$order->id,
            'phone' => 'sometimes|required|string|max:20',
        ]);

        $order->update($validatedData);

        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Client::findOrFail($id);
        $order->delete();
        /** Code 204 means that the request was completed successfully, but the response contains no content. */
        return response()->json(null, 204); // 204 - successful deletion without content
    }
}
