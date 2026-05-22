<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Student::with(['user', 'degree'])
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
     * @param  Student  $student
     */
    public function map($student): array
    {
        return [
            $student->id,
            $student->fname,
            $student->mname,
            $student->lname,
            $student->email,
            $student->contact_no,
            $student->birthdate,
            $student->gender,
            $student->address,
            $student->degree?->name,
            $student->user_id,
            $student->user?->username,
            $student->created_at,
        ];
    }
}
