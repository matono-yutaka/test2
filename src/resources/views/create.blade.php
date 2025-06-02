@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')


<form action="/products/register" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="product-create-container">
        <div class="header">
            <h1 class="title">商品登録</h1>
        </div>
        <div class="top-section">

            <div class="product-info">
                <div class="product-field">
                    <label>商品名 <span class="required-label">必須</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
                    @if ($errors->has('name'))
                        <div style="color: red;">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="product-field">
                    <label>値段 <span class="required-label">必須</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" placeholder="値段を入力">
                    @if ($errors->has('price'))
                        <div style="color: red;">{{ $errors->first('price') }}</div>
                    @endif
                </div>

                <div class="image-box">
                <label>商品画像 <span class="required-label">必須</span></label>
                    <img id="registerImagePreview">
                        <input type="file" name="image" id="registerImageInput">
                        @if ($errors->has('image'))
                        <div style="color: red;">{{ $errors->first('image') }}</div>
                        @endif
                </div>

                <div>
                    <label>季節 <span class="required-label">必須</span><span class="note-text">複数選択可</span></label><br>
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
            <label>商品説明 <span class="required-label">必須</span></label><br>
            <textarea name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @if ($errors->has('description'))
                <div style="color: red;">{{ $errors->first('description') }}</div>
            @endif
        </div>

        <div class="button-section">
            <a href="{{ url('/products') }}" class="btn">戻る</a>
            <button type="submit" class="btn save">登録</button>
        </div>
    </div>
</form>

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

