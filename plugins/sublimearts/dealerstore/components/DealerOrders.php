<?php namespace SublimeArts\DealerStore\Components;

use Cms\Classes\ComponentBase;
use Auth;

class DealerOrders extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Dealer Orders',
            'description' => 'Provides access to dealer orders.'
        ];
    }

    public function onRun()
    {
        $this->prepareVars();
    }

    public function prepareVars()
    {
        $pendingOrders = $this->dealer()->orders->where('is_shipped', 0)->toArray();
        $shippedOrders = $this->dealer()->orders->where('is_shipped', 1)->toArray();
        $allOrders = $this->dealer()->orders->toArray();

        $this->page['pendingOrders'] = $pendingOrders;
        $this->page['shippedOrders'] = $shippedOrders;
        $this->page['allOrders'] = $allOrders;
    }

    /**
     * Returns the logged in dealer, if available, and touches
     * the last seen timestamp.
     * @return SublimeArts\Dealers\Models\Dealer
     */
    public function dealer()
    {
        if (!$dealer = Auth::getUser()) {
            return null;
        }

        $dealer->touchLastSeen();

        return $dealer;
    }

}