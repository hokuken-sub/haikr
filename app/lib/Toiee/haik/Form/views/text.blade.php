@extends('parts_master')

@section('vertical')
<div class="form-group{{ isset($error) ? ' has-error' : '' }}{{ isset($icon) ? ' has-feedback' : ''}}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label">
    {{{ $label }}}
  </label>
  <div class="{{{ $size or '' }}}">
    @if (isset($before) OR isset($after))
    <div class="input-group">
    @endif
      @if (isset($before))
      <span class="input-group-addon">{{{ $before }}}</span>
      @endif
      @if (isset($icon))
      <span class="glyphicon glyphicon-{{{ $icon }}} form-control-feedback"></span>
      @endif
      <input type="text" name="data[{{{ $name }}}]" value="{{{ $value }}}" id="haik_form_{{ $id }}_{{{ $name }}}" class="form-control" placeholder="{{{ $placeholder or '' }}}"{{ $required ? ' required': ''}}>
      @if (isset($after))
      <span class="input-group-addon">{{{ $after }}}</span>
      @endif
    @if (isset($before) OR isset($after))
    </div>
    @endif
    @if (isset($help))
    <span class="help-block">
    {{{ $help }}}
    </span>
    @endif
  </div>
</div>
@endsection

@section('horizontal')
<div class="form-group{{ isset($error) ? ' has-error' : '' }}{{ isset($icon) ? ' has-feedback' : ''}}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label col-sm-3">
    {{{ $label }}}
  </label>
  <div class="col-sm-9">
    <div class="row">
      <div class="{{{ $size or '' }}}">
        @if (isset($before) OR isset($after))
        <div class="input-group">
        @endif
          @if (isset($before))
          <span class="input-group-addon">{{{ $before }}}</span>
          @endif
          @if (isset($icon))
          <span class="glyphicon glyphicon-{{{ $icon }}} form-control-feedback"></span>
          @endif
          <input type="text" name="data[{{{ $name }}}]" value="{{{ $value }}}" id="haik_form_{{ $id }}_{{{ $name }}}" class="form-control" placeholder="{{{ $placeholder or '' }}}"{{ $required ? ' required': ''}}>
          @if (isset($after))
          <span class="input-group-addon">{{{ $after }}}</span>
          @endif
        @if (isset($before) OR isset($after))
        </div>
        @endif
        @if (isset($help))
        <span class="help-block">
        {{{ $help }}}
        </span>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('linear')
<div class="form-group{{ isset($error) ? ' has-error' : '' }}{{ isset($icon) ? ' has-feedback' : ''}}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="sr-only">
    {{{ $label }}}
  </label>
  <div class="{{ $size or 'col-sm-6'}}">
    <div class="row">
      @if (isset($before) OR isset($after))
      <div class="input-group">
      @endif
        @if (isset($before))
        <span class="input-group-addon">{{{ $before }}}</span>
        @endif
        @if (isset($icon))
        <span class="glyphicon glyphicon-{{{ $icon }}} form-control-feedback"></span>
        @endif
        <input type="text" name="data[{{{ $name }}}]" value="{{{ $value }}}" id="haik_form_{{ $id }}_{{{ $name }}}" class="form-control" placeholder="{{{ $placeholder or '' }}}"{{ $required ? ' required': ''}}>
        @if (isset($after))
        <span class="input-group-addon">{{{ $after }}}</span>
        @endif
      @if (isset($before) OR isset($after))
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
