<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\ProductStatus;
use App\Models\PackageCategories;
use App\Models\ProductApplication;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\ApplicationStatusGrid;
use App\Mail\UserApplicationNotification;
use App\Mail\AdminApplicationNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    public function apply() {
        return view('products.apply');
    }

    public function fetchProduct($id) {
        $product = PackageCategories::find($id);
        return response()->json([
            'product' => $product
        ]);
    }

    public function submitApplication(Request $request) {
        $request->validate([
            'id_type' => 'required',
            'id_number' => 'required',
            'issue_date' => 'required',
            'dependants' => 'required',
            'program' => 'required',
            'amount' => 'required',
            'residential_address' => 'required',
            'passport' => 'required',
        ]);
        
        $statuses = ProductStatus::where('package_category_id', $request->program)->orderBy('priority', 'asc')->get();
        if(count($statuses) < 1) {
            alert()->error('There is no status for this program.');
            return back();
        }

        $apply = new ProductApplication;
        $apply->user_id = auth()->user()->id;
        $apply->dependants = $request->dependants;
        $apply->residential_address = $request->residential_address;
        $apply->product = $request->program;
        $apply->currency = explode(' ', $request->amount)[0];
        $apply->amount_due = explode(' ', $request->amount)[1];
        $apply->id_type = $request->id_type;
        $apply->id_number = $request->id_number;
        $apply->issue_date = Carbon::parse(str_replace('/', '-', $request->issue_date))->format('Y-m-d');
        $apply->expiry_date = Carbon::parse(str_replace('/', '-', $request->expiry_date))->format('Y-m-d');

        $file = $request->file('passport');
        $extension = $file->getClientOriginalExtension();
        $filename = auth()->user()->firstname . "-" .auth()->user()->id.'-'.time().'.'.$extension;
        $file->move(public_path('passport'), $filename);
        $apply->passport = $filename;

        $file = $request->file('id_card');
        $extension = $file->getClientOriginalExtension();
        $filename = auth()->user()->firstname . "-" .auth()->user()->id.'-'.time().'.'.$extension;
        $file->move(public_path('id_card'), $filename);
        $apply->id_card = $filename;
        $apply->save();

        foreach($statuses as $status) {
            $grid = new ApplicationStatusGrid;
            $grid->application_id = $apply->id;
            $grid->status_id = $status->id;
            $grid->save();
        }

        Mail::to(auth()->user()->email)->send(new UserApplicationNotification($apply));
        Mail::to(Admin::all())->send(new AdminApplicationNotification($apply));

        alert()->success('Your application has been submitted successfully');
        return redirect(route('dashboard'));
    }
}
