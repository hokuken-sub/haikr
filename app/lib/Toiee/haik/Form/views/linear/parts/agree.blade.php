<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <input type="hidden" name="data[{{{ $name }}}]" value="0">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="sr-only">
    {{{ $label }}}
  </label>
  <div class="checkbox">
    <label>
      <input type="checkbox" name="data[{{{ $name }}}]" value="1" id="haik_form_{{ $id }}_{{{ $name }}}">{{{ $terms_text }}}
   </label>
  </div>
</div>
