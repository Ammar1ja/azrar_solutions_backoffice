<div class="form-group">
    @if (isset($label))
        <label for="{{ $id ?? $name }}">{{ $label }}</label>

    @endif

    <input type="{{ $type ?? 'text' }}" class="form-control" id="{{ $id }}" name="{{ $name }}" value="{{ $value ?? '' }}"
        @required($required ?? false)>
</div>