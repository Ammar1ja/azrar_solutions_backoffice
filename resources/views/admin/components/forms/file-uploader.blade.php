<div class="form-group mb-3">
    @if (isset($label))
        <label class="form-label fw-bold">{{ $label }}</label>
    @endif

    {{-- old file --}}
    <input type="hidden" name="old_{{ $name }}" value="{{ $value ?? '' }}">

    <div class="file-uploader border rounded p-3">

        <input type="file" class="form-control" id="file-{{ $name }}" name="{{ $name }}"
            accept="{{ $accept ?? 'image/*,video/*' }}" onchange="previewFile(this, '{{ $name }}')" @required(!$value ?? $required ?? false) data-required="{{ $required ?? false }}">

        <div id="preview-{{ $name }}" class="mt-3 text-center">
            @if (!empty($value))
                @php
                    $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                @endphp

                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <img src="{{ asset($value) }}" class="img-fluid rounded" style="max-height:220px">
                @elseif (in_array($ext, ['mp4', 'webm', 'ogg']))
                    <video src="{{ asset($value) }}" controls class="w-100 rounded" style="max-height:220px"></video>
                @endif

                <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeFile('{{ $name }}')">
                    Remove file
                </button>
            @endif
        </div>

        <div id="remove-input-{{ $name }}"></div>
    </div>
</div>