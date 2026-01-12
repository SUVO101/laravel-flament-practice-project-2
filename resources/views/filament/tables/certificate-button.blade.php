
@if ($record->pivot->status === 'completed')
<x-filament::button
    href="{{ route('certificate.download', [
            'course' => $record->pivot->course_id,
            'student' => $record->pivot->student_id,
        ]) }}"
    tag="a"
    color="success"
    icon="heroicon-o-arrow-down-tray"
>
</x-filament::button>
@else
    <x-filament::button
    color="success"
    icon="heroicon-o-arrow-down-tray"
    disabled="true"
>
</x-filament::button>
@endif
