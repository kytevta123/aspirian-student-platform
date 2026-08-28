# Aspirian Student Platform — Assessment Model

**Version:** 1.0
**Status:** Final Assessment Data Model Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the domain-level assessment model for the Aspirian Student Platform.

The Assessment system manages:

* Tests
* Exams
* Quizzes
* Practice tests
* Chapter tests
* Topic tests
* Subject tests
* Mock exams
* School assessments
* Board-style assessments
* Student attempts
* Question selection
* Scoring
* Results
* Assessment configuration
* Assessment lifecycle

The model is designed to support learners from:

> **Nursery → Class 12**

and remain extensible for future competitive exams and professional learning programs.

---

# 2. Assessment Philosophy

An assessment should be treated as a structured academic activity that uses reusable questions from the Question Bank.

```text
QUESTION BANK
      ↓
ASSESSMENT
      ↓
QUESTIONS
      ↓
STUDENT ATTEMPT
      ↓
EVALUATION
      ↓
RESULT
      ↓
PERFORMANCE ANALYSIS
```

The same question may be reused across multiple assessments.

---

# 3. Core Assessment Entity

The central entity is:

```text
ASSESSMENT
```

Conceptual attributes:

```text
id
title
description
assessment_type
status
visibility
duration
total_marks
passing_marks
created_by
created_at
updated_at
```

Exact database implementation belongs to `DATABASE.md`.

---

# 4. Assessment Types

The platform should support the following initial assessment types:

```text
PRACTICE
QUIZ
TOPIC_TEST
CHAPTER_TEST
SUBJECT_TEST
CLASS_TEST
MIDTERM
FINAL_EXAM
MOCK_EXAM
BOARD_STYLE_EXAM
SCHOOL_EXAM
```

Future types may be added without changing the core model.

---

# 5. Practice Assessment

A practice assessment is designed primarily for learning.

Example:

```text
Class 9
 ↓
Biology
 ↓
Chapter 1
 ↓
Practice Test
```

Practice tests may provide immediate feedback and explanations.

---

# 6. Quiz

A quiz is generally a short assessment.

Example:

```text
Topic
 ↓
10 Questions
 ↓
Quiz
 ↓
Immediate Result
```

Quizzes may be used inside lessons or as independent activities.

---

# 7. Topic Test

A topic test evaluates a specific topic.

```text
Subject
 ↓
Chapter
 ↓
Topic
 ↓
Assessment
```

---

# 8. Chapter Test

A chapter test evaluates content from one chapter.

Example:

```text
Class 9 Biology
 ↓
Chapter 1
 ↓
Chapter Test
```

Questions should be selected according to the chapter's academic mapping.

---

# 9. Subject Test

A subject test may cover multiple chapters.

```text
Subject
 ├── Chapter 1
 ├── Chapter 2
 ├── Chapter 3
 └── Chapter 4
       ↓
   Subject Test
```

---

# 10. Class Test

A class test is associated with a particular academic class and may be created by a teacher or school.

Example:

```text
School
 ↓
Class 9
 ↓
Section A
 ↓
Teacher
 ↓
Class Test
```

---

# 11. Midterm Examination

A midterm assessment evaluates a defined portion of the academic curriculum.

```text
Academic Session
 ↓
Class
 ↓
Subject
 ↓
Midterm
```

---

# 12. Final Examination

A final examination may cover a larger portion or the full curriculum.

```text
Academic Session
 ↓
Class
 ↓
Subject / Group
 ↓
Final Examination
```

---

# 13. Mock Examination

A mock exam simulates an actual examination.

It may include:

* Fixed duration
* Fixed marks
* Question sections
* Negative marking
* Randomization
* Exam-style instructions

---

# 14. Board-Style Assessment

A board-style assessment can simulate examination patterns used by educational boards.

It should support:

```text
Board
 ↓
Class
 ↓
Subject
 ↓
Paper Pattern
 ↓
Assessment
```

Board-specific rules should remain configurable.

---

# 15. School Examination

A school examination is owned or administered by a specific institution.

```text
School
 ↓
Academic Session
 ↓
Exam
 ↓
Students
```

School assessments must remain isolated from other schools unless explicitly shared.

---

# 16. Assessment Ownership

An assessment may belong to:

```text
PLATFORM
SCHOOL
TEACHER
USER
```

Example:

```text
Platform
 └── Public Mock Test

School
 └── Annual Exam

Teacher
 └── Weekly Biology Test
```

