{{ Form::open() }}
{{ Form::label('email', 'Eメールアドレス：') }}
{{ Form::text('email', Input::old('email', '')) }}
<br>
{{ Form::label('password', 'パスワード：') }}
{{ Form::password('password') }}
<br>
{{ Form::submit('ログイン'); }}
{{ Form::close() }}