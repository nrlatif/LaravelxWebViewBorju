<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Register - KP Borju</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br" style="background: linear-gradient(to bottom right, #991B27, #BD2630)">
        <div class="w-full max-w-md p-8">
            <h2 class="text-2xl font-bold text-center mb-6 kp-form-label" style="color: white;">Daftar Akun Baru</h2>

            <!-- Alert Error -->
            <div id="errorAlert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span id="errorMessage" class="block sm:inline"></span>
            </div>

            <!-- Alert Success -->
            <div id="successAlert" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span id="successMessage" class="block sm:inline"></span>
            </div>

            <!-- Register Form -->
            <form id="registerForm" class="space-y-4" style="background: rgba(255, 255, 255, 0.95); padding: 2rem; border-radius: 12px; backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
                <div>
                    <label for="fullName" class="block font-semibold mb-2 kp-form-label">Nama Lengkap</label>
                    <input
                        type="text"
                        id="fullName"
                        name="fullName"
                        required
                        class="w-full px-4 py-2 rounded-lg kp-form-input"
                        placeholder="Masukkan nama lengkap Anda"
                    />
                </div>

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
                            placeholder="Masukkan password (minimal 6 karakter)"
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
                </div>

                <div>
                    <label for="confirmPassword" class="block font-semibold mb-2 kp-form-label">Konfirmasi Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="confirmPassword"
                            name="confirmPassword"
                            required
                            class="w-full px-4 py-2 rounded-lg kp-form-input pr-12"
                            placeholder="Ulangi password Anda"
                        />
                        <button
                            type="button"
                            id="toggleConfirmPassword"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                            title="Tampilkan/Sembunyikan password"
                        >
                            <svg class="w-5 h-5" id="eyeIconConfirm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full py-2 rounded-lg transition duration-200 kp-btn-primary"
                >
                    Daftar
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p style="color: rgba(255, 255, 255, 0.8);">Sudah punya akun? <a href="/login" class="kp-form-link" style="color: #ED884C;">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
