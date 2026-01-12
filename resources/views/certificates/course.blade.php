<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            text-align: center;
            font-family: DejaVu Sans;
        }
        .box {
            border: 10px solid #0f766e;
            padding: 40px;
        }
        h1 { font-size: 42px; }
        h2 { margin-top: 20px; }
    </style>
</head>
<body>

<div class="box">
    <h1>Certificate of Completion</h1>

    <p>This is to certify that</p>

    <h2>{{ $student->name }}</h2>

    <p>has successfully completed the course</p>

    <h2>{{ $course->title }}</h2>

    <p>Duration: {{ $course->duration }}</p>

    <p>Date: {{ $date }}</p>
</div>

</body>
</html>
