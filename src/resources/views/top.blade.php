<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/top.css') }}" />
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
    <section class="tabs">
        <a class="tab {{ $activeTab === 'recommend' ? 'active' : '' }}" href="{{ route('top') }}">おすすめ</a>
        @auth
        <a class="tab {{ $activeTab === 'favorites' ? 'active' : '' }}" href="{{ route('favorites') }}">マイリスト</a>
        @endauth
    </section>

        <section class="products">
            @foreach ($items as $item)
                <div class="product-item" style="position: relative;">
                    <!-- 商品ページへのリンク -->
                    <a href="{{ route('item.show', ['id' => $item->id]) }}">
                        <!-- 商品画像 -->
                        <img 
                            src="{{ asset('storage/images/' . ($item->images->first()->image_url ?? 'default.png')) }}" 
                            alt="商品画像">
                        
                        <!-- 売却済表示 -->
                        @if ($item->status === '売却済')
                            <div class="sold-label">売却済</div>
                        @endif
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