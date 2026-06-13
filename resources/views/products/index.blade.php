<h1>商品一覧</h1>

@foreach ($products as $product)
    <a href="{{ route('products.show', $product) }}">
        <div>
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
            width="200">

            <p>{{ $product->name }}</p>

            <p>¥{{ number_format($product->price) }}</p>
        </div>
    </a>
@endforeach

<form action="{{ route('products.search') }}" method="GET">
    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索">

    <select name="sort">
        <option value="">価格で並び替え</option>
        <option value="high">高い順に表示</option>
        <option value="low">低い順に表示</option>
    </select>

    <button type="submit">検索</button>
</form>

    <a href="{{ route('products.create') }}">
        +商品を追加
    </a>

{{ $products->links() }}