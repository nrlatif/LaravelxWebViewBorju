<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Login - KP Borju</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br" style="background: linear-gradient(to bottom right, #991B27, #BD2630)">
        <div class="w-full max-w-md p-8">
            <h2 class="text-2xl font-bold text-center mb-6 kp-form-label" style="color: white;">Login</h2>

            <!-- Alert Error -->
            <div id="errorAlert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span id="errorMessage" class="block sm:inline"></span>
            </div>

            <!-- Alert Success -->
            <div id="successAlert" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span id="successMessage" class="block sm:inline"></span>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="space-y-4" style="background: rgba(255, 255, 255, 0.95); padding: 2rem; border-radius: 12px; backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
                <div>
                    <label for="email" class="block font-semibold mb-2 kp-form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        class="w-full px-4 py-2 rounded-lg kp-form-input"
                        placeholder="Masukkan email Anda"
                    />
                </div>

                <div>
                    <label for="password" class="block font-semibold mb-2 kp-form-label">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-4 py-2 rounded-lg kp-form-input pr-14"
                            placeholder="Masukkan password Anda"
                        />
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                            title="Tampilkan/Sembunyikan password"
                        >
                            <svg class="w-5 h-5" id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-2 text-right">
                        <a href="#" id="forgotPasswordLink" class="text-sm kp-form-link" style="color: #ED884C;">Lupa Password?</a>
                    </div>
                </div>

                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full py-2 rounded-lg transition duration-200 kp-btn-primary"
                >
                    Login
                </button>
            </form>

            <!-- Forgot Password Modal -->
            <div id="forgotPasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4" style="background: rgba(255, 255, 255, 0.98);">
                    <h3 class="text-xl font-bold mb-4 kp-form-label">Reset Password</h3>
                    <p class="text-gray-600 mb-4">Masukkan email Anda untuk menerima link reset password</p>

                    <div id="forgotPasswordAlert" class="hidden mb-4 px-4 py-3 rounded" role="alert">
                        <span id="forgotPasswordMessage"></span>
                    </div>

                    <div class="mb-4">
                        <input
                            type="email"
                            id="forgotPasswordEmail"
                            class="w-full px-4 py-2 rounded-lg kp-form-input"
                            placeholder="Masukkan email Anda"
                        />
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="button"
                            id="sendResetBtn"
                            class="flex-1 py-2 rounded-lg transition duration-200 kp-btn-primary"
                        >
                            Kirim Link Reset
                        </button>
                        <button
                            type="button"
                            id="closeModalBtn"
                            class="flex-1 py-2 rounded-lg transition duration-200"
                            style="background-color: #E0E0E0; color: #333;"
                        >
                            Batal
                        </button>
                    </div>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p style="color: rgba(255, 255, 255, 0.8);">Belum punya akun? <a href="/register" class="kp-form-link" style="color: #ED884C;">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
