<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var  $clients
         *we use with('orders') because it allows you to retrieve all orders for each customer in one request,
         * which optimizes work with the database and reduces the number of requests.
         */

        $clients = Client::with('orders')->get(); // We receive all customers together with their orders

        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // We check the input data to avoid errors
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clients',
            'phone' => 'required|string|max:20',
        ]);

        // We create a new client
        $client = Client::create($validatedData);

        return response()->json($client, 201); // 201 is the code for successful resource creation
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /** @var  $client
         *we use findOrFail - if the client with the specified id is not found,
         * Laravel will automatically return a 404 error, which simplifies exception handling.
         */
        $client = Client::with('orders')->findOrFail($id); //We find the client by ID or return an error

        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id); // We find a client

        // We update the client's data after verification
        /** @var  $validatedData
         *sometimes|required - means that this field is not required to be sent,
         * but if it is, it must meet the validation rules
         */
        $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:clients,email,'.$client->id,
            'phone' => 'sometimes|required|string|max:20',
        ]);

        $client->update($validatedData);

        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    /** The destroy method takes the client id,
     * removes it from the database, and returns an empty response with a status of 204.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
    /** Code 204 means that the request was completed successfully, but the response contains no content. */
        return response()->json(null, 204); // 204 - successful deletion without content
    }

}
