<nav class="navbar navbar-expand-md navbar-dark bg-dark" id="headerNav">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    @if (Auth::check() && Auth::user()->is_news_unread && config('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex text-warning" href="{{ url('news') }}"><strong>News</strong><i class="fas fa-bell"></i></a>
                    @else
                        <a class="nav-link" href="{{ url('news') }}">공지</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (Auth::check() && Auth::user()->is_sales_unread && config('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex text-warning" href="{{ url('sales') }}"><strong>Sales</strong><i class="fas fa-bell"></i></a>
                    @else
                        <a class="nav-link" href="{{ url('sales') }}">분양</a>
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('raffles') }}">추첨</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="loreDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        세계
                    </a>
                    <div class="dropdown-menu" aria-labelledby="loreDropdown">
                        <a class="dropdown-item" href="{{ url('world') }}">백과사전</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('info/nivel') }}">배경</a>
                        <a class="dropdown-item" href="{{ url('world/species') }}">종족</a>
                        <a class="dropdown-item" href="{{ url('world/traits') }}">특성</a>
                        <a class="dropdown-item" href="{{ url('world/rarities') }}">희귀도</a>
                        <a class="dropdown-item" href="{{ url('world/items') }}">아이템</a>

                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        캐릭터
                    </a>

                    <div class="dropdown-menu" aria-labelledby="browseDropdown">
                        <a class="dropdown-item" href="{{ url('users') }}">유저</a>
                        <a class="dropdown-item" href="{{ url('masterlist') }}">개체리스트</a>
                        <a class="dropdown-item" href="{{ url('myos') }}">MYO 리스트</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('designs') }}">디자인 승인</a>

                    </div>
                </li>
                @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a id="queueDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            활동
                        </a>
                        <div class="dropdown-menu" aria-labelledby="queueDropdown">
                        <a class="dropdown-item" href="{{ url('prompts/prompts') }}">프롬프트</a>
                            <a class="dropdown-item" href="{{ url('submissions') }}">프롬프트 제출</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('shops') }}">상점</a>
                        </div>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('gallery') }}">갤러리</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->

            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('로그인') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('회원가입') }}</a>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->isStaff)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin') }}"><i class="fas fa-crown"></i></a>
                        </li>
                    @endif
                    @if (Auth::user()->notifications_unread)
                        <li class="nav-item">
                            <a class="nav-link btn btn-secondary btn-sm" href="{{ url('notifications') }}"><span class="fas fa-envelope"></span> {{ Auth::user()->notifications_unread }}</a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            제출</a>
                        <div class="dropdown-menu" aria-labelledby="browseDropdown">
                            <a class="dropdown-item" href="{{ url('submissions/new') }}">프롬프트 제출</a>
                            <a class="dropdown-item" href="{{ url('claims') }}">수령</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('reports/new') }}">신고 제출</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ Auth::user()->url }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ Auth::user()->url }}">프로필</a>
                            <a class="dropdown-item" href="{{ url('notifications') }}">알림</a>
                            <a class="dropdown-item" href="{{ url('account/bookmarks') }}">북마크</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('characters') }}">내 캐릭터</a>
                            <a class="dropdown-item" href="{{ url('characters/myos') }}">내 MYO 슬롯</a>
                            <a class="dropdown-item" href="{{ url('inventory') }}">인벤토리 </a>
                            <a class="dropdown-item" href="{{ url('bank') }}">재화</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('characters/transfers/incoming') }}">캐릭터 거래</a>
                            <a class="dropdown-item" href="{{ url('trades/open') }}">아이템 거래</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('account/settings') }}">설정</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('로그아웃') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
