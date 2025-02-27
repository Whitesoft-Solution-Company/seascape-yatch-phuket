@php

    $invoice_no = $Booking->booking_code;
    $payment_description = '2c2p';
    $order_id = $Booking->id . $Booking->statement_id;
    $merchant_id = env('merchant_id');
    $secret_key = env('secret_key');
    $result_url_1 = 'https://seascapeyachtphuket.com/payment/success';

    $version = env('version');
    $payment_url = env('payment_url');
    $currency = env('currency');

    //amount
    if ($Booking->arrearage > 0) {
        if ($Booking->arrearage == $Booking->amount) {
            $amounts = $Booking->pledge;
        } else {
            $amounts = $Booking->arrearage;
        }
    } else {
        $amounts = $Booking->amount;
    }
    $amount = sprintf('%012d', (int) $amounts * 100);
    $params = $version . $merchant_id . $payment_description . $order_id . $currency . $amount . $result_url_1;
    $hash_value = hash_hmac('sha256', $params, $secret_key, false);

@endphp

<form id="form2c" name="form2c" method="POST" action="<?php echo $payment_url; ?>">
    @csrf
    
    <input type="hidden" name="version" value="<?php echo $version; ?>" />
    <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>" />
    <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
    <input type="hidden" name="result_url_1" value="<?php echo $result_url_1; ?>" />
    <input type="hidden" name="hash_value" value="<?php echo $hash_value; ?>" />
    <input type="hidden" name="payment_description" value="<?php echo $payment_description; ?>" />
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
    <input type="hidden" name="amount" value="<?php echo $amount; ?>" />

</form>

<script>
    window.onload = function() {
        document.forms['form2c'].submit();
    }
</script>
