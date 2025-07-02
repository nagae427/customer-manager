<div>
    <div>
        <p><span class="text-2xl">{{ $user->name }}</span> さんを削除しますか？</p> 
        <p>この操作は元に戻せません</p>
    </div>

    <form id="deleteModal" method="post" action="{{ route('users.delete', $user) }}">
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">
        <div class="flex justify-end pt-4">
            <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded mr-2 close-modal" data-modal-id="deleteModal" id="cancelButton">キャンセル</button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="submitButton">削除</button>
        </div>
    </form>
</div>
