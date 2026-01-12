# Project Description
in this project we are going to create a student management system using laravel filament.its just a small project to understand the working of file generation such as `.pdf`,`.xls`,`.csv`. and also understand the `theme customization` of filament.

# Table of Contents

- [Installations](#installations)
- [Migrate](#migrate)
- [Create Filament user](#create-filament-user)
- [Create Models](#create-models)
- [Create SeederFile](#create-seederfile)
- [Run Seeder](#run-seeder)
- [Create Filament Resource](#create-filament-resource)
- [Understand the Model](#understand-the-model)
- [Relation Manager](#relation-manager)
- [Export CSV FILE](#export-csv-file)
- [Export PDF FILE](#export-pdf-file)
- [Show Enrolled and Completed Numbers in Table](#show-enrolled-and-completed-numbers-in-table)

# Installations 

## Install Laravel
```
laravel new laravel_filament_self_project_2
```

## Install Filament
```
composer require filament/filament:"^4.0"

php artisan filament:install --panels
```

## Migrate
```
php artisan migrate
```

## Create Filament user
```
php artisan make:filament-user
```
- give credentaials such as 
```
Email: admin@gmail.com
Password: 12345678
```

## Create Models 
```
php artisan make:model Student -m
php artisan make:model Course -m
```
add relation and fillable property in each model.
go to `Course.php` file and add the below code.
```
protected $fillable = [
        'title',
        'description',
        'duration',
    ];
public function students():BelongsToMany
    {
        return $this->belongsToMany(Student::class,'course_student')->withPivot(['status', 'completed_at'])->withTimestamps();
    }
```
go to `Student.php` file and add the below code.
```
 protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class,'course_student','student_id','course_id')->withPivot(['status', 'completed_at'])->withTimestamps();
    }
```
[📌More Details](#understand-the-model)

## Create SeederFile
```
php artisan make:seeder StudentSeeder
php artisan make:seeder CourseSeeder
```
- in the `StudentSeeder.php` file we are creating the three students.
```
 public function run(): void
    {
        Student::create([
            "name"=> "Ranit Nath",
            "email"=> "ranit@gmail.com",
            "phone"=> "1234567890",
            "address"=> "123 Main St",
        ]);
        Student::create([
            "name"=> "Pradipta Das",
            "email"=> "pradipta@gmail.com",
            "phone"=> "7845987451",
            "address"=> "Rathtala , Badamtala.",
        ]);
        Student::create([
            "name"=> "Subhankar Nath",
            "email"=> "subhankar@gmail.com",
            "phone"=> "8745963210",
            "address"=> "91 AB Road , Rathtala , Badamtala.",
        ]);
    }
```

- in the `CourseSeeder.php` file we are creating the three Courses.
```
 public function run(): void
    {
       Course::create([
            "title"=> "PHP",
            "description"=> "PHP is a server scripting language and a powerful tool for making dynamic and interactive websites.",
            "duration"=> "2 months",
        ]);
        Course::create([
            "title"=> "Laravel",
            "description"=> "Laravel is a web application framework with a focus on developer experience and a fast development cycle.",
            "duration"=> "3 months",
        ]);
        Course::create([
            "title"=> "Python",
            "description"=> "Python is a high-level, general-purpose programming language.",
            "duration"=> "4 months",
        ]);
    }
```

## Run Seeder
```
php artisan db:seed
```
inside `DatabaseSeeder.php` file we are write the below lines of code inside `run` function.
```
 $this->call([
            CourseSeeder::class,
            StudentSeeder::class
        ]);
```

## Create Filament Resource
```
php artisan make:filament-resource Course --generate --view
php artisan make:filament-resource Student --generate --view
```
the above command will create a resource file in the `app/Filament/Resources` directory.here we create two Resource so thats why its create two folders `Course` and `Student`.


# Understand the Model

## Tables
here we use three tables 
- students table contains `name,email,phone,address`.
- courses table contains `title,description,duration`.
- course_student ( ⭐ pivot table) contains `student_id,course_id,status,completed_at`.

## Models
- Student
- Course

## RelationShip
here both are `Many to Many` Relationship. beacuse , a Student has many courses and a Course has many students.
so , `Course ↔ Student`

## What is a Pivot Table?
A pivot table is a database table used to connect two tables that have a `many-to-many` relationship.

Example:

One Student can enroll in many Courses.

One Course can have many Students.

Because both sides are “many”, we cannot store this using a normal foreign key.

Solution 👉 `Pivot Table`

Table Structure:
- students
- courses
- course_student   ← **pivot table**

⭐⭐Pivot Table Connects students and courses and also Stores extra information about the relationship.

## Why do we use `BelongsToMany`?
We use `BelongsToMany` when:

A model is related to many records of another model

AND the other model is also related to many records back

Example:
- Student ↔ Course
- User ↔ Role
- Product ↔ Order

This is called a `many-to-many relationship`.

## Syntax

```
return $this->belongsToMany(
    RelatedModel::class,   // Related model
    'pivot_table_name',    // Pivot table
    'this_model_id',       // Foreign key of current model
    'related_model_id'     // Foreign key of related model
)
->withPivot(['column1', 'column2'])
->withTimestamps();
```

See Model Portition of this project. [📌Click here](#create-models)

# Relation Manager
- we are create a relation manager for both resourses. 
- Relation managers are interactive tables that allow administrators to list, create, attach, associate, edit, detach, dissociate and delete related records without leaving the resource’s Edit or View page.

## Course Relation Manager
```
👉 php artisan make:filament-relation-manager 

Which resource would you like to create this relation manager in?
❯ Courses

What is the relationship?
❯ students

Linking to an existing resource will open the resource's pages instead of modals when links are clicked. It will also inherit the resource's configuration.

Do you want to link this to an existing resource? (yes/no) [no]
❯ no

Should there be a read-only "view" modal on the relation manager? (yes/no) [no]
❯ yes

Should the configuration be generated from the current database columns? (yes/no) [no]
❯ yes

The "title attribute" is used to label each record in the UI.

What is the title attribute for this model?
❯ name

INFO  Filament relation manager [App\Filament\Resources\Courses\RelationManagers\StudentsRelationManager] created successfully.

INFO  Make sure to register the relation in [App\Filament\Resources\Courses\CourseResource::getRelations()].
```
then register the relation manager in `CourseResource.php` file.
open `CourseResource.php` file and add the below code in the `getRelations()` method.
```
public static function getRelations(): array
    {
        return [
           StudentsRelationManager::class // 👈👈 Register the Relation Manager
        ];
    }
```
same way create Student Relation Manager.👇👇

## Student Relation Manager
```
👉 php artisan make:filament-relation-manager

Which resource would you like to create this relation manager in?
❯ Students

What is the relationship?
❯ courses

Linking to an existing resource will open the resource's pages instead of modals when links are clicked. It will also inherit the resource's configuration.

Do you want to link this to an existing resource? (yes/no) [no]
❯ no

Should there be a read-only "view" modal on the relation manager? (yes/no) [no]
❯ yes

Should the configuration be generated from the current database columns? (yes/no) [no]
❯ yes

The "title attribute" is used to label each record in the UI.

What is the title attribute for this model?
❯ name

INFO  Filament relation manager [App\Filament\Resources\Students\RelationManagers\CoursesRelationManager] created successfully.

INFO  Make sure to register the relation in [App\Filament\Resources\Students\StudentResource::getRelations()].
```
then register the relation manager in `StudentResource.php` file.
open `StudentResource.php` file and add the below code in the `getRelations()` method.
```
public static function getRelations(): array
    {
        return [
           CoursesRelationManager::class // 👈👈 Register the Relation Manager
        ];
    }
```

## Sturucture of Relation Manager
A relation manager contains 4 importans parts.
1. **$relationship** : it is the relationship between the two models.
2. **$table** : it is the table that will be displayed in the relation manager.
3. **$form** : it is the form for (edit/create) that will be displayed in the relation manager.
4. **$infolists** : it is the infolist that will be displayed in the relation manager.


# Export CSV FILE
here we are export all the students data to a csv file and we can saved locally.
- Don't Installing any package. ❌
- without queue ❌
- Simple and Easy ✅

## Steps
- 1. Open 📄app\Filament\Resources\Students\Tables\StudentsTable.php file
- 2. Go to the `headerActions` method and add a action button withthe below code
```
Action::make('export_csv')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {

                   return response()->streamDownload(function () {

                        $handle = fopen('php://output', 'w');

                        // CSV header
                        fputcsv($handle, ['Name', 'Email', 'Phone', 'Address']);

                        // Data
                        Student::chunk(100, function ($students) use ($handle) {
                            foreach ($students as $student) {
                                fputcsv($handle, [
                                    $student->name,
                                    $student->email,
                                    $student->phone,
                                    $student->address,
                                ]);
                            }
                        });

                        fclose($handle);

                    }, 'students.csv');
                }),
```


# Export PDF FILE
here we create a course certificate for students who are completed their course successfully.
**`conditions`** : `status = completed`

## Install `domPdf` pacakge
```
composer require barryvdh/laravel-dompdf
```
## create a Controller file
```
php artisan make:controller CertificateController
```
inside controller create a `download()` function and paste the below code.
```
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
```

## create a view/template file for pdf
```
php artisan make:view certificates/course
```
paste the below code in the view file.
```
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

```

## create a route for pdf
```
Route::get('/certificate/{course}/{student}', [CertificateController::class, 'download'])->name('certificate.download');
```

## craete a button view 
```
php artisan make:view filament/tables/certificate-button
```
and paste the below code inside the view file.
```
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
```

## create a buuton in relation manager.
- open app\Filament\Resources\Students\RelationManagers\CoursesRelationManager.php file and add a column for button inside `table()` method.
```
ViewColumn::make('certificate')
                    ->label('Certificate')
                    ->view('filament.tables.certificate-button')
                    ->disabledClick(),
```
⭐⭐ if we do not use `disabledClick()` then the button will be `clickable` but it will not work❌. beacuse of Action buttons ⭐⭐


# Show Enrolled and Completed Numbers in Table
go to CoursesTable.php file and add the below code inside `table()` method and `before` the `columns([])`.
```
->modifyQueryUsing(fn (Builder $query): Builder => 
                    $query->withCount([
                        'students as enrolled_count' => function ($q) {
                            $q->where('course_student.status', 'enrolled');  // ← use FULL table.column
                        },
                        'students as completed_count' => function ($q) {
                            $q->where('course_student.status', 'completed');
                        },
                    ])
                )
```
like that
```
 public static function configure(Table $table): Table
    {
        return $table
                ->modifyQueryUsing(fn (Builder $query): Builder => 
                    $query->withCount([
                        'students as enrolled_count' => function ($q) {
                            $q->where('course_student.status', 'enrolled');  // ← use FULL table.column
                        },
                        'students as completed_count' => function ($q) {
                            $q->where('course_student.status', 'completed');
                        },
                    ])
                )
            ->columns([ 

            .....

            TextColumn::make('enrolled_count')
                ->label('Enrolled Students')
                ->badge()
                ->color('warning')
                ->sortable(false)->alignCenter(),

            TextColumn::make('completed_count')
                ->label('Completed Students')
                ->badge()
                ->color('success')
                ->sortable(false)->alignCenter(),
            .....

            ])
            ....
            ....
    }
```