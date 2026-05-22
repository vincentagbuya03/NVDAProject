@extends('layouts.mainlayout')

@section('title', 'Students - Student Management Dashboard')

@section('content')

    @if(session('success'))
        <div style="background-color: #f0fdf4; color: #166534; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; border-left: 4px solid #22c55e;">
            {{ session('success') }}
        </div>
    @endif

    <h1 style="font-size: 1.8rem; margin-bottom: 1.5rem; color: #2d3748;">Student List</h1>

    <table style="width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background-color: #2d3748; color: #fff;">
                <th style="padding: 0.75rem 1rem; text-align: left;">#</th>
                <th style="padding: 0.75rem 1rem; text-align: left;">Name</th>
                <th style="padding: 0.75rem 1rem; text-align: left;">Age</th>

                <th style="padding: 0.75rem 1rem; text-align: left;">Course</th>
                <th style="padding: 0.75rem 1rem; text-align: left;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            @php
                $displayAge = $student['age'] ?? (
                    !empty($student['birthdate'])
                        ? \Carbon\Carbon::parse($student['birthdate'])->age
                        : null
                );
            @endphp
            <tr style="border-bottom: 1px solid #e2e8f0; {{ $loop->even ? 'background-color: #f7fafc;' : '' }}">
                <td style="padding: 0.75rem 1rem;">{{ $loop->iteration }}</td>
                <td style="padding: 0.75rem 1rem;">{{ $student['name'] }}</td>
                <td style="padding: 0.75rem 1rem;">{{ $displayAge ?? 'N/A' }}</td>
                <td style="padding: 0.75rem 1rem;">{{ $student['course'] }}</td>
                <td style="padding: 0.75rem 1rem;">
                    
                    
                    @if($displayAge == 19)
                        <span style="color: #2b6cb0; font-weight: bold;">Freshman Student</span>
                    @elseif ($displayAge == 20)
                        <span style="color: #276749; font-weight: bold;">Sophomore</span>
                    @elseif ($displayAge == 21)
                        <span style="color: #b7791f; font-weight: bold;">Junior Student</span>
                    @elseif ($displayAge == 22)
                        <span style="color: #c53030; font-weight: bold;">Senior Student</span>
                    @else
                        <span style="color: #744210; font-weight: bold;">Irregular Student</span>
                    @endif
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection
