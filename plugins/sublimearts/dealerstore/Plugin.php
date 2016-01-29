<?php namespace SublimeArts\DealerStore;

use Backend;
use System\Classes\PluginBase;

/**
 * DealerStore Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Dealer Store',
            'description' => 'Provides Dealer Order management',
            'author'      => 'SublimeArts for VerveTronix',
            'homepage'    => 'http://sublimearts.me',
            'icon'        => 'icon-money'
        ];
    }

     public $require = ['SublimeArts.Dealers'];

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
     
        return [
            'SublimeArts\DealerStore\Components\ProductDisplay' => 'productDisplay',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'sublimearts.dealerstore.access_products' => ['tab' => 'Dealer Store', 'label' => 'Allow product management'],
            'sublimearts.dealerstore.access_orders' => ['tab' => 'Dealer Store', 'label' => 'Allow order management']
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'dealerstore' => [
                'label'       => 'Dealer Store',
                'url'         => Backend::url('sublimearts/dealerstore/products'),
                'icon'        => 'icon-money',
                'permissions' => ['sublimearts.dealerstore.*'],
                'order'       => 500,

                'sideMenu' => [
                    'products' => [
                        'label'       => 'Products',
                        'icon'        => 'icon-barcode',
                        'url'         => Backend::url('sublimearts/dealerstore/products'),
                        'permissions' => ['sublimearts.dealerstore.access_products']
                    ],
                    'orders' => [
                        'label'       => 'Orders',
                        'icon'        => 'icon-money',
                        'url'         => Backend::url('sublimearts/dealerstore/orders'),
                        'permissions' => ['sublimearts.dealerstore.access_orders']
                    ]
                ]
            ],
        ];
    }

}
