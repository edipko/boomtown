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

    @if (session('success'))
        <div class="mt-4 text-green-500">
            {{ session('success') }}
        </div>
    @endif

    <form id="gigLeadForm" method="POST" action="{{ route('giglead.store') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-white">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="Your Name">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-white">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="Your Email">
        </div>
        <div class="mb-4">
            <label for="telephone" class="block text-sm font-medium text-white">Telephone</label>
            <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="Your Telephone">
        </div>
        <div class="mb-4">
            <label for="event_information" class="block text-sm font-medium text-white">Event Information</label>
            <textarea id="event_information" name="event_information"
                      class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                      placeholder="Details about your event...">{{ old('event_information') }}</textarea>
        </div>

        <!-- Hidden reCAPTCHA Token Field -->
        <input type="hidden" id="recaptcha-token" name="recaptchaToken">

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button>
    </form>

    <div class="mt-4">
        <a href="{{ route('press-kit') }}" class="text-blue-400 underline">View Digital Press Kit</a>
    </div>
</section>

<script src="https://www.google.com/recaptcha/api.js?render={{ config('app.recaptcha_site_key') }}"></script>
<script>
    document.getElementById('gigLeadForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Stop the default form submission behavior

        grecaptcha.ready(function () {
            grecaptcha.execute('{{ config('app.recaptcha_site_key') }}', { action: 'submit' }).then(function (token) {
                console.log('Generated reCAPTCHA token:', token);

                if (!token) {
                    console.error('Failed to generate reCAPTCHA token.');
                    alert('Error: Could not generate reCAPTCHA token. Please try again.');
                    return;
                }

                // Set the token in the hidden input field
                document.getElementById('recaptcha-token').value = token;

                // Debug the form data
                const formData = new FormData(document.getElementById('gigLeadForm'));
                console.log('Form Data:', Array.from(formData.entries()));

                // Manually submit the form via fetch API
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
                            return response.json().then(err => {
                                console.error('Validation Errors:', err.errors);
                                alert('Validation Error: ' + JSON.stringify(err.errors));
                                throw new Error('Validation failed');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            document.getElementById('gigLeadForm').reset();
                            alert('Your booking request has been received!');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }).catch(function (error) {
                console.error('reCAPTCHA Error:', error);
                alert('Error generating reCAPTCHA. Please try again.');
            });
        });
    });


</script>
