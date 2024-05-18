<div class="w-full text-left">
    <label for="cv"
        class="relative w-full cursor-pointer text-[#162753] focus-within:outline-none focus-within:ring-0">
        <span class="hover:underline">Upload your cv file</span>
        <input id="cv" name="cv" type="file" class="sr-only" accept=".pdf" required>
    </label>
    <p id="cvName" class="text-red-500 cursor-default"></p>
</div>

@push('scripts')
    <script>
        var cv = document.getElementById('cv')
            cv.addEventListener('change', function (event) {
                console.log(event.target.files[0].name)
                var fileName = event.target.files[0].name;
                var cvName = document.getElementById('cvName');
                    cvName.innerHTML = fileName;
            });
    </script>
@endpush