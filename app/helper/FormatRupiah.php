<?php
function Rupiah($angka)
    {
        $hasil_rupiah = "" . number_format($angka, 0, ',', '.');
        return "Rp.". $hasil_rupiah;
    }