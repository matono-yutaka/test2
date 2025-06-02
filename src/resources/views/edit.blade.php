@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')

<form action="{{ url('/products/' . $product->id . '/update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="product-edit-container">
        <div class="breadcrumb">商品一覧 > {{ $product->name }}</div>

        <div class="top-section">
            <div class="image-box">
                <img id="editImagePreview" src="{{ asset('storage/images/fruits-img/' . $product->image) }}" alt="商品画像" class="product-image">
                <input type="file" name="image" id="editImageInput">
                @if ($errors->has('image'))
                    <div style="color: red;">{{ $errors->first('image') }}</div>
                @endif
            </div>

            <div class="product-info">
                <div class="product-field">
                    <label>商品名</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}">
                    @if ($errors->has('name'))
                        <div style="color: red;">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="product-field">
                    <label>値段</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}">
                    @if ($errors->has('price'))
                        <div style="color: red;">{{ $errors->first('price') }}</div>
                    @endif
                </div>

                <div>
                    <label>季節</label><br>
                    @foreach($seasons as $season)
                        <label>
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                            {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                    @endforeach
                    @if ($errors->has('seasons'))
                        <div style="color: red;">{{ $errors->first('seasons') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="description-section">
            <label>商品説明</label><br>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
            @if ($errors->has('description'))
                <div style="color: red;">{{ $errors->first('description') }}</div>
            @endif
        </div>

        <div class="button-wrapper">
            <div class="button-section">
                <a href="{{ url('/products') }}" class="btn">戻る</a>
                <button type="submit" class="btn save">変更を保存</button>
            </div>
</form>

            <form action="{{ url('/products/' . $product->id . '/delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('本当に削除しますか？')" class="delete-button">🗑</button>
            </form>
        </div>
    </div>

<script>
    const previews = [
        { inputId: 'editImageInput', previewId: 'editImagePreview' },
        { inputId: 'registerImageInput', previewId: 'registerImagePreview' }
    ];

    previews.forEach(pair => {
        const input = document.getElementById(pair.inputId);
        const preview = document.getElementById(pair.previewId);

        if (input && preview) {
            input.addEventListener('change', e => {
                const file = e.target.files[0];
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                }
            });
        }
    });
</script>

@endsection

