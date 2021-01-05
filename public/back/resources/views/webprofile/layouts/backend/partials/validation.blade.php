@if ($errors->count() > 0)
	<div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        @foreach ($errors->all(':message') as $error)
			{{ $error }}<br>
		@endforeach
    </div>
@endif
