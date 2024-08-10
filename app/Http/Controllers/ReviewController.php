<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index(Request $request)
    {

        $services = Service::where('status', 'Active')->get();
        $reviews = Review::with('service')->latest()->paginate(4);

        if ($request->ajax()) {
            return response()->json($reviews);
        }

        return view('frontend.modules.reviews.index', compact('reviews', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'user_name' => 'required',
            'user_email' => 'required|email',
            'review' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        try {
            DB::beginTransaction();
            Review::create($request->all());
            DB::commit();
            return redirect()->route('reviews.index')->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to create review. Please try again.');
        }
    }
}
