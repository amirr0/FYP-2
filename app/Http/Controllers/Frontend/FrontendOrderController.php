<?php

namespace App\Http\Controllers\Frontend;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FrontendOrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'transaction_id' => 'required',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Retrieve the total price and selected items from the request
        $totalPrice = $request->input('total_price');
        $selectedItems = json_decode($request->input('items'), true); // Assuming items are JSON encoded

        // Create a new order
        $order = new Order();
        $order->user_id = $user->id;
        $order->total_price = $totalPrice;
        $order->save();

        // Loop through selected items and save them as order items
        foreach ($selectedItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->item_id = $item['id'];
            $orderItem->item_type = $item['type'];
            $orderItem->price = $item['price'];
            $orderItem->save();
        }

        // Create a new payment record
        $payment = new Payment;
        $payment->order_id = $order->id;
        $payment->amount = $totalPrice;
        $payment->transaction_id = $request->transaction_id;
        $payment->payment_type = 'proof';

        // Handle the file upload
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('payment_proofs'), $filename);
            $payment->payment_proof = $filename;
        }

        // Save the payment record
        $payment->save();

        // Return a JSON response
        return response()->json(['message' => 'Order placed successfully. Payment proof submitted successfully. We will verify and update your order status.']);
    }


    public function storeStripe(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'stripeToken' => 'required',
            'total_price' => 'required|numeric', // Ensure total_price is required and numeric
            'items' => 'required|json', // Ensure items are required and valid JSON
        ]);

        $user = Auth::user();
        $totalPrice = $request->input('total_price'); // Total price should be in dollars
        $selectedItems = json_decode($request->input('items'), true); // Decode JSON encoded items

        // Create a new order
        $order = new Order();
        $order->user_id = $user->id;
        $order->total_price = $totalPrice;
        $order->save();

        // Loop through selected items and save them as order items
        foreach ($selectedItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->item_id = $item['id'];
            $orderItem->item_type = $item['type'];
            $orderItem->price = $item['price'];
            $orderItem->save();
        }

        Stripe::setApiKey("sk_test_51PdpVRG5pw69iY75PLz4ge0j9OsnYOzHdZjd9icD5DvdpiTYaOgXKpgEUDNnJguybEnhEr1QYJ9xtUVkvINtP99c00ZkSOst23");

        try {
            // Stripe charge amount should be in cents
            $charge = Charge::create([
                'amount' => $totalPrice * 100, // Convert dollars to cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment for Order ID: ' . $order->id,
            ]);

            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->amount = $charge->amount / 100; // Convert cents to dollars
            $payment->transaction_id = $charge->id;
            $payment->payment_type = 'stripe';
            $payment->card_brand = $charge->source->brand;
            $payment->card_last_four = $charge->source->last4;
            $payment->save();
            return response()->json(['message' => 'Order placed successfully. Payment submitted successfully. We will verify and update your order status.']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while processing the payment. Please try again later.', 'error' => $e->getMessage()], 500);

        }
    }
}
