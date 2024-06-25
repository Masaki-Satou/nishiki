<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="md:p-6 bg-white border-b border-gray-200">

                        <section class="text-gray-600 body-font">
                            <div class="container mx-auto">

                                <x-flash-message />

                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    
                                    
                                    <div class="flex items-center justify-end my-3">
                                
                                        <x-button type="button" onclick="location.href='{{ route('admin.users.create') }}'" class="">
                                            新規登録
                                        </x-button>
                                       
                                    </div>

                                    <table class="table-auto w-full text-left whitespace-no-wrap">

                                        <thead>

                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">作成日</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                            </tr>

                                        </thead>

                                    <tbody>

                                        @foreach($users as $user)
                                            <tr>

                                                <td class="px-4 py-3">
                                                    <x-btn.edit type="button" onclick="location.href='{{ route('admin.users.edit',['user'=>$user->id]) }}'" class="">
                                                        編集
                                                    </x-btn.edit>
                                                </td>

                                                <td class="px-4 py-3">{{ $user->name }}</td>
                                                <td class="px-4 py-3">{{ $user->email }}</td>
                                                <td class="px-4 py-3">{{ $user->created_at }}</td>

                                               
                                                <form id="delete_{{ $user->id }}" method="POST" action="{{ route('admin.users.destroy',['user'=>$user->id]) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <td class="text-end px-4 py-3">
                                                        <x-btn.delete type="button" data-id="{{ $user->id }}" onclick="deletePost(this)" class="">
                                                            削除
                                                        </x-btn.delete-button>
                                                    </td>
                                                </form>

                                            </tr>
                                        @endforeach
                                        
                                    </tbody>

                                </table>

                                <div class="py-4 my-3 border-t-2">
                                    {{ $users->links() }}
                                </div>

                                </div>

                            </div>

                          </section>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deletePost(e){
            if(confirm('本当に削除しますか？')){
                document.querySelector('#delete_' + e.dataset.id).submit();
            }
        }
    </script>

</x-app-layout>
