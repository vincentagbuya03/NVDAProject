

@foreach ($student as $s)
    @foreach ($s->courses as $course)
        <p> {{ $s->name }} , {{ $course->name }} </p>
    @endforeach
@endforeach