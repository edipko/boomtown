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
        <div class="status-message mb-4"></div>
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
        <input type="hidden" id="recaptcha-token" name="recaptchaToken">
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button>
    </form>

    <div class="mt-4">
        <a href="{{ route('press-kit') }}" class="text-blue-400 underline">View Digital Press Kit</a>
    </div>
</section>

<script src="https://www.google.com/recaptcha/api.js?render={{ config('app.recaptcha_site_key') }}"></script>
<script>
    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            const recaptchaInput = form.querySelector('input[name="recaptchaToken"]');
            const statusMessageContainer = form.querySelector('.status-message');
            if (!recaptchaInput) {
                console.error('Hidden input field for recaptchaToken not found in this form!');
                return;
            }

            grecaptcha.ready(async function () {
                try {
                    // Clear any existing messages
                    if (statusMessageContainer) {
                        statusMessageContainer.innerHTML = '';
                        statusMessageContainer.classList.remove('text-green-500', 'text-red-500');
                    }

                    // Generate the reCAPTCHA token
                    const token = await grecaptcha.execute('{{ config('app.recaptcha_site_key') }}', { action: 'submit' });
                    console.log('Generated reCAPTCHA token:', token);

                    if (!token) {
                        if (statusMessageContainer) {
                            statusMessageContainer.textContent = 'Error: Could not generate reCAPTCHA token. Please try again.';
                            statusMessageContainer.classList.add('text-red-500');
                        }
                        return;
                    }

                    // Set the token in the hidden input field
                    recaptchaInput.value = token;

                    // Use fetch API to submit the form
                    const formData = new FormData(form);

                    // Log the form data for debugging
                    console.log('Form Data Before Submission:', Array.from(formData.entries()));

                    const response = await fetch(form.action, {
                        method: form.method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        console.error('Validation Errors:', errorData.errors);
                        if (statusMessageContainer) {
                            statusMessageContainer.textContent = `Validation Error: ${Object.values(errorData.errors).join(', ')}`;
                            statusMessageContainer.classList.add('text-red-500');
                        }
                        return;
                    }

                    const responseData = await response.json();
                    console.log('Server Response:', responseData);

                    if (responseData.success) {
                        if (statusMessageContainer) {
                            statusMessageContainer.textContent = responseData.message || 'Submission successful!';
                            statusMessageContainer.classList.add('text-green-500');
                        }
                        form.reset();
                    }
                } catch (error) {
                    console.error('Error:', error);
                    if (statusMessageContainer) {
                        statusMessageContainer.textContent = 'An error occurred while submitting the form. Please try again.';
                        statusMessageContainer.classList.add('text-red-500');
                    }
                }
            });
        });
    });


</script>
