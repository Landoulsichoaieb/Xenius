<!DOCTYPE html>
<html>
<head>
    <title>CV</title>
    <style>
        /* Add your CSS styling here */
    </style>
</head>
<body>
    <div class="cv-container">
        <h1>Curriculum Vitae</h1>

        <h2>{{ $cv->firstname }} {{ $cv->lastname }}</h2>
        <p><strong>Email:</strong> {{ $cv->email }}</p>
        <p><strong>Phone:</strong> {{ $cv->phone }}</p>

        <h3>About Me</h3>
        <p>{{ $cv->about }}</p>

        <h3>Experience</h3>
        <p>{{ $cv->experience }}</p>

        <h3>Skills</h3>
        <p>{{ $cv->skills }}</p>
    </div>
</body>
</html>