---

# 17. Assessment Creator

The creator may be:

```text
Teacher
School Admin
Platform Admin
Authorized Content Team
System / AI
```

The creator should be recorded.

---

# 18. Assessment Status

Initial lifecycle states:

```text
DRAFT
REVIEW
SCHEDULED
PUBLISHED
ACTIVE
COMPLETED
ARCHIVED
CANCELLED
```

The exact state transitions should be enforced by the application.

---

# 19. Assessment Lifecycle

Typical lifecycle:

```text
DRAFT
  ↓
REVIEW
  ↓
PUBLISHED
  ↓
SCHEDULED
  ↓
ACTIVE
  ↓
COMPLETED
  ↓
ARCHIVED
```

Not every assessment must use every state.

---

# 20. Assessment Visibility

Possible visibility:

```text
PRIVATE
CLASS
SCHOOL
PLATFORM
PUBLIC
```

Visibility must always work together with authorization.

---

# 21. Academic Mapping

An assessment may be mapped to:

```text
Board / Curriculum
Academic Session
Class
Group / Stream
Subject
Book
Chapter
Topic
```

Not every field is mandatory for every assessment type.

---

# 22. Nursery → Primary Support

Early-grade assessments may use:

```text
Class
Learning Area
Lesson / Activity
```

rather than requiring a formal chapter structure.

---

# 23. Secondary Assessment Structure

For secondary classes:

```text
Board
 ↓
Class
 ↓
Group
 ↓
Subject
 ↓
Chapter / Topic
 ↓
Assessment
```

---

# 24. Higher Secondary Assessment Structure

For Classes 11–12:

```text
Board
 ↓
Class
 ↓
Group / Stream
 ↓
Subject
 ↓
Assessment
```

Example:

```text
Class 11
 ↓
Pre-Medical
 ↓
Biology
 ↓
Assessment
```

---

# 25. Assessment Questions

An assessment contains references to questions.

```text
ASSESSMENT
     ↓
ASSESSMENT QUESTION
     ↓
QUESTION BANK QUESTION
```

Questions should not normally be copied into a new question record.

---

# 26. Assessment Question Entity

The relationship between an assessment and a question may contain:

```text
assessment_id
question_id
display_order
section
marks
negative_marks
required
```

This allows the same question to behave differently in different assessments.

---

# 27. Question Ordering

Questions may be presented in:

```text
FIXED_ORDER
RANDOM_ORDER
```

Randomization should be configurable.

---

# 28. Option Randomization

For MCQs, answer options may optionally be randomized.

```text
Question
 ├── A
 ├── B
 ├── C
 └── D
```

The student's displayed order should be preserved in the attempt record when required for reliable result interpretation.

---

# 29. Question Pools

An assessment may use a larger question pool.

Example:

```text
Question Pool = 100
Questions Presented = 30
```

The system selects the required number according to defined rules.

---

# 30. Fixed Question Assessment

Some exams require a fixed set of questions.

```text
Assessment
 ↓
Question 1
Question 2
Question 3
...
```

No random selection is required.

---

# 31. Random Question Assessment

Practice tests may randomly select questions from a pool.

Possible rules:

```text
Number of Questions
Difficulty
Topic
Chapter
Question Type
```

---

# 32. Difficulty Distribution

An assessment may define a difficulty distribution.

Example:

```text
Easy     → 40%
Medium   → 40%
Hard     → 20%
```

The Question Bank supplies matching questions.

---

# 33. Question Type Distribution

An assessment may define question-type distribution.

Example:

```text
MCQ              → 20
Short Answer     → 5
Long Answer      → 3
```

---

# 34. Assessment Sections

An assessment may contain multiple sections.

Example:

```text
Assessment
 ├── Section A — MCQs
 ├── Section B — Short Questions
 └── Section C — Long Questions
```

Each section may have its own rules.

---

# 35. Section Model

Conceptual attributes:

```text
id
assessment_id
title
description
display_order
marks
instructions
```

---

# 36. Section Rules

A section may define:

```text
Number of Questions
Attempt Limit
Marks
Negative Marks
Question Type
Time Limit
```

depending on assessment requirements.

---

# 37. Total Questions

The assessment should define the expected number of questions.

Example:

```text
Total Questions = 50
```

For pool-based assessments:

```text
Pool = 100
Presented = 50
```

---

# 38. Total Marks

Total marks may be calculated from assessment questions.

