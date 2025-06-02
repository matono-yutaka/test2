@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="product-page">
    <div class="header">
    <h1 class="title">商品一覧</h1>
    <a href="{{ url('/products/register') }}" class="add-button">+ 商品を追加</a>
    </div>

    <div class="layout">
        <div class="sidebar">
            <form method="GET" action="{{ url('/products/search') }}" class="search-form">
                <input type="text" name="keyword" placeholder="商品名で検索">
                <button type="submit">検索</button>

            <div class="sort-form">
                <label>価格順で表示</label><br>
                <select name="sort" onchange="this.form.submit()">
                    <option value="">価格で並べ替え</option>
                    <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>低い順に表示</option>
                </select>
            </div>
            </form>

            @if(request('sort'))
                <div class="sort-tag">
                    並び替え: {{ request('sort') == 'high' ? '高い順' : '低い順' }}
                    <a href="{{ url('/products') }}">×</a>
                </div>
            @endif
        </div>

        <div class="product-list">
            @foreach($products as $product)
                <a href="{{ url('/products/' . $product->id) }}" class="product-card-link">
                <div class="product-card">
                    <img src="{{ asset('storage/images/fruits-img/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="card-info">
                        <h5>{{ $product->name }}</h5>
                        <p>￥{{ number_format($product->price) }}</p>
                    </div>
                </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="pagination">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection
