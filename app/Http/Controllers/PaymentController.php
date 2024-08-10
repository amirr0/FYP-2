<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function uploadProof(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'transaction_id' => 'required',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $payment = new Payment;
        $payment->order_id = $request->order_id;
        $payment->amount = $request->amount;
        $payment->transaction_id = $request->transaction_id;
        $payment->payment_type = 'proof';

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('payment_proofs'), $filename);
            $payment->payment_proof = $filename;
        }

        $payment->save();

        return redirect()->back()->with('success', 'Payment proof submitted successfully. We will verify and update your order status.');
    }

    public function viewUploadedProofs(Request $request)
    {

        $order_id = $request->order_id;
        $paymentProofs = Payment::where('order_id', $order_id)->get();

        return response()->json(['paymentProofs' => $paymentProofs]);
    }

    public function processStripePayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'stripeToken' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        Stripe::setApiKey("sk_test_51PdpVRG5pw69iY75PLz4ge0j9OsnYOzHdZjd9icD5DvdpiTYaOgXKpgEUDNnJguybEnhEr1QYJ9xtUVkvINtP99c00ZkSOst23");

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment for Order ID: ' . $request->order_id,
            ]);

            $payment = new Payment();
            $payment->order_id = $request->order_id;
            $payment->amount = $charge->amount / 100;
            $payment->transaction_id = $charge->id;
            $payment->payment_type = 'stripe';
            $payment->card_brand = $charge->source->brand;
            $payment->card_last_four = $charge->source->last4;
            $payment->save();

            return back()->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