Example:

```text
Question 1 = 1
Question 2 = 1
Question 3 = 2
...
```

The assessment total should remain consistent with its question configuration.

---

# 39. Passing Marks

An assessment may define:

```text
passing_marks
```

Example:

```text
Total Marks = 100
Passing Marks = 40
```

Some practice assessments may not require passing marks.

---

# 40. Passing Percentage

Alternatively, passing may be percentage-based.

Example:

```text
Passing Percentage = 40%
```

The assessment configuration should support both marks and percentage rules where necessary.

---

# 41. Grading

Assessments may produce:

```text
Marks
Percentage
Grade
Pass / Fail
Rank
Percentile
```

depending on assessment type.

---

# 42. Grading Rules

Grading should be configurable.

Example:

```text
90–100 → A+
80–89  → A
70–79  → B
60–69  → C
50–59  → D
Below 50 → F
```

The exact grading scale should not be hard-coded globally.

---

# 43. Negative Marking

Assessments may support negative marking.

Example:

```text
Correct = +1
Incorrect = -0.25
Unattempted = 0
```

Negative marking should be configurable per assessment or section.

---

# 44. Time Limit

An assessment may have a duration.

Example:

```text
Duration = 60 minutes
```

The system should enforce server-side timing rules where required.

---

# 45. Start Time

Scheduled assessments may define:

```text
start_at
```

Students should not normally begin before the configured availability window.

---

# 46. End Time

Scheduled assessments may define:

```text
end_at
```

After the assessment closes, new attempts should not normally begin.

---

# 47. Availability Window

An assessment may define:

```text
Available From
Available Until
```

This is useful for:

* School tests
* Scheduled quizzes
* Mock exams
* Assignments

---

# 48. Attempt Limit

An assessment may allow:

```text
1 Attempt
2 Attempts
Unlimited Attempts
```

depending on the assessment type.

---

# 49. Best Attempt

For repeated practice, the platform may calculate:

```text
Best Score
Latest Score
Average Score
First Score
```

The selected result policy should be assessment-specific.

---

# 50. Student Attempt

A student attempt represents one actual attempt at an assessment.

```text
STUDENT
   ↓
ASSESSMENT ATTEMPT
   ↓
ATTEMPT QUESTIONS
   ↓
ANSWERS
   ↓
EVALUATION
   ↓
RESULT
```

---

# 51. Attempt Status

Possible states:

```text
NOT_STARTED
IN_PROGRESS
SUBMITTED
AUTO_SUBMITTED
EVALUATING
EVALUATED
ABANDONED
CANCELLED
```

---

# 52. Attempt Timing

An attempt may store:

```text
started_at
submitted_at
time_spent
```

The server should remain the authoritative source for assessment timing.

---

# 53. Attempt Question

Each presented question should have an attempt-level record where necessary.

Concept:

```text
Attempt
 ↓
Attempt Question
 ↓
Question
```

This supports:

* Selected options
* Answer state
* Question order
* Time spent
* Marks

---

# 54. Student Answer

For an MCQ:

```text
Attempt Question
 ↓
Selected Option
```

For text-based questions:

```text
Attempt Question
 ↓
Submitted Answer
```

---

# 55. Answer Status

Possible states:

```text
UNANSWERED
ANSWERED
MARKED_FOR_REVIEW
SKIPPED
```

---

# 56. Question Navigation

During an assessment, students may navigate between questions.

Possible controls:

```text
Next
Previous
Jump to Question
Mark for Review
Clear Answer
```

The navigation layer should not alter the underlying question bank.

---

# 57. Auto-Save

For active online assessments, answers should be saved progressively where appropriate.

Concept:

```text
Student Answer
      ↓
Auto Save
      ↓
Server
```

This reduces data loss caused by:

* Browser refresh
* Connection interruption
* Device failure

---

# 58. Auto Submission

The system may automatically submit an attempt when:

```text
Time Limit Expires
Assessment Window Closes
```

The final behavior must be explicitly configured.

---

# 59. Evaluation

Evaluation may be:

```text
AUTOMATIC
MANUAL
AI_ASSISTED
HYBRID
```

---

# 60. Automatic Evaluation

Suitable for:

```text
MCQ
True / False
Numeric
Some Fill-in-the-Blank
```

according to configured rules.

---

# 61. Manual Evaluation

Suitable for:

```text
Short Answer
Long Answer
Essay
Subjective Questions
```

