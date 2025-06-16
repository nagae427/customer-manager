document.addEventListener('DOMContentLoaded', function () {
    const openModalButtons = document.querySelectorAll('.js-open-modal');  ///ゴミ箱ボタン
    const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');  // modal全体
    const modalCustomerName = document.getElementById('modalCustomerName');  //削除する人の名前を入れるところ
    const deleteForm = document.getElementById('deleteForm');  //削除フォーム。あとでaction先をしていするため
    const closeModalButtons = document.querySelectorAll('.js-close-modal');  //閉じるボタン

    //モーダルを開く関数
    function openModal(customerId, customerName) {
        //モーダル内の顧客名を更新
        modalCustomerName.textContent = customerName;

        //actionを更新
        deleteForm.action = `/customers/${customerId}`;

        deleteConfirmationModal.style.display = 'flex';

        // ESCキーでの閉じを有効にする
        document.addEventListener('keydown', handleEscapeKey);
    }

    //モーダルを閉じる関数
    function closeModal() {
        // モーダルを直接非表示
        deleteConfirmationModal.style.display = 'none';

        // ESCキーでの閉じを無効にする
        document.removeEventListener('keydown', handleEscapeKey);
    }

    // ESCキーイベントハンドラ
    function handleEscapeKey(event) {
        if (event.key === 'Escape' && deleteConfirmationModal.style.display === 'flex') { // displayがflexの時に判定
            closeModal();
        }
    }


    //クリックされたら開く関数にデータ渡す
    openModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            const customerId = this.getAttribute('data-customer-id');
            const customerName = this.getAttribute('data-customer-name');
            openModal(customerId, customerName);
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