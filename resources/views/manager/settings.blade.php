<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - 設定</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')

    <!-- Tailwind CSS -->

</head>
<body class="bg-gray-100">
    <!-- Navigation and other common elements omitted for brevity -->
    <nav class="bg-white p-6">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('manager.top') }}" class="text-lg font-semibold text-gray-900">管理画面</a>
                </div>

                @auth('manager')
                    <div>
                        <a href="{{ url('/manager/settings') }}" class="text-gray-500">設定</a>
                    </div>
                    {{-- <div>
                        <a href="{{ route('manager.line_info') }}" class="text-gray-500">LINE管理アカウント</a>
                    </div> --}}

                    <!-- Dropdown menu -->
                    <div>
                        <button id="questionDropdownButton" data-dropdown-toggle="questionDropdown" class="text-gray-500 hover:text-gray-900 font-medium text-sm px-2 py-1 text-center inline-flex items-center" type="button">質問管理 <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg></button>

                        <!-- Dropdown menu -->
                        <div id="questionDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="questionDropdownButton">
                                <li>
                                    <a href="{{ route('manager.create_question') }}" class="block px-4 py-2 hover:bg-blue-100">質問作成</a>
                                </li>
                                <li>
                                    <a href="{{ route('manager.question_list') }}" class="block px-4 py-2 hover:bg-blue-100">質問一覧</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('manager.line_info') }}" class="text-gray-500">ユーザーチャット</a>
                    </div>
                    <div>
                        <a href="{{ route('manager.analysis') }}" class="text-gray-500">回答分析</a>
                    </div>
                    <div class="ml-4">
                        <form method="POST" action="{{ route('manager.logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500">ログアウト</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        @auth('manager')
            <div class="p-6 bg-white shadow rounded">
                <h2 class="text-xl font-semibold mb-4">ユーザー設定</h2>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4 rounded">
                        <strong class="font-bold">成功！</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('manager.settings.update') }}">
                    @csrf

                    <div>
                        <label for="last_name" class="font-semibold">名字:</label>
                        <input id="last_name" type="text" name="last_name" value="{{ $manager->last_name }}">
                    </div>

                    <div>
                        <label for="first_name" class="font-semibold">名前:</label>
                        <input id="first_name" type="text" name="first_name" value="{{ $manager->first_name }}">
                    </div>

                    <div>
                        <label for="last_name_kana" class="font-semibold">名字(カナ):</label>
                        <input id="last_name_kana" type="text" name="last_name_kana" value="{{ $manager->last_name_kana }}">
                    </div>

                    <div>
                        <label for="first_name_kana" class="font-semibold">名前(カナ):</label>
                        <input id="first_name_kana" type="text" name="first_name_kana" value="{{ $manager->first_name_kana }}">
                    </div>

                    <div>
                        <label for="channel_token" class="font-semibold">チャネルアクセストークン:</label>
                        <input id="channel_token" type="text" name="channel_token" value="{{ $decryptedChannel_token }}">
                    </div>

                    <!-- Add other fields as necessary -->

                    <div class="mt-4">
                        <button type="submit" class="text-white bg-blue-500 rounded px-4 py-2">更新</button>
                    </div>
                </form>
            </div>
        @else
            <p>ログインしてください。</p>
        @endauth
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>

    <!-- Scripts omitted for brevity -->
</body>
</html>