Teachers or authorized evaluators may assign marks.

---

# 62. AI-Assisted Evaluation

AI may provide:

```text
Suggested Marks
Feedback
Concept Detection
Mistake Identification
Improvement Suggestions
```

AI output should be treated according to the assessment's configured evaluation policy.

---

# 63. Evaluation Authority

The system should distinguish:

```text
AI Suggested Result
```

from:

```text
Final Official Result
```

This is particularly important for formal school examinations.

---

# 64. Result

A result represents the evaluated outcome of an attempt.

Possible data:

```text
attempt_id
marks_obtained
total_marks
percentage
grade
pass_status
completed_at
```

---

# 65. Result Status

Possible states:

```text
PENDING
PROVISIONAL
FINAL
REVISED
CANCELLED
```

---

# 66. Result Publication

Results may be:

```text
PRIVATE
VISIBLE_TO_STUDENT
VISIBLE_TO_PARENT
VISIBLE_TO_TEACHER
VISIBLE_TO_SCHOOL
PUBLISHED
```

Access must respect authorization.

---

# 67. Student Result

Students may view:

```text
Score
Percentage
Grade
Correct Answers
Incorrect Answers
Skipped Questions
Time Taken
Explanations
Weak Topics
```

depending on assessment settings.

---

# 68. Parent Result Access

Authorized parents may view permitted academic results of linked students.

```text
Parent
 ↓
Authorized Child
 ↓
Assessment Result
```

---

# 69. Teacher Result Access

Teachers may view results for assessments they are authorized to manage.

```text
Teacher
 ↓
Assigned Class / Subject
 ↓
Assessment
 ↓
Student Results
```

---

# 70. School Result Access

School administrators may view authorized school-level assessment data.

```text
School Admin
 ↓
School
 ↓
Assessment
 ↓
Students
 ↓
Results
```

---

# 71. Performance Analytics

Assessment results can contribute to:

```text
Student Performance
Subject Performance
Chapter Performance
Topic Performance
Class Performance
School Performance
```

---

# 72. Student Analytics

Example:

```text
Student
 ↓
Assessment Results
 ↓
Performance Analysis
 ↓
Weak Topics
 ↓
Revision Recommendations
```

---

# 73. Topic Analytics

The system may calculate:

```text
Topic Accuracy
Attempts
Average Score
Difficulty
```

This supports targeted learning.

---

# 74. Class Analytics

Teachers may view aggregated information such as:

```text
Class Average
Highest Score
Lowest Score
Question Accuracy
Topic Performance
```

Individual student information must remain access-controlled.

---

# 75. School Analytics

Authorized school administrators may view:

```text
Average Performance
Class Comparisons
Subject Performance
Assessment Participation
```

School-to-school comparison should only be available where explicitly permitted.

---

# 76. Assessment Participation

The system may track:

```text
Invited Students
Started
Completed
Submitted
Not Attempted
```

---

# 77. Assessment Assignment

An assessment may be assigned to:

```text
Individual Student
Class
Section
Group
School
Public Audience
```

Assignment rules should be separate from the core assessment definition.

---

# 78. Assessment Audience

Possible audience:

```text
PRIVATE
SELECTED_STUDENTS
CLASS
SECTION
SCHOOL
PLATFORM_USERS
PUBLIC
```

---

# 79. Assessment Instructions

An assessment may contain:

```text
Instructions
Rules
Time Limit
Passing Criteria
Negative Marking Rules
Allowed Attempts
```

Students should see these before starting.

---

# 80. Assessment Resources

An assessment may optionally reference:

```text
Notes
Lessons
Videos
Documents
Study Material
```

This is particularly useful for practice assessments.

---

# 81. Practice Feedback

Practice assessments may show feedback immediately.

Example:

```text
Answer
 ↓
Correct / Incorrect
 ↓
Explanation
 ↓
Next Question
```

Formal exams may delay feedback until submission.

---

# 82. Exam Security

Formal assessments may require additional controls:

```text
Attempt Limits
Time Enforcement
Question Randomization
Option Randomization
Access Restrictions
Server-Side Validation
Audit Logging
```

Advanced proctoring should remain a future capability unless explicitly required.

---

# 83. Question Leakage Protection

The platform should reduce unauthorized exposure of private examination questions.

Potential protections:

```text
Access Control
Limited API Exposure
No Unauthorized Export
Question Pool Security
Exam-Specific Permissions
```

