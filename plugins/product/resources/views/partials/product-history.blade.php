<?php
	$defaultAvatar = '/storage/system/images/default-avatar.png';

	$colors = [
		'success',
		'info',
		'warning',
		'danger'
	];
	$indexColor = 0;
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">{{ trans('Histories') }}</h4>
		<a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
				<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
				<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
				<li><a data-action="close"><i class="ft-x"></i></a></li>
			</ul>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="media-list list-group" id="log-history-product">
				@if(!empty($histories))
	                @foreach($histories as $log)
	                	<a href="#" class="list-group-item list-group-item-action media }}">
							<div class="media-left">
								<img class="media-object rounded-circle" src="{{ $log->user->profile_image ?? $defaultAvatar }}" alt="Generic placeholder image" style="width: 48px;height: 48px;">
							</div>
							<div class="media-body">
								<div class="d-flex justify-content-between">
							      	<h5 class="list-group-item-heading text-bold-600">{{ $log->user->getFullName() ?? '' }} - {{ find_reference_by_id($log->type)->value }}</h5>
							      	<small class="text-muted">{{ $log->created_at }}</small>
							    </div>
								<span class="list-group-item-text text-bold-600">{{ $log->content }}</span>
							</div>
						</a>
	                @endforeach
	            @endif
			</div>
		</div>
	</div>
</div>