<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Galeria de gats</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-4 px-4">
        <h1 class="text-center text-2xl font-bold mb-6">🐱Galeria de gats🐱</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($cats as $cat)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('storage/' . $cat->image_path) }}" alt="{{ $cat->tags }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h5 class="text-lg font-semibold">Cat ID: {{ $cat->_id }}</h5>
                        <ul class="list-disc pl-5 text-gray-600">
                            @foreach (json_decode($cat->tags, true) as $tag)
                                <li>{{ $tag }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center mt-6">
            {{ $cats->links() }}
        </div>
    </div>
</body>
</html>