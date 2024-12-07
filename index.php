<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Harga Foto</title>
    <!-- Link ke Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi Slide Down */
        .slide-enter {
            transform: translateY(-20px);
            opacity: 0;
        }

        .slide-enter-active {
            transform: translateY(0);
            opacity: 1;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        /* Posisi Confetti */
        .confetti-container {
            position: relative;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto">
            <h1 class="text-2xl text-center text-blue-600 font-bold mb-4">Kalkulator Harga Foto</h1>

            <h3 class="text-sm text-gray-700 mb-4">Harga Foto:</h3>
            <ul class="list-disc pl-5 mb-6 text-gray-600 text-sm">
                <li>2x3 = Rp 2000</li>
                <li>3x4 = Rp 2500</li>
                <li>4x6 = Rp 3000</li>
            </ul>

            <form method="POST">
                <label for="size" class="block text-gray-700 font-semibold text-sm mb-2">Pilih Ukuran Foto:</label>
                <select name="size" id="size" class="w-full p-2 mb-4 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                    <option value="2x3">2x3</option>
                    <option value="3x4">3x4</option>
                    <option value="4x6">4x6</option>
                </select>

                <label for="quantity" class="block text-gray-700 font-semibold text-sm mb-2">Jumlah Foto:</label>
                <input type="number" name="quantity" id="quantity" min="1" class="w-full p-2 mb-4 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>

                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">Hitung Harga</button>
            </form>

            <div class="confetti-container">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $size = $_POST['size'];
                    $quantity = $_POST['quantity'];
                    $price = 0;

                    // Tentukan harga berdasarkan ukuran foto
                    if ($size == '2x3') {
                        $price = 2000;
                    } elseif ($size == '3x4') {
                        $price = 2500;
                    } elseif ($size == '4x6') {
                        $price = 3000;
                    }

                    // Hitung harga dasar
                    $totalPrice = $price * $quantity;

                    // Fitur diskon
                    if ($quantity >= 10 && $quantity < 20) {
                        $discount = 0.05;  // Diskon 5% untuk 10-19 foto
                    } elseif ($quantity >= 20 && $quantity < 50) {
                        $discount = 0.1;  // Diskon 10% untuk 20-49 foto
                    } elseif ($quantity >= 50) {
                        $discount = 0.15; // Diskon 15% untuk 50 foto atau lebih
                    } else {
                        $discount = 0;  // Tidak ada diskon
                    }

                    // Hitung total setelah diskon dan bulatkan diskonnya ke nilai terdekat
                    $discountAmount = round($totalPrice * $discount, -3); // Pembulatan ke ribuan (misalnya 500, 1000)
                    $totalPriceWithDiscount = $totalPrice - $discountAmount;

                    // Tampilkan informasi lengkap tentang perhitungan dengan animasi slide-down
                    echo "<div id='resultDiv' class='mt-4 p-4 bg-gray-200 rounded-lg shadow-lg slide-enter'>";
                    echo "<h3 class='text-md font-semibold mb-2'>Hasil Perhitungan:</h3>";
                    echo "<p class='text-sm text-gray-800 mb-2'>Untuk Foto Ukuran <span class='font-bold text-blue-600'>" . htmlspecialchars($size) . "</span> sebanyak <span class='font-bold text-blue-600'>" . htmlspecialchars($quantity) . "</span> foto</p>";
                    echo "<p class='text-sm text-gray-800 mb-2'>Harga Sebelum Diskon: <span class='font-bold'>" . number_format($totalPrice, 0, ',', '.') . "</span></p>";

                    if ($discount > 0) {
                        echo "<p class='text-sm text-gray-800 mb-2'>Diskon: <span class='font-bold'>" . number_format($discountAmount, 0, ',', '.') . "</span></p>";
                    } else {
                        echo "<p class='text-sm text-gray-800 mb-2'>Diskon: Tidak Ada</p>";
                    }

                    echo "<h3 class='text-lg font-semibold mt-2 text-green-600'>Total Harga Setelah Diskon: <span class='font-bold'>" . number_format($totalPriceWithDiscount, 0, ',', '.') . "</span></h3>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Tambahin Audio untuk Suara Uang -->
    <audio id="coinSound" src="coin_sound.mp3" preload="auto"></audio>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const resultDiv = document.getElementById("resultDiv");
            const coinSound = document.getElementById("coinSound");

            // Setelah konten muncul
            setTimeout(function() {
                // Tambah animasi slide-down
                resultDiv.classList.add("slide-enter-active");

                // Mainkan suara uang
                coinSound.play();

                // Efek confetti uang berjatuhan
                confetti({
                    particleCount: 100, // Jumlah partikel confetti
                    spread: 70, // Seberapa luas penyebarannya
                    origin: {
                        x: 0.5, // Posisi horizontal confetti (tengah)
                        y: 0.4 // Posisi vertikal confetti (di atas hasil perhitungan)
                    }
                });
            }, 100); // Delay sedikit untuk animasi yang lebih smooth
        });
    </script>
</body>

</html>