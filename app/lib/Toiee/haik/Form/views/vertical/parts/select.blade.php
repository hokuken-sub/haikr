<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label">
    {{{ $label }}} @if($required) <span class="haik-form-required">*</span>@endif
  </label>
  <select class="form-control" name="data[{{{ $name }}}]" id="haik_form_{{ $id }}_{{{ $name }}}"@if ($multiple) multiple@endif>
  @if ($empty !== '')
    <option value="">{{{ $empty }}}</option>
  @endif
  @foreach($options as $i => $option)
    @if ($option === '') @continue @endif
    <option value="{{{ $option }}}"@if ($option === $value) selected@endif>{{{ $option }}}</option>
  @endforeach
  </select>
  @if (isset($help))
  <span class="help-block">
    {{{ $help }}}
  </span>
  @endif
</div>
