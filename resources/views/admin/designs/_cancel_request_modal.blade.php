<p>{{ __('This will cancel the design approval request, returning it to draft form and allowing the user to edit it again.') }}</p>
{!! Form::open(['url' => 'admin/designs/edit/' . $request->id . '/cancel']) !!}
<div class="form-group">
    {!! Form::label('staff_comments', __('Comment')) !!} {!! add_help(__('Enter a comment for the user. They will see this on their request page.')) !!}
    {!! Form::textarea('staff_comments', $request->staff_comment, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::checkbox('preserve_queue', 1, 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('preserve_queue', __('Preserve Queue Position'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('Allows the user to avoid needing to wait for their request to return to the front of the queue. If this is turned off, the request will go into the back of the queue as per normal.')) !!}
</div>
<div class="text-right">
    {!! Form::submit(__('Cancel Request'), ['class' => 'btn btn-secondary']) !!}
</div>
{!! Form::close() !!}
