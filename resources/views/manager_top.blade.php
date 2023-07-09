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
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->last_name }}</dd>

                    <dt class="font-semibold">名前:</dt>
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->first_name }}</dd>

                    <dt class="font-semibold">名字(カナ):</dt>
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->last_name_kana }}</dd>

                    <dt class="font-semibold">名前(カナ):</dt>
                    <dd class="mb-2">{{ Auth::guard('manager')->user()->first_name_kana }}</dd>
                </dl>
            </div>
        @else
            <p>ログインしてください。</p>
        @endauth
    </div>
</body>
</html>
