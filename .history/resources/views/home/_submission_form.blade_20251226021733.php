@if ($submission->status == 'Draft')
    {!! Form::open(['url' => $isClaim ? 'claims/edit' : 'submissions/edit', 'id' => 'submissionForm']) !!}
@else
    {!! Form::open(['url' => $isClaim ? 'claims/new' : 'submissions/new', 'id' => 'submissionForm']) !!}
@endif

@if (Auth::check() && $submission->staff_comments && ($submission->user_id == Auth::user()->id || Auth::user()->hasPower('manage_submissions')))
    <h2>스태프 코멘트 ({!! $submission->staff->displayName !!})</h2>
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

@if (!$isClaim)
    <div class="form-group">
        {!! Form::label('prompt_id', '프롬프트') !!}
        {!! Form::select('prompt_id', $prompts, isset($submission->prompt_id) ? $submission->prompt_id : old('prompt_id') ?? Request::get('prompt_id'), ['class' => 'form-control selectize', 'id' => 'prompt', 'placeholder' => '']) !!}
    </div>
@endif

<div class="form-group">
    {!! Form::label('url', $isClaim ? 'URL (옵션)' : '제출 URL (옵션)') !!}
    @if ($isClaim)
        {!! add_help('귀하의 주장과 관련된 URL을 입력하세요(예: 이 주장을 할 수 있음을 증명하는 댓글).') !!}
    @else
        {!! add_help('제출한 URL(트위터 또는 기타 호스팅 서비스에 업로드되었는지 여부)을 입력합니다.') !!}
    @endif
    {!! Form::text('url', isset($submission->url) ? $submission->url : old('url') ?? Request::get('url'), ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('comments', '코멘트 (옵션)') !!} {!! add_help(($isClaim ? '수령' : '제출') . '에 대한 코멘트를 입력하세요 (HTML 미적용). 스태프가 당신의 ' . ($isClaim ? '수령' : '제출') . '을 확인할 때 참고할 것입니다.') !!}
    {!! Form::textarea('comments', isset($submission->comments) ? $submission->comments : old('comments') ?? Request::get('comments'), ['class' => 'form-control']) !!}
</div>

@if ($submission->prompt_id)
    <div class="mb-3">
        @include('home._prompt', ['prompt' => $submission->prompt, 'staffView' => false])
    </div>
@endif

<div class="card mb-3">
    <div class="card-header h2">
        보상
    </div>
    <div class="card-body">
        @if ($isClaim)
            <p>받고 싶은 보상을 선택하세요.</p>
        @else
            <p>이곳에 추가한 보상은 기본 프롬프트 보상과 <u>추가</u>됩니다. 추가 보상을 원하지 않으면 이 항목을 비워둘 수 있습니다.</p>
        @endif

        {{-- previous input --}}
        @if (old('rewardable_type'))
            @php
                $loots = [];
                foreach (old('rewardable_type') as $key => $type) {
                    if (!isset(old('rewardable_id')[$key])) {
                        continue;
                    }
                    $loots[] = (object) [
                        'rewardable_type' => $type,
                        'rewardable_id' => old('rewardable_id')[$key],
                        'quantity' => old('quantity')[$key] ?? 1,
                    ];
                }
            @endphp
        @endif
        @if ($isClaim)
            @include('widgets._loot_select', ['loots' => $submission->id ? $submission->rewards : $loots ?? null, 'showLootTables' => false, 'showRaffles' => true])
        @else
            @include('widgets._loot_select', ['loots' => $submission->id ? $submission->rewards : $loots ?? null, 'showLootTables' => false, 'showRaffles' => false])
        @endif

        @if (!$isClaim)
            <div id="rewards" class="mb-3"></div>
        @endif
    </div>
</div>

<div class="card mb-3">
    <div class="card-header h2">
        <a href="#" class="btn btn-outline-info float-right" id="addCharacter">Add Character</a>
        Characters
    </div>
    <div class="card-body" style="clear:both;">
        @if ($isClaim)
            <p>If there are character-specific rewards you would like to claim, attach them here. Otherwise, this section can be left blank.</p>
        @endif
        <div id="characters" class="mb-3">
            @foreach ($submission->characters as $character)
                @include('widgets._character_select_entry', [
                    'characterCurrencies' => $characterCurrencies,
                    'items' => $items,
                    'tables' => [],
                    'showTables' => false,
                    'character' => $character,
                    'expanded_rewards' => $expanded_rewards,
                ])
            @endforeach
            @if (old('slug') && !$submission->id)
                @php
                    session()->forget('_old_input.character_rewardable_type');
                    session()->forget('_old_input.character_rewardable_id');
                    session()->forget('_old_input.character_rewardable_quantity');
                @endphp
                @foreach (array_unique(old('slug')) as $slug)
                    @include('widgets._character_select_entry', ['character' => \App\Models\Character\Character::where('slug', $slug)->first()])
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header h2">
        Add-Ons
    </div>
    <div class="card-body">
        <p>If your {{ $isClaim ? 'claim' : 'submission' }} consumes items, attach them here. Otherwise, this section can be left blank. These items will be removed from your inventory but refunded if your {{ $isClaim ? 'claim' : 'submission' }} is
            rejected.</p>
        <div id="addons" class="mb-3">
            @include('widgets._inventory_select', [
                'user' => Auth::user(),
                'inventory' => $inventory,
                'categories' => $categories,
                'selected' => $submission->id ? $submission->getInventory($submission->user) : (old('stack_id') ? array_combine(old('stack_id'), old('stack_quantity')) : []),
                'page' => $page,
            ])
            @include('widgets._bank_select', [
                'owner' => Auth::user(),
                'selected' => $submission->id ? $submission->getCurrencies($submission->user) : (old('currency_id') ? array_combine(old('currency_id')['user-' . Auth::user()->id], old('currency_quantity')['user-' . Auth::user()->id]) : []),
            ])
        </div>
    </div>
</div>

@if ($submission->status == 'Draft')
    <div class="text-right">
        <a href="#" class="btn btn-danger mr-2" id="cancelButton">Delete Draft</a>
        <a href="#" class="btn btn-secondary mr-2" id="draftButton">Save Draft</a>
        <a href="#" class="btn btn-primary" id="confirmButton">Submit</a>
    </div>
@else
    <div class="text-right">
        <a href="#" class="btn btn-secondary mr-2" id="draftButton">Save Draft</a>
        <a href="#" class="btn btn-primary" id="confirmButton">Submit</a>
    </div>
@endif

{!! Form::close() !!}

@include('widgets._character_select', ['characterCurrencies' => $characterCurrencies, 'showLootTables' => false])
@if ($isClaim)
    @include('widgets._loot_select_row', ['items' => $items, 'currencies' => $currencies, 'showLootTables' => false, 'showRaffles' => true])
@else
    @include('widgets._loot_select_row', ['items' => $items, 'currencies' => $currencies, 'showLootTables' => false, 'showRaffles' => false])
@endif
