document.addEventListener('DOMContentLoaded', function () {
    const openModalButtons = document.querySelectorAll('.js-open-modal');  ///ゴミ箱ボタン
    const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');  // modal全体
    const modalCustomerName = document.getElementById('modalCustomerName');  //削除する人の名前を入れるところ
    const deleteForm = document.getElementById('deleteForm');  //削除フォーム。あとでaction先をしていするため
    const closeModalButtons = document.querySelectorAll('.js-close-modal');  //閉じるボタン

    //モーダルを開く関数
    function openModal(customerName, deleteUrl) {
        //モーダル内の顧客名を更新
        modalCustomerName.textContent = customerName;

        //actionを更新
        deleteForm.action = deleteUrl;

        deleteConfirmationModal.style.display = 'flex';
    }

    //モーダルを閉じる関数
    function closeModal() {
        // モーダルを直接非表示
        deleteConfirmationModal.style.display = 'none';
    }

    
    //クリックされたら開く関数にデータ渡す
    openModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            const customerName = this.getAttribute('data-customer-name');
            const deleteUrl = this.getAttribute('data-delete-url');
                        // ⭐ 追加: ここで deleteUrl の値を確認 ⭐
            console.log('Delete URL from data attribute:', deleteUrl);
            openModal(customerName, deleteUrl);
        });
    });

    //閉じるボタンが押されたら閉じる関数を実行
    closeModalButtons.forEach(button => {
        button.addEventListener('click', closeModal);
    });

    //背景をクリックしても閉じれるように
    deleteConfirmationModal.addEventListener('click', function (event) {
        //きちんと背景のみかをチェックしている
        if (event.target === deleteConfirmationModal) {
            closeModal();
        }
    });
})