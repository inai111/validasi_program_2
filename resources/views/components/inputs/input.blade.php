@props(['message'=>''])

<div class="mb-3">
    <label for="{{ $attributes['id'] }}">{{$attributes['placeholder']}}</label>
    <input {{$attributes->class([
            "form-control",
            "is-invalid"=>$message
            ]) }}>
    @if($message)
        <div class="invalid-feedback">
            {{ $message ?? 'Mohon lengkapi form ini' }}
        </div>
    @endif
</div>
