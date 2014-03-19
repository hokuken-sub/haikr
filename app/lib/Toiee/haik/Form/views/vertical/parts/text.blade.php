<div class="form-group{{ isset($error) ? ' has-error' : '' }}{{ isset($icon) ? ' has-feedback' : ''}}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label">
    {{{ $label }}} @if($required) <span class="haik-form-required">*</span> @endif
  </label>
  <div class="row">
    <div class="{{{ $size or 'col-sm-6' }}}">
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
    @if (isset($help))
    <span class="help-block">
      {{{ $help }}}
    </span>
    @endif
  </div>
</div>
