@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-8 offset-2">

                    <div class="row">
                        <h1>プロフィールを編集</h1>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label">タイトル<span class="text-danger">(必須)</span></label>

                        <input id="title"
                            type="text"
                            class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                            name="title"
                            value="{{ old('title') ?? $user->profile->title }}"
                            autocomplete="title" autofocus>

                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label for="url" class="col-md-4 col-form-label">ウェブサイト<span class="text-dark">(任意)</span></label>

                        <input id="url"
                            type="text"
                            class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}"
                            name="url"
                            value="{{ old('url') ?? $user->profile->url }}"
                            autocomplete="url" autofocus>

                        @if ($errors->has('url'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('url') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label">自己紹介<span class="text-dark">(任意)</span></label>

                        <textarea id="description"
                            rows="3"
                            class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                            name="description"
                            value="{{ old('description') ?? $user->profile->description }}"
                            autocomplete="description" autofocus></textarea>

                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="row">
                        <label for="image" class="col-md-10 col-form-label">プロフィール写真<span class="text-dark">(任意)</span></label>

                        @if(Auth::user()->profile->profileImage())
                            <div class="col-md-3 ProfileImagePreview" style="background-image: url(data:img/png;base64,{{Auth::user()->profile->profileImage()}})"></div>
                        @else
                            <div class="col-md-3 ProfileImagePreview" style="background-image: url(/Psy0tMpnjUQIbumb25Csi1XLLdhLV2QWT2R3K4Zh.jpeg)"></div>
                        @endif
                        <div class="input-group mt-2">
                            <label class="input-group-btn">
                                <span class="uploade-image">
                                    写真を選択
                                    <input type="file" class="form-control-file" id="image" name="image" style="display:none;">
                                </span>
                            </label>
                            <input type="text" class="form-control" readonly="">
                        </div>

                        @if ($errors->has('image'))
                            <strong class="text-danger error-font-size">{{ $errors->first('image') }}</strong>
                        @endif
                    </div>

                    <div class="row pt-4">
                        <button class="btn btn-primary">変更する</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
$(document).on('change', ':file', function() {
            var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.parent().parent().next(':text').val(label);

            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file
                reader.onloadend = function(){ // set image data as background of div
                    input.parent().parent().parent().prev('.ProfileImagePreview').css("background-image", "url("+this.result+")");
                }
            }
        });
</script>
