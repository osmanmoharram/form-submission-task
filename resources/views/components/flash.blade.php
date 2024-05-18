@if (session()->has('success'))
    <p id="flash" class="w-full text-lg py-5 px-8 rounded bg-green-100 text-green-900">
        {{ session('success') }}
    </p>
@endif

@foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var flashMessage = document.getElementById('flash');

            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.opacity = '0';
                    setTimeout(function() {
                        flashMessage.style.display = 'none';
                    }, 500);
                }, 4000);
            }
        });
    </script>
@endpush