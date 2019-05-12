@if (isset($item->role_id))
    <a data-container="body" data-placement="top" data-type="select" data-source="{{ route('admin.roles.list.json') }}" data-pk="{{ $item->id }}" data-url="{{ route('admin.roles.assign') }}" data-value="{{ $item->role_id }}" data-title="Assigned Role" class="editable" href="#">{{ $item->role_name }}</a>
@else
    <a data-container="body" data-placement="top" data-type="select" data-source="{{ route('admin.roles.list.json') }}" data-pk="{{ $item->id }}" data-url="{{ route('admin.roles.assign') }}" data-value="0" data-title="Assigned Role" class="editable" href="#">No role assigned</a>
@endif

