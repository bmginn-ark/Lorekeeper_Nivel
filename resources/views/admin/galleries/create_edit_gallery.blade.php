@extends('admin.layout')

@section('admin-title')
    {{ $gallery->id ? __('Edit') : __('Create') }} {{ __('Gallery') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Galleries') => 'admin/data/galleries', ($gallery->id ? __('Edit') : __('Create')) . ' ' . __('Gallery') => $gallery->id ? 'admin/data/galleries/edit/' . $gallery->id : 'admin/data/galleries/create']) !!}

    <h1>{{ $gallery->id ? __('Edit') : __('Create') }} {{ __('Gallery') }}
        @if ($gallery->id)
            <a href="#" class="btn btn-danger float-right delete-gallery-button">{{ __('Delete Gallery') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $gallery->id ? 'admin/data/galleries/edit/' . $gallery->id : 'admin/data/galleries/create']) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="row">
        <div class="col-md">
            <div class="form-group">
                {!! Form::label(__('Name')) !!}
                {!! Form::text('name', $gallery->name, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label(__('Sort (Optional)')) !!} {!! add_help(__('Galleries are ordered first by sort number, then by name-- so galleries without a sort number are sorted only by name.')) !!}
                {!! Form::number('sort', $gallery->sort, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label(__('Parent Gallery (Optional)')) !!}
        {!! Form::select('parent_id', $galleries, $gallery->parent_id, ['class' => 'form-control', 'placeholder' => __('Select a gallery')]) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('Description (Optional)')) !!}
        {!! Form::textarea('description', $gallery->description, ['class' => 'form-control']) !!}
    </div>

    <div class="row">
        <div class="col-md">
            <div class="form-group">
                {!! Form::checkbox('submissions_open', 1, $gallery->submissions_open, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                {!! Form::label('submissions_open', __('Submissions Open'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(
                    __('Whether or not users can submit to this gallery. Admins can submit regardless of this setting. Does not override global setting. Leave this on for time-limited galleries; users wll not be able to submit outside of the start and end times regardless of this setting, but will not be able to submit at all if this is off.'),
                ) !!}
            </div>
        </div>
        @if (Settings::get('gallery_submissions_reward_currency'))
            <div class="col-md">
                <div class="form-group">
                    {!! Form::checkbox('currency_enabled', 1, $gallery->currency_enabled, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                    {!! Form::label('currency_enabled', __('Enable Currency Rewards'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('Whether or not submissions to this gallery are eligible for rewards of group currency.')) !!}
                </div>
            </div>
        @endif
        <div class="col-md">
            <div class="form-group">
                {!! Form::checkbox('prompt_selection', 1, $gallery->prompt_selection, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                {!! Form::label('prompt_selection', __('Prompt Selection'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(
                    __('Whether or not users can select a prompt to associate a gallery submission with when creating it. Gallery submissions will still auto-associate, prefix, etc. themselves with prompts if approved prompt submissions using the gallery submission exist.'),
                ) !!}
            </div>
        </div>
    </div>
    @if (Settings::get('gallery_submissions_require_approval'))
        <div class="form-group">
            {!! Form::label(__('Votes Required')) !!} {!! add_help(__('How many votes are required for submissions to this gallery to be accepted. Set to 0 to automatically accept submissions.')) !!}
            {!! Form::number('votes_required', $gallery->votes_required, ['class' => 'form-control']) !!}
        </div>
    @endif

    <div class="row">
        <div class="col-md">
            <div class="form-group">
                {!! Form::label('hide_before_start', __('Hide Before Start Time'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If hidden, the gallery will not be shown on the gallery list before the starting time is reached. A starting time needs to be set. Galleries are always visible after the end time.')) !!}<br />
                {!! Form::checkbox('hide_before_start', 1, $gallery->id ? $gallery->hide_before_start : 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
            </div>
        </div>
        <div class="col-md">
            <div class="form-group">
                {!! Form::label('start_at', __('Start Time (Optional)')) !!} {!! add_help(__('Pieces cannot be submitted to the gallery before the starting time.')) !!}
                {!! Form::text('start_at', $gallery->start_at, ['class' => 'form-control datepicker']) !!}
            </div>
        </div>
        <div class="col-md">
            <div class="form-group">
                {!! Form::label('end_at', __('End Time (Optional)')) !!} {!! add_help(__('Pieces cannot be submitted to the gallery after the ending time.')) !!}
                {!! Form::text('end_at', $gallery->end_at, ['class' => 'form-control datepicker']) !!}
            </div>
        </div>
    </div>

    <div class="text-right">
        {!! Form::submit($gallery->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent
    @include('widgets._datetimepicker_js')
    <script>
        $(document).ready(function() {
            $('.delete-gallery-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/galleries/delete') }}/{{ $gallery->id }}", '{{ __("Delete Gallery") }}');
            });

        });
    </script>
@endsection
