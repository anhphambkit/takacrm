@foreach($statuses as $key => $status)
    @if ($key == $selected)
        <span class="btn btn-sm {{ array_get($status, 'class', 'label-info') }}  box-shadow-2 round btn-min-width pull-right" data-value="{{ $key }}" data-text="{{ ucfirst(array_get($status, 'text')) }}">
            {{ array_get($status, 'text') }}
        </span>
    @endif
@endforeach