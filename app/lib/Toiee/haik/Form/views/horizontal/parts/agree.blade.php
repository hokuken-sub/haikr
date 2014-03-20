<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <input type="hidden" name="data[{{{ $name }}}]" value="0">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="control-label col-sm-3">
    {{{ $label }}}@if($required)<span class="haik-form-required">*</span>@endif
  </label>
  <div class="col-sm-9">
    <div class="checkbox">
      <label>
        <input type="checkbox" name="data[{{{ $name }}}]" value="1" id="haik_form_{{ $id }}_{{{ $name }}}">{{{ $terms_text }}}
     </label>
    </div>
    @if (isset($help))
    <span class="help-block">
      {{{ $help }}}
    </span>
    @endif
  </div>
</div>
