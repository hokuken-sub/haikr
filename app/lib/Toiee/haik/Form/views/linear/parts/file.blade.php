<div class="form-group{{ isset($error) ? ' has-error' : '' }}">
  <label for="haik_form_{{ $id }}_{{{ $name }}}" class="sr-only">
    {{{ $label }}}
  </label>
  <input type="file" name="data[{{{ $name }}}]" id="haik_form_{{ $id }}_{{{ $name }}}" value=""{{ $required ? ' required': ''}}>
</div>
