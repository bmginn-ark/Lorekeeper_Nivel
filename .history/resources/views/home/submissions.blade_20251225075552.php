@extends('home.layout')

@section('home-title')
    {{ $isClaims ? 'Claims' : 'Prompt Submissions' }}
@endsection

@section('home-content')
    @if ($isClaims)
        {!! breadcrumbs(['Claims' => 'claims']) !!}
    @else
        {!! breadcrumbs(['Prompt Submissions' => 'submissions']) !!}
    @endif

    <h1>
        {{ $isClaims ? 'Claims' : 'Prompt Submissions' }}
    </h1>

    <div class="text-right">
        @if (!$isClaims)
            <a href="{{ url('submissions/new') }}" class="btn btn-success">새 제출</a>
        @else
            <a href="{{ url('claims/new') }}" class="btn btn-success">새 수령</a>
        @endif
    </div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ Request::get('type') == 'draft' ? 'active' : '' }}" href="{{ url($isClaims ? 'claims' : 'submissions') . '?type=draft' }}">임시저장</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ !Request::get('type') || Request::get('type') == 'pending' ? 'active' : '' }}" href="{{ url($isClaims ? 'claims' : 'submissions') }}">대기중</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::get('type') == 'approved' ? 'active' : '' }}" href="{{ url($isClaims ? 'claims' : 'submissions') . '?type=approved' }}">승인됨</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::get('type') == 'rejected' ? 'active' : '' }}" href="{{ url($isClaims ? 'claims' : 'submissions') . '?type=rejected' }}">거절됨</a>
        </li>
    </ul>

    @if (count($submissions))
        {!! $submissions->render() !!}
        <div class="mb-4 logs-table">
            <div class="logs-table-header">
                <div class="row">
                    @if (!$isClaims)
                        <div class="col-12 col-md-2 font-weight-bold">
                            <div class="logs-table-cell">프롬프트</div>
                        </div>
                    @endif
                    <div class="col-6 {{ !$isClaims ? 'col-md-3' : 'col-md-4' }} font-weight-bold">
                        <div class="logs-table-cell">링크</div>
                    </div>
                    <div class="col-6 {{ !$isClaims ? 'col-md-5' : 'col-md-6' }} font-weight-bold">
                        <div class="logs-table-cell">마지막 작업</div>
                    </div>
                    <div class="col-12 col-md-1 font-weight-bold">
                        <div class="logs-table-cell">상태</div>
                    </div>
                </div>
            </div>
            <div class="logs-table-body">
                @foreach ($submissions as $submission)
                    <div class="logs-table-row">
                        <div class="row flex-wrap">
                            @if (!$isClaims)
                                <div class="col-12 col-md-2">
                                    <div class="logs-table-cell">{!! $submission->prompt->displayName !!}</div>
                                </div>
                            @endif
                            <div class="col-6 {{ !$isClaims ? 'col-md-3' : 'col-md-4' }}">
                                <div class="logs-table-cell">
                                    <span class="ubt-texthide"><a href="{{ $submission->url }}">{{ $submission->url }}</a></span>
                                </div>
                            </div>
                            <div class="col-6 {{ !$isClaims ? 'col-md-5' : 'col-md-6' }}">
                                <div class="logs-table-cell">{!! pretty_date($submission->updated_at) !!}</div>
                            </div>
                            <div class="col-6 col-md-1 text-right">
                                <div class="logs-table-cell">
                                    <span class="btn btn-{{ $submission->status == 'Pending' ? 'secondary' : ($submission->status == 'Approved' ? 'success' : 'danger') }} btn-sm py-0 px-1">{{ $submission->status }}</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-1">
                                <div class="logs-table-cell"><a href="{{ $submission->viewUrl }}" class="btn btn-primary btn-sm py-0 px-1">자세히</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {!! $submissions->render() !!}
        <div class="text-center mt-4 small text-muted">{{ $submissions->total() }} result{{ $submissions->total() == 1 ? '' : 's' }} found.</div>
    @else
        <p>{{ $isClaims ? '수령' : '제출' }} 이 없습니다.</p>
    @endif

@endsection
