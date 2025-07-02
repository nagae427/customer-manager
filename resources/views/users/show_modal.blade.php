<div id="showModal" class="text-left">
    <h3 class="text-2xl">電話番号:</h3>
    <p class="mb-5">{{ $user->phone }}</p>
    <h3 class="text-2xl">メールアドレス:</h3>
    <p class="mb-5">{{ $user->email }}"</p>
    <h3 class="text-2xl">顧客人数:</h3>
    <p class="mb-5"><span>{{ $user->customers()->count() }}</span>人</p>
</div>