document.addEventListener('DOMContentLoaded', function () {
    const messages = document.querySelectorAll('.message-container .message');

    if (messages.length > 0) {
        messages.forEach(message => {
            setTimeout(() => {
                message.remove();
            }, 5000);
        });
    }
});