<div class="form-group">
    @if (isset($label))
        <label for="{{ $id ?? $name }}">{{ $label }}</label>
    @endif

    @php
        $fieldId = $id ?? $name;
        $checkedState = old($name, isset($value) ? (bool) $value : (isset($checked) ? (bool) $checked : false));
    @endphp

    <div class="form-check form-switch">
        <input type="hidden" name="{{ $name }}" value="0">
        <input
            class="form-check-input"
            type="checkbox"
            id="{{ $fieldId }}"
            name="{{ $name }}"
            value="1"
            @if($checkedState) checked @endif
            @required($required ?? false)
        >
        @if(isset($toggleLabel))
            <label class="form-check-label" for="{{ $fieldId }}">{{ $toggleLabel }}</label>
        @endif
    </div>

    @if(isset($help))
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
</div>
