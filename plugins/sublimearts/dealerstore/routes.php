<?php

use SublimeArts\DealerStore\Models\Product;
use SublimeArts\DealerStore\Models\LineItem;
use SublimeArts\DealerStore\Models\Order;

use SublimeArts\Dealers\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use October\Rain\Support\Facades\Flash;
use Illuminate\Support\Facades\Session;

// Get All Products
Route::get('/dealerstore/products', function() {
    return Product::all()->toArray();
});


// Save a New Order
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

// Load an order for editing
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

// Save an Edited Order
Route::post('/dealerstore/orders/{id}/edit', function($id, Request $data) {
    if(!Auth::check()) {
        return 'No dealer logged in..';
    } else {
        $dealer = Auth::getUser();
    }

    $order = Order::where('id', $id)->first();
    $rcvdLineItems = $data->all();
    $oldLineItems = $order->lineItems;

    if($dealer->id !== $order->dealer->id) {
        return "error";
    }

    foreach($oldLineItems as $oldLineItem) 
    {
        if(!array_has($rcvdLineItems, $oldLineItem->product_id)) {
            // Product qty was zeroed out during editing
            $oldLineItem->delete();
            $order->updateTotal();
            $order->save();
        } else {
            foreach($rcvdLineItems as $rcvdProductId => $rcvdLineItem)
            {
                if($oldLineItem->product_id == $rcvdProductId) {
                    $line = $oldLineItem;
                } else {
                    $line = new LineItem;
                    $line->order_id = $order->id;
                    $line->product_id = $rcvdProductId;
                }

                $line->product_qty = $rcvdLineItem['order_qty'];
                $line->value = $rcvdLineItem['value'];
                $line->save();
            }
        }
    }

    $order->updateTotal();
    $order->save();

    if($order->save()) {
        Flash::success('Your order was saved! A confirmation will be emailed to you shortly.');
    } else {
        Flash::error('Oh Snap! Something went wrong! Please retry.');
    }
});


Route::delete('/dealerstore/orders/{id}/cancel', function($id) {
    if(!Auth::check()) {
        return 'No dealer logged in..';
    } else {
        $dealer = Auth::getUser();
    }

    $order = Order::where('id', $id)->first();

    if($dealer->id !== $order->dealer->id) {
        return "error";
    }

    $order->delete();
    Flash::success('Your order was cancelled! A confirmation will be emailed to you shortly.');
});