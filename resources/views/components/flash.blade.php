{{ $slot }}

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var flashMessage = document.getElementById('flashMessage');

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