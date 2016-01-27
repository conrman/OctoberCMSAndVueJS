// Subscription Form Modal
$('#subscriptionForm').on('shown.bs.modal', function () {
    $('#emailInput').focus()
});

// Dealership request Form Modal
$('#dealershipRequestForm').on('shown.bs.modal', function () {
    $('#company_name').focus()
});

$('#dealershipRequestForm button#submit').on('click', function() {
    ('#dealershipRequestForm').modal('hide');
})

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