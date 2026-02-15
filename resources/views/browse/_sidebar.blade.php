<ul>
    <li class="sidebar-header"><a href="{{ url('masterlist') }}" class="card-link">{{ __('Masterlist') }}</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">{{ __('Masterlist') }}</div>
        <div class="sidebar-item"><a href="{{ url('masterlist') }}" class="{{ set_active('masterlist*') }}">{{ __('Character masterlist') }}</a></div>
        <div class="sidebar-item"><a href="{{ url('myos') }}" class="{{ set_active('myos*') }}">{{ __('MYO Slot Masterlist') }}</a></div>
    </li>
    @if (isset($sublists) && $sublists->count() > 0)
        <li class="sidebar-section">
            <div class="sidebar-section-header">{{ __('Sub Masterlist') }}</div>
            @foreach ($sublists as $sublist)
                <div class="sidebar-item"><a href="{{ url('sublist/' . $sublist->key) }}" class="{{ set_active('sublist/' . $sublist->key) }}">{{ $sublist->name }}</a></div>
            @endforeach
        </li>
    @endif
</ul>
