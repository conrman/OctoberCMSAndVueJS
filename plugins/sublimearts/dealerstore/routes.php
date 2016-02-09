<?php

use SublimeArts\DealerStore\Models\Product;
use SublimeArts\DealerStore\Models\LineItem;
use SublimeArts\DealerStore\Models\Order;

use SublimeArts\Dealers\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use October\Rain\Support\Facades\Flash;
use Illuminate\Support\Facades\Session;

Route::get('/dealerstore/products', function() {
    return Product::all()->toArray();
});

Route::post('/dealerstore/orders', function(Request $data) {
    $dirtyOrder = $data->all();

    if(!Auth::check()) {
        return 'No Logged In User';
    } else {
        $dealer = Auth::getUser();
    }

    $order = new Order;
    $order->dealer_id = $dealer->id;
    $order->save();

    foreach($dirtyOrder as $lineItem) {
        $lineModel = new LineItem;
        $lineModel->product_id = $lineItem['product']['id'];
        $lineModel->product_qty = $lineItem['order_qty'];
        $lineModel->order_id = $order->id;
        $lineModel->save();
    }

    $order->save();

    if($order->save()) {
        Flash::success('Your order was saved! A confirmation will be emailed to you shortly.');
    } else {
        Flash::error('Oh Snap! Something went wrong! Please retry.');
    }

});
