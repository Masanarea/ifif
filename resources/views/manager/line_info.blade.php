<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - LINE情報</title>
    @vite('resources/css/app.css')
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
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        @auth('manager')
            <div class="p-6 bg-white shadow rounded">
                <h2 class="text-xl font-semibold mb-4">担当者のLINEアカウント情報</h2>

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">LINE ID</th>
                            <th class="px-4 py-2">ユーザー名</th>
                            <th class="px-4 py-2">写真</th>
                            <th class="px-4 py-2">ステータスメッセージ</th>
                            <th class="px-4 py-2">言語</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lineInfos as $lineInfo)
                            <tr>
                                <td class="border px-4 py-2">{{ $lineInfo->line_id }}</td>
                                <td class="border px-4 py-2">{{ $lineInfo->displayName }}</td>
                                <td class="border px-4 py-2">
                                    <img src="{{ $lineInfo->pictureUrl }}" alt="Profile Picture" width="50">
                                </td>
                                <td class="border px-4 py-2">{{ $lineInfo->statusMessage }}</td>
                                <td class="border px-4 py-2">{{ $lineInfo->language }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">データが存在しません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <p>ログインしてください。</p>
        @endauth
    </div>
</body>
</html>
