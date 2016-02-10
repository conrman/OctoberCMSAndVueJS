// Subscription Form Modal
$('#subscriptionForm').on('shown.bs.modal', function () {
    $('#emailInput').focus()
});

// ---------------------------------- x ----------------------------------
// Dealership request Form Modal
$('#dealershipRequestForm').on('shown.bs.modal', function () {
    $('#company_name').focus()
});

// ---------------------------------- x ----------------------------------
// Countdown Timer
var finalDate = '2016/01/13';
$('div#countdown').countdown(finalDate, {
    elapse: false    
}).on('update.countdown', function(event) {
    $('span#days').html(event.strftime('%D'));
    $('span#hours').html(event.strftime('%H'));
    $('span#minutes').html(event.strftime('%M'));
    $('span#seconds').html(event.strftime('%S'));
    $('b#days-text').html(event.strftime('<b>day%!D</b>'));
    $('b#hours-text').html(event.strftime('<b>hour%!H</b>'));
    $('b#minutes-text').html(event.strftime('<b>minute%!M</b>'));
    $('b#seconds-text').html(event.strftime('<b>second%!S</b>'));
});

// ---------------------------------- x ----------------------------------
// VueJS based Ordering System
new Vue({
    el: '#vue-ordering-system',

    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    
    data: {
        products: [],
    
        lines: {},

        order_total: 0,

        mode: 'create'
    },

    ready: function() {
        if(this.mode == 'edit' || this.mode == 'cancel') {
            this.fetchOrder();
        } 
        this.fetchProducts();
    },

    computed: {
        hasAnOrder: function() {
            return (this.order_total != 0);
        }
    },

    methods: {
        fetchProducts: function() {
            this.$http.get('/dealerstore/products', function(products) {
                this.products = products;
            }.bind(this));
        },

        fetchOrder: function() {
            if(this.mode == 'edit') {
                var orderId = this.getIdFromEditUrl();
            } else if(this.mode == 'cancel') {
                var orderId = this.getIdFromCancelUrl();
            }

            this.$http.get('/dealerstore/orders/' + orderId + '/edit', function(order) {
                this.lines = order;
                this.$dispatch('line-items-updated');
            }.bind(this));
        },

        getIdFromEditUrl: function() {
            var url = window.location.href,
                dirtyId = url.replace('http://' + window.location.hostname + '/dealers/orders/', ''),
                orderId = dirtyId.replace('/edit', '');

            return orderId;
        },

        getIdFromCancelUrl: function() {
            var url = window.location.href,
                dirtyId = url.replace('http://' + window.location.hostname + '/dealers/orders/', ''),
                orderId = dirtyId.replace('/cancel', '');

            return orderId;
        },

        saveOrder: function() {
            var url = '/dealerstore/orders';
            
            this.$http.post(url, this.lines).then(function(response) {
                window.location.replace('/dealers/home');
            }, function(response) {
                console.log('Something went wrong as below:');
                console.log(response);
            });
        },

        saveEditedOrder: function() {
            var orderId = this.getIdFromEditUrl(),
                url = '/dealerstore/orders/' + orderId + '/edit';

            this.$http.post(url, this.lines).then(function(response) {
                window.location.replace('/dealers/home');
            }, function(response) {
                console.log('Something went wrong as below:');
                console.log(response);
            });  
        },

        cancelOrder: function() {
            var orderId = this.getIdFromCancelUrl(),
                url = '/dealerstore/orders/' + orderId + '/cancel';

            this.$http.delete(url).then(function(response) {
                window.location.replace('/dealers/home');
            }, function(response) {
                console.log('Something went wrong as below:');
                console.log(response);
            });  
        }
    },

    events: {
        'line-items-updated': function() {
            var orderTotal = 0;

            for(var lineId in this.lines) {
                if(!this.lines.hasOwnProperty(lineId)) continue;
                orderTotal += this.lines[lineId].value;
            }

            this.order_total = orderTotal;
        }
    },

    components: {
        'line-item': {
            template: '#line-item-template',
    
            props: ['product', 'lines', 'mode'],

            watch: {
                lines: function(val, oldVal) {
                    this.order_qty = (this.lines[this.product.id] != undefined) ? this.lines[this.product.id].order_qty : '';
                }
            },
    
            data: function() {
                return {
                    order_qty: ''
                };
            },
    
            computed: {
                lineValue: function() {
                    return (this.product.dealer_price * this.order_qty);
                },

                isOrdered: function() {
                    return !(this.order_qty == 0);
                },

                wasOrdered: function() {
                    return (this.product.id in this.lines);
                }
            },

            methods: {
                addToOrder: function() {
                    if(this.isOrdered) {
                        this.lines[this.product.id] = {
                            product: {
                                id: this.product.id,
                                name: this.product.name,
                                dealer_price: this.product.dealer_price,
                                code: this.product.code
                            },
                            order_qty: this.order_qty,
                            value: this.lineValue 
                        };
                    } else {
                        delete this.lines[this.product.id];
                    }

                    this.$dispatch('line-items-updated');
                }                
            }
            
        }
    }
});
// ---------------------------------- x ----------------------------------
