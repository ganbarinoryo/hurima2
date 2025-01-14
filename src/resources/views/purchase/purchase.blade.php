<!--商品購入ページ-->

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
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="コーチテック">
            </a>

            <div class="search-bar">
                <input type="text" placeholder="なにをお探しですか？" class="search-input">
            </div>

            <nav class="nav">
                @guest
                    <a href="/login" class="nav__link__login">ログイン</a>
                    <a href="/register" class="nav__link__register">会員登録</a>
                @else
                    <a href="#" class="nav__logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
        <div class="left_side">
            <div class="item_image">
                <img src="{{ asset('storage/images/' . ($item->images->first()->image_url ?? 'default.png')) }}" alt="商品画像">
            </div>
        </div>

        <div class="right_side">
            <div class="item_information">
                <table class="item_table">
                    <tr>
                        <th>商品名</th>
                        <td>{{ $item->item_name }}</td>
                    </tr>
                    <tr>
                        <th>商品代金</th>
                        <td>¥{{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <th>支払い金額</th>
                        <td>¥{{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <th>支払い方法<a href="#">変更する</a></th>
                        <td>コンビニ払い</td> <!-- 支払い方法が status カラムに格納されている場合 -->
                    </tr>
                    <tr>
                        <th>配送先<a href="/address">変更する</a></th>
                        <td>〒{{ $user->postal_code }}{{ $user->address }}</td>
                    </tr>
                </table>

            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">購入する</button>
            </div>
        </div>
    </main>
</body>
</html>