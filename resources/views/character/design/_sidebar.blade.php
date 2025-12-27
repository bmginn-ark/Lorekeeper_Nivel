<ul>
    @if (isset($request))
        <li class="sidebar-section">
            <div class="sidebar-section-header">현재 요청</div>
            <div class="sidebar-item"><a href="{{ $request->url }}" class="{{ set_active('designs/' . $request->id) }}">보기</a></div>
            <div class="sidebar-item"><a href="{{ $request->url . '/comments' }}" class="{{ set_active('designs/' . $request->id . '/comments') }}">코멘트</a></div>
            <div class="sidebar-item"><a href="{{ $request->url . '/image' }}" class="{{ set_active('designs/' . $request->id . '/image') }}">이미지</a></div>
            <div class="sidebar-item"><a href="{{ $request->url . '/addons' }}" class="{{ set_active('designs/' . $request->id . '/addons') }}">추가</a></div>
            <div class="sidebar-item"><a href="{{ $request->url . '/traits' }}" class="{{ set_active('designs/' . $request->id . '/traits') }}">특성</a></div>
        </li>
    @endif
    <li class="sidebar-section">
        <div class="sidebar-section-header">디자인 승인</div>
        <div class="sidebar-item"><a href="{{ url('designs') }}" class="{{ set_active('designs') }}">초안</a></div>
        <div class="sidebar-item"><a href="{{ url('designs/pending') }}" class="{{ set_active('designs/*') }}">제출</a></div>
    </li>
</ul>
