@props(['inputName','inputPlaceholder','message'=>''])

<div class="form-floating mb-3">
    <textarea @class([
        "form-control",
        "is-invalid"=>$message
        ]) placeholder="{{$inputPlaceholder}}"
    name="{{ $inputName }}" id="{{ $inputName }}" {{$attributes}}>{{$slot}}</textarea>
    <label for="{{$inputName}}">{{$inputPlaceholder}}</label>
    @if($message)
        <div class="invalid-feedback">
            {{ $message ?? 'Mohon lengkapi form ini' }}
        </div>
    @endif
</div>