---

# 84. Assessment Audit Trail

Important events should be auditable.

Examples:

```text
Assessment Created
Assessment Edited
Question Added
Question Removed
Assessment Published
Assessment Scheduled
Attempt Started
Answer Submitted
Attempt Submitted
Result Published
Result Revised
```

---

# 85. Assessment Versioning

Formal assessments may need versioning.

Example:

```text
Assessment Version 1
        ↓
Assessment Version 2
```

Historical student attempts should remain associated with the version they actually attempted.

---

# 86. Question Snapshot Principle

For high-stakes assessments, the system should preserve enough information about the presented question configuration to interpret historical attempts accurately.

Concept:

```text
Assessment
 ↓
Assessment Question
 ↓
Attempt
 ↓
Historical Question Context
```

The exact snapshot implementation belongs to the database/application architecture.

---

# 87. Assessment Templates

Future assessments may be generated from templates.

Example:

```text
Template
 ↓
Class 9 Biology
 ↓
20 MCQs
 ↓
5 Short Questions
 ↓
Difficulty Distribution
 ↓
Generated Assessment
```

---

# 88. Assessment Generator

A future assessment generator may use:

```text
Class
Subject
Chapter
Topic
Question Type
Difficulty
Number of Questions
Marks
Duration
```

to automatically create assessments.

---

# 89. AI Assessment Generation

Future AI workflow:

```text
Academic Context
       ↓
Assessment Requirements
       ↓
Question Bank
       ↓
AI Selection / Generation
       ↓
Validation
       ↓
Human Review
       ↓
Assessment
```

AI-generated assessments should not automatically become high-stakes exams without appropriate review.

---

# 90. Adaptive Assessment

Future adaptive tests may change question difficulty according to student performance.

Example:

```text
Correct
 ↓
Higher Difficulty

Incorrect
 ↓
Lower / Remedial Difficulty
```

The core assessment model should remain extensible for this capability.

---

# 91. Personalized Practice

Student performance can drive personalized assessments.

```text
Student
 ↓
Weak Topic
 ↓
Question Bank
 ↓
Personalized Assessment
 ↓
Result
 ↓
Updated Profile
```

---

# 92. Assessment Scheduling

Scheduled assessments may include:

```text
Start Date
End Date
Start Time
End Time
Timezone
```

The platform should use a consistent timezone strategy.

---

# 93. Academic Session

Assessments should support academic session mapping where relevant.

Example:

```text
2026–27
 ↓
Class 9
 ↓
Biology
 ↓
Midterm
```

---

# 94. Board and Curriculum

Board/curriculum-specific assessments should maintain explicit academic mapping.

Example:

```text
Board A
 ↓
Class 10
 ↓
Mathematics
 ↓
Assessment
```

A Board A assessment should not automatically be assumed compatible with Board B.

---

# 95. Language

Assessments may support:

```text
English
Urdu
Roman Urdu
```

where the associated question bank supports those languages.

---

# 96. Accessibility

The assessment interface should eventually support accessibility requirements such as:

```text
Keyboard Navigation
Readable Text
Screen Reader Compatibility
Clear Question States
Accessible Controls
```

The exact UI implementation belongs to the frontend design.

---

# 97. Assessment Notifications

Students and teachers may receive notifications for:

```text
Assessment Assigned
Assessment Starting Soon
Assessment Closing Soon
Assessment Submitted
Result Available
Result Updated
```

---

# 98. Assessment Reporting

Authorized users may access reports such as:

```text
Student Result Report
Class Performance Report
Subject Performance Report
Assessment Participation Report
Question Performance Report
```

---

# 99. Assessment Export

Authorized users may export permitted assessment data for:

```text
School Records
Teacher Reports
Academic Analysis
Backup
Administrative Use
```

Export permissions must be enforced.

---

# 100. Assessment Deletion

Assessments with historical student attempts should normally be archived rather than permanently deleted.

```text
Published
   ↓
Completed
   ↓
Archived
```

Historical academic records must remain interpretable.

---

# 101. Assessment Cancellation

A scheduled assessment may be cancelled.

Cancellation should preserve:

```text
Assessment Identity
Reason
Timestamp
Authorized Actor
Affected Students
```

where appropriate.

---

# 102. Assessment Integrity

The system should ensure:

```text
Question Exists
Question Is Authorized
Marks Are Valid
Question Count Is Valid
Assessment Timing Is Valid
Academic Mapping Is Valid
```

