@extends('galleries.layout')

@section('gallery-title')
    {{ $submission->title }}로그
@endsection

@section('gallery-content')
    {!! breadcrumbs(['gallery' => 'gallery', $submission->gallery->displayName => 'gallery/' . $submission->gallery->id, $submission->title => 'gallery/view/' . $submission->id, 'Log Details' => 'gallery/queue/' . $submission->id]) !!}

    <h1>로그 디테일
        <span
            class="float-right badge badge-{{ $submission->status == 'Pending' ? 'secondary' : ($submission->status == 'Accepted' ? 'success' : 'danger') }}">{{ $submission->collaboratorApproval ? $submission->status : '협력자 승인 대기중' }}</span>
    </h1>

    @include('galleries._queue_submission', ['key' => 0])

    <div class="row">
        <div class="col col-md">
            @if (Settings::get('gallery_submissions_reward_currency') && $submission->gallery->currency_enabled)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{!! $currency->displayName !!} 어워드 정보 <a class="small inventory-collapse-toggle collapse-toggle {{ $submission->status == 'Accepted' ? '' : 'collapsed' }}" href="#currencyForm" data-toggle="collapse">보기</a></h5>
                    </div>
                    <div class="card-body collapse {{ $submission->status == 'Accepted' ? 'show' : '' }}" id="currencyForm">
                        @if ($submission->status == 'Accepted')
                            @if (!$submission->is_valued)
                                @if (Auth::user()->hasPower('manage_submissions'))
                                    <p>{{ $submission->collaborators->count() ? '각 협력자' : '제출한 유저' }}{{ $submission->participants->count() ? ' 그리고 모든 참여자' : '' }}가 수령할 {{ $currency->name }}의 수량을 입력합니다.
                                        제안된 금액은 제공된 양식 응답에 따라 미리 채워졌지만, 이는 사용자 입력을 기반으로 한 지침일 뿐이며 필요에 따라 확인하고 조정해야 합니다.
                                    </p>
                                    {!! Form::open(['url' => 'admin/gallery/edit/' . $submission->id . '/value']) !!}
                                    @if (!$submission->collaborators->count() || $submission->collaborators->where('user_id', $submission->user_id)->first() == null)
                                        <div class="form-group">
                                            {!! Form::label($submission->user->name) !!}:
                                            {!! Form::number(
                                                'value[submitted][' . $submission->user->id . ']',
                                                isset($submission->data['total'])
                                                    ? round(($submission->characters->count() ? round($submission->data['total'] * $submission->characters->count()) : $submission->data['total']) / ($submission->collaborators->count() ? $submission->collaborators->count() : '1'))
                                                    : 0,
                                                ['class' => 'form-control'],
                                            ) !!}
                                        </div>
                                    @endif
                                    @if ($submission->collaborators->count())
                                        @foreach ($submission->collaborators as $key => $collaborator)
                                            <div class="form-group">
                                                {!! Form::label($collaborator->user->name . ' (' . $collaborator->data . ')') !!}:
                                                {!! Form::number(
                                                    'value[collaborator][' . $collaborator->user->id . ']',
                                                    isset($submission->data['total'])
                                                        ? round(($submission->characters->count() ? round($submission->data['total'] * $submission->characters->count()) : $submission->data['total']) / ($submission->collaborators->count() ? $submission->collaborators->count() : '1'))
                                                        : 0,
                                                    ['class' => 'form-control'],
                                                ) !!}
                                            </div>
                                        @endforeach
                                    @endif
                                    @if ($submission->participants->count())
                                        @foreach ($submission->participants as $key => $participant)
                                            <div class="form-group">
                                                {!! Form::label($participant->user->name . ' (' . $participant->displayType . ')') !!}:
                                                {!! Form::number(
                                                    'value[participant][' . $participant->user->id . ']',
                                                    isset($submission->data['total'])
                                                        ? ($participant->type == 'Comm'
                                                            ? round(($submission->characters->count() ? round($submission->data['total'] * $submission->characters->count()) : $submission->data['total']) / ($submission->collaborators->count() ? $submission->collaborators->count() : '1') / 2)
                                                            : 0)
                                                        : 0,
                                                    ['class' => 'form-control'],
                                                ) !!}
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="form-group">
                                        {!! Form::checkbox('ineligible', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-onstyle' => 'danger']) !!}
                                        {!! Form::label('ineligible', 'Inelegible/Award No Currency', ['class' => 'form-check-label ml-3']) !!} {!! add_help('When on, this will mark the submission as valued, but will not award currency to any of the users listed.') !!}
                                    </div>
                                    <div class="text-right">
                                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                @else
                                    <p>이 제출물은 아직 평가되지 않았습니다. 제출이 완료되면 알림을 받게 될 것입니다!</p>
                                @endif
                            @else
                                @if (isset($submission->data['staff']))
                                    <p><strong>처리자:</strong> {!! App\Models\User\User::find($submission->data['staff'])->displayName !!}</p>
                                @endif
                                @if (isset($submission->data['ineligible']) && $submission->data['ineligible'] == 1)
                                    <p>이 제출물은 {{$currency->name}} 보상에 적합하지 않은 것으로 평가되었습니다.</p>
                                @else
                                    <p>{{ $currency->name }} 가 이 제출물에 대해 지급되었습니다.</p>
                                    <div class="row">
                                        @if (isset($submission->data['value']['submitted']))
                                            <div class="col-md-4">
                                                {!! $submission->user->displayName !!}: {!! $currency->display($submission->data['value']['submitted'][$submission->user->id]) !!}
                                            </div>
                                        @endif
                                        @if ($submission->collaborators->count())
                                            <div class="col-md-4">
                                                @foreach ($submission->collaborators as $collaborator)
                                                    {!! $collaborator->user->displayName !!} ({{ $collaborator->data }}): {!! $currency->display($submission->data['value']['collaborator'][$collaborator->user->id]) !!}
                                                    <br />
                                                @endforeach
                                            </div>
                                        @endif
                                        @if ($submission->participants->count())
                                            <div class="col-md-4">
                                                @foreach ($submission->participants as $participant)
                                                    {!! $participant->user->displayName !!} ({{ $participant->displayType }}): {!! $currency->display($submission->data['value']['participant'][$participant->user->id]) !!}
                                                    <br />
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @else
                            <p>이 제출물은 화폐 보상에 적합하지 않습니다.{{ $submission->status == 'Pending' ? ' 먼저 승인이 필요합니다.' : '' }}.</p>
                        @endif
                        <hr />
                        @if (isset($submission->data['total']))
                            <h6>양식 응답:</h6>
                            <div class="row mb-2">
                                @foreach ($submission->data['currencyData'] as $key => $data)
                                    <div class="col-md-3 text-center">
                                        @if (isset($data) && isset(config('lorekeeper.group_currency_form')[$key]))
                                            <strong>{{ config('lorekeeper.group_currency_form')[$key]['name'] }}:</strong><br />
                                            @if (config('lorekeeper.group_currency_form')[$key]['type'] == 'choice')
                                                @if (isset(config('lorekeeper.group_currency_form')[$key]['multiple']) && config('lorekeeper.group_currency_form')[$key]['multiple'] == 'true')
                                                    @foreach ($data as $answer)
                                                        {{ config('lorekeeper.group_currency_form')[$key]['choices'][$answer] ?? '-' }}<br />
                                                    @endforeach
                                                @else
                                                    {{ config('lorekeeper.group_currency_form')[$key]['choices'][$data] }}
                                                @endif
                                            @else
                                                {{ config('lorekeeper.group_currency_form')[$key]['type'] == 'checkbox' ? (config('lorekeeper.group_currency_form')[$key]['value'] == $data ? 'True' : 'False') : $data }}
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if (Auth::user()->hasPower('manage_submissions') && isset($submission->data['total']))
                                <h6>[Admin]</h6>
                                <p class="text-center">
                                    <strong>계산된 총합:</strong> {{ $submission->data['total'] }}
                                    @if ($submission->characters->count())
                                        ・ <strong> {{ $submission->characters->count() }} 명의 캐릭터 수:</strong> {{ round($submission->data['total'] * $submission->characters->count()) }}
                                    @endif
                                    @if ($submission->collaborators->count())
                                        <br /><strong>{{ $submission->collaborators->count() }} 명의 협력자:</strong> {{ round($submission->data['total'] / $submission->collaborators->count()) }}
                                        @if ($submission->characters->count())
                                            ・ <strong> {{ $submission->characters->count() }} 마리의 캐릭터:</strong> {{ round(round($submission->data['total'] * $submission->characters->count()) / $submission->collaborators->count()) }}
                                        @endif
                                    @endif
                                    <br />제안된 경우 {!! $currency->display(
                                        round(($submission->characters->count() ? round($submission->data['total'] * $submission->characters->count()) : $submission->data['total']) / ($submission->collaborators->count() ? $submission->collaborators->count() : '1')),
                                    ) !!}{{ $submission->collaborators->count() ? ' per collaborator' : '' }}
                                </p>
                            @endif
                        @else
                            <p>이 제출물에는 양식 데이터가 연결되어 있지 않습니다.</p>
                        @endif
                    </div>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header">
                    <h4>스태프 코멘트</h4> {!! Auth::user()->hasPower('staff_comments') ? '(Visible to ' . $submission->credits . ')' : '' !!}
                </div>
                <div class="card-body">
                    @if (isset($submission->parsed_staff_comments))
                        <h5>스태프 코멘트 (옛):</h5>
                        {!! $submission->parsed_staff_comments !!}
                        <hr />
                    @endif
                    <!-- Staff-User Comments -->
                    <div class="container">
                        @comments(['model' => $submission, 'type' => 'Staff-User', 'perPage' => 5])
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::user()->hasPower('manage_submissions') && $submission->collaboratorApproval)
            <div class="col-12 col-md-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>[Admin] Vote Info</h5>
                    </div>
                    <div class="card-body">
                        @if ($submission->getVoteData()['raw']->count())
                            @foreach ($submission->getVoteData(1)['raw'] as $vote)
                                <li>
                                    {!! $vote['user']->displayName !!} {{ $vote['user']->id == Auth::user()->id ? '(you)' : '' }}: <span {!! $vote['vote'] == 2 ? 'class="text-success">Accept' : 'class="text-danger">Reject' !!}</span>
                                </li>
                            @endforeach
                        @else
                            <p>No votes have been cast yet!</p>
                        @endif
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>[Admin] Staff Comments</h5> (Only visible to staff)
                    </div>
                    <div class="card-body">
                        <!-- Staff-User Comments -->
                        <div class="container">
                            @comments(['model' => $submission, 'type' => 'Staff-Staff', 'perPage' => 5])
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
