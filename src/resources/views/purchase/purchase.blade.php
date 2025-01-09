<!--商品詳細ページ-->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
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

    <main>

<!--左側-->
<div class="left_side">

    <!-- 商品情報（画像と詳細） -->
    <div class="product_info">

        <!-- 商品画像 -->
        <div class="product_image">
            <img src="" alt="商品画像">
        </div>

        <!-- 商品名と価格 -->
        <div class="product_details">
            <h1 class="product_name">商品名</h1>
            <p class="product_price">¥10,000</p>
        </div>

    </div>

    <!-- 支払い方法 -->
    <div class="payment_method">
        <h2 class="section_title">支払い方法</h2>
        <a href="#" class="change_link">変更する</a>
    </div>

    <!-- 配送先 -->
    <div class="shipping_address">
        <h2 class="section_title">配送先</h2>
        <a href="#" class="change_link">変更する</a>
    </div>

</div>




<!--右側-->
    <div class="right_side">

<!-- 商品情報セクション -->
<div class="product_information">
    <table class="product_table">
        <!-- 商品代金 -->
        <tr>
            <th>商品代金</th>
            <td>10,000</td>
        </tr>
        <!-- 支払い金額 -->
        <tr>
            <th>支払い金額</th>
            <td>10,000</td>
        </tr>
        <!-- 支払い方法 -->
        <tr>
            <th>支払い方法</th>
            <td>コンビニ払い</td>
        </tr>
        <!-- 配送先 -->
        <tr>
            <th>配送先</th>
            <td>住所入力</td>
        </tr>
    </table>
</div>



    <div class="form__button">
        <button class="form__button-submit" type="submit">購入する
        </button>
    </div>

    </div>







    </main>
</body>
</html>