<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NumberGenerator
{
    /**
     * Generate a unique document number V1. 
     *
     * @param string $tableName - Nama tabel di database.
     * @param string $prefix - Prefix dokumen (misalnya: "MUI/PR-").
     * @param string $dateColumn - Nama kolom untuk tanggal (default: 'created_at').
     * @param string $counterColumn - Nama kolom untuk counter (default: 'doc_counter').
     * @return array - [doc_num, doc_counter]
     */
    public static function generateNumber($tableName, $prefix, $dateColumn = 'created_at', $counterColumn = 'doc_counter')
    {
        $currentYear = Carbon::now()->format('y'); // Tahun dalam format dua digit (misal: '24').
        $currentMonth = Carbon::now()->format('m'); // Bulan dalam format dua digit (misal: '01').

        // Cari entry terakhir di tabel untuk bulan dan tahun ini
        $lastEntry = DB::table($tableName)
            ->whereYear($dateColumn, Carbon::now()->year)
            ->whereMonth($dateColumn, Carbon::now()->month)
            ->orderBy($counterColumn, 'desc')
            ->first();

        // Jika ada data, increment counter, jika tidak, reset counter ke 1
        $newCounter = $lastEntry ? $lastEntry->$counterColumn + 1 : 1;

        // Format counter menjadi 4 digit (0001, 0002, dst.)
        $formattedCounter = str_pad($newCounter, 4, '0', STR_PAD_LEFT);

        // Format nomor dokumen
        $docNumber = "{$prefix}-{$currentYear}/{$currentMonth}/{$formattedCounter}";

        return [
            'doc_num' => $docNumber,
            'doc_counter' => $newCounter,
        ];
    }

    /**
     * Generate a unique document number V2. 
     *
     * @param string $tableName - Nama tabel di database.
     * @param string $prefix - Prefix dokumen (misalnya: "MUI/PO/").
     * @param string $dateColumn - Nama kolom untuk tanggal (default: 'created_at').
     * @param string $counterColumn - Nama kolom untuk counter (default: 'doc_counter').
     * @return array - [doc_num, doc_counter]
     */
    public static function generateNumberV2($tableName, $prefix, $dateColumn = 'created_at', $counterColumn = 'doc_counter')
    {
        $currentYear = Carbon::now()->format('y'); // Tahun dalam format dua digit (misal: '24').
        $currentMonth = Carbon::now()->format('m'); // Bulan dalam format dua digit (misal: '01').

        // Cari entry terakhir di tabel untuk bulan dan tahun ini
        $lastEntry = DB::table($tableName)
            ->whereYear($dateColumn, Carbon::now()->year)
            ->whereMonth($dateColumn, Carbon::now()->month)
            ->orderBy($counterColumn, 'desc')
            ->first();

        // Jika ada data, increment counter, jika tidak, reset counter ke 1
        $newCounter = $lastEntry ? $lastEntry->$counterColumn + 1 : 1;

        // Format counter menjadi 4 digit (0001, 0002, dst.)
        $formattedCounter = str_pad($newCounter, 4, '0', STR_PAD_LEFT);

        // Format nomor dokumen
        $docNumber = "{$prefix}/{$currentYear}/{$currentMonth}/{$formattedCounter}";

        return [
            'doc_num' => $docNumber,
            'doc_counter' => $newCounter,
        ];
    }

    
    public static function generateNumberV3($tableName, $prefix, $counterColumn = 'doc_counter')
    {
        // Cari entry terakhir di tabel untuk bulan dan tahun ini
        $lastEntry = DB::table($tableName)
            ->orderBy($counterColumn, 'desc')
            ->first();

        // Jika ada data, increment counter, jika tidak, reset counter ke 1
        $newCounter = $lastEntry ? $lastEntry->$counterColumn + 1 : 1;
        

        // Format counter menjadi 4 digit (0001, 0002, dst.)
        $formattedCounter = str_pad($newCounter, 3, '0', STR_PAD_LEFT);
        // Format nomor dokumen
        $docNumber = "{$prefix}-{$formattedCounter}";

        return [
            'doc_num' => $docNumber,
            'doc_counter' => $newCounter,
        ];
    }
}
