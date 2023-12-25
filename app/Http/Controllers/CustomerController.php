<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->perPage ?? 5;
        $keyword = $request->keyword;

        $query = Customer::query();

        if ($keyword) {
            $query = $query->where('name', 'like', '%' . $keyword . '%');
            // $query->orWhere('email', 'like', '%' . $keyword . '%');
        }

        return $query->orderByDesc('id')->paginate($perPage)->withQueryString();
    }

    public function show(Customer $customer) {
        return $customer;
    }
    //Store News Customer
    function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:70|unique:customers',
            'mobile' => 'required|string|max:14'
        ]);

        $customer = Customer::create($validated);
        return response()->json($customer, Response::HTTP_CREATED);
    }

    public function update(Request $request, Customer $customer) {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:70|unique:customers',
            'mobile' => 'required|string|max:14'
        ]);

        $customer->update($validated);

        return response()->json($customer);
    }

    public function destroy(Customer $customer) {
        $customer->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


}
