<section class="w-full bg-gray-900 p-8 rounded-lg shadow-xl my-8">
    <h2 class="text-3xl font-bold mb-4">Book the Band</h2>

    <div id="status-message" class="hidden text-white p-3 rounded"></div>

    <form id="gigLeadForm" method="POST" action="{{ route('giglead.store') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-white">Name</label>
            <input type="text" id="name" name="name" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="Your Name">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-white">Email</label>
            <div class="flex">
                <input type="email" id="email" name="email" required
                       class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                       placeholder="Your Email">
                <button type="button" id="verifyEmailButton" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">
                    Verify
                </button>
            </div>
        </div>

        <!-- Hidden Verification Field -->
        <div id="verification-section" class="mb-4 hidden">
            <label for="verification_code" class="block text-sm font-medium text-white">Enter Verification Code</label>
            <input type="text" id="verification_code" name="verification_code" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="6-digit Code">
            <button type="button" id="submitVerificationCode" class="mt-2 bg-green-500 text-white px-4 py-2 rounded">
                Confirm Code
            </button>
        </div>

        <div class="mb-4">
            <label for="telephone" class="block text-sm font-medium text-white">Telephone</label>
            <input type="text" id="telephone" name="telephone" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="Your Telephone">
        </div>

        <div class="mb-4">
            <label for="event_information" class="block text-sm font-medium text-white">Event Information</label>
            <textarea id="event_information" name="event_information"
                      class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                      placeholder="Details about your event..."></textarea>
        </div>

        <button type="submit" id="submitButton" class="bg-blue-500 text-white py-2 px-4 rounded" disabled>
            Submit
        </button>
    </form>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let verifyButton = document.getElementById('verifyEmailButton');
        let emailInput = document.getElementById('email');
        let verificationSection = document.getElementById('verification-section');
        let verificationInput = document.getElementById('verification_code');
        let submitVerificationButton = document.getElementById('submitVerificationCode');
        let submitButton = document.getElementById('submitButton');

        // Send verification code when clicking "Verify"
        verifyButton.addEventListener('click', function () {
            let email = emailInput.value.trim();

            if (!email) {
                alert('Please enter an email address first.');
                return;
            }

            fetch('/send-verification-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Verification code sent! Check your email.');
                        verificationSection.classList.remove('hidden');
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Verify the code and enable the submit button
        submitVerificationButton.addEventListener('click', function () {
            let email = emailInput.value.trim();
            let code = verificationInput.value.trim();

            if (!email || !code) {
                alert('Please enter the verification code.');
                return;
            }

            fetch('/verify-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email, code: code })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Verification successful! You may now submit the form.');
                        submitButton.disabled = false; // Enable submit button
                    } else {
                        alert('Invalid verification code. Please try again.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
