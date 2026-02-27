<?php
class Student {
    public string $name;
    public array $courses;
    public function __construct(string $name) {
        $this->name = $name;
    }
    public function addCourse(string $name, $grade) {
        $this->courses[$name] = $grade;
    }

}
class CourseManager {

    public array $students = [];

    public function getCourses($studentsInfo, $scoresInfo) {
        $studentsInfo = explode(';', $studentsInfo);
        foreach ($studentsInfo as $info) {
            $info = explode(',', $info);
            if (!isset($this->students[$info[0]])) {
                $this->students[$info[0]] = new Student($info[0]);
            }
            $this->students[$info[0]]->addCourse($info[1], $info[2]);
        }
    }
}

// ваш код
$studentsInfo = trim(fgets(STDIN));
$scoresInfo = trim(fgets(STDIN));


