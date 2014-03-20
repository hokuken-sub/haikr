<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="sr-only">
    {{{ $label }}} @if($required) <span class="haik-form-required">*</span>@endif
  </label>
  <select class="form-control" name="data[{{{ $name }}}]" id="haik_form_{{ $id }}_{{{ $name }}}">
  @if ($empty !== '')
    <option value="">{{{ $empty }}}</option>
  @endif
  @foreach($options as $i => $option)
    @if ($option === '') @continue @endif
    <option value="{{{ $option }}}"@if ($option === $value) selected@endif>{{{ $option }}}</option>
  @endforeach
  </select>
</div>
