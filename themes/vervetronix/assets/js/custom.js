new Vue({
    el: '#vue-app',

    methods: {
        subscribeCustomer: function() {
            alert('Customer Subscribed');
        }
    }
});

$('#subscriptionForm').on('shown.bs.modal', function () {
    $('#emailInput').focus()
});

