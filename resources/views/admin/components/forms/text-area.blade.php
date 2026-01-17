<div class="form-group">
    @if (isset($label))
        <label for="{{ $id ?? $name }}">{{ $label }}</label>

    @endif

    <textarea class="form-control" id="{{ $id }}" name="{{ $name }}" @required($required ?? false)>{{ $value ?? '' }}</textarea>
</div>