<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductApplication;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function activeApplications() {
        $applications = ProductApplication::where('status', '>', 0)->where('status', '<', 100)->get();
        return view('admin.applications.active', compact('applications'));
    }

    public function viewApplications($id) {
        $program = ProductApplication::where('id', $id)->first();
        return view('admin.applications.view', compact('program'));
    }

    public function changeApplicationStatus($id, Request $request) {
        $program = ProductApplication::where('id', $id)->first();
        $program->status = $request->status;
        $program->save();

        alert()->success('Status changed successfully');
        return back();
    } 
}
