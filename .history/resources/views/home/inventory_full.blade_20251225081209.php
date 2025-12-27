@extends('home.layout')

@section('home-title')
    전체 인벤토리
@endsection

@section('home-content')
    {!! breadcrumbs(['Inventory' => 'inventory', 'Full Inventory' => 'inventory-full']) !!}

    <h1>
        전체 인벤토리
    </h1>

    <p>이것은 당신의 전체 인벤토리입니다. 항목 이름을 클릭하여 해당 항목에 대한 자세한 정보를 확인하고, 'stack'이라는 단어를 클릭하여 해당 항목에서 수행할 수 있는 작업을 확인할 수 있습니다.</p>

    @foreach ($items as $categoryId => $categoryItems)
        <div class="card mb-2">
            <h5 class="card-header">
                {!! isset($categories[$categoryId]) ? '<a href="' . $categories[$categoryId]->searchUrl . '">' . $categories[$categoryId]->name . '</a>' : '기타' !!}
                <a class="small inventory-collapse-toggle collapse-toggle" href="#categoryId_{!! isset($categories[$categoryId]) ? $categories[$categoryId]->id : '기타' !!}" data-toggle="collapse">보기</a>
            </h5>
            <div class="card-body p-2 collapse show row" id="categoryId_{!! isset($categories[$categoryId]) ? $categories[$categoryId]->id : '기타' !!}">
                @foreach ($categoryItems as $itemtype)
                    <div class="col-lg-3 col-sm-4 col-12">
                        @if ($itemtype->first()->has_image)
                            <img src="{{ $itemtype->first()->imageUrl }}" style="height: 25px;" alt="{{ $itemtype->first()->name }}" />
                        @endif
                        <a href="{{ $itemtype->first()->idUrl }}">{{ $itemtype->first()->name }}</a>
                        <ul class="mb-0">
                            @foreach ($itemtype as $item)
                                <li>
                                    @if (isset($item->pivot->user_id))
                                        <a href="/inventory">
                                            인벤토리의 
                                        </a>
                                        <a class="invuser" data-id="{{ $item->pivot->id }}" data-name="{{ $user->name }}의 {{ $item->name }}" href="#">
                                            스택
                                        </a>
                                        x{{ $item->pivot->count }}개
                                    @else
                                        @foreach ($characters as $char)
                                            @if ($char->id == $item->pivot->character_id)
                                                @php
                                                    $charaname = $char->name ? $char->name : $char->slug;
                                                    $charalink = $char->url;
                                                    $charavisi = '';
                                                    if (!$char->is_visible) {
                                                        $charavisi = '<i class="fas fa-eye-slash"></i>';
                                                    }
                                                @endphp
                                            @endif
                                        @endforeach
                                        <?php
                                        $canName = $item->category->can_name;
                                        $itemNames = $item->pivot->pluck('stack_name', 'id');
                                        $stackName = $itemNames[$item->pivot->id];
                                        $stackNameClean = htmlentities($stackName);
                                        ?>
                                        <a href="{{ $charalink }}">
                                            {{ $charaname }}
                                        </a>의 인벤토리의
                                        <a class="invchar" data-id="{{ $item->pivot->id }}" data-name="{!! $canName && $stackName ? htmlentities($stackNameClean) . ' [' : null !!}{{ $charaname }}'s {{ $item->name }}{!! $canName && $stackName ? ']' : null !!}" href="#">
                                            스택
                                        </a>
                                        x{{ $item->pivot->count }}개
                                        @if ($canName && $stackName)
                                            <span class="text-info m-0" style="font-size:95%; margin:5px;" data-toggle="tooltip" data-placement="top" title='Named stack:<br />"{{ $stackName }}"'>
                                                &nbsp;<i class="fas fa-tag"></i>
                                            </span>
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.invuser').on('click', function(e) {
                e.preventDefault();
                var $parent = $(this);
                loadModal("{{ url('items') }}/" + $parent.data('id'), $parent.data('name'));
            });

            $('.invchar').on('click', function(e) {
                e.preventDefault();
                var $parent = $(this);
                loadModal("{{ url('items') }}/character/" + $parent.data('id'), $parent.data('name'));
            });
        });
    </script>
@endsection
