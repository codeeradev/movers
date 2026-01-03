<?php

namespace App\Imports;

use App\Models\Property;
use App\Models\Sector;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PropertyImport implements ToModel, WithHeadingRow
{
    protected $rowCount = 1;

   public function model(array $row)
{
    try {
        // Cleaner
        $clean = function ($value) {
            if (is_null($value)) return null;
            return trim(str_replace('_x000D_', ' ', strip_tags($value)));
        };

       

        /* --------------------------------------------
            FIND EXISTING SECTOR (NO NEW CREATION)
        -------------------------------------------- */
        $sector = null;
        if (!empty($row['sectorid'])) {
            $sectorName = $clean($row['sectorid']);
            $sector = Sector::where('name', $sectorName)->first();
        }

        /* --------------------------------------------
            FIND CATEGORY
        -------------------------------------------- */
        $category = null;
        if (!empty($row['categorycode'])) {
            $catCode = $clean($row['categorycode']);
            $category = Category::where('code', $catCode)->first();
        }

        /* --------------------------------------------
            FIND SUBCATEGORY
        -------------------------------------------- */
        $subcategory = null;
        if (!empty($row['subcategorycode'])) {
            $subCatCode = $clean($row['subcategorycode']);
            $subcategory = Subcategory::where('code', $subCatCode)->first();
        }

        /* --------------------------------------------
            DOB PARSING
        -------------------------------------------- */
        $dobValue = $row['dob']
            ?? $row['dob_dd_mm_yyyy']
            ?? $row['dob (dd-mm-yyyy)']
            ?? null;

        $dob = null;
        if (!empty($dobValue)) {
            try {
                if (is_numeric($dobValue)) {
                    $dob = ExcelDate::excelToDateTimeObject($dobValue);
                } else {
                    $dob = Carbon::parse(trim($dobValue));
                }
            } catch (\Exception $e) {
                $dob = null;
                Log::warning("Invalid DOB on row {$this->rowCount}");
            }
        }

        $dobFormatted = $dob instanceof \DateTimeInterface ? $dob->format('Y-m-d') : null;

        /* --------------------------------------------
            UNIQUE PROPERTY MATCHING
        -------------------------------------------- */
        $propertyNumber = $clean($row['property_number'] ?? null);

        if (!$propertyNumber) {
            Log::warning("Missing property_number on row {$this->rowCount}");
            return null;
        }

        $property = Property::updateOrCreate(
            [
                'property_number' => $propertyNumber,
                'sector_id'       => $sector ? $sector->id : null,
                'category_id'     => $category ? $category->id : null,
                'subcategory_id'  => $subcategory ? $subcategory->id : null,
            ],
            [
                'owner_name'      => $clean($row['owner_name'] ?? null),
                'father_name'     => $clean($row['father_name'] ?? null),
                'contact_number'  => $clean($row['contact_number'] ?? null),
                'email'           => $clean($row['email'] ?? null),
                'dob'             => $dobFormatted,

                'address'         => isset($row['address']) ? substr($clean($row['address']), 0, 1000) : null,
                'property_type'   => $clean($row['property_type'] ?? null),

                'property_status' => $clean($row['property_status'] ?? null), // ✅ ADDED

                'khewat_number'   => $clean($row['khewat_number'] ?? null),
                'khasra_number'   => $clean($row['khasra_number'] ?? null),
                'plot_size'       => $clean($row['plot_size'] ?? null),
                'ownership_type'  => $clean($row['ownership_type'] ?? null),
                'location'        => $clean($row['location'] ?? null),
                'landmark'        => $clean($row['landmark'] ?? null),

                'price'           => is_numeric($row['price'] ?? null) ? $row['price'] : 0,

                'description'     => isset($row['description']) ? substr($clean($row['description']), 0, 2000) : null,

                'status'          => isset($row['status']) && $row['status'] !== '' ? $row['status'] : 1,
            ]
        );

        if ($property->wasRecentlyCreated) {
            Log::info("Property Created: {$propertyNumber}");
        } else {
            Log::info("Property Updated: {$propertyNumber}");
        }

        $this->rowCount++;
        return $property;

    } catch (\Throwable $e) {

        Log::error("Import Error at Row {$this->rowCount}: " . $e->getMessage(), [
            'row_data' => $row,
            'trace' => $e->getTraceAsString(),
        ]);

        return null;
    }
}

}
