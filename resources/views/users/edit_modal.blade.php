<form id="editModal" method="post" action="{{ route('users.store') }}">
    @csrf
    <input type="hidden" name="id" value="{{ $user->id }}">
    
    <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">営業担当者名<span class="text-red-500">*</span>:</label>
        <input type="text" name="name" autocomplete="name" value="{{ old('name', $user->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" maxlength="50">
        <div class="text-red-700 mt-1 text-sm error-message" id="error-name"></div>
    </div>
    <div class="mb-4">
        <label for="name_kana" class="block text-gray-700 text-sm font-bold mb-2">営業担当者名(かな)<span class="text-red-500">*</span>:</label>
        <input type="text" name="name_kana" value="{{ old('name_kana', $user->name_kana ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" maxlength="100">
        <div class="text-red-700 mt-1 text-sm error-message" id="error-name_kana"></div>
    </div>
    <div class="mb-4">
        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">電話番号<span class="text-red-500">*</span>:</label>
        <input type="text" name="phone" autocomplete="tel" value="{{ old('phone', $user->phone ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <div class="text-red-700 mt-1 text-sm error-message" id="error-phone"></div>
    </div>
    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">メールアドレス<span class="text-red-500">*</span>:</label>
        <input type="email" name="email" autocomplete="email" value="{{ old('email', $user->email ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <div class="text-red-700 mt-1 text-sm error-message" id="error-email"></div>
    </div>

    <div class="mb-4">
        <label for="is_admin" class="block text-gray-700 text-sm font-bold mb-2">権限<span class="text-red-500">*</span>:</label>
        <select name="is_admin" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="sales" @if(old($user->isSales())) selected @endif>営業担当者</option>
            <option value="admin" @if(old($user->isAdmin())) selected @endif>管理者</option>
        </select>
        <div class="text-red-700 mt-1 text-sm error-message" id="error-is_admin"></div>
    </div>

    <div class="flex justify-end pt-4">
        <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded mr-2 close-modal" data-modal-id="editModal" id="cancelButton">キャンセル</button>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="submitButton">
            {{ isset($user) ? '更新' : '登録' }}
        </button>
    </div>
</form>