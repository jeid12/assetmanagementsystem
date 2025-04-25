<?php

namespace App\Services;

use App\Models\Device;
use App\Models\School;

class DeviceNameTagService
{
    /**
     * Generate a name tag in the format:
     * RTB/{CATEGORY}/{SCHOOL_CODE}/{COUNT}
     */
    public function generate(string $category, int $schoolId): string
    {
        $school = School::findOrFail($schoolId);

        $count = Device::where('category', $category)
            ->where('current_school_id', $schoolId)
            ->count() + 1;

        return 'RTB/' . strtoupper($category) . '/' . strtoupper($school->code  ) . '/' . $count;
    }
}