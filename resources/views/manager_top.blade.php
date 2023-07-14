<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - Top</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

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
                    <div>
                        <a href="{{ route('manager.line_info') }}" class="text-gray-500">LINE管理アカウント</a>
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
</body>
</html>
