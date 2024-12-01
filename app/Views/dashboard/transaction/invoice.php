<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        rel="stylesheet" />
    <style>
        body {
            font-family: "Inter", Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            max-width: 800px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .line {
            border: none;
            border-top: 2px solid #e5e7eb;
            margin: 20px 0;
        }

        .invoice-logo span {
            color: #84f779;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-name,
        .item-quantity,
        .item-price,
        .item-total {
            flex: 1;
            text-align: center;
        }

        .total-section {
            margin-top: 30px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
            font-weight: bold;
        }

        .icon {
            margin-right: 8px;
            color: #6b7280;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .invoice-logo h1 {
            font-size: 32px;
            font-weight: bold;
            color: #374151;
        }

        .invoice-logo p {
            color: #6b7280;
            margin-top: 5px;
        }

        .total-row p {
            font-size: 18px;
        }

        .total-value {
            font-size: 20px;
            color: #111827;
        }

        .line {
            border: none;
            border-top: 2px solid #d1d5db;
            margin: 16px 0;
        }

        @media (max-width: 768px) {
            .invoice-header {
                flex-direction: column;
                text-align: center;
            }

            .invoice-logo h1 {
                font-size: 28px;
            }

            .total-section {
                margin-top: 20px;
            }

            .total-row {
                padding: 12px 0;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="flex items-center">
                <img
                    src="https://via.placeholder.com/50"
                    alt="Logo"
                    class="w-16 h-16 mr-6" />
                <div>
                    <h1 class="invoice-logo text-3xl font-bold text-gray-800">
                        Waroeng<span class="text-green-400">Rindu</span>
                    </h1>
                    <p class="text-gray-500 mt-2 text-sm">
                        Restoran Waroeng Rindu<br />
                        Jl. Kemayu No. 11, Kecamatan, Kota, Provinsi, 1110
                    </p>
                </div>
            </div>
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-700">INVOICE</h2>
                <p class="text-gray-500 mt-1">INV/20240715/3675</p>
            </div>
        </div>

        <!-- Buyer and Shipping Information -->
        <div class="mb-8">
            <p class="text-gray-600">
                <i class="fas fa-user icon"></i><span class="font-semibold">Buyer:</span> Siska
            </p>
            <p class="text-gray-600">
                <i class="fas fa-calendar-day icon"></i><span class="font-semibold">Purchase Date:</span> November 30, 2024
            </p>
            <p class="text-gray-600">
                <i class="fas fa-map-marker-alt icon"></i><span class="font-semibold">Shipping Address:</span><br />
                Siska (082186462), Kp. Durian Runtuh RT.01/RW.02,<br />
                Kota Bekasi, Jawa Barat
            </p>
        </div>

        <!-- Item List -->
        <table
            class="w-full mb-8 border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left py-4 px-6 text-gray-600">ITEM NAME</th>
                    <th class="text-left py-4 px-6 text-gray-600">QUANTITY</th>
                    <th class="text-left py-4 px-6 text-gray-600">UNIT PRICE</th>
                    <th class="text-left py-4 px-6 text-gray-600">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t">
                    <td class="py-4 px-6">Ifu Mie Seafood</td>
                    <td class="py-4 px-6">1</td>
                    <td class="py-4 px-6">Rp75.000</td>
                    <td class="py-4 px-6">Rp75.000</td>
                </tr>
                <tr class="border-t">
                    <td class="py-4 px-6">Lemon Tea</td>
                    <td class="py-4 px-6">1</td>
                    <td class="py-4 px-6">Rp20.000</td>
                    <td class="py-4 px-6">Rp20.000</td>
                </tr>
            </tbody>
        </table>

        <!-- Total and Payment -->
        <div class="total-section">
            <!-- Line above Total Price -->
            <hr class="line" />

            <div class="total-row">
                <div class="total-label text-gray-600">
                    <i class="fas fa-wallet icon"></i> TOTAL PRICE
                </div>
                <div class="total-value">Rp95.000</div>
            </div>
            <div class="total-row">
                <div class="total-label text-gray-600">
                    <i class="fas fa-truck icon"></i> Delivery Fee Total
                </div>
                <div class="total-value">Rp11.500</div>
            </div>
            <div class="total-row">
                <div class="total-label text-gray-600">
                    <i class="fas fa-cogs icon"></i> Service Fee Total
                </div>
                <div class="total-value">Rp1.000</div>
            </div>
            <div class="total-row font-bold">
                <div class="total-label text-gray-600">
                    <i class="fas fa-money-bill-wave icon"></i> TOTAL BILL
                </div>
                <div class="total-value text-lg">Rp107.500</div>
            </div>
        </div>

        <!-- Shipping and Payment -->
        <hr class="line" />
        <div class="flex justify-between items-center mt-8">
            <p class="text-gray-600">
                <i class="fas fa-shipping-fast icon"></i><span class="font-semibold">Courier:</span> Regular
            </p>
            <div class="text-right">
                <p class="text-gray-600">
                    <i class="fas fa-credit-card icon"></i> Payment Method:
                </p>
                <p class="font-bold text-gray-700">Bank Transfer</p>
            </div>
        </div>

</body>

</html>
