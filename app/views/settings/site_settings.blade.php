<div class="page-header">サイト情報</div>
<div class="row">
  <div class="col-sm-10 col-xs-12">

    {{ Form::open(array('url' => 'haik--admin/site/settings', 'class'=>'form')) }}

      <div class="form-group">
        <label>サイトのタイトル</label>
        {{ Form::text('title', $title, array('placeholder'=>'サイトタイトル', 'class'=>'form-control', 'tabindex'=>1)) }}
      </div>

      <div class="form-group">
        <label>サイトの説明</label>
        {{ Form::textarea('description', $description, array('placeholder'=>'サイトの説明', 'class'=>'form-control', 'tabindex'=>2, 'data-exnote'=>'onready')) }}
      </div>

      <div class="form-group edit_buttons">
        {{ Form::submit('設定', array('class'=>'btn btn-primary', 'tabindex'=>3)) }}
      </div>

    {{ Form::close() }}
  </div>
</div>
