<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>
<body>

    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img src="{{ asset ('images/logo.png') }} " alt="コーチテック" >
            </a>
        </div>
    </header>

        <div class="flex__login-form__heading">
            <h1>ログイン</h1>
        </div>

    <div class="flex__login__content">

    <form action="/login" method="POST">
        @csrf

        <div class="form__group">
            <div class="form__group-content">
                <p>メールアドレス</p>
                <div class="form__input--text">
                    <input type="text" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror"/>
                </div>
                <div class="form__error">
                <!--バリデーション追加してから記述-->
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-content">
                <p>パスワード</p>
                <div class="form__input--text">
                    <input type="password" name="password" value="{{ old('password') }}" class="@error('password') is-invalid @enderror"/>
                </div>
                <div class="form__error">
                <!--バリデーション追加してから記述-->
                </div>
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">ログインする
            </button>
        </div>

        <div class="flex__form__register-link">
            <a href="/register">会員登録はこちら</a>
        </div>

    </form>
    </div><!--login__contentの終わり-->
</body>
</html>