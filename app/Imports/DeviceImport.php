<?php

namespace App\Imports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeviceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Device([
            'name_tag' => $row['name_tag'],
            'category' => $row['category'],
            'slug' => $row['slug'],
            'model' => $row['model'],
            'serial_number' => $row['serial_number'],
            'brand' => $row['brand'],
            'specifications' => json_decode($row['specifications'], true),
            'purchase_date' => $row['purchase_date'],
            'warranty_expiry' => $row['warranty_expiry'],
            'current_status' => $row['current_status'],
            'current_school_id' => $row['current_school_id'],
            'purchase_cost' => $row['purchase_cost'],
            'notes' => $row['notes'],
        ]);
    }
}