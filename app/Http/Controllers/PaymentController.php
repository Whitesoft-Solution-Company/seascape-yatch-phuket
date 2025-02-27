<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($bid = null)
    {
        

        if ($bid) {
            $Booking = Booking::where('id', $bid)->orderBy('id', 'desc')->first();
        } else {
            $Booking = Booking::where('statement_status', 'unpaid')->where('user_id', auth()->id())->orderBy('id', 'desc')->first();
        }

        
        return view('payment.2c2p', compact('Booking'));
    }

    public function payment_success(Request $request)
    {


        $data = $request->all();
      
        $booking = Booking::where('id', $data['order_id'])
            ->where('booking_status', 'unpaid')
            ->first();
        if (!$booking) {
            return redirect()->route('home')->with('alert', [
                'type' => 'warning',
                'title' => 'An error occurred.!',
                'message' => 'Payment completed But unable to record the program Please contact the staff.',
            ]);
        }

        if ($data['payment_status'] == '000') {
      

            if ($this->updatepayment($data, $booking, 'success')) {
                $this->updatebooking($data);

                return redirect()->route('booking_detail');
            } else {
                return redirect()->route('home')->with('alert', [
                    'type' => 'warning',
                    'title' => 'An error occurred.!',
                    'message' => 'Payment completed But unable to record the program Please contact the staff.
',
                ]);
            }
        } else if ($data['payment_status'] == '003') {
         
            if ($this->updatepayment($data, $booking, 'unpaid')) {
                return redirect()->route('home')->with('alert', [
                    'type' => 'warning',
                    'title' => 'An error occurred.!',
                    'message' => 'Completed reservation Please make payment within 30 minutes.',
                ]);
            } else {
                return redirect()->route('home')->with('alert', [
                    'type' => 'warning',
                    'title' => 'An error occurred.!',
                    'message' => 'Unable to save the program Please contact the staff.',
                ]);
            }
        } else {
     
            return redirect()->route('home')->with('alert', [
                    'type' => 'warning',
                    'title' => 'There was an error in payment.',
                    'message' => 'Please capture the screen and contact the staff.',
            ]);
        }
    }

    public function updatepayment($data, $booking, $status)
    {

        $payment = Payment::updateOrCreate(
            [
                'booking_id' => $data['order_id']
            ],
            [
                'user_id' => $booking->user_id,
                'account' => $data['transaction_ref'] ?? 0,
                'type' => 'website',
                'name' =>  '-',
                'amount' => str_replace(',', '', number_format($data['amount'] / 100, 2)),
                'bank' => $data['paid_agent'] ?? '-',
                'transfer_time' => $data['transaction_datetime'] ??  now()->format('Y-m-d H:i:s'),
                'slip' => ($data['paid_agent'] ?? 'unpaid') . '.png',
                'admin_id' => 0,
                'status' => $status,
            ]

        );


        return $payment;
    }

    public function updatebooking($data)
    {
        $booking =  Booking::where('id', $data['order_id'])
            ->update(['booking_status' => 'confirmed', 'statement_status' => 'paid']);

        return $booking;
    }
}
