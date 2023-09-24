@props(['inputName', 'inputPlaceholder', 'message' => ''])

<div class="form-floating mb-3">
    <select class="form-select" name="{{ $inputName }}" id="{{ $inputName }}" aria-label="{{$inputPlaceholder}}"
        @class(['form-select', 'is-invalid' => $message]) {{$attributes}}>
        {{$slot}}
    </select>
    <label for="{{ $inputName }}">{{ $inputPlaceholder }}</label>
    @if ($message)
        <div class="invalid-feedback">
            {{ $message ?? 'Mohon lengkapi form ini' }}
        </div>
    @endif
</div>
