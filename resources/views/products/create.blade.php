@vite(['resources/css/app.css', 'resources/js/app.js'])

<header class="site-header">
    <a href="{{ route('products.index') }}" class="site-logo">mogitate</a>
</header>

<main class="product-form-page">
    <div class="product-form-page__head">
        <h1>商品登録</h1>
    </div>

    <div class="product-form-layout product-form-layout--single">
        <div class="product-form-card">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
                @csrf

                <div class="form-group">
                    <label>
                        商品名
                        <span class="required-label">必須</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}">

                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        値段
                        <span class="required-label">必須</span>
                    </label>
                    <input type="text" name="price" value="{{ old('price') }}">

                    @error('price')
                        <P class="form-error">{{ $message }}</P>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        商品画像
                        <span class="required-label">必須</span>
                        <span class="multiple-label">複数選択可</span>
                    </label>
                    <input type="file" name="image">

                    @error('image')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        季節
                        <span class="required-label">必須</span>
                    </label>

                    <div class="checkbox-group">
                        @foreach ($seasons as $season)
                            <label class="checkbox-label">
                                <input 
                                type="checkbox" 
                                name="season_ids[]" 
                                value="{{ $season->id }}"
                                {{ in_array($season->id, old('season_ids', [])) ? 'checked' : '' }}
                                >
                                {{ $season->name }}
                            </label>
                        @endforeach
                    </div>

                    @error('season_ids')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        商品説明
                        <span class="required-label">必須</span>
                    </label>
                    <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea>

                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="product-form-actions">
                    <a href="{{ route('products.index') }}" class="secondary-button">
                        戻る
                    </a>

                    <button type="submit" class="primary-button">
                        登録
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>