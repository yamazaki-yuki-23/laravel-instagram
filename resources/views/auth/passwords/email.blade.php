@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2 class="password-lock mx-auto"></h2>
                    <h5 class="text-center">ログインできない場合</h5>
                    <div class="col-md-6 mx-auto">
                        <p class="text-center text-muted">アカウントにアクセスするためのログインリンクを送信するため、ユーザーネームまたはメールアドレスを入力してください。</p>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row justify-content-center">

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
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    ログインリンクを送信
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="col-md-6 mx-auto mt-4">
                        <span class="title-border text-muted">または</span>
                        <p class="text-center pt-3"><a class="card-link text-dark" href="/register">新しいアカウントを作成</a></p>
                    </div>

                </div>

                <div class="card-footer text-center">
                    <a class="card-link text-dark" href="/login">ログインに戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
