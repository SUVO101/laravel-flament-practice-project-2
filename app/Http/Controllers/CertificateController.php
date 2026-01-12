<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
     public function download(Course $course, Student $student)
    {
        // optional: security check
        if (
            ! $course->students()
                ->where('student_id', $student->id)
                ->wherePivot('status', 'completed')
                ->exists()
        ) {
            abort(403);
        }

        $pdf = Pdf::loadView('certificates.course', [
            'course' => $course,
            'student' => $student,
            'date' => now()->format('d M Y'),
        ]);

        return $pdf->download(
            'certificate-'.$student->name.'.pdf'
        );
    }
}
