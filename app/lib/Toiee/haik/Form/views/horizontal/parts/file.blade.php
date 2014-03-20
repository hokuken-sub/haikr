<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label col-sm-3">
    {{{ $label }}}@if($required)<span class="haik-form-required">*</span>@endif
  </label>
  <div class="col-sm-9">
    <input type="file" name="data[{{{ $name }}}]" id="haik_form_{{ $id }}_{{{ $name }}}" value=""{{ $required ? ' required': ''}}>
    @if (isset($help))
    <span class="help-block">
      {{{ $help }}}
    </span>
    @endif
  </div>
</div>
