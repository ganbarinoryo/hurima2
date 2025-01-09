<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
</head>
<body>

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

        <div class="flex__sell-form__heading">
            <h1>商品の出品</h1>
        </div>

    <div class="flex__sell__content">

    <form action="">

        <div class="form__group">
            <div class="form__group-content">
                <h3>商品画像</h3>
                <div class="form__input--img">
                <!-- ファイル選択用のカスタムラベル -->
                    <input class="input--img"type="file" id="product_image" name="product_image" accept="image/*" class="@error('product_image') is-invalid @enderror" hidden/>
                <label for="product_image" class="file-label">画像を選択する</label>
                </div>
                <div class="form__error">
                <!-- バリデーション追加してから記述 -->
                </div>
            </div>
        </div>


        <h2>商品の詳細</h2>

        <div class="form__group">
            <div class="form__group-content">
                <h3>カテゴリー</h3>
                <div class="form__input--text">
                    <input type="text" id="category" name="category" value="{{ old('category') }}" class="@error('category') is-invalid @enderror"/>
                </div>
                <div class="form__error">
                <!--バリデーション追加してから記述-->
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-content">
                <h3>商品の状態</h3>
                <div class="form__input--text">
                    <input type="text" id="condition" name="condition" value="{{ old('condition') }}" class="@error('condition') is-invalid @enderror"/>
                </div>
                <div class="form__error">
                <!--バリデーション追加してから記述-->
                </div>
            </div>
        </div>

        <h2>商品名と説明</h2>

        <div class="form__group">
            <div class="form__group-content">
                <h3>商品名</h3>
                <div class="form__input--text">
                    <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}" class="@error('product_name') is-invalid @enderror"/>
                </div>
                <div class="form__error">
                <!--バリデーション追加してから記述-->
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-content">
                <h3>商品の説明</h3>
                <div class="form__input--description">
                    <textarea 
                    id="product_description" 
                    name="product_description" 
                    class="textarea--description @error('product_description') is-invalid @enderror" 
                    rows="5">
                    </textarea>
                    </div>
                <div class="form__error">
                <!-- バリデーションエラーがあれば表示 -->
                </div>
            </div>
        </div>


        <h2>販売価格</h2>

        <div class="form__group">
            <div class="form__group-content">
                <h3>販売価格</h3>
                <div class="form__input--text">
                    <div class="input-with-symbol">
                    <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    value="{{ old('price') }}" 
                    class="@error('price') is-invalid @enderror"/>
                    </div>
                    </div>
                    <div class="form__error">
                    <!-- バリデーション追加してから記述 -->
                </div>
            </div>
        </div>


        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する
            </button>
        </div>

    </form>
    </div><!--register__contentの終わり-->
</body>
</html>