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

    // 新規登録モーダルを開く
    $('#openEditModal').on('click', function() {
        $('#editModalTitle').text('新規営業担当者登録');
        $('#editForm').find('input[name="_method"]').remove();
        $('#editUserId').val('');
        $('#editName').val('');
        $('#editNameKana').val('');
        $('#editPhone').val('');
        $('#editEmail').val('');
        $('#editSubmitButton').text('登録');
        openModal('editModal');
    });

    //編集モーダルを開く
    $('.open-edit-modal').on('click', function(event) {
        event.stopPropagation(); //行のボタンに対しての伝搬を防ぐ
        const userId = $(this).data('user-id');
        const $userRow = $('.user-row[data-user-id="' + userId + '"]');
        const userData = $userRow.data('user');

        if(userData) {
            $('#editModalTitle').text('営業担当者情報編集');
            $('#editForm').attr('action', '/users/store');
            $('#editUserId').val(userData.id);
            $('#editName').val(userData.name);
            $('#editNameKana').val(userData.name_kana);
            $('#editPhone').val(userData.phone);
            $('#editEmail').val(userData.email);
            $('#editIsAdmin').val(userData.is_admin ? 'admin' : 'sales');
            $('#editSubmitButton').text('更新');
            openModal('editModal');
        }
    });

    //詳細モーダルを開く
    $('.user-row , .open-show-modal').on('click', function(event) {
        if (!$(event.target).closest('.js-no-modal-open').length || $(event.target).closest('.open-show-modal').length) {
            const userData = $(this).data('user');

            if(userData) {
                $('#showName').text(userData.name);
                $('#showNameKana').text(userData.name_kana);
                $('#showPhone').text(userData.phone);
                $('#showEmail').text(userData.phone);
                $('#showCustomersCount').text(userData.customers_count || '0');

                openModal('showModal');
            }
        }
    });

    $('.close-modal').on('click', function() {
        const modalId = $(this).data('modal-id');
        closeModal(modalId);
    });

    $('[data-modal-id]').on('click', function(event) {
        if ($(event.target).is(this)) {
            const modalId = $(this).data('modal-id');
            closeModal(modalId);
        }
    });
});