before publication.

---

# 103. Assessment Validation

Before publication, the system should validate:

```text
Title
Assessment Type
Academic Context
Questions
Question Types
Correct Answers
Marks
Duration
Passing Rules
Availability
Permissions
```

---

# 104. Assessment Permission Model

Conceptually:

```text
STUDENT
 → Attempt Assigned / Public Assessments

TEACHER
 → Create / Manage Authorized Assessments

SCHOOL_ADMIN
 → Manage School Assessments

PLATFORM_ADMIN
 → Manage Platform Assessments
```

Exact permissions belong to the authorization layer.

---

# 105. Assessment Data Boundary

This document defines the domain model for:

```text
Assessments
Assessment Types
Assessment Questions
Sections
Question Pools
Attempts
Answers
Evaluation
Results
Scheduling
Assignments
Assessment Analytics
```

The exact SQL schema belongs to:

```text
DATABASE.md
```

Question structure belongs to:

```text
QUESTION_BANK_MODEL.md
```

---

# 106. Core Assessment Relationships

```text
ASSESSMENT
 │
 ├── SECTIONS
 │      │
 │      └── ASSESSMENT QUESTIONS
 │
 ├── ASSIGNMENTS
 │
 ├── ATTEMPTS
 │      │
 │      └── ATTEMPT QUESTIONS
 │              │
 │              └── ANSWERS
 │
 └── RESULTS
```

---

# 107. Complete Assessment Flow

```text
QUESTION BANK
      ↓
ASSESSMENT CREATION
      ↓
QUESTION SELECTION
      ↓
VALIDATION
      ↓
REVIEW
      ↓
PUBLISH / SCHEDULE
      ↓
STUDENT ACCESS
      ↓
ATTEMPT
      ↓
ANSWER
      ↓
SUBMISSION
      ↓
EVALUATION
      ↓
RESULT
      ↓
ANALYTICS
      ↓
PERSONALIZED LEARNING
```

---

# 108. Example — Student Practice Test

```text
Student
 ↓
Class 9
 ↓
Biology
 ↓
Chapter 1
 ↓
Practice Test
 ↓
20 Questions
 ↓
Attempt
 ↓
Score
 ↓
Explanations
 ↓
Weak Topics
```

---

# 109. Example — Teacher Test

```text
Teacher
 ↓
Class 9 Biology
 ↓
Create Test
 ↓
Select Questions
 ↓
Set 30 Marks
 ↓
Set 30 Minutes
 ↓
Assign to Class
 ↓
Students Attempt
 ↓
Teacher Reviews Results
```

---

# 110. Example — School Examination

```text
School
 ↓
Academic Session
 ↓
Class 10
 ↓
Mathematics
 ↓
Final Examination
 ↓
Assigned Students
 ↓
Attempts
 ↓
Evaluation
 ↓
Official Results
```

---

# 111. Example — AI Personalized Test

```text
Student
 ↓
Performance Analysis
 ↓
Weak Topic Identified
 ↓
Question Bank
 ↓
Suitable Questions
 ↓
AI-Personalized Practice
 ↓
Assessment
 ↓
Result
 ↓
Updated Learning Profile
```

---

# 112. Final Assessment Architecture

```text
                         ASSESSMENT
                              │
            ┌─────────────────┼─────────────────┐
            │                 │                 │
         SECTIONS          QUESTIONS        ASSIGNMENTS
            │                 │                 │
            │                 ↓                 │
            │          QUESTION BANK            │
            │                                   │
            └─────────────────┬─────────────────┘
                              ↓
                           STUDENT
                              ↓
                            ATTEMPT
                              ↓
                           ANSWERS
                              ↓
                          EVALUATION
                              ↓
                            RESULT
                              ↓
                         ANALYTICS
                              ↓
                     PERSONALIZED LEARNING
```

---

# 113. Final Principles

The Aspirian Assessment Model must be:

> **Reusable, configurable, curriculum-aware, question-bank driven, secure, scalable, analytics-ready, AI-ready, and suitable for Nursery → Class 12.**

Assessments should reference reusable Question Bank content while preserving sufficient historical information to keep completed attempts and official results accurate.

---

# 114. Document Status

**File:** `ASSESSMENT_MODEL.md`
**Version:** 1.0
**Status:** Final Assessment Data Model Blueprint
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Tests, Exams & Assessments data model for the Aspirian Student Platform.
