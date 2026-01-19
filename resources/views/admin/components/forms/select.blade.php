<div class="form-group">
    @if (isset($label))
        <label for="{{ $id ?? $name }}">{{ $label }}</label>

    @endif

    <select
        class="form-select {{ $classes ?? '' }}"
        id="{{ $id ?? $name }}"
        name="{{ $name }}{{ isset($multiple) && $multiple ? '[]' : '' }}"
        @if(isset($multiple) && $multiple) multiple @endif
        @required($required ?? false)
        >
        @foreach ($options as $option)
            <option 
            @selected( (isset($default) && ( (is_array($default) && in_array($option['value'], $default)) || $default == $option['value'] ) ) )
            value="{{ $option['value'] }}">{{ $option['label'] }}</option>
        @endforeach
    </select>
</div>