<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="sr-only">
    {{{ $label }}} @if($required) <span class="haik-form-required">*</span> @endif
  </label>
@foreach($options as $i => $option)
  @if ($option === '') @continue @endif
  <div class="radio">
    <label>
      <input type="radio" name="data[{{{ $name }}}][]" value="{{{ $option }}}" id="haik_form_{{ $id }}_{{{ $name }}}"@if ($option ===  $value) checked@endif>{{{ $option }}}
    </label>
  </div>
@endforeach
</div>
