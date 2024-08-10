<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Service;

class PackageController extends Controller
{
    public function index(Request $request)
    {


        $services  = Service::where('Status', 'Active')->get();
        $query = Package::query();

        // Include trashed users if the 'trashed' parameter is present and true
        if ($request->has('trashed') && $request->trashed == true) {
            $query->onlyTrashed();
        }

        $packages = $query->get();

        $totalPackagesCount = Package::count();
        $activePackagesCount =  Package::where('status', 'Active')->count();
        $inactivePackagesCount =  Package::where('status', 'Inactive')->count();
        $trashedPackagesCount =  Package::onlyTrashed()->count();
        return view('modules.packages.index', compact('packages', 'services', 'totalPackagesCount', 'activePackagesCount', 'inactivePackagesCount', 'trashedPackagesCount'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'package_name' => 'required|string|max:255',
            'package_price' => 'required|numeric',
            'service_id' => 'required|numeric',
            'item_name.*' => 'required|string|max:255',
            'item_price.*' => 'required|numeric',
        ]);

        $package = new Package();
        $package->name = $validatedData['package_name'];
        $package->price = $validatedData['package_price'];
        $package->service_id = $validatedData['service_id'];

        $package->save();

        $items = [];
        foreach ($validatedData['item_name'] as $key => $itemName) {
            $items[] = [
                'name' => $itemName,
                'price' => $validatedData['item_price'][$key],
            ];
        }

        $package->items()->createMany($items);

        return redirect()->route('packages.index')->with('success', 'Package created successfully.');
    }

    public function update(Request $request, Package $package)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Update package details
            $package->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
            ]);

            // Update or create items
            $package->items()->delete(); // Clear existing items
            foreach ($validatedData['items'] as $itemData) {
                $package->items()->create([
                    'name' => $itemData['name'],
                    'price' => $itemData['price'],
                ]);
            }

            DB::commit();



            return redirect()->route('packages.index')->with('success', 'Package updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Failed to update package. Please try again.');
        }
    }

    public function edit($package_id)
    {
        $package = Package::with('items')->findOrFail($package_id);

        return response()->json($package);
    }

    public function destroy(Package $package)
    {
        try {
            // Delete related package items
            $package->Items()->delete();

            // Delete the package itself
            $package->delete();

            return back()->with('success', 'Package has been deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete Package. Please try again.');
        }
    }

    public function updateStatus(Request $request, Package $package)
    {
        $request->validate([
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            $status = $request->input('status');
            $package->update(['status' => $status]);
            return back()->with('success', 'Package status updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update package status. Please try again.');
        }
    }

    public function packagePermanentDelete($id)
    {
        try {
            // Find the package with trashed records
            $package = Package::withTrashed()->findOrFail($id);

            // Force delete related package items
            $package->Items()->withTrashed()->forceDelete();

            // Force delete the package itself
            $package->forceDelete();

            return redirect()->route('services.index')->with('success', 'Package permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete Package. Please try again.');
        }
    }


    public function restorePackage($id)
    {
        try {
            // Find the trashed package
            $package = Package::onlyTrashed()->findOrFail($id);

            // Restore the package
            $package->restore();

            // Restore related package items
            $package->Items()->onlyTrashed()->restore();

            return redirect()->back()->with('success', 'Package restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore Package. Please try again. ' . $e->getMessage());
        }
    }

    public function viewItems(Package $package)
    {
        $packageItems = $package->Items()->get();

        return view('modules.packages.items', compact('package', 'packageItems'));
    }
}
