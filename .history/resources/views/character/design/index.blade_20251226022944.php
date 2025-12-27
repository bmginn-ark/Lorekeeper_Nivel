@extends('character.design.layout')

@section('design-title')
    목록
@endsection

@section('design-content')
    {!! breadcrumbs(['디자인 승인' => 'designs'] + ($status == 'draft' ? ['초안' => 'designs'] : ['제출 내역' => 'designs/' . $status])) !!}

    @if ($status == 'draft')
        <h1>디자인 승인 초안</h1>

        <p>
            디자인 승인 요청을 통해 캐릭터 디자인 업데이트를 제출하거나,
            MYO 슬롯의 완성된 디자인을 제출할 수 있습니다.
            새 승인 요청을 생성하려면 캐릭터 또는 MYO 슬롯 페이지로 이동하여
            사이드바에서 “디자인 업데이트”를 선택하세요.
        </p>
    @else
        <h1>
            디자인 승인
        </h1>

        <p>
            아래는 당신이 제출한 디자인 승인 요청 목록입니다.
            스태프가 이를 검토하며, 디자인이 요구사항과 가이드라인을 충족할 경우 승인됩니다.
        </p>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ $status == 'pending' ? 'active' : '' }}" href="{{ url('designs/pending') }}">대기 중</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'approved' ? 'active' : '' }}" href="{{ url('designs/approved') }}">승인됨</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'rejected' ? 'active' : '' }}" href="{{ url('designs/rejected') }}">반려됨</a>
            </li>
        </ul>
    @endif

    @if (count($requests))
        {!! $requests->render() !!}
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>캐릭터 / MYO 슬롯</th>
                    <th width="20%">제출일</th>
                    @if ($status != 'draft')
                        <th width="20%">상태</th>
                    @endif
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $r)
                    <tr>
                        <td>{!! $r->character ? $r->character->displayName : '삭제된 캐릭터 [#' . $r->character_id . ']' !!}</td>
                        <td>{!! $r->submitted_at ? format_date($r->submitted_at) : '---' !!}</td>
                        @if ($status != 'draft')
                            <td>
                                <span class="badge badge-{{ $r->status == 'Pending' ? 'secondary' : ($r->status == 'Approved' ? 'success' : 'danger') }}">{{ $r->status }}</span>
                            </td>
                        @endif
                        <td class="text-right">
                            <a href="{{ $r->url }}" class="btn btn-primary btn-sm">상세보기</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $requests->render() !!}
    @else
        <p>요청이 없습니다.</p>
    @endif

@endsection
