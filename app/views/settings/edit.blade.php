<div class="row">
  <div class="edit_form col-sm-offset-1 col-sm-10 col-xs-12">
    {{ Form::open(array('url' => 'haik-admin/edit', 'id' => 'edit_form_main', 'class'=>'form')) }}

      {{ Form::hidden('pagename', e($pagename)) }}

      <div class="form-group">
        {{ Form::text('title', e($title), array('placeholder'=>'ページタイトル', 'class'=>'form-control', 'tabindex'=>1)) }}
      </div>

      <div class="form-group">
        {{ Form::textarea('contents', e($md), array('placeholder'=>'クリックして文章を入力してください。', 'class'=>'', 'tabindex'=>2, 'data-exnote'=>'onready')) }}
      </div>

      <div class="form-group edit_buttons">
        {{ Form::submit('公開', array('class'=>'btn btn-primary', 'tabindex'=>3)) }}
      </div>

    {{ Form::close() }}
  </div>
</div>
