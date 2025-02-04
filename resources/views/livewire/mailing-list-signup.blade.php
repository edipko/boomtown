<div class="relative flex items-center justify-center bg-black py-10">
    <!-- Background Image with Overlay constrained to content height -->
    <div class="absolute bg-blue-800 inset-0 h-full w-full flex items-center justify-center">
        <img src="{{ asset('images/mailing-list-bg.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-30">
    </div>

    <!-- Form Container centered and sized for content -->
    <div class="relative z-10 bg-opacity-75 p-10 rounded-lg shadow-lg text-white w-11/12 max-w-lg mx-auto">
        <h2 class="text-3xl font-semibold text-center mb-6">Join the Mailing List</h2>

        <div id="success-message" class="hidden bg-green-500 text-white p-3 rounded mb-4"></div>
        <div id="error-message" class="hidden bg-red-500 text-white p-3 rounded mb-4"></div>

        <form id="signup-form">
            <div class="mb-4">
                <input type="text" id="name" name="name" placeholder="Full Name" class="w-full p-3 rounded focus:outline-none text-gray-900 placeholder-gray-400" />
            </div>

            <div class="mb-4">
                <input type="email" id="email" name="email" placeholder="Email Address" class="w-full p-3 rounded focus:outline-none text-gray-900 placeholder-gray-400" />
            </div>

            <!-- Hidden field for reCAPTCHA token -->
            <input type="hidden" id="recaptcha-token" name="recaptchaToken">
            <input type="hidden" id="hidden-token" name="hiddenToken" value="{{ env('VERIFICATION_TOKEN') }}">

            <button type="submit" id="submit-button" class="w-full p-3 bg-blue-500 hover:bg-blue-600 text-white rounded font-semibold">Sign Up</button>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render='{{ config('app.recaptcha_site_key') }}'"></script>
<script>
    document.getElementById('signup-form').addEventListener('submit', function (e) {
        e.preventDefault();

        grecaptcha.ready(function () {
            grecaptcha.execute('{{ config('app.recaptcha_site_key') }}', { action: 'submit' }).then(function (token) {
                document.getElementById('recaptcha-token').value = token;

                let formData = {
                    email: document.getElementById('email').value,
                    site_name: "Boomtown", // Adjust as needed
                    form_data: { name: document.getElementById('name').value },
                    hidden_token: document.getElementById('hidden-token').value
                };

                fetch('/create-verification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.verification_link) {
                            document.getElementById('success-message').classList.remove('hidden');
                            document.getElementById('success-message').innerText = 'Verification email sent! Check your inbox.';
                        } else {
                            document.getElementById('error-message').classList.remove('hidden');
                            document.getElementById('error-message').innerText = 'Error sending verification email.';
                        }
                    })
                    .catch(error => {
                        document.getElementById('error-message').classList.remove('hidden');
                        document.getElementById('error-message').innerText = 'Error: ' + error.message;
                    });
            });
        });
    });
</script>
