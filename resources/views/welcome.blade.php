<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کوتاه‌کننده لینک</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-800 mb-3">🔗 کوتاه‌کننده لینک</h1>
            <p class="text-gray-600 text-lg">لینک‌های خود را به راحتی کوتاه کنید</p>
        </div>

        <!-- Main Card -->
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-8 mb-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border-r-4 border-green-500 text-green-800 p-4 rounded-lg mb-6">
                    <p class="font-semibold">{{ session('success') }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <input type="text" value="{{ session('short_url') }}"
                               id="shortUrl" readonly
                               class="flex-1 bg-white border border-green-300 rounded-lg px-4 py-2 text-sm">
                        <button onclick="copyUrl()"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            کپی
                        </button>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border-r-4 border-red-500 text-red-800 p-4 rounded-lg mb-6">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('shorten') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        لینک خود را وارد کنید:
                    </label>
                    <input type="text"
                           name="original_url"
                           value="{{ old('original_url') }}"
                           placeholder="https://example.com/very/long/url"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none transition">
                </div>
                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-3 rounded-lg transition transform hover:scale-105 shadow-lg">
                    کوتاه کن! 🚀
                </button>
            </form>
        </div>

        <!-- URLs Table -->
        @if($urls->count() > 0)
            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">آخرین لینک‌های کوتاه شده</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-right py-3 px-4">لینک اصلی</th>
                                <th class="text-right py-3 px-4">لینک کوتاه</th>
                                <th class="text-center py-3 px-4">کلیک‌ها</th>
                                <th class="text-center py-3 px-4">تاریخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($urls as $url)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-600 truncate max-w-xs">
                                        {{ Str::limit($url->original_url, 50) }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ url($url->short_code) }}"
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800 font-semibold">
                                            {{ url($url->short_code) }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            {{ $url->clicks }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center text-sm text-gray-500">
                                        {{ $url->created_at->format('Y/m/d') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $urls->links() }}
                </div>
            </div>
        @endif
    </div>

    <script>
        function copyUrl() {
            const urlInput = document.getElementById('shortUrl');
            urlInput.select();
            document.execCommand('copy');
            alert('لینک کپی شد!');
        }
    </script>
</body>
</html>
