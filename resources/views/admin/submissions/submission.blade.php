@extends('admin.layout')

@section('admin-title')
    {{ $submission->prompt_id ? __('Submission') : __('Claim') }} (#{{ $submission->id }})
@endsection

@section('admin-content')
    @if ($submission->prompt_id)
        {!! breadcrumbs([__('Admin Panel') => 'admin', __('Prompt Queue') => 'admin/submissions/pending', __('Submission') . ' (#' . $submission->id . ')' => $submission->viewUrl]) !!}
    @else
        {!! breadcrumbs([__('Admin Panel') => 'admin', __('Claim Queue') => 'admin/claims/pending', __('Claim') . ' (#' . $submission->id . ')' => $submission->viewUrl]) !!}
    @endif

    @if ($submission->status == 'Pending')

        <h1>
            {{ $submission->prompt_id ? __('Submission') : __('Claim') }} (#{{ $submission->id }})
            <span class="float-right badge badge-{{ $submission->status == 'Pending' || $submission->status == 'Draft' ? 'secondary' : ($submission->status == 'Approved' ? 'success' : 'danger') }}">
                {{ __($submission->status) }}
            </span>
        </h1>

        <div class="mb-1">
            <div class="row">
                <div class="col-md-2 col-4">
                    <h5>{{ __('User') }}</h5>
                </div>
                <div class="col-md-10 col-8">{!! $submission->user->displayName !!}</div>
            </div>
            @if ($submission->prompt_id)
                <div class="row">
                    <div class="col-md-2 col-4">
                        <h5>{{ __('Prompt') }}</h5>
                    </div>
                    <div class="col-md-10 col-8">{!! $submission->prompt->displayName !!}</div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-4">
                        <h5>{{ __('Previous Submissions') }}</h5>
                    </div>
                    <div class="col-md-10 col-8">{{ $count }} {!! add_help(__('This is the number of times the user has submitted this prompt before and had their submission approved.')) !!}</div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-2 col-4">
                    <h5>{{ __('URL') }}</h5>
                </div>
                <div class="col-md-10 col-8"><a href="{{ $submission->url }}">{{ $submission->url }}</a></div>
            </div>
            <div class="row">
                <div class="col-md-2 col-4">
                    <h5>{{ __('Submitted') }}</h5>
                </div>
                <div class="col-md-10 col-8">{!! format_date($submission->created_at) !!} ({{ $submission->created_at->diffForHumans() }})</div>
            </div>
        </div>
        <h2>{{ __('Comments') }}</h2>
        <div class="card mb-3">
            <div class="card-body">{!! nl2br(htmlentities($submission->comments)) !!}</div>
        </div>
        @if (Auth::check() && $submission->staff_comments && ($submission->user_id == Auth::user()->id || Auth::user()->hasPower('manage_submissions')))
            <h2>{{ __('Staff Comments') }} ({!! $submission->staff->displayName !!})</h2>
            <div class="card mb-3">
                <div class="card-body">
                    @if (isset($submission->parsed_staff_comments))
                        {!! $submission->parsed_staff_comments !!}
                    @else
                        {!! $submission->staff_comments !!}
                    @endif
                </div>
            </div>
        @endif

        {!! Form::open(['url' => url()->current(), 'id' => 'submissionForm']) !!}

        <h2>{{ __('Rewards') }}</h2>
        @include('widgets._loot_select', ['loots' => $submission->rewards, 'showLootTables' => true, 'showRaffles' => true])
        @if ($submission->prompt_id)
            <div class="mb-3">
                @include('home._prompt', ['prompt' => $submission->prompt, 'staffView' => true])
            </div>
        @endif

        <h2>{{ __('Characters') }}</h2>
        <div id="characters" class="mb-3">
            @if (count(
                    $submission->characters()->whereRelation('character', 'deleted_at', null)->get()) != count($submission->characters()->get()))
                <div class="alert alert-warning">
                    {{ __('Some characters have been deleted since this submission was created.') }}
                </div>
            @endif
            @foreach ($submission->characters()->whereRelation('character', 'deleted_at', null)->get() as $character)
                @include('widgets._character_select_entry', ['characterCurrencies' => $characterCurrencies, 'items' => $items, 'tables' => $tables, 'character' => $character, 'expanded_rewards' => $expanded_rewards])
            @endforeach
        </div>
        <div class="text-right mb-3">
            <a href="#" class="btn btn-outline-info" id="addCharacter">{{ __('Add Character') }}</a>
        </div>

        @if (isset($inventory['user_items']))
            <h2>{{ __('Add-Ons') }}</h2>
            <p>{{ __('These items have been removed from the :role\'s inventory and will be refunded if the request is rejected or consumed if it is approved.', ['role' => $submission->prompt_id ? __('submitter') : __('claimant')]) }}</p>
            <table class="table table-sm">
                <thead class="thead-light">
                    <tr class="d-flex">
                        <th class="col-2">{{ __('Item') }}</th>
                        <th class="col-4">{{ __('Source') }}</th>
                        <th class="col-4">{{ __('Notes') }}</th>
                        <th class="col-2">{{ __('Quantity') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventory['user_items'] as $itemRow)
                        <tr class="d-flex">
                            <td class="col-2">
                                @if (isset($itemsrow[$itemRow['asset']->item_id]->image_url))
                                    <img class="small-icon" src="{{ $itemsrow[$itemRow['asset']->item_id]->image_url }}" alt="{{ $itemsrow[$itemRow['asset']->item_id]->name }}">
                                @endif {!! $itemsrow[$itemRow['asset']->item_id]->name !!}
                            <td class="col-4">{!! array_key_exists('data', $itemRow['asset']->data) ? ($itemRow['asset']->data['data'] ? $itemRow['asset']->data['data'] : 'N/A') : 'N/A' !!}</td>
                            <td class="col-4">{!! array_key_exists('notes', $itemRow['asset']->data) ? ($itemRow['asset']->data['notes'] ? $itemRow['asset']->data['notes'] : 'N/A') : 'N/A' !!}</td>
                            <td class="col-2">{!! $itemRow['quantity'] !!}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if (isset($inventory['currencies']))
            <h3>{{ __(":name's Bank", ['name' => $submission->user->name]) }}</h3>
            <table class="table table-sm mb-3">
                <thead>
                    <tr>
                        <th width="70%">{{ __('Currency') }}</th>
                        <th width="30%">{{ __('Quantity') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventory['currencies'] as $currency)
                        <tr>
                            <td>{!! $currency['asset']->name !!}</td>
                            <td>{{ $currency['quantity'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="form-group">
            {!! Form::label('staff_comments', __('Staff Comments (Optional)')) !!}
            {!! Form::textarea('staff_comments', $submission->staffComments, ['class' => 'form-control wysiwyg']) !!}
        </div>

        <div class="text-right">
            <a href="#" class="btn btn-danger mr-2" id="rejectionButton">{{ __('Reject') }}</a>
            <a href="#" class="btn btn-secondary mr-2" id="cancelButton">{{ __('Cancel') }}</a>
            <a href="#" class="btn btn-success" id="approvalButton">{{ __('Approve') }}</a>
        </div>

        {!! Form::close() !!}

        <div id="characterComponents" class="hide">
            <div class="submission-character mb-3 card">
                <div class="card-body">
                    <div class="text-right"><a href="#" class="remove-character text-muted"><i class="fas fa-times"></i></a></div>
                    <div class="row">
                        <div class="col-md-2 align-items-stretch d-flex">
                            <div class="d-flex text-center align-items-center">
                                <div class="character-image-blank">{{ __('Enter character code.') }}</div>
                                <div class="character-image-loaded hide"></div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {!! Form::label('slug', __('Character Code')) !!}
                                {!! Form::select('slug[]', $characters, null, ['class' => 'form-control character-code', 'placeholder' => __('Select Character')]) !!}
                            </div>
                            <div class="character-rewards hide">
                                <h4>{{ __('Character Rewards') }}</h4>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            @if ($expanded_rewards)
                                                <th width="35%">{{ __('Reward Type') }}</th>
                                                <th width="35%">{{ __('Reward') }}</th>
                                            @else
                                                <th width="70%">{{ __('Reward') }}</th>
                                            @endif
                                            <th width="30%">{{ __('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="character-rewards">
                                    </tbody>
                                </table>
                                <div class="text-right">
                                    <a href="#" class="btn btn-outline-primary btn-sm add-reward">{{ __('Add Reward') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table>
                <tr class="character-reward-row">

                    @if ($expanded_rewards)
                        <td>
                            {!! Form::select('character_rewardable_type[]', ['Item' => __('Item'), 'Currency' => __('Currency'), 'LootTable' => __('Loot Table')], null, ['class' => 'form-control character-rewardable-type', 'placeholder' => __('Select Reward Type')]) !!}
                        </td>
                        <td class="lootDivs">
                            <div class="character-currencies hide">{!! Form::select('character_rewardable_id[]', $characterCurrencies, 0, ['class' => 'form-control character-currency-id', 'placeholder' => __('Select Currency')]) !!}</div>
                            <div class="character-items hide">{!! Form::select('character_rewardable_id[]', $items, 0, ['class' => 'form-control character-item-id', 'placeholder' => __('Select Item')]) !!}</div>
                            <div class="character-tables hide">{!! Form::select('character_rewardable_id[]', $tables, 0, ['class' => 'form-control character-table-id', 'placeholder' => __('Select Loot Table')]) !!}</div>
                        </td>
                    @else
                        <td class="lootDivs">
                            {!! Form::hidden('character_rewardable_type[]', 'Currency', ['class' => 'character-rewardable-type']) !!}
                            {!! Form::select('character_rewardable_id[]', $characterCurrencies, 0, ['class' => 'form-control character-currency-id', 'placeholder' => __('Select Currency')]) !!}
                        </td>
                    @endif

                    <td class="d-flex align-items-center">
                        {!! Form::text('character_quantity[]', 0, ['class' => 'form-control mr-2  character-rewardable-quantity']) !!}
                        <a href="#" class="remove-reward d-block"><i class="fas fa-times text-muted"></i></a>
                    </td>
                </tr>
            </table>
        </div>
        @include('widgets._loot_select_row', ['showLootTables' => true, 'showRaffles' => true])

        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content hide" id="approvalContent">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0">{{ __('Confirm Approval') }}</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('This will approve the :type and distribute the above rewards to the user.', ['type' => $submission->prompt_id ? __('submission') : __('claim')]) }}</p>
                        <div class="text-right">
                            <a href="#" id="approvalSubmit" class="btn btn-success">{{ __('Approve') }}</a>
                        </div>
                    </div>
                </div>
                <div class="modal-content hide" id="cancelContent">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0">{{ __('Confirm Cancellation') }}</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('This will cancel the :type and send it back to drafts. Make sure to include a staff comment if you do this!', ['type' => $submission->prompt_id ? __('submission') : __('claim')]) }}</p>
                        <div class="text-right">
                            <a href="#" id="cancelSubmit" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </div>
                <div class="modal-content hide" id="rejectionContent">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0">{{ __('Confirm Rejection') }}</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('This will reject the :type.', ['type' => $submission->prompt_id ? __('submission') : __('claim')]) }}</p>
                        <div class="text-right">
                            <a href="#" id="rejectionSubmit" class="btn btn-danger">{{ __('Reject') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">{{ __('This :type has already been processed.', ['type' => $submission->prompt_id ? __('submission') : __('claim')]) }}</div>
        @include('home._submission_content', ['submission' => $submission])
    @endif

@endsection

@section('scripts')
    @parent
    @if ($submission->status == 'Pending')
        @include('js._loot_js', ['showLootTables' => true, 'showRaffles' => true])
        @include('js._character_select_js')

        <script>
            $(document).ready(function() {
                var $confirmationModal = $('#confirmationModal');
                var $submissionForm = $('#submissionForm');

                var $approvalButton = $('#approvalButton');
                var $approvalContent = $('#approvalContent');
                var $approvalSubmit = $('#approvalSubmit');

                var $rejectionButton = $('#rejectionButton');
                var $rejectionContent = $('#rejectionContent');
                var $rejectionSubmit = $('#rejectionSubmit');

                var $cancelButton = $('#cancelButton');
                var $cancelContent = $('#cancelContent');
                var $cancelSubmit = $('#cancelSubmit');

                $approvalButton.on('click', function(e) {
                    e.preventDefault();
                    $approvalContent.removeClass('hide');
                    $rejectionContent.addClass('hide');
                    $cancelContent.addClass('hide');
                    $confirmationModal.modal('show');
                });

                $rejectionButton.on('click', function(e) {
                    e.preventDefault();
                    $rejectionContent.removeClass('hide');
                    $approvalContent.addClass('hide');
                    $cancelContent.addClass('hide');
                    $confirmationModal.modal('show');
                });

                $cancelButton.on('click', function(e) {
                    e.preventDefault();
                    $cancelContent.removeClass('hide');
                    $rejectionContent.addClass('hide');
                    $approvalContent.addClass('hide');
                    $confirmationModal.modal('show');
                });

                $approvalSubmit.on('click', function(e) {
                    e.preventDefault();
                    $submissionForm.attr('action', '{{ url()->current() }}/approve');
                    $submissionForm.submit();
                });

                $rejectionSubmit.on('click', function(e) {
                    e.preventDefault();
                    $submissionForm.attr('action', '{{ url()->current() }}/reject');
                    $submissionForm.submit();
                });

                $cancelSubmit.on('click', function(e) {
                    e.preventDefault();
                    $submissionForm.attr('action', '{{ url()->current() }}/cancel');
                    $submissionForm.submit();
                });
            });
        </script>
    @endif
@endsection
