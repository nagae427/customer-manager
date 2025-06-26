{{--!-- 削除確認モーダル --}}
<div id="deleteConfirmationModal" class="modal-overlay" style="display: none;">  
    <div class="modal-content">
        <div class="modal-header">
            <div></div>
            <h5 class="modal-title">確認</h5>
            <button type="button" class="modal-close js-close-modal" aria-label="閉じる">×</button>
        </div>
        <div class="modal-body">
            <p><span id="modalUserName"></span> を削除しますか？</p> 
            <p>この操作は元に戻せません</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-cancel btn btn-back js-close-modal">キャンセル</button>
            <form action="" id="deleteForm" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-delete btn btn-confirm">削除</button>
            </form>
        </div>
    </div>
</div>