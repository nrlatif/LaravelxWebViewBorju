<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KP Borju</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-600 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">KP Borju</h1>
                <button
                    id="logoutBtn"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-200"
                >
                    Logout
                </button>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto p-4 mt-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang di Dashboard</h2>

                <!-- User Info -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <p class="text-gray-700">
                        <strong>Nama:</strong> <span id="userName" class="text-blue-600">Loading...</span>
                    </p>
                    <p class="text-gray-700 mt-2">
                        <strong>Email:</strong> <span id="userEmail" class="text-blue-600">Loading...</span>
                    </p>
                </div>

                <p class="text-gray-600">Anda berhasil login ke sistem KP Borju.</p>
            </div>
        </div>
    </div>
</body>
</html>
