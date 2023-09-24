@props(['inputType','inputName','inputPlaceholder','message'=>''])

<div class="form-floating mb-3">
    <input {{$attributes}} type="{{ $inputType }}" name="{{ $inputName }}" id="{{ $inputName }}"
        placeholder="{{ $inputPlaceholder }}" @class([
            "form-control",
            "is-invalid"=>$message
            ])>
    <label for="{{ $inputName }}">{{$inputPlaceholder}}</label>
    @if($message)
        <div class="invalid-feedback">
            {{ $message ?? 'Mohon lengkapi form ini' }}
        </div>
    @endif
</div>
