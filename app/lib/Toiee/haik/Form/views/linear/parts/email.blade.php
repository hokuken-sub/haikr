<div class="form-group{{ isset($error) ? ' has-error' : '' }}{{ isset($icon) ? ' has-feedback' : ''}}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="sr-only">
    {{{ $label }}}
  </label>
  <div class="{{{ $size or 'col-sm-6' }}}">
    @if (isset($icon))
    <span class="glyphicon glyphicon-{{{ $icon }}} form-control-feedback"></span>
    @endif
    <input type="text" name="data[{{{ $name }}}]" value="{{{ $value }}}" id="haik_form_{{ $id }}_{{{ $name }}}" class="form-control" placeholder="{{{ $placeholder or '' }}}"{{ $required ? ' required': ''}}>
  </div>
</div>
