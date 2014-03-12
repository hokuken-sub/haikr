<div class="form-group">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label">
    {{{ $label }}}
  </label>
  <div class="form-control{{{ $class ? ' ' . $class : '' }}}">
    <div class="row">
      <div class="{{{ $size or 'col-sm-6' }}}">
        @if ($before OR $after)
        <div class="input-group">
        @endif
        @if ($before)
          <span class="input-group-addon">{{{ $before }}}</span>
        @endif
          <input type="text" name="data[{{{ $name }}}]" value="{{{ $value }}}" id="haik_form_{{ $id }}_{{{ $name }}}" class="form-control" placeholder="{{{ $placeholder }}}"{{ $required ? ' required': ''}}>
        @if ($after)
          <span class="input-group-addon">{{{ $after }}}</span>
        @endif
        @if ($before OR $after)
        </div>
        @endif
      </div>
    </div>
    <span class="help-block">
      {{{ $help }}}
    </span>
  </div>
</div>
