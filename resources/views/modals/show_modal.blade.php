<div id="showModal" data-modal-id="showModal" class="fixed inset-0 bg-gray-600/70 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div class="modal-content relative m-auto bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-1/2 lg:w-2/5 max-w-3xl transition-transform duration-300 ease-out transform scale-95 opacity-0">
        <div class="flex justify-between text-center border-b pb-3 mb-3">
            <div>
                <h2 id="showName" class="text-3xl"></h2>
                <p id="showNameKana" class="text-gray-500 opacity-70"></p>
            </div>
            <div>
                <button class="close-modal text-gray-500 hover:text-gray-700 text-2xl focus:outline-none" data-modal-id="showModal">&times;</button> 
            </div>
        </div>
        <div class="text-left">
            <h3 class="text-2xl">電話番号:</h3>
            <p id="showPhone" class="mb-5"></p>
            <h3 class="text-2xl">メールアドレス:</h3>
            <p id="showEmail" class="mb-5"></p>
            <h3 class="text-2xl">顧客人数:</h3>
            <p class="mb-5"><span id="showCustomersCount"></span>人</p>
        </div>
    </div>
</div>