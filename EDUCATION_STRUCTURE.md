# Aspirian Student Platform — Education Structure

**Version:** 1.0
**Status:** Final Academic Structure Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the academic structure of the Aspirian Student Platform from:

> **Nursery → Class 12**

The structure is designed to support:

* Early education
* Primary education
* Middle education
* Secondary education
* Higher secondary education
* Multiple boards
* Multiple curricula
* Multiple academic sessions
* Multiple subjects
* Books
* Chapters
* Topics
* School sections
* Student progression
* Future academic expansion

---

# 2. Core Principle

Aspirian must not hard-code the education system around only one class range or one board.

The academic structure should be configurable.

```text
Education System
       ↓
Board / Curriculum
       ↓
Academic Session
       ↓
Education Level
       ↓
Class / Grade
       ↓
Subject
       ↓
Book
       ↓
Chapter
       ↓
Topic
```

---

# 3. Academic Range

The initial platform officially supports:

```text
Nursery
KG
Class 1
Class 2
Class 3
Class 4
Class 5
Class 6
Class 7
Class 8
Class 9
Class 10
Class 11
Class 12
```

This range is the initial academic foundation of the platform.

---

# 4. Education Levels

The platform groups classes into logical education levels.

Recommended structure:

```text
Early Education
    ├── Nursery
    └── KG

Primary Education
    ├── Class 1
    ├── Class 2
    ├── Class 3
    ├── Class 4
    └── Class 5

Middle Education
    ├── Class 6
    ├── Class 7
    └── Class 8

Secondary Education
    ├── Class 9
    └── Class 10

Higher Secondary Education
    ├── Class 11
    └── Class 12
```

---

# 5. Nursery

Nursery represents the initial structured learning stage.

Potential learning areas may include:

```text
Language Development
Basic Mathematics
General Knowledge
Drawing
Early Science Concepts
Social Skills
Creative Activities
Basic Computer Awareness
```

The exact curriculum may vary by institution.

---

# 6. KG

KG represents the next early-learning stage.

Potential learning areas may include:

```text
English
Urdu
Basic Mathematics
General Knowledge
Basic Science
Drawing
Computer Awareness
Creative Activities
```

The structure remains flexible for different curricula.

---

# 7. Primary Education

Primary education includes:

```text
Class 1
Class 2
Class 3
Class 4
Class 5
```

Typical subjects may include:

```text
English
Urdu
Mathematics
General Science
Computer
Islamiyat
Social Studies
```

Actual subjects must be determined by the selected board/curriculum.

---

# 8. Middle Education

Middle education includes:

```text
Class 6
Class 7
Class 8
```

Subjects may become more specialized.

Examples:

```text
English
Urdu
Mathematics
General Science
Computer Science
Social Studies
Islamiyat
```

Board-specific differences must be supported.

---

# 9. Secondary Education

Secondary education includes:

```text
Class 9
Class 10
```

At this level, subject structures may differ significantly between boards and study groups.

The platform must therefore support:

```text
Board
 ↓
Class
 ↓
Group / Stream
 ↓
Subjects
```

---

# 10. Higher Secondary Education

Higher secondary education includes:

```text
Class 11
Class 12
```

Students may follow different groups/streams.

Examples may include:

```text
Pre-Medical
Pre-Engineering
Computer Science
Humanities
Commerce
Other Board-Specific Groups
```

The platform must not permanently limit these groups to the examples above.

---

# 11. Academic Hierarchy

The complete hierarchy is:

```text
Education System
        │
        ▼
Board / Curriculum
        │
        ▼
Academic Session
        │
        ▼
Education Level
        │
        ▼
Class / Grade
        │
        ▼
Group / Stream
        │
        ▼
Subject
        │
        ▼
Book
        │
        ▼
Chapter
        │
        ▼
Topic
        │
        ▼
Learning Content
        │
        ▼
Questions / Tests / Revision
```

Not every level is mandatory for every class.

---

# 12. Board / Curriculum

Aspirian should support multiple boards and curricula.

The academic structure must therefore separate:

```text
Class
```

from:

```text
Board / Curriculum
```

For example:

```text
Class 9
   ├── Board A
   ├── Board B
   └── Board C
```

This prevents one board's curriculum from becoming the platform-wide default.

---

# 13. Academic Session

Academic content may change between sessions.

Example:

```text
2025–26
2026–27
2027–28
```

A curriculum should therefore be associated with an academic session where required.

```text
Board
   ↓
Academic Session
   ↓
Class
   ↓
Subjects
```

---

# 14. Class Identity

