@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="mt-3 logo-img mx-auto"></h2>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control bg-light @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control bg-light @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="パスワード">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">ログイン</button>
                            </div>
                        </div>

                        <hr class="col-md-6">

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6 text-center">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link card-link" href="{{ route('password.request') }}">
                                        パスワードを忘れた場合
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body text-center">
                    アカウントをお持ちでないですか？ <a href="/register" class="card-link">登録する</a>
                </div>
            </div>

            <p class="text-center mt-3">ダウンロード</p>

            <div class="row justify-content-center">
                <a class="mr-3" href="https://itunes.apple.com/app/instagram/id389801252?pt=428156&ct=igweb.loginPage.badge&mt=8&vt=lo">
                    <img src="/images/app-store.png" style="height:40px; width:136px;">
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.instagram.android&referrer=utm_source%3Dinstagramweb%26utm_campaign%3DloginPage%26ig_mid%3D258A90F8-C610-46E3-9E6D-5F5A98AAE28E%26utm_content%3Dlo%26utm_medium%3Dbadge">
                    <img src="/images/google-play.png" style="height:40px; width:136px;">
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
