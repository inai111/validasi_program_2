@props(['label','message'=>''])

<div class="form-check form-switch">
    <input {{ $attributes->class([
        "form-check-input"
        ]) }} {{$attributes}} type="checkbox" role="switch">
    <label class="form-check-label" for="{{$attributes['id']}}">{{$attributes['placeholder']}}</label>
</div>
