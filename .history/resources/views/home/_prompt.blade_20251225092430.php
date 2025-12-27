<div class="card">
    <div class="card-body">
        <h4>기본 프롬프트 조합</h4>
        @if (isset($staffView) && $staffView)
            <p>이 프롬프트의 기본 보상은 다음과 같습니다. 위의 편집 가능한 섹션에는 이러한 보상이 포함되어 있습니다.</p>
            @if ($count)
                <p>이 프롬프트를 <strong>{{ $count }}</strong> 번 제출했습니다.</p>
            @endif
        @else
            <p>이 프롬프트의 기본 보상은 다음과 같습니다. 실제 보상은 승인 과정에서 스태프가 편집할 수 있습니다.</p>
            @if ($count)
                <p>이 프롬프트를 <strong>{{ $count }}</strong> 번 제출했습니다.</p>
            @endif
        @endif
        <table class="table table-sm mb-0">
            <thead>
                <tr>
                    <th width="70%">보상</th>
                    <th width="30%">수량</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prompt->rewards as $reward)
                    <tr>
                        <td>{!! $reward->reward->displayName !!}</td>
                        <td>{{ $reward->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
