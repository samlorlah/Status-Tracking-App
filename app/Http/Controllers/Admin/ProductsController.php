<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductStatus;
use App\Models\PackageCategories;
use App\Models\ClientProductStatus;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index() {
        $products = PackageCategories::all();
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        return view('admin.products.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'currency' => 'required',
            'amount' => 'required',
        ]);

        $product = new PackageCategories;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->currency = $request->currency;
        $product->amount = $request->amount;
        $product->save();

        alert()->success('Product added successfully');
        return redirect(route('admin.products.index'));
    }

    public function delete($id) {
        $product = PackageCategories::find($id);
        $product->delete();

        alert()->success('Product deleted successfully');
        return redirect(route('admin.products.index'));
    }

    public function fetchProduct($id) {
        $product = PackageCategories::find($id);
        return response()->json([
            'product' => $product
        ]);
    }

    public function addStatus()
    {
        return view('admin.products.addstatus');
    }

    public function storeStatus(Request $request)
    {
        $request->validate([
            'program' => 'required|string',
            'name' => 'required',
            'percent' => 'required',
            'tat' => 'required',
            'priority' => 'required',
        ]);

        foreach($request->name as $key => $value) {
            $status = new ProductStatus;
            $status->package_category_id = $request->program;
            $status->name = $value;
            $status->percent = $request->percent[$key];
            $status->priority = $request->priority[$key];
            $status->tat = $request->tat[$key];
            $status->save();
        }

        alert()->success('Status added successfully');
        return redirect(route('admin.products.index'));
    }

    public function addClientStatus()
    {
        return view('admin.products.addclientstatus');
    }

    public function fetchProgramStatus($id)
    {
        $product = PackageCategories::find($id);
        $statuses = $product->statuses;

        return response()->json([
            'statuses' => $statuses
        ]);
    }

    public function storeClientStatus(Request $request)
    {
        $exitingStatus = ClientProductStatus::where('package_category_id', $request->program)->get();
        foreach($exitingStatus as $existing) {
            $stats = json_decode($existing->statuses, true);
            foreach($stats as $stat) {
                if(in_array($stat, $request->statuses)) {
                    alert()->error('One or more of the statuses has been assigned to Client Status.');
                    return back();
                }
            }
        }

        $status = new ClientProductStatus;
        $status->package_category_id = $request->program;
        $status->name = $request->name;
        $status->statuses = json_encode($request->statuses);
        $status->save();

        alert()->success('Status added successfully');
        // return redirect(route('admin.products.index'));
        return back();
    }
}
