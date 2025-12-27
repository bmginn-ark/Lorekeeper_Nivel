<h1>
    요청 (#{{ $request->id }}):
    {!! $request->character ? $request->character->displayName : '삭제된 캐릭터 [#' . $request->character_id . ']' !!}
    <span class="float-right badge badge-{{ $request->status == 'Draft' || $request->status == 'Pending' ? 'secondary' : ($request->status == 'Approved' ? 'success' : 'danger') }}">
        {{ $request->status }}
    </span>
</h1>

@if (isset($request->staff_id))
    @if ($request->staff_comments && ($request->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
        <h5 class="text-danger">스태프 코멘트 ({{ $request->staff->displayName }})</h5>
        <div class="card border-danger mb-3">
            <div class="card-body">{!! nl2br(htmlentities($request->staff_comments)) !!}</div>
        </div>
    @else
        <p>스태프 코멘트가 제공되지 않았습니다.</p>
    @endif
@endif

@if ($request->status != 'Draft' && Auth::user()->hasPower('manage_characters') && config('lorekeeper.extensions.design_update_voting'))
    <?php
    $rejectSum = 0;
    $approveSum = 0;
    foreach ($request->voteData as $voter => $vote) {
        if ($vote == 1) {
            $rejectSum += 1;
        }
        if ($vote == 2) {
            $approveSum += 1;
        }
    }
    ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="text-left">
                이 {{ $request->update_type == 'MYO' ? 'MYO 제출물' : '디자인 업데이트' }}에 대한
                {{ $request->status == 'Pending' ? '투표' : '이전 투표 기록' }}

                @if ($request->status == 'Pending')
                    <span class="text-right float-right">
                        <div class="row">
                            <div class="col-sm-6 text-center text-danger">
                                {{ $rejectSum }}/{{ Settings::get('design_votes_needed') }}
                                {!! Form::open(['url' => 'admin/designs/vote/' . $request->id . '/reject', 'id' => 'voteRejectForm']) !!}
                                <button class="btn {{ $request->voteData->get(Auth::user()->id) == 1 ? 'btn-danger' : 'btn-outline-danger' }}" style="min-width:40px;" data-action="reject">
                                    <i class="fas fa-times"></i>
                                </button>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-sm-6 text-center text-success">
                                {{ $approveSum }}/{{ Settings::get('design_votes_needed') }}
                                {!! Form::open(['url' => 'admin/designs/vote/' . $request->id . '/approve', 'id' => 'voteApproveForm']) !!}
                                <button class="btn {{ $request->voteData->get(Auth::user()->id) == 2 ? 'btn-success' : 'btn-outline-success' }}" style="min-width:40px;" data-action="approve">
                                    <i class="fas fa-check"></i>
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </span>
                @endif
            </h5>

            <p>
                {{ $request->update_type == 'MYO' ? 'MYO 제출물' : '디자인 업데이트' }}은
                승인으로 간주되기 위해 {{ Settings::get('design_votes_needed') }}표가 필요합니다.
                단, 이는 자동으로 제출물을 처리하지 않으며,
                단지 합의 여부를 나타낼 뿐입니다.
            </p>

            <hr />

            @if (isset($request->vote_data) && $request->vote_data)
                <h4>투표 내역:</h4>
                <div class="row">
                    <div class="col-md">
                        <h5>거절:</h5>
                        <ul>
                            @foreach ($request->voteData as $voter => $vote)
                                @if ($vote == 1)
                                    <li>
                                        {!! App\Models\User\User::find($voter)->displayName !!}
                                        {{ $voter == Auth::user()->id ? '(본인)' : '' }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md">
                        <h5>승인:</h5>
                        <ul>
                            @foreach ($request->voteData as $voter => $vote)
                                @if ($vote == 2)
                                    <li>
                                        {!! App\Models\User\User::find($voter)->displayName !!}
                                        {{ $voter == Auth::user()->id ? '(본인)' : '' }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <p>아직 투표가 진행되지 않았습니다!</p>
            @endif
        </div>
    </div>
@endif

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ set_active('designs/' . $request->id) }}" href="{{ url('designs/' . $request->id) }}">
            @if ($request->is_complete)
                <i class="text-success fas fa-check-circle fa-fw mr-2"></i>
            @endif 상태
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ set_active('designs/' . $request->id . '/comments') }}" href="{{ url('designs/' . $request->id . '/comments') }}">
            <i class="text-{{ $request->has_comments ? 'success far fa-circle' : 'danger fas fa-times' }} fa-fw mr-2"></i>
            코멘트
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ set_active('designs/' . $request->id . '/image') }}" href="{{ url('designs/' . $request->id . '/image') }}">
            <i class="text-{{ $request->has_image ? 'success far fa-circle' : 'danger fas fa-times' }} fa-fw mr-2"></i>
            마스터리스트 이미지
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ set_active('designs/' . $request->id . '/addons') }}" href="{{ url('designs/' . $request->id . '/addons') }}">
            <i class="text-{{ $request->has_addons ? 'success far fa-circle' : 'danger fas fa-times' }} fa-fw mr-2"></i>
            애드온
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ set_active('designs/' . $request->id . '/traits') }}" href="{{ url('designs/' . $request->id . '/traits') }}">
            <i class="text-{{ $request->has_features ? 'success far fa-circle' : 'danger fas fa-times' }} fa-fw mr-2"></i>
            특성
        </a>
    </li>
</ul>
