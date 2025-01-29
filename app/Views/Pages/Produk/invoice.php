<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        .invoice-container {
            width: 80%;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
        }

        .header {
            text-align: center;
        }

        .invoice-info,
        .customer-info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .print-button {
            margin-top: 20px;
            text-align: center;
        }

        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <img src="<?= base_url('image/logo.png'); ?>" class="img-fluid" alt="logo" width="100px" height="100px">
            <h2>Invoice</h2>
        </div>
        <div class="invoice-info">
            <p><strong>No. Invoice:</strong> INV-001</p>
            <p><strong>Tanggal:</strong> <?= $tanggal; ?></p>
        </div>
        <div class="customer-info">
            <p><strong>Pelanggan:</strong> John Doe</p>
            <p><strong>Alamat:</strong> Jl. Mawar No. 10, Jakarta</p>
        </div>
        <table>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
            <tr>
                <td><?= $produk['nama_barang'] ?></td>
                <td>5</td>
                <td><?= number_format($produk['harga_jual'], 0, ',', ','); ?></td>
                <td><?= number_format((5 * $produk['harga_jual']), 0, ',', ','); ?></td>
            </tr>
            <tr>
                <td colspan="3" class="total">Total (Rp)</td>
                <td><strong><?= number_format((5 * $produk['harga_jual']), 0, ',', ','); ?></strong></td>
            </tr>
        </table>
        <div class="print-button">
            <button onclick="window.print()">Cetak Invoice</button>
        </div>
    </div>
</body>

</html>