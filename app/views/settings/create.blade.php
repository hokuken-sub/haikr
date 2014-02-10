<div class="page-header">新規ページ作成</div>
<div class="row">
  <div class="col-sm-10 col-xs-12">
    {{ Form::open(array('url' => 'haik-admin/create', 'class'=>'form')) }}

      <div class="form-group">
        <label>新規ページ名</label>
        <div class="row">
          <div class="col-sm-6">
            {{ Form::text('name', '' ,array('placeholder'=>'ページ名', 'class'=>'form-control')) }}
          </div>
        </div>
      </div>

      <div class="form-group">
        {{ Form::submit('作成', array('class'=>'btn btn-primary', 'tabindex'=>3)) }}
      </div>

    {{ Form::close() }}
  </div>
</div>
