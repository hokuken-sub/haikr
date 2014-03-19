<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label">
    {{{ $label }}} @if($required) <span class="haik-form-required">*</span>@endif
  </label>

  @if ($valign === 'vertical')
  <div>
    @foreach($options as $i => $option)
      @if ($option === '') @continue @endif
      <label class="checkbox-inline">
        <input type="checkbox" 
               name="data[{{{ $name }}}][]" 
               value="{{{ $option }}}" 
               id="haik_form_{{ $id }}_{{{ $name }}}" 
               {{ (in_array($option, $value)) ? 'checked' : '' }}>
        {{{ $option }}}
      </label>
    @endforeach
  </div>

  @else
    @foreach($options as $i => $option)
      @if ($option === '') @continue @endif
      <div class="checkbox">
        <label>
          <input type="checkbox" 
                 name="data[{{{ $name }}}][]" 
                 value="{{{ $option }}}" 
                 id="haik_form_{{ $id }}_{{{ $name }}}" 
                 {{ (in_array($option, $value)) ? 'checked' : '' }}>
          {{{ $option }}}
        </label>
      </div>
    @endforeach
  @endif

  @if (isset($help))
  <span class="help-block">
    {{{ $help }}}
  </span>
  @endif
</div>

