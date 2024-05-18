<x-flash>
    @if (session()->has('success'))
        <p id="flashMessage" class="w-full text-lg py-2 px-4 rounded bg-green-100 text-green-900">
            {{ session('success') }}
        </p>
    @endif

    @if ($errors->any())
        <ul class="px-4 py-2 rounded bg-red-100 text-red-900">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</x-flash>