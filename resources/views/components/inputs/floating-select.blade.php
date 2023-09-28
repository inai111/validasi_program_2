@props(['message' => ''])

<div class="form-floating mb-3">
    <select aria-label="{{$attributes['placeholder']}}"
    {{ $attributes->class(['form-select', 'is-invalid' => $message]) }}>
        {{$slot}}
    </select>
    <label for="{{ $attributes['id'] }}">{{ $attributes['placeholder'] }}</label>
    @if ($message)
        <div class="invalid-feedback">
            {{ $message ?? 'Mohon lengkapi form ini' }}
        </div>
    @endif
</div>
