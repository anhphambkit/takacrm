<?php
/**
 * @var string $value
 */
$value = isset($value) ? (array)$value : [];
?>
@if($categories)
    <ul>
        @foreach($categories as $category)
            @if($category->id != $currentId)
                <li value="{{ $category->id or '' }}"
                        {{ $category->id == $value ? 'selected' : '' }}>
                    {!! Form::customCheckbox([
                        [
                            $name, $category->id, $category->name, in_array($category->id, $value),
                        ]
                    ]) !!}
                    @include('plugins-blog::category.partials.categories-checkbox-option-line', [
                        'categories' => $category->child_cats,
                        'value' => $value,
                        'currentId' => $currentId,
                        'name' => $name
                    ])
                </li>
            @endif
        @endforeach
    </ul>
@endif