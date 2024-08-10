<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        // Fetch active packages
        $packages = Package::where('status', 'Active')->get();

        // Initialize the query for PackageItem
        $query = PackageItem::query();

        // Check if 'package' query parameter exists and filter by package_id if so
        if ($request->has('package')) {
            $query->where('package_id', $request->input('package'));
        }

        // Check if 'trashed' query parameter exists and include trashed items if true
        if ($request->has('trashed') && $request->input('trashed') == true) {
            $query->onlyTrashed();
        }

        // Retrieve the items based on the constructed query
        $items = $query->get();

        // Pass the items and packages to the view
        return view('modules.items.index', compact('items', 'packages'));
    }


    // public function index(Request $request, Package $package = null)
    // {



    //     dd($request->has('package'));
    //     // Fetch active packages
    //

    //     // Prepare the query for items
    //     if ($package) {
    //         $query = $package->items();
    //     } else {
    //         $query = PackageItem::query();
    //     }
    //     if () {
    //         $query->where('package_id', $request->input('package'));
    //     }

    //     // Check if the request includes the 'trashed' parameter
    //     if ($request->has('trashed') && $request->input('trashed') == true) {
    //         $query->onlyTrashed();
    //     }

    //     $items = $query->get();

    //     return view('modules.items.index', compact('items', 'packages', 'package'));
    // }
    public function store(Request $request, Package $package)
    {
        $validatedData = $request->validate([
            'item_name.*' => 'required|string|max:255',
            'item_price.*' => 'required|numeric',
            'package_id.*' => 'required|numeric',
        ]);

        $items = [];
        foreach ($validatedData['item_name'] as $key => $itemName) {
            $items[] = [
                'name' => $itemName,
                'price' => $validatedData['item_price'][$key],
            ];
        }

        $package->items()->createMany($items);

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function edit($item_id)
    {
        $item = PackageItem::findOrFail($item_id);

        return response()->json($item);
    }


    public function update(Request $request, PackageItem $item)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Update the item with validated data
            $item->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Item updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Failed to update item. Please try again.');
        }
    }


    public function updateStatus(Request $request, PackageItem $item)
    {
        $request->validate([
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            $status = $request->input('status');
            $item->update(['status' => $status]);
            return back()->with('success', 'Item status updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update item status. Please try again.');
        }
    }

    public function itemPermanentDelete($id)
    {
        try {
            // Find the item with trashed records
            $item = PackageItem::withTrashed()->findOrFail($id);

            // Force delete the item itself
            $item->forceDelete();

            return redirect()->back()->with('success', 'Item permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete Item. Please try again.');
        }
    }


    public function restoreItem($id)
    {
        try {
            // Find the trashed item
            $item = PackageItem::onlyTrashed()->findOrFail($id);

            // Restore the item
            $item->restore();
            return redirect()->back()->with('success', 'Item restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore Item. Please try again. ' . $e->getMessage());
        }
    }


    public function destroy(PackageItem $item)
    {
        try {
            $item->delete();
            return back()->with('success', 'Item has been deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete Item. Please try again.');
        }
    }
}
