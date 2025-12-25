@extends('home.layout')

@section('home-title')
    내 MYO 슬롯
@endsection

@section('home-content')
    {!! breadcrumbs(['Characters' => 'characters', 'My MYO Slots' => 'myos']) !!}

    <h1>
        내 MYO 슬롯
    </h1>

    <p>이것은 당신이 소유한 MYO 슬롯 목록입니다 - 슬롯을 클릭하여 해당 슬롯에 대한 자세한 정보를 확인할 수 있습니다. MYO 슬롯은 해당 페이지에서 디자인 승인을 위해 제출할 수 있습니다.</p>
    <div class="row">
        @foreach ($slots as $slot)
            <div class="col-md-3 col-6 text-center mb-2">
                <div>
                    <a href="{{ $slot->url }}"><img src="{{ $slot->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $slot->fullName }}" /></a>
                </div>
                <div class="mt-1 h5">
                    {!! $slot->displayName !!}
                </div>
            </div>
        @endforeach
    </div>
@endsection
