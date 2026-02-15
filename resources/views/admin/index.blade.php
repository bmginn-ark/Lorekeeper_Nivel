@extends('admin.layout')

@section('admin-title')
    {{ __('Dashboard') }}
@endsection

@section('admin-content')
    {!! breadcrumbs([__('Admin Panel') => 'admin', __('Home') => 'admin']) !!}

    <h1>{{ __('Admin Dashboard') }}</h1>
    <div class="row">
        @if (Auth::user()->hasPower('manage_submissions'))
            <div class="col-sm-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Prompt Submissions') }} @if ($submissionCount)
                                <span class="badge badge-primary">{{ $submissionCount }}</span>
                            @endif
                        </h5>
                        <p class="card-text">
                            @if ($submissionCount)
                                {{ $submissionCount }} {{ $submissionCount == 1 ? __('submission') : __('submissions') }} {{ __('awaiting processing') }}.
                            @else
                                {{ __('The submission queue is clear. Hooray!') }}
                            @endif
                        </p>
                        <div class="text-right">
                            <a href="{{ url('admin/submissions/pending') }}" class="card-link">{{ __('View Queue') }} <span class="fas fa-caret-right ml-1"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Claims') }} @if ($claimCount)
                                <span class="badge badge-primary">{{ $claimCount }}</span>
                            @endif
                        </h5>
                        <p class="card-text">
                            @if ($claimCount)
                                {{ $claimCount }} {{ $claimCount == 1 ? __('claim') : __('claims') }} {{ __('awaiting processing') }}.
                            @else
                                {{ __('The claim queue is clear. Hooray!') }}
                            @endif
                        </p>
                        <div class="text-right">
                            <a href="{{ url('admin/claims/pending') }}" class="card-link">{{ __('View Queue') }} <span class="fas fa-caret-right ml-1"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->hasPower('manage_characters'))
            <div class="col-sm-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Design Updates') }} @if ($designCount)
                                <span class="badge badge-primary">{{ $designCount }}</span>
                            @endif
                        </h5>
                        <p class="card-text">
                            @if ($designCount)
                                {{ $designCount }} {{ $designCount == 1 ? __('design update') : __('design updates') }} {{ __('awaiting processing') }}.
                            @else
                                {{ __('The design update approval queue is clear. Hooray!') }}
                            @endif
                        </p>
                        <div class="text-right">
                            <a href="{{ url('admin/design-approvals/pending') }}" class="card-link">{{ __('View Queue') }} <span class="fas fa-caret-right ml-1"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('MYO Approvals') }} @if ($myoCount)
                                <span class="badge badge-primary">{{ $myoCount }}</span>
                            @endif
                        </h5>
                        <p class="card-text">
                            @if ($myoCount)
                                {{ $myoCount }} {{ $myoCount == 1 ? __('MYO slot') : __('MYO slots') }} {{ __('awaiting processing') }}.
                            @else
                                {{ __('The MYO slot approval queue is clear. Hooray!') }}
                            @endif
                        </p>
                        <div class="text-right">
                            <a href="{{ url('admin/myo-approvals/pending') }}" class="card-link">{{ __('View Queue') }} <span class="fas fa-caret-right ml-1"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            @if ($openTransfersQueue)
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Character Transfers') }} @if ($transferCount + $tradeCount)
                                    <span class="badge badge-primary">{{ $transferCount + $tradeCount }}</span>
                                @endif
                            </h5>
                            <p class="card-text">
                                @if ($transferCount + $tradeCount)
                                    {{ $transferCount + $tradeCount }} {{ $transferCount + $tradeCount == 1 ? __('character transfer') : __('character transfers') }} {{ __('and/or') }} {{ $transferCount + $tradeCount == 1 ? __('trade') : __('trades') }} {{ __('awaiting processing') }}.
                                @else
                                    {{ __('The character transfer/trade queue is clear. Hooray!') }}
                                @endif
                            </p>
                            <div class="text-right">
                                <a href="{{ url('admin/masterlist/transfers/incoming') }}" class="card-link">{{ __('View Queue') }} <span class="fas fa-caret-right ml-1"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        @if (Auth::user()->hasPower('manage_reports'))
            <div class="col-sm-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Reports') }} @if ($reportCount || $assignedReportCount)
                                <span class="badge badge-primary">{{ $reportCount + $assignedReportCount }}</span>
                            @endif
                        </h5>
                        <p class="card-text">
                            @if ($reportCount || $assignedReportCount)
                                @if ($reportCount)
                                    {{ $reportCount }} {{ $reportCount == 1 ? __('report') : __('reports') }} {{ __('awaiting assignment') }}.
                                @endif
                                {!! $reportCount && $assignedReportCount ? '<br/>' : '' !!}
                                @if ($assignedReportCount)
                                    {{ $assignedReportCount }} {{ $assignedReportCount == 1 ? __('report') : __('reports') }} {{ __('awaiting processing') }}.
                                @endif
                            @else
                                {{ __('The report queue is clear. Hooray!') }}
                            @endif
                        </p>
                        <div class="text-right">
                            <a href="{{ url('admin/reports/pending') }}" class="card-link">{{ __('View Queue') }} <span class="fas fa-caret-right ml-1"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (!Auth::user()->hasPower('manage_submissions') && !Auth::user()->hasPower('manage_characters') && !Auth::user()->hasPower('manage_reports'))
            <div class="card p-4 col-12">
                <h5 class="card-title">{{ __('You do not have a rank that allows you to access any queues.') }}</h5>
                <p class="mb-1">
                    {{ __('Refer to the sidebar for what you can access as a staff member.') }}
                </p>
                <p class="mb-0">
                    {{ __('If you believe this to be in error, contact your site administrator.') }}
                </p>
            </div>
        @endif
        @if (Auth::user()->hasPower('manage_submissions'))
            @if ($galleryRequireApproval)
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Gallery Submissions') }} @if ($gallerySubmissionCount)
                                    <span class="badge badge-primary">{{ $gallerySubmissionCount }}</span>
                                @endif
                            </h5>
                            <p class="card-text">
                                @if ($gallerySubmissionCount)
                                    {{ $gallerySubmissionCount }} {{ $gallerySubmissionCount == 1 ? __('gallery submission') : __('gallery submissions') }} {{ __('awaiting processing') }}.
                                @else
                                    {{ __('The gallery submission queue is clear. Hooray!') }}
                                @endif
                            </p>
                            <div class="text-right">
                                <a href="{{ url('admin/gallery/submissions/pending') }}" class="card-link">{{ __('View Queue') }} <span class="fas fa-caret-right ml-1"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($galleryCurrencyAwards)
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Gallery Currency Awards') }} @if ($galleryAwardCount)
                                    <span class="badge badge-primary">{{ $galleryAwardCount }}</span>
                                @endif
                            </h5>
                            <p class="card-text">
                                @if ($galleryAwardCount)
                                    {{ $galleryAwardCount }} {{ $galleryAwardCount == 1 ? __('gallery submission') : __('gallery submissions') }} {{ __('awaiting currency rewards') }}.
                                @else
                                    {{ __('The gallery currency award queue is clear. Hooray!') }}
                                @endif
                            </p>
                            <div class="text-right">
                                <a href="{{ url('admin/gallery/currency/pending') }}" class="card-link">{{ __('View Queue') }} <span class="fas fa-caret-right ml-1"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
