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
    public array $courses = [];

    public function __construct($studentsInfo, $coursesInfo) {
        $this->setStudents($studentsInfo);
        $this->setScores($coursesInfo);
    }

    public function setStudents($studentsInfo) {
        $studentsInfo = explode(';', $studentsInfo);
        foreach ($studentsInfo as $info) {
            $info = explode(',', $info);
            if (!isset($this->students[$info[0]])) {
                $this->students[$info[0]] = new Student($info[0]);
            }
            $this->students[$info[0]]->addCourse($info[1], $info[2]);
        }
    }

    public function setScores($coursesInfo) {
        $coursesInfo = explode(';', $coursesInfo);
        foreach ($coursesInfo as $info) {
            $info = explode(',', $info);
            $this->courses[$info[0]] = $info[1];
        }
    }

    public function coursesWithDuty(): array {
        $coursesWithoutDuty = $this->courses;
        foreach ($this->students as $student) {
            foreach ($student->courses as $st_course => $st_grade) {
                if (isset($coursesWithoutDuty[$st_course]) && $st_grade < $this->courses[$st_course]) {
                    unset($coursesWithoutDuty[$st_course]);
                }
            }
        }
        return $coursesWithoutDuty;
    }
    public function coursesWithDutyForOutput() {
        $coursesWithoutDuty = $this->coursesWithDuty();
        if ($coursesWithoutDuty) {
            return implode('<br>', array_keys($coursesWithoutDuty));
        } else {
            return 'Пусто';
        }
    }
}

// ваш код
$infos = [];
$infos[] = [
    'studentsInfo' => 'Анна,Математика,85;Анна,Химия,90;Борис,Математика,75;Борис,История,80;Евгений,Математика,95',
    'coursesInfo' => 'Математика,80;Химия,60;История,80',
];
$infos[] = [
    'studentsInfo' => 'Анна,Математика,75;Анна,Химия,70;Борис,История,80;Евгений,Математика,50;Евгений,История,75',
    'coursesInfo' => 'Математика,80;Химия,90;История,90',
];
foreach ($infos as $key=>$info) {
    echo '<h1>Тест #'.$key.'</h1>';
    echo '<h2>Входные данные: </h2><p>'.$info['studentsInfo'].'</p><p>'.$info['coursesInfo'].'</p>';
    $cm = new CourseManager($info['studentsInfo'], $info['coursesInfo']);
    echo '<h2>Выходные данные: </h2>'. $cm->coursesWithDutyForOutput();
    echo '<hr>';
}
