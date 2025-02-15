<!DOCTYPE html>
<html>

<head>
    <title><?= $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Daftar Produk</h2>
    <table>
        <tr>
            <th>No.</th>
            <th>Image</th>
            <th>Nama Produk</th>
            <th>Kategori Produk</th>
            <th>Harga Beli (Rp)</th>
            <th>Harga Jual (Rp)</th>
            <th>Stok Produk</th>
        </tr>
        <?php $no = 1;
        foreach ($products as $product): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td>
                    <!-- <?php
                    $imagePath = 'public/uploads/' . $product['image'];
                    $imageFullPath = base_url($imagePath);
                    ?>
                    <img src="<?= $imageFullPath ?>" alt="Produk"> -->
                    <?= $product['image'] ?>
                </td>
                <td><?= $product['nama_barang'] ?></td>
                <td><?= $product['kategori'] ?></td>
                <td><?= number_format($product['harga_beli'], 0, ',', ','); ?></td>
                <td><?= number_format($product['harga_jual'], 0, ',', ','); ?></td>
                <td><?= $product['stock_barang'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>