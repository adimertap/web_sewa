<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FilteredDataExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
  protected $data;
  protected $minPembayaranYear;
  protected $maxPembayaranYear;
  protected $minKenaikanYear;
  protected $maxKenaikanYear;

  public function __construct($data, $minPembayaranYear, $maxPembayaranYear, $minKenaikanYear, $maxKenaikanYear)
  {
    $this->data = $data;
    $this->minPembayaranYear = $minPembayaranYear;
    $this->maxPembayaranYear = $maxPembayaranYear;
    $this->minKenaikanYear = $minKenaikanYear;
    $this->maxKenaikanYear = $maxKenaikanYear;
  }

  public function collection()
  {
    return collect($this->data)->map(function ($row) {
      // Format 'besar sewa' and 'kontribusi awal' as Rupiah
      $row['besar_sewa'] = $this->formatRupiah($row['besar_sewa']);
      $row['kontribusi_awal'] = $this->formatRupiah($row['kontribusi_awal']);

      // Dynamically format nominal values for Pembayaran
      foreach ($row as $key => $value) {
        if (strpos($key, 'pembayaran tahun') !== false && is_numeric($value)) {
          $row[$key] = $this->formatRupiah($value);
        }
      }

      // Dynamically format nominal values for Kenaikan
      foreach ($row as $key => $value) {
        if (strpos($key, 'kenaikan tahun ke') !== false && is_numeric($value)) {
          $row[$key] = $this->formatRupiah($value);
        }
      }

      return $row;
    });
  }

  private function formatRupiah($value)
  {
    if (is_numeric($value)) {
      return 'Rp ' . number_format($value, 0, ',', '.');
    }
    return $value;
  }

  public function headings(): array
  {
    $headers = [
      'No.',
      'jenis',
      'lokasi',
      'Nomor tanggal perjanjian',
      'Nomor Kode Barang',
      'Nomor register',
      'sertipikat',
      'jumlah bidang sewa sebagian',
      'luas total sertipikat',
      'luas yang disewa',
      'nama pengguna',
      'nomor telepon',
      'peruntukan',
      'tahun peninjauan berikutnya',
      'jumlah bidang sewa keseluruhan',
      'sudah jatuh tempo pembayaran/belum',
      'jatuh tempo pembayaran',
      'sistem pembayaran',
      'jangka waktu mulai',
      'jangka waktu berakhir',
      'besar sewa',
      'kontribusi awal',
      'keterangan',
      'Kabupaten/ kota',
    ];

    // Add dynamic columns for Kenaikan
    for ($year = $this->minKenaikanYear; $year <= $this->maxKenaikanYear; $year++) {
      $headers[] = "kenaikan tahun ke $year";
    }

    // Add dynamic columns for Pembayaran
    for ($year = $this->minPembayaranYear; $year <= $this->maxPembayaranYear; $year++) {
      $headers[] = "pembayaran tahun $year";
    }

    return $headers;
  }

  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function (AfterSheet $event) {
        $sheet = $event->sheet->getDelegate();

        // Get the last column dynamically
        $lastColumn = $sheet->getHighestColumn(); // Get the last column (e.g., "AD")
        $totalRows = $sheet->getHighestRow(); // Get the total number of rows

        // Apply dynamic header styling
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
          'font' => [
            'bold' => true,
            'size' => 14,
          ],
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
          ],
        ]);

        // Define row colors based on the image
        $colorMapping = [
          'Sudah Diputus' => 'FFFF00', // Yellow
          'Restitusi/belanja tidak terduga' => 'B85450', // Red
          'Sewa Sebagian' => '7F41AA', // Purple
          'Belum Tuntas' => '4AACC5', // Blue
          'Kerjasama Pemanfaatan' => 'A6A6A6', // Gray
          'Sudah Bayar Batal Sewa' => 'FAC090', // Peach
        ];

        // Apply color logic for each row
        foreach ($this->data as $rowIndex => $row) {
          $rowNumber = $rowIndex + 2; // +2 to account for 0-based index and header row

          $jenis = $row['jenis'];
          $colorHex = $colorMapping[$jenis] ?? null;

          if ($colorHex) {
            // Apply color to the entire row dynamically
            $sheet->getStyle("A{$rowNumber}:{$lastColumn}{$rowNumber}")->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setARGB($colorHex);
          }
        }
      },
    ];
  }
}
