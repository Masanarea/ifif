<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - Top</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')

    <!-- Tailwind CSS -->

</head>
<body class="bg-gray-100">
    <nav class="bg-white p-6">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('manager.top') }}" class="text-lg font-semibold text-gray-900">管理画面</a>
                </div>

                @auth('manager')
                    {{-- <div>
                        <a href="{{ url('/manager/settings') }}" class="text-gray-500">設定</a>
                    </div> --}}
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
                        <a href="{{ route('manager.line_info') }}" class="text-gray-500">回答分析</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        @auth('manager')
            <div class="p-6 bg-white shadow rounded">
                <h2 class="text-xl font-semibold mb-4">ログインユーザー情報</h2>

                <dl>
                    <dt class="font-semibold">Eメール:</dt>
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->email }}</dd>

                    <dt class="font-semibold">名字:</dt>
                    <dd class="mb-2">ifif</dd>
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->last_name }}</dd>

                    <dt class="font-semibold">名前:</dt>
                    <dd class="mb-2">太郎</dd>
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->first_name }}</dd>

                    <dt class="font-semibold">名字(カナ):</dt>
                    <dd class="mb-2">イフイフ</dd>
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->last_name_kana }}</dd>

                    <dt class="font-semibold">名前(カナ):</dt>
                    <dd class="mb-2">タロウ</dd>
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->first_name_kana }}</dd>

                    <dt class="font-semibold">チャネルID:</dt>
                    <dd class="mb-2">{{ $decryptedChannel_id }}</dd>

                    <dt class="font-semibold">チャネルシークレットトークン:</dt>
                    <dd class="mb-2">{{ $decryptedChannel_secret }}</dd>

                    <dt class="font-semibold">チャネルアクセストークン:</dt>
                    <dd class="mb-2">{{ $decryptedChannel_token }}</dd>

                    <dt class="font-semibold">URL for Messaging API:</dt>
                    <dd class="mb-2">https://b93c-125-103-218-181.ngrok-free.app/line/webhook/message?manager_id={{ $encrypted_manager_id }}</dd>

                </dl>
            </div>
        @else
            <p>ログインしてください。</p>
        @endauth
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
</body>
</html>
