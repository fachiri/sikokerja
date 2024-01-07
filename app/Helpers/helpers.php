<?php

if (!function_exists('get_progress')) {
    function get_progress($task, $currentProgress)
    {
      $jumlah_jjg = $task->nilai_kontrak_jtm + $task->nilai_kontrak_jtr + $task->nilai_kontrak_gardu;
      $jumlah_kontrak_keseluruhan = $jumlah_jjg + $task->ongkos_angkut;

      $pendapatan_persen_jtm = $task->nilai_kontrak_jtm / $jumlah_jjg;
      $pendapatan_persen_jtr = $task->nilai_kontrak_jtr / $jumlah_jjg;
      $pendapatan_persen_gardu = $task->nilai_kontrak_gardu / $jumlah_jjg;

      $ongkos_angkut_jtm = $pendapatan_persen_jtm * $task->ongkos_angkut;
      $ongkos_angkut_jtr = $pendapatan_persen_jtr * $task->ongkos_angkut;
      $ongkos_angkut_gardu = $pendapatan_persen_gardu * $task->ongkos_angkut;

      $jumlah_seluruh_jtm = $task->nilai_kontrak_jtm + (int) $ongkos_angkut_jtm;
      $jumlah_seluruh_jtr = $task->nilai_kontrak_jtr + (int) $ongkos_angkut_jtr;
      $jumlah_seluruh_gardu = $task->nilai_kontrak_gardu + (int) $ongkos_angkut_gardu;

      $jumlah_keseluruhan = $jumlah_seluruh_jtm + $jumlah_seluruh_jtr + $jumlah_seluruh_gardu; 

      $jtm = $currentProgress->jtm ?? 0;
      $jtr = $currentProgress->jtr ?? 0;
      $gardu = $currentProgress->gardu ?? 0;
      $nilai_total_rp_jtm = intval($jtm / $task->target_jtm * $jumlah_seluruh_jtm);
      $nilai_total_rp_jtr = intval($jtr / $task->target_jtr * $jumlah_seluruh_jtr);
      $nilai_total_rp_gardu = intval($gardu / $task->target_gardu * $jumlah_seluruh_gardu);
      $nilai_total_rp = $nilai_total_rp_jtm + $nilai_total_rp_jtr + $nilai_total_rp_gardu;
      $persentase = (float) number_format($nilai_total_rp / $jumlah_keseluruhan * 100, 2);

      $progress = (object) [
          'jtm' => $jtm,
          'jtr' => $jtr,
          'gardu' => $gardu,
          'nilai_total_rp_jtm' => $nilai_total_rp_jtm,
          'nilai_total_rp_jtr' => $nilai_total_rp_jtr,
          'nilai_total_rp_gardu' => $nilai_total_rp_gardu,
          'nilai_total_rp' => $nilai_total_rp,
          'persentase' => $persentase
      ];

      return $progress;
    }
}

if (!function_exists('formatRupiah')) {
  function formatRupiah($angka)
  {
      $rupiah = "Rp. " . number_format($angka, 0, ',', '.');
      return $rupiah;
  }
}

if (!function_exists('formatKms')) {
  function formatKms($angka)
  {
      $kms = $angka. " kms";
      return $kms;
  }
}