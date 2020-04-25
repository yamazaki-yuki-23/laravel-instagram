@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/p" enctype="multipart/form-data" method="post">
        @csrf

        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>新規投稿</h1>
                </div>

                <div class="form-group row">
                    <label for="caption" class="col-md-4 col-form-label">キャプション<span class="text-danger">(必須)</span></label>

                    <input id="caption"
                            type="text"
                            class="form-control{{ $errors->has('caption') ? ' is-invalid' : '' }}"
                            name="caption"
                            value="{{ old('caption') }}"
                            autocomplete="caption" autofocus>

                    @if ($errors->has('caption'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('caption') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <label for="tags" class="col-md-4 col-form-label">タグ<span class="text-dark">(任意)</span></label>

                    <input id="tags"
                            type="text"
                            class="form-control{{ $errors->has('tags') ? ' is-invalid' : '' }}"
                            name="tags"
                            value="{{ old('tags') }}"
                            autocomplete="tags"
                            placeholder="先頭に#をつけて入力してください(最大5コまで)">
                    <span class="text-muted">例)#夏,#冬</span>

                    @if ($errors->has('tags'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('tags') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row">
                    <label for="image" class="col-md-4 col-form-label">シェアする写真<span class="text-danger">(必須)</span></label>

                    <div class="imagePreview"></div>
                    <div class="input-group">
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
                    <button class="btn-lg btn-primary">投稿する</button>
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
                    input.parent().parent().parent().prev('.imagePreview').css("background-image", "url("+this.result+")");
                }
            }
        });
</script>


