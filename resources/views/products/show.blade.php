@vite(['resources/css/app.css', 'resources/js/app.js'])

<header class="site-header">
    <a href="{{ route('products.index') }}" class="site-logo">mogitate</a>
</header>

<main class="product-detail-page">
    <div class="product-detail-page__head"></div>

    <div class="product-detail">
        <div class="product-detail__image-area">
            <img
                src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="product-detail__image"
            >
        </div>

        <div class="product-detail__content">
            <h1 class="product-detail__name">{{ $product->name }}</h1>

            <p class="product-detail__price">
                ¥{{ number_format($product->price) }}
            </p>

            <div class="product-detail__section">
                <h2>季節</h2>

                <div class="season-list">
                    @foreach ($product->seasons as $season)
                        <span class="season-tag">{{ $season->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="product-detail__section">
                <h2>商品説明</h2>
                <p class="product-detail__description">
                    {{ $product->description }}
                </p>
            </div>

            <div class="product-detail__actions">
                <a href="{{ route('products.index') }}" class="secondary-button">
                    戻る
                </a>

                <a href="{{ route('products.edit', $product) }}" class="primary-button">
                    変更
                </a>
            </div>
        </div>
    </div>
</main>
