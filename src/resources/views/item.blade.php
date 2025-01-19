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
<!--コメント欄-->
        <div class="comment-container">
            <button id="comment-button" class="comment-button">
                <img src="{{ asset('images/hukidashi.png') }}" alt="ふきだし">
            </button>
            <div id="comment-area" class="comment-area" style="display: none;">
                <div id="comments" class="message-container">
                    <!-- コメントを動的に挿入 -->
                </div>
                <div class="comment-input-area">
                    <textarea id="comment-input" placeholder="コメントを入力"></textarea>
                    <button class="comment_send_button" id="comment-submit">コメントを送信する</button>
                </div>
            </div>
        </div>

    </div>

<!--購入するボタン-->
        <div class="form__button">
            @if ($item->status === '売却済')
                <button class="form__button-submit disabled" disabled>売却済</button>
            @else
                <form action="{{ route('purchase.store', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    <button class="form__button-submit">購入する</button>
                </form>
            @endif
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

<!--コメント欄表示・非表示・送受信-->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 各要素を取得
        const commentButton = document.getElementById('comment-button');
        const commentArea = document.getElementById('comment-area');
        const commentsContainer = document.getElementById('comments');
        const commentInput = document.getElementById('comment-input');
        const commentSubmit = document.getElementById('comment-submit');
        const itemData = document.querySelector('.item_data');
        const itemId = {{ $item->id }};  // BladeでitemIdを取得

        // 初期表示状態を設定
        commentArea.style.display = 'none';
        itemData.style.display = 'block';

        // コメントボタンクリック時の処理
        commentButton.addEventListener('click', () => {
            if (commentArea.style.display === 'none' || commentArea.style.display === '') {
                commentArea.style.display = 'block';
                itemData.style.display = 'none';
                loadComments(itemId);  // コメントのロード
            } else {
                commentArea.style.display = 'none';
                itemData.style.display = 'block';
            }
        });

        // コメントを読み込む関数
        function loadComments(itemId) {
            commentsContainer.innerHTML = '<p>Loading...</p>';

            fetch(`/items/${itemId}/comments`)
                .then(response => response.json())
                .then(comments => {
                    commentsContainer.innerHTML = '';
                    comments.forEach(comment => {
                        addCommentToDOM(comment);  // コメントを表示する関数
                    });
                })
                .catch(error => {
                    console.error('Error fetching comments:', error);
                    commentsContainer.innerHTML = '<p>コメントの取得に失敗しました。</p>';
                });
        }

        // コメントをDOMに追加する関数
        function addCommentToDOM(comment) {
            const commentDiv = document.createElement('div');
            commentDiv.classList.add('comment');

            const commentHeader = document.createElement('div');
            commentHeader.classList.add('comment_header');

            const userName = document.createElement('span');
            userName.textContent = comment.user.name;
            userName.classList.add('user-name');

            // アイコンURLの設定
            const userIcon = document.createElement('img');
            userIcon.src = comment.user.icon_url || '/default-icon.png';  // アイコンURLがない場合はデフォルトアイコンを表示
            userIcon.alt = 'User Icon';
            userIcon.classList.add('user-icon');

            commentHeader.appendChild(userName);
            commentHeader.appendChild(userIcon);

            const commentBody = document.createElement('div');
            commentBody.classList.add('comment_body');
            commentBody.innerHTML = `<p>${comment.comment}</p>`;  // コメント本文

            commentDiv.appendChild(commentHeader);
            commentDiv.appendChild(commentBody);
            commentsContainer.appendChild(commentDiv);  // コメントを表示
        }

        // コメント送信ボタンクリック時の処理
        commentSubmit.addEventListener('click', () => {
            const commentText = commentInput.value.trim();
            if (!commentText) return;

            fetch(`/items/${itemId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ comment: commentText })  // 入力されたコメントを送信
            })
                .then(response => response.json())
                .then(data => {
                    addCommentToDOM(data);  // 送信したコメントをDOMに追加
                    commentInput.value = '';  // コメント入力欄をクリア
                })
                .catch(error => console.error('Error posting comment:', error));
        });
    });
</script>




</body>
</html>