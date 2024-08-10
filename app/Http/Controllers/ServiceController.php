<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        // Include trashed users if the 'trashed' parameter is present and true
        if ($request->has('trashed') && $request->trashed == true) {
            $query->onlyTrashed();
        }

        $services = $query->get();

        $totalServicesCount = Service::count();
        $activeServicesCount =  Service::where('status', 'Active')->count();
        $inactiveServicesCount =  Service::where('status', 'Inactive')->count();
        $trashedServicesCount =  Service::onlyTrashed()->count();
        return view('modules.services.index', compact('services', 'totalServicesCount', 'activeServicesCount', 'inactiveServicesCount', 'trashedServicesCount'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'icon' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $service = Service::create($validatedData);

            DB::commit();
            return redirect()->route('services.index')->with('success', 'Service created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to create service. Please try again.');
        }
    }

    public function update(Request $request, Service $service)
    {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'icon' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $service->update($validatedData);

            DB::commit();
            return redirect()->route('services.index')->with('success', 'Service updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Failed to update service. Please try again.');
        }
    }

    public function edit(Request $request,$service_id)
    {
        $service = Service::find($service_id);
        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return back()->with('success', 'Service has been deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete Service. Please try again.');
        }
    }

    public function updateStatus(Request $request, Service $service)
    {
        try {
            $status = $request->input('status');
            $service->update(['status' => $status]);
            return back()->with('success', 'Service status updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update service status. Please try again.');
        }
    }

    public function servicePermanentDelete($id)
    {
        try {
            $service = Service::withTrashed()->findOrFail($id);
            $service->forceDelete();
            return redirect()->route('services.index')->with('success', 'Service permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete Service. Please try again.');
        }
    }

    public function restoreService($id)
    {

        try {
            $service = Service::onlyTrashed()->findOrFail($id);
            $service->restore();
            return redirect()->back()->with('success', 'Service restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore Service. Please try again.' . $e->getMessage());
        }
    }
}