Every class should have a stable internal identifier.

Display names may be:

```text
Nursery
KG
Class 1
Class 2
...
Class 12
```

The internal system should use stable IDs rather than relying on display names.

---

# 15. Display Order

Classes should have an explicit display order.

Example:

```text
Nursery = 1
KG      = 2
Class 1 = 3
Class 2 = 4
...
Class 12 = 14
```

This allows the user interface to display classes correctly.

---

# 16. Class Progression

The normal academic progression is:

```text
Nursery
  ↓
KG
  ↓
Class 1
  ↓
Class 2
  ↓
Class 3
  ↓
Class 4
  ↓
Class 5
  ↓
Class 6
  ↓
Class 7
  ↓
Class 8
  ↓
Class 9
  ↓
Class 10
  ↓
Class 11
  ↓
Class 12
```

The platform should not automatically assume that every student follows this sequence without exceptions.

---

# 17. Student Academic Placement

A student's current academic placement may depend on:

```text
School
Board
Academic Session
Class
Section
Group / Stream
Subjects
```

Example:

```text
Student
 ↓
School
 ↓
Academic Session
 ↓
Class 10
 ↓
Section A
 ↓
Board / Curriculum
```

---

# 18. School Sections

Schools may divide a class into sections.

Example:

```text
Class 9
 ├── Section A
 ├── Section B
 └── Section C
```

A section is an institutional grouping and should not replace the global class entity.

---

# 19. Groups / Streams

Groups become especially important in higher classes.

Example:

```text
Class 11
 ├── Pre-Medical
 ├── Pre-Engineering
 ├── Computer Science
 ├── Humanities
 └── Commerce
```

The available groups depend on the selected board/curriculum.

---

# 20. Subject Structure

Subjects belong to a curriculum context.

Concept:

```text
Board
 ↓
Academic Session
 ↓
Class
 ↓
Subject
```

The same subject can therefore exist across different classes and boards.

---

# 21. Core vs Optional Subjects

The platform should support:

```text
Core Subject
Optional Subject
Elective Subject
Group Subject
```

Example:

```text
Class
 ├── Core Subjects
 └── Optional / Group Subjects
```

---

# 22. Subject Ordering

Subjects should have configurable display order.

Example:

```text
1. English
2. Urdu
3. Mathematics
4. Physics
5. Chemistry
```

The order may differ by curriculum.

---

# 23. Books

A subject may have one or more books.

```text
Subject
 ├── Book 1
 ├── Book 2
 └── Supplementary Material
```

Books should be associated with the correct:

```text
Board
Class
Subject
Academic Session
```

where applicable.

---

# 24. Chapters

Books contain chapters.

```text
Book
 ├── Chapter 1
 ├── Chapter 2
 ├── Chapter 3
 └── ...
```

Chapter numbering and titles should remain configurable.

---

# 25. Topics

Chapters can be divided into topics.

```text
Chapter
 ├── Topic 1
 ├── Topic 2
 ├── Topic 3
 └── ...
```

Topics provide a useful level for:

* Learning
* Practice
* Questions
* Revision
* AI tutoring
* Performance analysis

---

# 26. Learning Unit

The recommended smallest standard academic learning unit is:

```text
Topic
```

A topic may contain:

```text
Notes
Explanation
Examples
Images
Diagrams
Videos
Audio
Questions
Flashcards
Practice
```

---

# 27. Academic Content Mapping

All major educational content should be traceable to its academic context.

Example:

```text
Board
 ↓
Class
 ↓
Subject
 ↓
Book
 ↓
Chapter
 ↓
Topic
 ↓
Content
```

This allows students to discover relevant resources accurately.

---

# 28. Question Mapping

Questions should be mapped to academic structures.

Example:

```text
Question
 ↓
Topic
 ↓
Chapter
 ↓
Book
 ↓
Subject
 ↓
Class
 ↓
Board
```

This enables:

```text
Topic Tests
Chapter Tests
Subject Tests
Board-Specific Tests
```

---

# 29. Test Mapping

Tests may be associated with:

```text
Board
Class
Group
Subject
Book
Chapter
Topic
Academic Session
```

Not every test needs every association.

---

# 30. Revision Mapping

Revision should be connected to the student's academic context.

Example:

```text
Student
 ↓
Subject
 ↓
Chapter
 ↓
Topic
 ↓
Weak Area
 ↓
Revision
```

---

# 31. AI Academic Context

AI features should understand the student's academic context.

Example:

```text
Student
 ↓
Class 9
 ↓
Punjab Curriculum
 ↓
Biology
 ↓
Chapter 1
 ↓
Topic
```

