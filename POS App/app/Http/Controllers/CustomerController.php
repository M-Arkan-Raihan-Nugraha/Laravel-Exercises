<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::all();
        return view('customer.index', compact('data'));
    }

    public function create()
    {
        return view('customer.form');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Customer::create($request->all());
            DB::commit();
            return redirect('customer')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('customer')->with('error', $e->getMessage());
        }
    }

    public function edit(Customer $customer)
    {
        return view('customer.form_edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        DB::beginTransaction();
        try {
            $customer->update($request->all());
            DB::commit();
            return redirect('customer')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('customer')->with('error', $e->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect('customer')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('customer')->with('error', $e->getMessage());
        }
    }
}