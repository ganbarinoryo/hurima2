<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
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

        <div class="flex__profile-form__heading">
            <h1>プロフィール設定</h1>
        </div>

    <div class="flex__profile__content">

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- 画像選択 -->
    <div class="form__group">
        <div class="form__group-content">
            <div class="form__input--icon">
                <div class="icon">
                    <img id="image-icon" src="{{ asset('storage/images/' . Auth::user()->user_icon) }}" alt="選択された画像" style="display: {{ Auth::user()->user_icon ? 'block' : 'none' }};" />
                </div>
                <div class="image-upload">
                    <input type="file" id="user_icon" name="user_icon" accept="image/*" class="file-input" />
                    <label for="user_icon" class="file-label">
                        画像を選択する
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- ユーザー名 -->
    <div class="form__group">
        <div class="form__group-content">
            <h2>ユーザー名</h2>
            <div class="form__input--text__user_name">
                <input type="text" id="user_name" name="user_name" value="{{ old('user_name', Auth::user()->user_name) }}" class="@error('user_name') is-invalid @enderror"/>
            </div>
            <div class="form__error">
                @error('user_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- 郵便番号 -->
    <div class="form__group">
        <div class="form__group-content">
            <h2>郵便番号</h2>
            <div class="form__input--text">
                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}" class="@error('postal_code') is-invalid @enderror"/>
            </div>
            <div class="form__error">
                @error('postal_code')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- 住所 -->
    <div class="form__group">
        <div class="form__group-content">
            <h2>住所</h2>
            <div class="form__input--text">
                <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}" class="@error('address') is-invalid @enderror"/>
            </div>
            <div class="form__error">
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- 建物名 -->
    <div class="form__group">
        <div class="form__group-content">
            <h2>建物名</h2>
            <div class="form__input--text">
                <input type="text" id="building_name" name="building_name" value="{{ old('building_name', Auth::user()->building_name) }}" class="@error('building_name') is-invalid @enderror"/>
            </div>
            <div class="form__error">
                @error('building_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- 更新ボタン -->
    <div class="form__button">
        <button class="form__button-submit" type="submit">更新する</button>
    </div>
</form>



    </div><!--register__contentの終わり-->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('user_icon');
            const imgElement = document.getElementById('image-icon');

            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];

                // ファイルが選択されていない場合、プレビューを非表示に
                if (!file) {
                    imgElement.style.display = 'none';
                    imgElement.src = '';
                    return;
                }

                // ファイルが画像であるか確認
                if (!file.type.startsWith('image/')) {
                    alert('画像ファイルを選択してください。');
                    fileInput.value = ''; // 入力をリセット
                    imgElement.style.display = 'none';
                    imgElement.src = '';
                    return;
                }

                // 画像プレビューの表示
                const reader = new FileReader();

                reader.onload = function (e) {
                    imgElement.src = e.target.result; // 選択された画像をプレビューに設定
                    imgElement.style.display = 'block'; // 画像を表示
                };

                reader.onerror = function () {
                    alert('画像の読み込み中にエラーが発生しました。');
                    imgElement.style.display = 'none';
                    imgElement.src = '';
                };

                reader.readAsDataURL(file); // 画像ファイルを読み込む
            });
        });

    </script>


</body>
</html>