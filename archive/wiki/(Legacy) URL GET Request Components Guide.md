# (Legacy) URL GET Request Components Guide

RexYuan edited this page on Sep 19 · 1 revision

### This guide is now obsolete because of the emergence of new method, but is archived for the sake of reference and potential future application
A URL for a course page info from 選課系統大綱 will look something like this:
```
http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?year=103&term=2&courseCode=01UG025&courseGroup=&deptCode=GU&formS=&classes1=&deptGroup
```
The first part(`http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl`) is the controller of course page info GET request, the second part seperated by the question mark is the actual GET request sent to that controller.
You will find below the detailed description for each and every part of the GET request.

1. year: School year.
2. term: Semester. '1' for the first and '2' for the second.
3. courseCode: Course code, the identifier of a course. Same for the same course, 7 chars total, with first 3 chars being the department code(consult abbr column in department.sql), the forth char being 'G' for general ed or a number(0~9) for others (? E for 教程 C for 碩班), last 3 chars are all numbers(000~999).
4. courseGroup: Indicator for different offers of a single course. Blank if course has only one offer, 1 char if course is offered differently depending on time or instructor, 1 char being a letter(A~Z).
5. deptCode: Department code(not to be confused with department abbreviation in courseCode). Same for courses under same department, 2 chars for general ed and 4 chars for others total, 2 chars for general ed being 'GU', 4 chars for others is random shits(consult code column department.sql db).
6. formS: The grade is course is intended for. Blank for general ed or not restricted, a number(1~4) for every grade(大一 => 1, 大二 => 2, 大三 => 3, 大四 => 4).
7. classes1: indicator for different offers for different classes of a single department of a single course, blank if course has only offer or for general ed, 1 char if course is offered to more that one class(班別), 1 char being a number(0~9) whichs corresponds to 天干地支(甲乙丙...).
8. deptGroup: department group/division for which course is intended, blank if department has only one group, a char if department is divided into more than one group, a char being a letter(A~Z), currently only 美術系 is divided into 2 groups(A/B).

p.s. 1: the combination is insurmountable if the approach is checking all possibilities: 9999(code) * 27(course group) * 5(grade) * 12(class) * 27(dept group) = 437356260.
