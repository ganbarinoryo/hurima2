<!--商品詳細ページ-->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

<!--商品詳細-->
<main>
<!--商品画像-->
    <div class="item__image">
        <img src="{{ asset('storage/images/' . ($item->images->first()->image_url ?? 'default.png')) }}" alt="商品画像">
    </div>
    <!--商品内容-->
        <div class="item__detail">

        <h1>{{ $item->item_name }}</h1>
        <p class="price">¥{{ number_format($item->price) }} (値段)</p>

<!--お気に入り・コメントボタン-->
    <div class="item-container">
        <div class="favorite-button-container">
            <button class="favorite-button {{ $item->is_favorited ? 'favorited' : '' }}" data-item-id="{{ $item->id }}">
                ☆
            </button>
        </div>

        <div class="comment-container">
            <button id="comment-button" class="comment-button">
                <img src="{{ asset('images/hukidashi.png') }}" alt="ふきだし">
            </button>
            <div id="comment-area" class="comment-area" style="display: none;">
                <div class="message-container">
                    <div class="message my-message">
                        <p>自分が送信したコメントの例です。</p>
                    </div>
                    <div class="message other-message">
                        <p>他のユーザーが送信したコメントの例です。</p>
                    </div>
                    </div>
                <div class="comment-input-area">
                    <textarea id="comment-input" placeholder="コメントを入力"></textarea>
                    <button class="comment_send_button" id="comment-submit">コメントを送信する</button>
                </div>
            </div>
        </div>
    </div>

<!--購入するボタン-->
    <div class="item_data">
        <div class="form__button">
            <button class="form__button-submit" type="submit">
                <a href="{{ route('purchase.show', ['id' => $item->id]) }}">購入する</a>
            </button>
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
</div>

</main>
    
<!--お気に入りボタンスクリプト-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const favoriteButtons = document.querySelectorAll('.favorite-button');

        favoriteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const isFavorited = this.classList.contains('favorited');

                fetch(`/favorite/toggle/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF対策
                    },
                    body: JSON.stringify({ _method: 'POST'}) // POSTメソッドを明示的に指定
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.favorited) {
                            this.classList.add('favorited');
                        } else {
                            this.classList.remove('favorited');
                        }
                    } else {
                        console.error('お気に入り処理に失敗しました。');
                        // エラーメッセージを表示するなど、適切なエラーハンドリングを行う
                    }
                })
                .catch(error => {
                    console.error('通信エラー:', error);
                    // エラーメッセージを表示するなど、適切なエラーハンドリングを行う
                });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const commentButton = document.getElementById('comment-button');
    const commentArea = document.getElementById('comment-area');
    const itemData = document.querySelector('.item_data'); // 該当部分のセクションを取得

    commentButton.addEventListener('click', function () {
        if (commentArea.style.display === 'none') {
            // コメント欄を表示し、商品情報を非表示に
            commentArea.style.display = 'block';
            itemData.style.display = 'none';
        } else {
            // コメント欄を非表示にし、商品情報を再表示
            commentArea.style.display = 'none';
            itemData.style.display = 'block';
        }
    });
});

</script>


</body>
</html>