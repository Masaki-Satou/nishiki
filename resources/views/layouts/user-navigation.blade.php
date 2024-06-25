

<div class="mobile-menu">
    <div class="mobile-menu__nav-wrap">
        
        <div class="mobile-menu__auther">
            @auth('users')

            <x-dropdown>
                <x-slot name="trigger">
                    <button class="flex items-center text-sm">
                        <div>{{ Auth::user()->name."さん" }}</div>

                        <div class="ml-1 mx-auto">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">

                    <!-- Authentication -->

                    <x-dropdown-link :href="route('user.edit')" class="text-black block text-center mb-1">会員情報</x-dropdown-link>

                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('user.logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                    
                </x-slot>
            </x-dropdown>
           
            @else
                @if (Route::has('user.login'))
                    <div class="">
                        
                        <a href="{{ route('user.login') }}" class="text-sm underline">ログイン</a>
        
                    </div>
                @endif

                
            @endauth

            
        </div>

        <nav class="mobile-menu__nav">
            <ul class="mobile-menu__ul">

                <li class="mobile-menu__li"><a href="/welcome">カレンダー</a></li>
                <li class="mobile-menu__li"><a href="/reserveds">予約確認</a></li>
                
            </ul>
        </nav>
    </div>
</div>

<div class="nav-trigger"></div>

<header class="header">
   
    <div class="header__inner">

        <!-- Logo -->
        <div class="logo">
            <a href="/">
                <x-application-logo class="block h-12 md:h-16 w-auto fill-current text-gray-600" />
            </a>
        </div>
        
        <div class="header__nav-wrap">
            <div class="header__auther">
                @auth('users')
                <!-- Primary Navigation Menu -->
              
                <!-- Settings Dropdown -->
                <div class="flex justify-end">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm">
                                <div>{{ Auth::user()->name."さん" }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->


                           <x-dropdown-link class="text-center" :href="route('user.edit')">
                                会員情報
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('user.logout') }}">
                                @csrf
                                <x-dropdown-link class="text-center" :href="route('user.logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>


                        </x-slot>
                    </x-dropdown>
                </div>
               
                @else
                    @if (Route::has('user.login'))
                        <div class="">
                           
                            <a href="{{ route('user.login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ログイン</a>
            
                        </div>
                    @endif

                    
                @endauth

                
            </div>

            <nav class="header__nav">
                <ul class="appear left header__ul">
                    <li class="header__li item"><a href="/welcome">カレンダー</a></li>
                    <li class="header__li item"><a href="/reserveds">予約確認</a></li>
                </ul>
            </nav>

           
        </div>
        
        <button class="mobile-menu__btn">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
    </div>

</header>

