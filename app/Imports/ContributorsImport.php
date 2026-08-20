<?php

namespace App\Imports;

use App\Models\Contributor;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContributorsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Contributor([
            'name' => $row['name'],
            'phone_no' => $row['phone_no'],
            'assigned_seats' => $row['assigned_seats'] ?? 0,
            'status' => $row['status'] ?? 'not_invited',
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone_no' => 'required|string|unique:contributors,phone_no',
            'assigned_seats' => 'nullable|integer|min:0',
            'status' => 'nullable|in:not_invited,invited',
        ];
    }
}
