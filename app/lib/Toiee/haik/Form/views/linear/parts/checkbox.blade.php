<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="sr-only">
    {{{ $label }}} @if($required) <span class="haik-form-required">*</span> @endif
  </label>
@foreach($options as $i => $option)
  @if ($option === '') @continue @endif
  @if ($valign === 'vertical')
  <label class="checkbox-inline">
  @else
  <div class="checkbox">
    <label>
  @endif
      <input type="checkbox" name="data[{{{ $name }}}][]" value="{{{ $option }}}" id="haik_form_{{ $id }}_{{{ $name }}}"@if (in_array($option, $value)) checked@endif>{{{ $option }}}
  @if ($valign === 'vertical')
  </label>
  @else
    </label>
  </div>
  @endif
@endforeach
</div>
