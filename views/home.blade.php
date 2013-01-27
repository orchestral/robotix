<div class="page-header">
	<h2>Robots.txt</h2>
</div>

{{ Form::open(handles('orchestra::resources/robotix'), 'POST') }}

	<div class="control-group {{ $errors->has('robots') ? 'error' : '' }}">
		<div class="controls">
			{{ Form::textarea('robots', $robots, array('class' => 'span12')) }}
			{{ $errors->first('robots', '<p class="help-block">:message</p>') }}
		</div>
	</div>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">
			{{ __('orchestra::label.submit') }}
		</button>
	</div>

{{ Form::close() }}
