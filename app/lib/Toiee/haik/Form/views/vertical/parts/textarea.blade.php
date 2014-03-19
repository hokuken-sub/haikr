<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label">
    {{{ $label }}} @if($required) <span class="haik-form-required">*</span> @endif
  </label>
  <div class="row">
    <div class="{{{ $size or 'col-sm-6' }}}">
      <textarea name="data[{{{ $name }}}]" id="haik_form_{{ $id }}_{{{ $name }}}" class="form-control" rows="{{{ $rows }}}" placeholder="{{{ $placeholder or '' }}}"{{ $required ? ' required': ''}}>{{{ $value }}}</textarea>
    </div>
    @if (isset($help))
    <span class="help-block">
      {{{ $help }}}
    </span>
    @endif
  </div>
</div>
