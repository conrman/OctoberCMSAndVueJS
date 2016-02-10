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

Route::get('/dealerstore/orders/{id}/edit', function($id) {
    $dirtyOrder = Order::with('lineItems.product')->where('id', $id)->first();

    $order = [];

    foreach($dirtyOrder->lineItems as $item)
    {
        $order[$item->product->id] = [
            'product' => [
                'name' => $item->product->name,
                'dealer_price' => $item->product->dealer_price,
                'id' => $item->product->id,
            ],
            'order_qty' => $item->product_qty,
            'value' => $item->value
        ];
    }

    return $order;
});

Route::post('/dealerstore/orders/{id}/edit', function($id, Request $data) {
    if(!Auth::check()) {
        return 'No dealer logged in..';
    } else {
        $dealer = Auth::getUser();
    }

    $order = Order::where('id', $id)->first();
    $dirtyOrder = $data->all();
    $oldLineItems = $order->lineItems;

    if($dealer->id !== $order->dealer->id) {
        return "error";
    }

    $dirtyOrder = $data->all();
    foreach($dirtyOrder as $rcvdProductId => $rcvdLineItem) {
        foreach($oldLineItems as $oldLineItem) {
            if($oldLineItem->product_id == $rcvdProductId) {
                if($rcvdLineItem['order_qty'] != 0) {
                    $oldLineItem->product_qty = $rcvdLineItem['order_qty'];
                    $oldLineItem->value = $rcvdLineItem['value'];
                    $oldLineItem->save();
                } else {
                    $oldLineItem->delete();
                }
            } else {
                $newLineItem = new LineItem;
                $newLineItem->order_id = $order->id;
                $newLineItem->product_id = $rcvdProductId;
                $newLineItem->product_qty = $rcvdLineItem['order_qty'];
                $newLineItem->value = $rcvdLineItem['value'];
                $newLineItem->save();
            }
        }
    }

    $order->save();


    if($order->save()) {
        Flash::success('Your order was saved! A confirmation will be emailed to you shortly.');
    } else {
        Flash::error('Oh Snap! Something went wrong! Please retry.');
    }
});
