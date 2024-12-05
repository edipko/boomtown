<section class="w-full bg-gray-900 p-8 rounded-lg shadow-xl my-8">
    <h2 class="text-3xl font-bold mb-4">Book the Band</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="gigLeadForm">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="telephone">Telephone:</label>
            <input type="text" name="telephone" id="telephone" required>
        </div>
        <div>
            <label for="event_information">Event Information:</label>
            <textarea name="event_information" id="event_information"></textarea>
        </div>

        <!-- Hidden reCAPTCHA Token Field -->
        <input type="hidden" id="recaptcha-token" name="recaptchaToken">

        <button type="submit">Submit</button>
    </form>

    <div id="gigLeadSuccessMessage" class="hidden">
        Thank you for your inquiry! We'll get back to you soon.
    </div>

    <script src="https://www.google.com/recaptcha/api.js?render={{ config('app.recaptcha_site_key') }}"></script>
    <script>
        document.getElementById('gigLeadForm').addEventListener('submit', function (event) {
            event.preventDefault();

            grecaptcha.ready(function () {
                grecaptcha.execute('{{ config('app.recaptcha_site_key') }}', { action: 'submit' }).then(function (token) {
                    // Attach the token to the hidden input field
                    document.getElementById('recaptcha-token').value = token;

                    // Submit the form via AJAX
                    const formData = new FormData(document.getElementById('gigLeadForm'));

                    fetch("{{ route('giglead.store') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                document.getElementById('gigLeadSuccessMessage').classList.remove('hidden');
                                document.getElementById('gigLeadForm').reset();
                            } else {
                                console.error('Submission error:', data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

    <div class="mt-4">
        <a href="{{ route('press-kit') }}" class="text-blue-400 underline">View Digital Press Kit</a>
    </div>
</section>
