<h1>商品詳細</h1>

<img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200">

<p>{{ $product->name }}</p>
<p>¥{{ number_format($product->price) }}</p>
<p>{{ $product->description }}</p>

<a href="{{ route('products.index') }}">戻る</a>