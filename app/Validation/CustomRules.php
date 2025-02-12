<?php

namespace App\Validation;

class CustomRules
{
    public function min_harga_jual(string $str, string $fields, array $data): bool
    {
        // Pastikan 'harga_beli' tersedia dalam data
        if (!isset($data['harga_beli'])) {
            return false;
        }

        // Hitung 30% dari harga_beli
        $minHargaJual = $data['harga_beli'] * 1.3;

        // Periksa apakah harga_jual memenuhi syarat
        return $str >= $minHargaJual;
    }
}
