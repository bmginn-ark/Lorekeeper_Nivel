<ul>
    <li class="sidebar-header">
        <a href="{{ url('prompts') }}" class="card-link">프롬프트</a>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">프롬프트</div>
        <div class="sidebar-item"><a href="{{ url('prompts/prompt-categories') }}" class="{{ set_active('prompts/prompt-categories*') }}">프롬프트 카테고리</a></div>
        <div class="sidebar-item"><a href="{{ url('prompts/prompts') }}" class="{{ set_active('prompts/prompts*') }}">모든 프롬프트</a></div>
    </li>
</ul>
