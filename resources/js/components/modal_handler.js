import $ from 'jquery';

$(function() {
    function openModal(modalId) {
        const $modal = $('#' + modalId);
        const $modalContent = $modal.find('> div:first-child');

        $modal.removeClass('hidden').addClass('flex');

        setTimeout(() => {
            $modalContent.removeClass('opacity-0 scale-95').addClass('opacity-100 scale-100');
        }, 100);
    }

    function closeModal(modalId) {
        const $modal = $('#' + modalId);
        const $modalContent = $modal.find('> div:first-child');

        $modalContent.removeClass('opacity-100 scale-100').addClass('opacity-0 scale-95');

        setTimeout(() => {
            $modal.removeClass('flex').addClass('hidden');
        }, 200);
    }

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    function noOpenModal(event) {
        if (!$(event.target).closest('.no-open-modal').length) {

        }
    }

    //モーダルを開く
    $(document).on('click', '.open-modal-btn', function(event) {
        event.preventDefault();
        event.stopPropagation();

        const url = $(this).data('url');
        const title = $(this).data('title');

        if (!url) return;

        $('#commonModalBody').html('<p class="text-center py-8">読み込み中...</p>');
        $('#commonModalTitle').text(title);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
        }).done(function(html) {
            $('#commonModalBody').html(html);
            openModal('commonModal');
        }).fail(function() {
            $('#commonModalBody').html('<p class="text-center text-red-500 py-8">コンテンツの読み込みに失敗しました。');
            openModal('commonModal');
        });
    });

    //送信
     $('#commonModalBody').on('submit', '#editModal,#deleteModal', function(event) {
        //リロードをキャンセルしておく
        event.preventDefault();

        //エラーメッセージと色をクリア
        $('.error-message').text('');
        $(this).find('.border-red-500').removeClass('border-red-500');
        $('#ajax-message-container').addClass('hidden').find('.ajax-message').text('');

        const formData = $(this).serialize();
        const url = $(this).attr('action');

        const $closeButton = $('#closeButton');
        const $cancelButton = $('#cancelButton');
        const $submitButton = $('#submitButton');
        //送信ボタンのメッセージを戻す用
        const originalButtonText = $submitButton.text();
        $closeButton.prop('hidden', true);
        $cancelButton.prop('hidden', true);
        $submitButton.prop('disabled', true).text('処理中...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
        }).done(function(response) {
            if (response.success) {
                localStorage.setItem('successMessage', response.success);
            }

            // モーダルを閉じる
            closeModal('commonModal');

            // ページをリロードする
            window.location.reload();
        }).fail(function(jqXHR) {  //エラーハンドリング用のコールバック関数
            if (jqXHR.status === 422) {
                const errors = jqXHR.responseJSON.errors;
                for(const field in errors) {
                    const errorMessage = errors[field][0];

                    $('#error-' + field).text(errorMessage);
                    $(this).find('[name="' + field + '"]').addClass('border-red-500');
                }
            }
        }).always(function() {
            $closeButton.prop('hidden', false);
            $cancelButton.prop('hidden', false);
            $submitButton.prop('disabled', false).text(originalButtonText);
        });
    });

    //モーダルを閉じる
    $('#commonModal').on('click', '.close-modal', function() {
        closeModal('commonModal');
    });

    $('#commonModal').on('click', function(event) {
        if ($(event.target).is(this) && $('#commonModalBody').find('#showModal').length) {
            const modalId = $(this).data('modal-id');
            closeModal(modalId);
        }
    });

    function activeTab(tabId, color) {
        const $tab = $('#' + tabId);
        const $active = $('.active');
        $active.removeClass('active scale-110');
        $tab.addClass('active');

        setTimeout(() => {
            $active.addClass('opacity-50');
            $tab.removeClass('opacity-50 hover:bg-' + color +'-500').addClass('scale-110');
        }, 100);
    }

    //初めはsalesを表示
    $('.user-row[data-user-role="admin"]').hide();

    //タブで切り替え
    $('#salesBtn').on('click', function() {
        $('.user-row[data-user-role="admin"]').hide();
        $('.user-row[data-user-role="sales"]').show();
        activeTab('salesBtn', 'green');
    });

    $('#adminBtn').on('click', function() {
        $('.user-row[data-user-role="admin"]').show();
        $('.user-row[data-user-role="sales"]').hide();
        activeTab('adminBtn', 'red');
    });

});