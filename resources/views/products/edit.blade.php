@vite(['resources/css/app.css', 'resources/js/app.js'])

<header class="site-header">
    <a href="{{ route('products.index') }}" class="site-logo">mogitate</a>
</header>

<main class="product-form-page">
    <div class="product-form-page__head">
        <div class="breadcrumb">
            <a href="{{ route('products.index') }}">商品一覧</a>
            <span>＞</span>
            <span>{{ $product->name }}</span>
        </div>
    </div>

    <div class="product-form-layout">
        <div class="product-form-image">
            <p class="product-form-image__label">現在の商品画像</p>
            <img 
                src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="product-form-image__img"
            >
        </div>

        <div class="product-form-card">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="product-form">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label>商品名</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>値段</label>
                    <input type="text" name="price" value="{{ old('price', $product->price) }}">
                    @error("price")
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>商品画像</label>
                    <input type="file" name="image">
                    @error('image')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>季節</label>
                
                    @php
$selectedSeasons = old('season_ids', $product->seasons->pluck('id')->toArray());
                    @endphp

                    <div class="checkbox-group">
                        @foreach ($seasons as $season)
                            <label class="checkbox-label">
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

                    @error('season_ids')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>


                <div class="form-group">
                    <label>商品説明</label>
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>

                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="product-form-actions">
                    <a href="{{ route('products.index') }}" class="secondary-button">
                        戻る
                    </a>

                    <button type="submit" class="primary-button">
                        変更を保存
                    </button>
                </div>
            </form>

            <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
            
                <button type="submit" class="delete-button">
                    削除
                </button>
            </form>
        </div>
    </div>
</main>