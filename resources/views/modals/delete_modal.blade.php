{{--!-- 削除確認モーダル --}}
<div id="deleteModal" data-modal-id="deleteModal" class="fixed inset-0 bg-gray-600/70 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">  
    <div class="modal-content relative m-auto bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-1/2 lg:w-2/5 max-w-3xl transition-transform duration-300 ease-out transform scale-95 opacity-0">
        <div class="flex justify-between text-center border-b pb-3 mb-3">
            <div>
                <h2 class="text-3xl">削除確認</h2>
            </div>
            <div>
                <button class="close-modal text-gray-500 hover:text-gray-700 text-2xl focus:outline-none" data-modal-id="deleteModal">&times;</button> 
            </div>
        </div>
        <div>
            <p><span id="deleteName" class="text-2xl"></span> を削除しますか？</p> 
            <p>この操作は元に戻せません</p>
        </div>

        <form id="deleteForm" method="post" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end pt-4">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded mr-2 close-modal" data-modal-id="deleteModal">キャンセル</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="deleteSubmitButton">削除</button>
            </div>
        </form>
    </div>
</div>