<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-5 mx-auto">
                        <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                            <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">オーナー登録</font>
                            </font>
                        </h1>
                        
                        </div>
                        <div class="lg:w-1/2 md:w-2/3 mx-auto">

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="text-center mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('admin.users.store') }}">
                            @csrf
                
                            <!-- Name -->
                            <div>
                                <x-label for="name" value="オーナー名" />
                
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            </div>
                
                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-label for="email" value="メールアドレス" />
                
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            </div>
                
                            <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" value="パスワード" />
                
                                <x-input placeholder="10文字以上の英数字（大文字小文字混在）のパスワードをオススメします" id="password" class="block mt-1 w-full"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />
                            </div>
                
                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                
                                <x-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation" required />
                            </div>
                
                            <div class="flex items-center justify-end mt-4">
                                
                                <x-button type="button" onclick="location.href='{{ route('admin.users.index') }}'" class="ml-4">
                                    戻る
                                </x-button>
                
                                <x-button type="submit" class="ml-4">
                                    登録
                                </x-button>
                                
                            </div>
                        </form>
                        </div>
                    </div>
                </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
