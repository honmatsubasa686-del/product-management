@vite(['resources/css/app.css', 'resources/js/app.js'])

<header class="site-header">
    <a href="{{ route('products.index') }}" class="site-logo">mogitate</a>
</header>

<main class="products-page">
    <div class="products-page__head">
        @if (request('keyword'))
            <h1>"{{ request('keyword') }}"の商品一覧</h1>
        @else
            <h1>商品一覧</h1>
        @endif

        <a href="{{ route('products.create') }}" class="add-button">
            + 商品を追加
        </a>
    </div>

    <div class="products-layout">
        <aside class="products-sidebar">
            <form action="{{ route('products.search') }}" method="GET" class="search-form">
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}" placeholder="商品名で検索"
                    class="search-form__input"
                >

                <button type="submit" class="search-form__button">検索</button>

                <p class="search-form__label">価格順で表示</p>

                <select name="sort" class="search-form__select">
                    <option value="">価格で並び替え</option>
                    <option value="high" {{ request('sort') === 'high' ? 'selected' : '' }}>
                        高い順に表示
                    </option>
                    <option value="low" {{ request('sort') === 'low' ? 'selected' : '' }}>
                        低い順に表示
                    </option>
                </select>
            </form>

            @if (request('sort'))
                <div class="sort-tag">
                    @if (request('sort') === 'high')
                        <span>高い順に表示</span>
                    @elseif (request('sort') === 'low')
                        <span>低い順に表示</span>
                    @endif

                    <a href="{{ route('products.search', ['keyword' => request('keyword')]) }}">×</a>
                </div>
            @endif
        </aside>

        <section class="products-main">
            <div class="product-grid">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="product-card">
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="product-card__image"
                        >

                        <div class="product-card__body">
                            <span class="product-card__name">{{ $product->name }}</span>
                            <span class="product-card__price">¥{{ number_format($product->price) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pagination">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </section>
    </div>
</main>