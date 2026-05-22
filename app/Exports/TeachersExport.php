<?php

namespace App\Exports;

use App\Models\Teacher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Teacher::with(['user', 'degree'])
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Middle Name',
            'Last Name',
            'Email',
            'Contact No',
            'Birthdate',
            'Gender',
            'Address',
            'Degree',
            'User ID',
            'Username',
            'Created At',
        ];
    }

    /**
     * @param  Teacher  $teacher
     */
    public function map($teacher): array
    {
        return [
            $teacher->id,
            $teacher->fname,
            $teacher->mname,
            $teacher->lname,
            $teacher->email,
            $teacher->contact_no,
            $teacher->birthdate,
            $teacher->gender,
            $teacher->address,
            $teacher->degree?->name,
            $teacher->user_id,
            $teacher->user?->username,
            $teacher->created_at,
        ];
    }
}
