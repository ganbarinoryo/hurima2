<!--マイページ-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
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

    <main class="main-content">
        <!-- ユーザーアイコン、ユーザー名、プロフィール編集先に遷移するボタン -->
        <div class="user_data">
            <!-- ユーザーアイコン -->
            <div class="user_icon">
                <img src="{{ asset('storage/' . $user->user_icon) }}" alt="ユーザーアイコン">
            </div>
        
            <!-- ユーザー名 -->
            <div class="user_name">
                <p>{{ Auth::user()->user_name }}</p>
            </div>
        
            <!-- プロフィール編集ページへのリンク -->
            <div class="profile_edit">
                <a href="/mypage/profile" class="edit_button">プロフィールを編集</a>
            </div>
        </div>

        @php
            $activeTab = $activeTab ?? 'selling';
        @endphp

        <section class="tabs">
            <a class="tab {{ $activeTab === 'selling' ? 'active' : '' }}" href="{{ route('mypage.selling') }}">出品した商品</a>
            <a class="tab {{ $activeTab === 'purchased' ? 'active' : '' }}" href="{{ route('mypage.purchased') }}">購入した商品</a>
        </section>

        <section class="products">
            @foreach ($items as $item)
                <div class="product-item">
                    <!-- 商品ページへのリンク -->
                    <a href="{{ route('item.show', ['id' => $item->id]) }}">
                        <!-- 商品画像 -->
                        <img 
                            src="{{ asset('storage/images/' . ($item->images->first()->image_url ?? 'default.png')) }}" 
                            alt="商品画像">
                    </a>
                    <!-- 価格 -->
                    <p>¥{{ number_format($item->price) }}</p>
                </div>
            @endforeach

            <!-- 商品が存在しない場合のメッセージ -->
            @if ($items->isEmpty())
                <p>商品が見つかりません。</p>
            @endif
        </section>
        
    </main>

</body>
</html>
