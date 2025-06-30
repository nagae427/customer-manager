import $ from 'jquery';

$(function() {
    const $message = $('.message');

    setTimeout(() => {
        $message.remove();
    }, 5000);
});
