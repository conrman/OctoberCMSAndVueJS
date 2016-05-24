### VerveTronix.com

A draft website for VerveTronix (never used)

### Created By

[SublimeArts](http://www.sublimearts.me)

### Notes

Includes my first draft of an Ordering System built using VueJS. The code was just meant to "make it work". A lot of abstraction needs to happen now. Anyways, here is what you might want to know

- The HTML 
    - `themes/vervetronix/pages/dealer-order.htm`
    - `themes/vervetronix/pages/dealer-order-cancel.htm`
- The JavaScript
    - `themes/vervetronix/assets/js/custom.js`
    - There is also a JSFiddle with just the VueJS frontend stuff [here](https://jsfiddle.net/pratyushpundir/qrz48tdx/7/)
- The PHP
    - the routes - `plugins/sublimearts/dealerstore/routes.php`
- Test Dealer credentials (for the dealer login):
    - default login page: `http://localhost:8000/dealers/login` assuming that you are running the built-in laravel server
    - email: tester2@dealer.com
    - password: tester

### Instructions

- Run `git clone https://github.com/pratyushpundir/OctoberCMSAndVueJS.git`.
- In the root of the project, run `composer update`.
- Add your MySQL credentials and DB info in `.env.example` and rename the file to just `.env`.
- Run `php artisan october:up`.
- Either setup a VirtualHost or just use the built-in server by running `php artisan serve`.