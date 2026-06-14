<h1>商品編集</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif


<form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div>
        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}">
    </div>

    <div>
        <label>値段</label>
        <input type="text" name="price" value="{{ old('price', $product->price) }}">
    </div>

    <div>
        <label>現在の商品画像</label>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200">
    </div>

    <div>
        <label>商品画像</label>
        <input type="file" name="image">
    </div>

    <div>
        <label>季節</label>

        @php
            $selectedSeasons = old('season_ids', $product->seasons->pluck('id')->toArray());
        @endphp

        @foreach ($seasons as $season)
            <label>
                <input
                    type="checkbox"
                    name="season_ids[]"
                    value="{{ $season->id }}"
                    {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}
                >
                {{ $season->name }}
            </label>
        @endforeach
    </div>

    <div>
        <label>商品説明</label>
        <textarea name="description">{{ old('description', $product->description) }}</textarea>
    </div>

    <button type="submit">変更を保存</button>
</form>

<a href="{{ route('products.index') }}">
    戻る
</a>