<div id="editModal" class="fixed inset-0 bg-gray-600/70 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div class="relative m-auto bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-1/2 lg:w-1/3 max-w-lg transition-transform duration-300 ease-out transform scale-95 opacity-0">
        <div class="flex justify-between text-center border-b pb-3 mb-4">
            <h3 class="text-xl font-semibold" id="editModalTitle"></h3>
            <button class="text-gray-500 hover:text-gray-700 text-2xl focus:outline-none close-modal" data-modal-id="editModal">&times;</button>
        </div>
        <form id="editForm" method="post" action="{{ route('users.store') }}">
            @csrf
            <input type="hidden" id="editUserId" name="id">
            <input type="hidden" name="password"> 
            
            <div class="mb-4">
                <label for="editName" class="block text-gray-700 text-sm font-bold mb-2">営業担当者名<span class="text-red-500">*</span>:</label>
                <input type="text" id="editName" name="name" autocomplete="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" maxlength="50">
                @error('name')
                    <div class="text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="editNameKana" class="block text-gray-700 text-sm font-bold mb-2">営業担当者名(かな)<span class="text-red-500">*</span>:</label>
                <input type="text" id="editNameKana" name="name_kana" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" maxlength="100">
                @error('name_kana')
                    <div class="text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="editPhone" class="block text-gray-700 text-sm font-bold mb-2">電話番号<span class="text-red-500">*</span>:</label>
                <input type="text" id="editPhone" name="phone" autocomplete="tel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('phone')
                    <div class="text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="editEmail" class="block text-gray-700 text-sm font-bold mb-2">メールアドレス<span class="text-red-500">*</span>:</label>
                <input type="email" id="editEmail" name="email" autocomplete="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('email')
                    <div class="text-red-700">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="editIsAdmin" class="block text-gray-700 text-sm font-bold mb-2">権限<span class="text-red-500">*</span>:</label>
                <select name="is_admin" id="editIsAdmin" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="sales">営業担当者</option>
                    <option value="admin">管理者</option>
                </select>
                @error('is_admin')
                    <div class="text-red-700">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded mr-2 close-modal" data-modal-id="editModal">キャンセル</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="editSubmitButton">登録</button>
            </div>
        </form>
    </div>
</div>