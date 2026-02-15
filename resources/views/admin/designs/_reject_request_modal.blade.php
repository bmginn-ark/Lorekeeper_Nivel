<p>{{ __('This will reject the design approval request, which closes the request and disallows the user from editing it further. Any attached items and/or currency will be returned.') }}</p>
{!! Form::open(['url' => 'admin/designs/edit/' . $request->id . '/reject']) !!}
<div class="form-group">
    {!! Form::label('staff_comments', __('Comment')) !!} {!! add_help(__('Enter a comment for the user. They will see this on their request page.')) !!}
    {!! Form::textarea('staff_comments', $request->staff_comments, ['class' => 'form-control']) !!}
</div>
<div class="text-right">
    {!! Form::submit(__('Reject Request'), ['class' => 'btn btn-danger']) !!}
</div>
{!! Form::close() !!}
