@extends('admin.layout')

@section('admin-title')
    {{ $page->id ? __('Edit') : __('Create') }} {{ __('Page') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Pages') => 'admin/pages', ($page->id ? __('Edit') : __('Create')) . ' ' . __('Page') => $page->id ? 'admin/pages/edit/' . $page->id : 'admin/pages/create']) !!}

    <h1>{{ $page->id ? __('Edit') : __('Create') }} {{ __('Page') }}
        @if ($page->id && !config('lorekeeper.text_pages.' . $page->key))
            <a href="#" class="btn btn-danger float-right delete-page-button">{{ __('Delete Page') }}</a>
        @endif
        @if ($page->id)
            <a href="{{ $page->url }}" class="btn btn-info float-right mr-md-2">{{ __('View Page') }}</a>
        @endif
    </h1>

    {!! Form::open(['url' => $page->id ? 'admin/pages/edit/' . $page->id : 'admin/pages/create', 'files' => true]) !!}

    <h3>{{ __('Basic Information') }}</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label(__('Title')) !!}
                {!! Form::text('title', $page->title, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label(__('Key')) !!} {!! add_help(__('This is a unique name used to form the URL of the page. Only alphanumeric characters, dash and underscore (no spaces) can be used.')) !!}
                {!! Form::text('key', $page->key, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label(__('Page Content')) !!}
        {!! Form::textarea('text', $page->text, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::checkbox('is_visible', 1, $page->id ? $page->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                {!! Form::label('is_visible', __('Is Viewable'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If this is turned off, users will not be able to view the page even if they have the link to it.')) !!}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                {!! Form::checkbox('can_comment', 1, $page->id ? $page->can_comment : 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                {!! Form::label('can_comment', __('Commentable'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If this is turned on, users will be able to comment on the page.')) !!}
            </div>
            @if (!Settings::get('comment_dislikes_enabled'))
                <div class="form-group">
                    {!! Form::checkbox('allow_dislikes', 1, $page->id ? $page->allow_dislikes : 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                    {!! Form::label('allow_dislikes', __('Allow Dislikes On Comments?'), ['class' => 'form-check-label ml-3']) !!} {!! add_help(__('If this is turned off, users cannot dislike comments.')) !!}
                </div>
            @endif
        </div>
    </div>

    <div class="text-right">
        {!! Form::submit($page->id ? __('Edit') : __('Create'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.delete-page-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/pages/delete') }}/{{ $page->id }}", '{{ __("Delete Page") }}');
            });
        });
    </script>
@endsection
