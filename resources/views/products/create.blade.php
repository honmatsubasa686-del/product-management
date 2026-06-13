<h1>商品登録</h1>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div>
        <label>商品名</label>
        <input type="text" name="name">
    </div>
    <div>
        <label>値段</label>
        <input type="text" name="price" value="{{ old('price') }}">
    </div>
    <div>
        <label>商品説明</label>
        <textarea name="description"></textarea>
    </div>
    <div>
        <label>季節</label>
        @foreach ($seasons as $season)
            <label>
                <input type="checkbox" name="season_ids[]" value="{{ $season->id }}">
                {{ $season->name }}
            </label>
        @endforeach
    </div>
    <div>
        <label>商品画像</label>
        <input type="file" name="image">
    </div>

    <button type="submit">登録</button>
</form>

<a href="{{ route('products.index') }}">
    戻る
</a>