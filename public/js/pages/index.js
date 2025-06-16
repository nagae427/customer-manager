document.addEventListener('DOMContentLoaded', function() {
    const clickableRows = document.querySelectorAll('.js-clickable-row');

    clickableRows.forEach(row => {
        row.addEventListener('click', function(event) {
            //アクションボタン周辺は押せないように
            if(!event.target.closest('.js-no-link')) {
                const href = this.dataset.href;
                if (href) {
                    window.location.href = href;
                }
            }
        })
    })
})