The AI system can then generate contextually relevant assistance.

---

# 32. Academic Language

The platform should support multiple languages.

Potential languages:

```text
English
Urdu
Roman Urdu
```

Future languages may be added.

Language should be treated separately from academic classification.

---

# 33. Content Language

A single academic topic may have content in multiple languages.

Example:

```text
Topic
 ├── English Content
 ├── Urdu Content
 └── Roman Urdu Support
```

This prevents duplication of the underlying academic structure.

---

# 34. Curriculum Variations

Different boards may organize the same subject differently.

Example:

```text
Board A
 └── Biology
      ├── Chapter 1
      └── Chapter 2

Board B
 └── Biology
      ├── Unit 1
      └── Unit 2
```

The platform should preserve each curriculum's original structure.

---

# 35. Content Versioning

Academic content may change.

Therefore the system should support version-aware content.

Example:

```text
Biology
 ├── 2025–26 Curriculum
 └── 2026–27 Curriculum
```

Older content should remain available where historical records depend on it.

---

# 36. Academic Session Independence

A student's previous academic record must not be destroyed when they move to a new class.

Example:

```text
2025–26
Student → Class 9

2026–27
Student → Class 10
```

The previous enrollment remains part of the student's academic history.

---

# 37. Student Academic History

The platform should be able to represent:

```text
Student
 ├── Previous Classes
 ├── Current Class
 ├── Previous Sessions
 ├── Current Session
 ├── Previous Results
 └── Current Progress
```

---

# 38. School Academic Structure

A school may have:

```text
School
 ├── Academic Session
 │    ├── Class 1
 │    │    ├── Section A
 │    │    └── Section B
 │    │
 │    ├── Class 9
 │    │    ├── Section A
 │    │    └── Section B
 │    │
 │    └── Class 12
 │         ├── Group A
 │         └── Group B
```

---

# 39. Teacher Academic Structure

Teachers may be assigned:

```text
Teacher
 ↓
School
 ↓
Academic Session
 ↓
Class / Section
 ↓
Subject
```

A teacher may teach multiple classes or subjects.

---

# 40. Parent Academic View

Parents/guardians may receive authorized information about a student's:

```text
Current Class
Subjects
Progress
Tests
Results
Assignments
Revision
```

Access must be permission-controlled.

---

# 41. Public Academic Navigation

The public website may use the academic hierarchy for SEO and discovery.

Example:

```text
Class 9
 ↓
Biology
 ↓
Chapter 1
 ↓
Notes
 ↓
MCQs
 ↓
Test
```

This can connect `aspirian.pk` content with the student platform.

---

# 42. Platform Academic Navigation

The application may provide:

```text
Select Class
     ↓
Select Subject
     ↓
Select Chapter
     ↓
Select Topic
     ↓
Learn
Practice
Test
Revise
```

---

# 43. Academic Search

Users should be able to search by:

```text
Class
Subject
Chapter
Topic
Board
Academic Session
Content Type
Language
```

---

# 44. Academic Filters

The platform should support combinations such as:

```text
Class 9
+
Biology
+
Chapter 1
+
MCQs
```

or:

```text
Class 10
+
Mathematics
+
Board
+
Past Paper
```

---

# 45. Early Education Flexibility

Nursery and KG may not follow the same chapter/topic structure as secondary classes.

Therefore:

```text
Class
 ↓
Subject
 ↓
Learning Area
 ↓
Activity / Lesson
```

may be used where traditional books and chapters do not exist.

---

# 46. Primary Education Flexibility

Primary classes may use:

```text
Subject
 ↓
Book
 ↓
Chapter
 ↓
Topic
```

but the system must also support activity-based learning.

---

# 47. Secondary Education Flexibility

Secondary classes generally require stronger academic mapping.

```text
Board
 ↓
Class
 ↓
Group
 ↓
Subject
 ↓
Book
 ↓
Chapter
 ↓
Topic
```

This level should support detailed assessment mapping.

---

# 48. Higher Secondary Flexibility

Higher secondary education requires group/stream-aware subject mapping.

Example:

```text
Class 11
 ↓
Group
 ↓
Subjects
 ↓
Books
 ↓
Chapters
 ↓
Topics
```

---

# 49. Academic Completion

The platform's initial academic boundary is:

```text
START
Nursery
   ↓
...
   ↓
Class 12
END
```

This is the official initial product scope.

---

# 50. Future Academic Expansion

The architecture should allow future addition of:

```text
Pre-School
Vocational Education
Technical Education
Diploma Programs
College
University
Competitive Exams
Professional Certifications
International Curricula
```

