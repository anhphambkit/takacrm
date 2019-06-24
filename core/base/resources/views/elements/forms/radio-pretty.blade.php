<div class="pretty p-icon p-round p-plain p-smooth radio-pretty-custom mb-1 {{ $classRadio }}">
	<input type="radio" name="{{ $name }}" value="{{ $default }}" {{ ($value == $default) ? 'checked' : '' }} {!! html_attributes_builder($attributes) !!}/>
	<div class="state p-success">
		<i class="icon {{ $attributes['icon'] ?? 'fas fa-check' }}"></i>
		<label for="{{ $title }}">{{ $title }}</label>
	</div>
</div>