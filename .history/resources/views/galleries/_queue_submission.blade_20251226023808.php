<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md mb-4 text-center">
                <a href="{{ $submission->url }}">@include('widgets._gallery_thumb', ['submission' => $submission])</a>
            </div>
            <div class="col-md text-center align-self-center">
                <h5>{!! $submission->displayName !!}</h5>

                @if (isset($submission->content_warning))
                    <p>
                        <span class="text-danger"><strong>콘텐츠 경고:</strong></span>
                        {!! nl2br(htmlentities($submission->content_warning)) !!}
                    </p>
                @endif

                @if (isset($queue) && $queue)
                    <span style="font-size:95%;" class="badge badge-{{ $submission->status == 'Accepted' ? 'success' : ($submission->status == 'Rejected' ? 'danger' : 'secondary') }}">
                        {{ $submission->status }}
                    </span> ・
                @endif

                {!! $submission->gallery->displayName !!} 에서 ・ 제작자 {!! $submission->credits !!}<br />
                제출일: {!! pretty_date($submission->created_at) !!} ・ 마지막 수정: {!! pretty_date($submission->updated_at) !!}

                @if ($submission->status == 'Pending' && $submission->collaboratorApproval && Auth::user()->hasPower('manage_submissions'))
                    <div class="row mt-2">
                        <div class="col-6 text-right text-danger">
                            {{ $submission->getVoteData()['reject'] }}/{{ $submission->gallery->votes_required }}
                            {!! Form::open(['url' => 'admin/gallery/edit/' . $submission->id . '/reject', 'id' => 'voteRejectForm']) !!}
                            <button
                                class="btn {{ ($submission->getVoteData()['raw']->get(Auth::user()->id)['vote'] ?? 0) == 1 ? 'btn-danger' : 'btn-outline-danger' }}"
                                style="min-width:40px;"
                                data-action="reject">
                                <i class="fas fa-times"></i>
                            </button>
                            {!! Form::close() !!}
                        </div>

                        <div class="col-6 text-left text-success">
                            {{ $submission->getVoteData()['approve'] }}/{{ $submission->gallery->votes_required }}
                            {!! Form::open(['url' => 'admin/gallery/edit/' . $submission->id . '/accept', 'id' => 'voteApproveForm']) !!}
                            <button
                                class="btn {{ ($submission->getVoteData()['raw']->get(Auth::user()->id)['vote'] ?? 0) == 2 ? 'btn-success' : 'btn-outline-success' }}"
                                style="min-width:40px;"
                                data-action="approve">
                                <i class="fas fa-check"></i>
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endif

                @if (isset($queue) && $queue)
                    <h6 class="mt-2">
                        {{ $submission->comments->where('type', 'Staff-User')->count() }}
                        {{ Auth::user()->hasPower('manage_submissions')
                            ? '스태프 ↔ 사용자 코멘트' . ($submission->comments->where('type', 'Staff-User')->count() != 1 ? '들' : '') . ' ・ '
                            : '스태프 코멘트'
                        }}
                        {{ Auth::user()->hasPower('manage_submissions')
                            ? $submission->comments->where('type', 'Staff-Staff')->count() . ' 스태프 ↔ 스태프 코멘트' . ($submission->comments->where('type', 'Staff-Staff')->count() != 1 ? '들' : '')
                            : ''
                        }}
                    </h6>

                    <h6 class="mt-2">
                        <a href="{{ $submission->queueUrl }}">상세 로그</a>
                    </h6>
                @endif
            </div>
        </div>
    </div>
</div>