These should be added without breaking the initial structure.

---

# 51. Competitive Examination Extension

Future competitive exam content may use a different hierarchy.

Example:

```text
Exam
 ↓
Subject
 ↓
Topic
 ↓
Question
```

Therefore the system should not force all future educational content into the school-class structure.

---

# 52. Technical Education Extension

Future technical education may use:

```text
Program
 ↓
Semester
 ↓
Course
 ↓
Module
 ↓
Topic
```

This is another reason the core platform must remain flexible.

---

# 53. Academic Structure Rules

The following rules are mandatory:

### Rule 1

Classes must not be hard-coded into application logic.

### Rule 2

Boards must be independent from classes.

### Rule 3

Academic sessions must support historical data.

### Rule 4

Subjects must be curriculum-aware.

### Rule 5

Groups/streams must be configurable.

### Rule 6

Sections must be institution-specific.

### Rule 7

Content should be traceable to its academic context.

### Rule 8

Future academic structures must be possible without redesigning the entire system.

---

# 54. Recommended Hierarchy

The canonical school-level hierarchy is:

```text
BOARD / CURRICULUM
        ↓
ACADEMIC SESSION
        ↓
EDUCATION LEVEL
        ↓
CLASS
        ↓
GROUP / STREAM
        ↓
SUBJECT
        ↓
BOOK
        ↓
CHAPTER
        ↓
TOPIC
        ↓
LEARNING CONTENT
```

Institutional layer:

```text
SCHOOL
 ↓
ACADEMIC SESSION
 ↓
CLASS / SECTION
 ↓
TEACHERS
 ↓
STUDENTS
```

---

# 55. Academic Data Separation

The platform should separate:

```text
Academic Structure
```

from:

```text
Student Enrollment
```

and:

```text
School Structure
```

This allows one academic curriculum to be used by multiple schools and thousands of students.

---

# 56. Example — Student Journey

Example student:

```text
Student
 ↓
School
 ↓
Academic Session 2026–27
 ↓
Class 9
 ↓
Board / Curriculum
 ↓
Biology
 ↓
Chapter 1
 ↓
Topic
 ↓
Learning
 ↓
Practice
 ↓
Test
 ↓
Result
 ↓
Revision
```

---

# 57. Example — Public Content Journey

```text
Google Search
 ↓
Aspirian.pk
 ↓
Class 9
 ↓
Biology
 ↓
Chapter 1
 ↓
Notes
 ↓
MCQs
 ↓
Student Platform
 ↓
Practice Test
```

This connects public SEO content with the application without making the two systems identical.

---

# 58. Example — Teacher Journey

```text
Teacher
 ↓
School
 ↓
Class 9
 ↓
Biology
 ↓
Chapter 1
 ↓
Question Bank
 ↓
Create Test
 ↓
Assign Test
 ↓
Student Attempts
 ↓
Results
```

---

# 59. Example — AI Learning Journey

```text
Student
 ↓
Class 9
 ↓
Biology
 ↓
Chapter 1
 ↓
AI Tutor
 ↓
Explanation
 ↓
Practice Questions
 ↓
Weakness Detection
 ↓
Revision Plan
```

---

# 60. Final Academic Structure

The Aspirian Student Platform officially begins with:

```text
Nursery
 ↓
KG
 ↓
Class 1
 ↓
Class 2
 ↓
Class 3
 ↓
Class 4
 ↓
Class 5
 ↓
Class 6
 ↓
Class 7
 ↓
Class 8
 ↓
Class 9
 ↓
Class 10
 ↓
Class 11
 ↓
Class 12
```

Supported by:

```text
Multiple Boards
Multiple Curricula
Multiple Academic Sessions
Multiple Languages
Multiple Groups / Streams
School Sections
Student History
Teacher Assignments
AI Learning
Assessment
Revision
```

---

# 61. Final Principle

The Aspirian academic structure must be:

> **Nursery-to-Class-12 complete, curriculum-aware, board-flexible, session-aware, student-centered, and extensible for future education systems.**

The platform should never be architecturally limited to a single board, single curriculum, or single academic model.

---

# 62. Document Status

**File:** `EDUCATION_STRUCTURE.md`
**Phase:** C
**Module:** C1 — Education Structure

**File:** `EDUCATION_STRUCTURE.md`
**Version:** 1.0
**Status:** Final Academic Structure Blueprint
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official academic hierarchy for the initial Aspirian Student Platform.

Detailed database tables and implementation rules remain part of `DATABASE.md`.
