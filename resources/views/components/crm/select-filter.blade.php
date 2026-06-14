<div class="{{ $class ?? 'col-md-4' }}">
    <label class="form-label">{{ $label }}</label>

    <select name="{{ $name }}" class="form-select">
        <option value="">{{ $default ?? 'All' }}</option>

        @foreach($options as $key => $value)
            @php
                $optionValue = is_numeric($key) ? $value : $key;
                $optionLabel = $value;
            @endphp

            <option value="{{ $optionValue }}" @selected(request($name) == $optionValue)>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
</div>
