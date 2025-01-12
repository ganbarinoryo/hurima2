<!--商品詳細ページ-->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/item.css') }}" />
</head>
<body>
<!--ヘッダー-->
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="コーチテック">
            </a>
            
            <!-- 検索バー -->
            <div class="search-bar">
                <input type="text" placeholder="なにをお探しですか？" class="search-input">
            </div>

            <!-- ナビゲーションメニュー -->
            <nav class="nav">
                @guest
                    <a href="/login" class="nav__link__login">ログイン</a>
                    <a href="/register" class="nav__link__register">会員登録</a>
                @else
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <a href="/mypage" class="nav__link__mypage">マイページ</a>
                @endguest
                <a href="/sell" class="nav__link__sell">出品</a>
            </nav>
        </div>
    </header>

<!--商品詳細-->
<main>
<!--商品画像-->
    <div class="item__image">
        <img src="{{ asset('storage/images/' . ($item->images->first()->image_url ?? 'default.png')) }}" alt="商品画像">
    </div>
    <!--商品内容-->
        <div class="item__detail">

        <h1>{{ $item->item_name }}</h1>
        <p class="brand_name">ブランド名<!--ここの欄は無視してください--></p>
        <p class="price">¥{{ number_format($item->price) }} (値段)</p>

        <div class="form__button">
            <button class="form__button-submit" type="submit">購入する</button>
        </div>

        <h2>商品説明</h2>
        <div class="form__input--description">
            <!-- 商品説明を表示 -->
            <textarea 
                id="description" 
                name="description" 
                class="textarea--description @error('description') is-invalid @enderror" 
                rows="5" 
                readonly>{{ $item->description }}</textarea>
        </div>

        <div class="item__data">
            <h2>商品の情報</h2>
            <div class="item__category">
                <h3>カテゴリー</h3>
                <p>{{ $item->category }}</p>
            </div>
            <div class="item__condition">
                <h3>商品の状態</h3>
                <p>{{ $item->condition }}</p>
            </div>
        </div>
    </div>

</main>
    
</body>
</html>