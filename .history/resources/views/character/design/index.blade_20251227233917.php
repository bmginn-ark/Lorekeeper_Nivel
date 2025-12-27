@extends('character.design.layout')

@section('design-title')
    인덱스
@endsection

@section('design-content')
    {!! breadcrumbs(['Design Approvals' => 'designs'] + ($status == 'draft' ? ['Drafts' => 'designs'] : ['Submissions' => 'designs/' . $status])) !!}

    @if ($status == 'draft')
        <h1>디자인 승인 초안</h1>

        <p>디자인 승인 요청을 통해 캐릭터의 디자인에 대한 업데이트를 제출하거나 MYO 슬롯에 대한 완성된 디자인을 제출할 수 있습니다. 새 승인 요청을 만들려면 캐릭터 또는 MYO 슬롯의 페이지로 이동하여 사이드바에서 "디자인 업데이트"를 선택하세요.
        </p>
    @else
        <h1>
            디자인 승인
        </h1>

        <p>이것은 제출한 디자인 승인 요청 목록입니다. 이 요청들은 스태프에 의해 검토되며, 디자인이 요구 사항과 지침을 충족하면 승인됩니다.</p>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ $status == 'pending' ? 'active' : '' }}" href="{{ url('designs/pending') }}">대기중</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'approved' ? 'active' : '' }}" href="{{ url('designs/approved') }}">승인됨</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'rejected' ? 'active' : '' }}" href="{{ url('designs/rejected') }}">거절됨</a>
            </li>
        </ul>
    @endif

    @if (count($requests))
        {!! $requests->render() !!}
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Character/MYO Slot</th>
                    <th width="20%">Submitted</th>
                    @if ($status != 'draft')
                        <th width="20%">Status</th>
                    @endif
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $r)
                    <tr>
                        <td>{!! $r->character ? $r->character->displayName : 'Deleted Character [#' . $r->character_id . ']' !!}</td>
                        <td>{!! $r->submitted_at ? format_date($r->submitted_at) : '---' !!}</td>
                        @if ($status != 'draft')
                            <td>
                                <span class="badge badge-{{ $r->status == 'Pending' ? 'secondary' : ($r->status == 'Approved' ? 'success' : 'danger') }}">{{ $r->status }}</span>
                            </td>
                        @endif
                        <td class="text-right"><a href="{{ $r->url }}" class="btn btn-primary btn-sm">Details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $requests->render() !!}
    @else
        <p>No {{ 'requests' }} found.</p>
    @endif

@endsection
