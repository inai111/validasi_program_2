@props(['message'=>''])

<div class="form-floating mb-3">
    <input {{$attributes->class([
            "form-control",
            "is-invalid"=>$message
            ]) }}>
    <label for="{{ $attributes['id'] }}">{{$attributes['placeholder']}}</label>
    @if($message)
        <div class="invalid-feedback">
            {{ $message ?? 'Mohon lengkapi form ini' }}
        </div>
    @endif
</div>
