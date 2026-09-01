# Aspirian Student Platform — Question Bank Model

**Version:** 1.0
**Status:** Final Question Bank Data Model Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the domain-level data model for the Aspirian Student Platform Question Bank.

The Question Bank is a core academic component used by:

* Students
* Teachers
* Schools
* Assessments
* Practice tests
* Chapter tests
* Topic tests
* Mock tests
* Revision
* AI-generated practice
* Performance analysis

The model is designed to support educational content from:

> **Nursery → Class 12**

while remaining flexible for future competitive exams and other educational programs.

---

# 2. Question Bank Philosophy

The Question Bank should be treated as a reusable pool of academic questions.

```text
Question Bank
      ↓
Questions
      ↓
Academic Context
      ↓
Practice / Tests / Assessments
```

A question should normally be created once and reused in multiple assessments rather than duplicated.

---

# 3. Core Question Entity

The central entity is:

```text
QUESTION
```

Conceptual attributes:

```text
id
question_text
question_type
difficulty
status
language
explanation
created_by
created_at
updated_at
```

The exact database implementation belongs to `DATABASE.md`.

---

# 4. Question Identity

Every question must have a stable internal identifier.

The identifier should remain unchanged even if:

* Question text changes
* Explanation changes
* Difficulty changes
* Academic classification changes
* Question is reused in another test

---

# 5. Question Types

The initial platform should support:

```text
MCQ
TRUE_FALSE
SHORT_ANSWER
LONG_ANSWER
FILL_IN_THE_BLANK
MATCHING
ORDERING
NUMERIC
```

Additional types may be introduced later.

---

# 6. MCQ Structure

Multiple Choice Questions contain:

```text
Question
 ├── Option A
 ├── Option B
 ├── Option C
 └── Option D
```

The system should not permanently assume four options.

Future questions may contain:

```text
3 options
4 options
5 options
More options
```

---

# 7. MCQ Option Model

Each option should have its own identity.

Conceptual data:

```text
id
question_id
option_text
display_order
is_correct
explanation
```

Correct-answer information should be stored structurally rather than inferred from the option text.

---

# 8. Multiple Correct Answers

The question model should allow questions with:

```text
Single Correct Answer
Multiple Correct Answers
```

where the question type requires it.

Example:

```text
Question
 ├── A → Correct
 ├── B → Correct
 ├── C → Incorrect
 └── D → Incorrect
```

---

# 9. Question Explanation

Questions may contain explanations.

Example:

```text
Question
 ↓
Correct Answer
 ↓
Explanation
```

Explanation can be useful for:

* Student learning
* Practice mode
* Test review
* AI tutoring
* Revision

---

# 10. Question Difficulty

Initial difficulty levels:

```text
EASY
MEDIUM
HARD
```

The model should remain extensible for:

```text
VERY_EASY
VERY_HARD
EXPERT
```

if required later.

---

# 11. Difficulty Sources

Difficulty may be:

```text
AUTHOR_ASSIGNED
SYSTEM_ESTIMATED
AI_ESTIMATED
PERFORMANCE_DERIVED
```

The source should be distinguishable where required.

---

# 12. Question Status

Possible lifecycle states:

```text
DRAFT
REVIEW
APPROVED
PUBLISHED
ARCHIVED
REJECTED
```

Only appropriate statuses should make questions available to students.

---

# 13. Question Ownership

Questions may be created by:

```text
Teacher
Platform Admin
Content Team
Authorized Contributor
AI System
```

The platform should record the creator/source.

---

# 14. Human vs AI Generated Questions

Questions should be able to identify their origin.

Possible sources:

```text
HUMAN
AI
IMPORTED
SYSTEM
```

AI-generated questions should pass through appropriate validation/review before being treated as trusted academic content.

---

# 15. Question Academic Mapping

Every published academic question should normally have sufficient academic context.

Example:

```text
Board / Curriculum
       ↓
Academic Session
       ↓
Class
       ↓
Group / Stream
       ↓
Subject
       ↓
Book
       ↓
Chapter
       ↓
Topic
       ↓
Question
```

Not every level is mandatory for every educational stage.

---

# 16. Nursery / KG Questions

Early education questions may not always have:

```text
Book
Chapter
Topic
```

Therefore the system may support:

```text
Class
 ↓
Subject / Learning Area
 ↓
Lesson / Activity
 ↓
Question
```

---

# 17. Primary Questions

Primary-level questions may use:

```text
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
Question
```

---

# 18. Secondary Questions

Secondary-level questions should support:

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
 ↓
Question
```

---

# 19. Higher Secondary Questions

Higher secondary questions should support group-specific classification.

Example:

```text
Class 11
 ↓
Pre-Medical
 ↓
Biology
 ↓
Chapter
 ↓
Topic
 ↓
Question
```

---

# 20. Question Tags

Questions may have tags.

Examples:

```text
important
conceptual
numerical
definition
board-exam
revision
frequently-asked
```

Tags support search and filtering.

---

# 21. Question Categories

Questions may have categories such as:

```text
CONCEPTUAL
FACTUAL
APPLICATION
ANALYTICAL
NUMERICAL
MEMORY
PROBLEM_SOLVING
```

Categories are different from difficulty levels.

---

# 22. Cognitive Level

Future assessment analytics may classify questions using cognitive levels.

Possible structure:

```text
REMEMBER
UNDERSTAND
APPLY
ANALYZE
EVALUATE
CREATE
```

This allows more advanced assessment analytics.

---

# 23. Question Language

Questions may support:

```text
English
Urdu
Roman Urdu
```

Language should be stored independently from academic classification.

---

# 24. Multilingual Questions

A question may have multiple language versions.

Concept:

```text
Question
 ├── English Version
 ├── Urdu Version
 └── Roman Urdu Version
```

These should ideally remain linked to the same logical question where they represent the same academic assessment item.

---

# 25. Question Media

Questions may contain media.

Supported conceptual media:

```text
Image
Diagram
Audio
Video
Formula
Table
```

Example:

```text
Question
 ├── Text
 ├── Image
 └── Options
```

Media references should be stored separately rather than embedding large files directly inside question records.

---

# 26. Diagram Questions

Some subjects require diagrams.

Examples:

```text
Biology
Physics
Chemistry
Geography
Computer Science
Mathematics
```

The question model should support image/diagram references.

---

# 27. Formula Questions

Mathematics and science questions may contain formulas.

The platform should support structured or renderable mathematical notation where required.

Example:

```text
E = mc²
```

The storage and rendering implementation will be defined at the technical layer.

---

# 28. Question Metadata

Potential metadata:

```text
question_id
source
language
difficulty
category
cognitive_level
status
creator
reviewer
created_at
updated_at
```

Only necessary metadata should be stored.

---

# 29. Question Source

Questions may originate from:

```text
Original Platform Content
Teacher Created
Imported Question Bank
Past Paper
AI Generated
External Licensed Content
```

Copyright/licensing information must be preserved where applicable.

---

# 30. Past Paper Questions

Past-paper questions should be identifiable.

Concept:

```text
Question
 ↓
Past Paper Source
 ├── Exam
 ├── Year
 ├── Board
 └── Paper Type
```

This allows students to practice historical exam questions.

---

# 31. Question Versioning

Questions may need revisions.

Example:

```text
Question
 ├── Version 1
 ├── Version 2
 └── Current Version
```

Versioning is useful when a question is corrected without destroying historical records.

---

# 32. Question Editing

Editing a question should not silently change historical student attempts.

For example:

```text
Question Version 1
        ↓
Student Attempt
        ↓
Question Version 2
```

The historical attempt should remain interpretable.

---

# 33. Question Review

A review workflow may be:

```text
DRAFT
  ↓
REVIEW
  ↓
APPROVED
  ↓
PUBLISHED
```

Rejected questions can be returned to the author for correction.

---

# 34. Question Approval

Approval may require:

```text
Content Reviewer
Teacher
Subject Expert
Platform Administrator
```

depending on the content workflow.

---

# 35. Question Bank

A Question Bank is a logical collection of questions.

Example:

```text
Question Bank
 ├── Question 1
 ├── Question 2
 ├── Question 3
 └── ...
```

A question may belong to more than one logical bank.

---

# 36. Question Bank Categories

Examples:

```text
Class 9 Biology
Class 10 Mathematics
Chapter 1 MCQs
Board Exam Practice
Teacher Question Bank
School Question Bank
AI Practice Bank
```

---

# 37. Shared Question Bank

A platform-level question bank can be shared across multiple schools where licensing and permissions allow.

```text
Platform Question Bank
        ↓
Multiple Schools
        ↓
Multiple Teachers
        ↓
Multiple Tests
```

---

# 38. School Question Bank

Schools may maintain private question banks.

```text
School
 ↓
Private Question Bank
 ↓
Teachers
 ↓
School Assessments
```

Private questions must not automatically become public.

---

# 39. Teacher Question Bank

Teachers may create their own reusable questions.

```text
Teacher
 ↓
My Question Bank
 ↓
Questions
 ↓
Tests
```

Teachers should retain control according to platform permissions.

---

# 40. Question Bank Visibility

Possible visibility levels:

```text
PRIVATE
SCHOOL
CLASS
PLATFORM
PUBLIC
```

Visibility must be enforced through authorization.

---

# 41. Question Reuse

A question can be reused in:

```text
Practice
Chapter Test
Topic Test
Subject Test
Mock Test
School Test
Teacher Test
AI Practice
Revision
```

The question should not need to be duplicated for every use.

---

# 42. Assessment Question Mapping

An assessment should reference existing questions.

Concept:

```text
Test
 ↓
Test Question
 ↓
Question
```

The `Test Question` relationship may store:

```text
display_order
marks
section
required
```

---

# 43. Marks

A question may have a default mark value.

However, the same question may carry different marks in different assessments.

Therefore:

```text
Question
   ↓
Default Marks

Test Question
   ↓
Assessment-Specific Marks
```

---

# 44. Negative Marking

Some assessments may use negative marking.

The assessment-question relationship should therefore be able to support:

```text
marks
negative_marks
```

where applicable.

---

# 45. Question Sections

Tests may organize questions into sections.

Example:

```text
Test
 ├── Section A — MCQs
 ├── Section B — Short Questions
 └── Section C — Long Questions
```

Question-bank design should allow questions to be placed into such sections through the assessment layer.

---

# 46. Randomization

Questions may be randomized during test generation.

Possible controls:

```text
Random Question Selection
Random Option Order
Question Pool
Fixed Question Order
```

Randomization rules belong to the assessment/test layer.

---

# 47. Question Pools

A test may select a defined number of questions from a larger pool.

Example:

```text
Question Pool = 50
Student receives = 20
```

The Question Bank must support this reuse model.

---

# 48. Topic-Based Pools

Example:

```text
Biology
 ↓
Chapter 1
 ↓
Topic A
 ↓
Question Pool
```

This allows automatic topic-specific practice.

---

# 49. Difficulty-Based Pools

Questions may be selected based on difficulty.

Example:

```text
Easy = 10
Medium = 10
Hard = 5
```

This supports balanced assessment generation.

---

# 50. Adaptive Question Selection

Future AI/adaptive learning may select questions based on:

```text
Student Performance
Weak Topics
Previous Attempts
Difficulty
Accuracy
Learning History
```

Example:

```text
Student Weak Topic
        ↓
Question Bank
        ↓
Suitable Questions
        ↓
Practice
```

---

# 51. Student Attempt Relationship

A student attempt references the question presented to the student.

Concept:

```text
Student
 ↓
Test Attempt
 ↓
Attempt Question
 ↓
Question
```

The system should preserve the question context used during the attempt.

---

# 52. Student Answer

For an MCQ:

```text
Attempt Question
 ↓
Selected Option
```

For text questions:

```text
Attempt Question
 ↓
Student Answer
```

Answers should be stored separately from the master question.

---

# 53. Automatic Evaluation

Automatically evaluatable question types may include:

```text
MCQ
TRUE_FALSE
FILL_IN_THE_BLANK
NUMERIC
```

depending on the evaluation rules.

---

# 54. Manual Evaluation

Questions such as:

```text
SHORT_ANSWER
LONG_ANSWER
ESSAY
```

may require teacher/manual evaluation or advanced AI-assisted evaluation.

---

# 55. AI-Assisted Evaluation

Future AI evaluation may provide:

```text
Suggested Score
Feedback
Detected Concepts
Mistakes
Improvement Suggestions
```

Final academic authority should remain configurable.

---

# 56. Question Analytics

Question-level analytics may include:

```text
Total Attempts
Correct Attempts
Incorrect Attempts
Skipped Attempts
Accuracy
Average Time
Difficulty Estimate
```

These analytics should be derived from attempt data rather than stored redundantly unless required for performance.

---

# 57. Question Performance

Example:

```text
Question
 ↓
1000 Attempts
 ↓
700 Correct
300 Incorrect
 ↓
70% Accuracy
```

This information can help identify:

* Easy questions
* Difficult questions
* Ambiguous questions
* Poorly written questions

---

# 58. Question Quality Monitoring

The system should be able to flag questions with:

```text
Very Low Accuracy
Very High Skip Rate
Unusual Answer Distribution
Potential Ambiguity
Repeated Complaints
Outdated Curriculum
```

These questions can be sent back for review.

---

# 59. Duplicate Detection

The platform should attempt to identify duplicate or near-duplicate questions.

Possible detection methods:

```text
Exact Text Match
Normalized Text Match
Semantic Similarity
AI-Assisted Detection
```

Duplicate detection should not automatically delete questions.

It should flag them for review.

---

# 60. Question Search

Question Bank search should support:

```text
Question Text
Class
Subject
Chapter
Topic
Board
Difficulty
Type
Language
Creator
Status
Tags
Source
```

---

# 61. Question Filtering

Example:

```text
Class 9
+
Biology
+
Chapter 1
+
MCQ
+
Medium
+
English
```

The result should contain only matching authorized questions.

---

# 62. Question Import

Future imports may support:

```text
CSV
Excel
JSON
API
Manual Entry
```

Imported questions should pass through validation.

---

# 63. Import Validation

Validation may check:

```text
Question Text Present
Question Type Valid
Options Present
Correct Answer Present
Academic Mapping Valid
Language Valid
Duplicate Detection
```

Invalid questions should not be published automatically.

---

# 64. Bulk Question Creation

Authorized users may create multiple questions at once.

Example:

```text
100 MCQs
 ↓
Import
 ↓
Validate
 ↓
Review
 ↓
Publish
```

Bulk operations must respect permissions and validation rules.

---

# 65. Question Export

Authorized users may export questions for:

```text
Teacher Use
School Exams
Backup
Migration
Reporting
```

Export permissions must be controlled.

---

# 66. Question Security

Questions may represent valuable academic content.

The system should protect against:

```text
Unauthorized Access
Bulk Scraping
Unauthorized Export
Unauthorized Editing
Question Leakage
```

Publicly available questions may have different protection requirements than private question banks.

---

# 67. Copyright Protection

Imported or licensed questions must retain appropriate source/licensing metadata.

The platform must not assume that every externally sourced question can be redistributed freely.

---

# 68. Question Moderation

Moderation may include:

```text
Content Review
Academic Accuracy
Language Review
Copyright Review
Difficulty Review
Duplicate Review
```

---

# 69. AI Question Generation

Future AI generation flow:

```text
Academic Context
      ↓
AI Question Generator
      ↓
Draft Questions
      ↓
Validation
      ↓
Human Review
      ↓
Approved Question
      ↓
Question Bank
```

AI should not bypass academic quality controls by default.

---

# 70. AI Generation Context

AI-generated questions should receive context such as:

```text
Class
Subject
Chapter
Topic
Difficulty
Question Type
Language
Learning Objective
```

This improves relevance.

---

# 71. Question Learning Objective

Questions may optionally be mapped to a learning objective.

Example:

```text
Topic
 ↓
Learning Objective
 ↓
Question
```

This can support curriculum-aligned assessment.

---

# 72. Question Competency

Future advanced assessment may associate questions with competencies.

Example:

```text
Question
 ↓
Competency
 ↓
Skill
```

This remains an extensibility point.

---

# 73. Question Dependency

Some questions may depend on prerequisites.

Example:

```text
Prerequisite Topic
       ↓
Question
       ↓
Advanced Topic
```

This can later support personalized learning paths.

---

# 74. Question Collections

Question collections may group questions for specific purposes.

Examples:

```text
Chapter 1 Practice
Annual Exam Preparation
Board Exam Important MCQs
Weak Area Practice
Teacher's Favorite Questions
```

---

# 75. Question Bookmarking

Teachers or authorized users may bookmark questions.

Example:

```text
Teacher
 ↓
Saved Questions
```

Students may also bookmark questions for revision if enabled.

---

# 76. Question Reporting

Users may report questions for:

```text
Incorrect Answer
Wrong Explanation
Typographical Error
Outdated Content
Duplicate
Inappropriate Content
Other Issue
```

Reports should enter a moderation workflow.

---

# 77. Question Correction

A reported question may follow:

```text
Report
 ↓
Review
 ↓
Correction
 ↓
New Version
 ↓
Approval
 ↓
Publication
```

Historical attempts must remain interpretable.

---

# 78. Question Archiving

Questions should be archived rather than deleted when historical records depend on them.

```text
Published
   ↓
Archived
```

Archived questions should not normally appear in new tests.

---

# 79. Question Deletion

Permanent deletion should be restricted.

If a question has been used in student attempts, hard deletion should normally be avoided.

---

# 80. Question Relationship Model

Conceptual relationship:

```text
                         QUESTION
                            │
             ┌──────────────┼──────────────┐
             │              │              │
          OPTIONS         MEDIA         TAGS
             │              │              │
             └──────────────┼──────────────┘
                            │
                     ACADEMIC CONTEXT
                            │
          ┌─────────────────┼─────────────────┐
          │                 │                 │
        CLASS            SUBJECT            TOPIC
                            │
                          BOOK
                            │
                         CHAPTER
```

---

# 81. Question Usage Model

```text
QUESTION BANK
      │
      ├── PRACTICE
      │
      ├── TEST
      │
      ├── MOCK TEST
      │
      ├── REVISION
      │
      └── AI PRACTICE
```

---

# 82. Question Attempt Model

```text
STUDENT
   ↓
TEST ATTEMPT
   ↓
ATTEMPT QUESTION
   ↓
QUESTION
   ↓
STUDENT ANSWER
   ↓
EVALUATION
   ↓
RESULT
```

---

# 83. Teacher Workflow

```text
Teacher
 ↓
Create Question
 ↓
Select Academic Context
 ↓
Select Question Type
 ↓
Add Options / Answer
 ↓
Add Explanation
 ↓
Save Draft
 ↓
Review
 ↓
Publish
 ↓
Use in Test
```

---

# 84. Student Workflow

```text
Student
 ↓
Select Class
 ↓
Select Subject
 ↓
Select Chapter
 ↓
Select Topic
 ↓
Start Practice
 ↓
Receive Questions
 ↓
Submit Answers
 ↓
View Results
 ↓
Review Explanations
 ↓
Revise Weak Areas
```

---

# 85. AI Workflow

```text
Student Context
 ↓
Performance Analysis
 ↓
Weak Topic Detection
 ↓
Question Bank Search
 ↓
Question Selection
 ↓
Personalized Practice
 ↓
Result
 ↓
Updated Learning Profile
```

---

# 86. Question Bank Permissions

Access should be permission-based.

Example:

```text
STUDENT
    → Attempt

TEACHER
    → Create / Edit / Use

SCHOOL_ADMIN
    → Manage School Bank

PLATFORM_ADMIN
    → Manage Platform Bank
```

Exact permissions will be defined in the authorization layer.

---

# 87. Multi-School Question Banks

The model must distinguish:

```text
Platform Question Bank
School Question Bank
Teacher Question Bank
Personal Saved Questions
```

This prevents accidental cross-school exposure.

---

# 88. Question Bank Ownership

Every private question bank should have an ownership context.

Possible owners:

```text
Platform
School
Teacher
User
```

---

# 89. Question Bank Visibility Rules

```text
PRIVATE
    ↓
Owner Only

SCHOOL
    ↓
Authorized School Users

PLATFORM
    ↓
Authorized Platform Users

PUBLIC
    ↓
Publicly Accessible
```

---

# 90. Academic Compatibility

A question should only be recommended to students when it is compatible with their academic context.

Example:

```text
Student:
Class 9
Board A
Biology

Question:
Class 9
Board B
Biology

→ Not automatically compatible
```

Board/curriculum compatibility must be respected.

---

# 91. Session Compatibility

Where curriculum changes by academic session:

```text
Student Session
        ↓
Question Session
```

The platform should avoid presenting outdated curriculum content as current content unless explicitly requested.

---

# 92. Question Bank Quality

The Question Bank should prioritize:

```text
Accuracy
Relevance
Curriculum Alignment
Clarity
Fairness
Appropriate Difficulty
Reliable Answers
Good Explanations
```

---

# 93. Question Bank Scalability

The model should support:

```text
Thousands of Questions
Millions of Questions
Multiple Boards
Multiple Schools
Multiple Subjects
Multiple Languages
Large Student Traffic
```

The exact database optimization strategy belongs to the technical/database layer.

---

# 94. API Compatibility

The Question Bank should be accessible through the platform API for:

```text
Web Application
Android Application
Future Mobile Apps
Teacher Tools
AI Services
Administrative Tools
```

API authorization must prevent unauthorized question access.

---

# 95. Data Separation

This document defines the domain model for:

```text
Questions
Options
Question Banks
Question Metadata
Question Sources
Question Versions
Question Academic Mapping
Question Usage
Question Visibility
Question Review
```

Detailed database implementation remains in:

```text
DATABASE.md
```

Assessment execution belongs to the appropriate assessment/test models.

---

# 96. Recommended Core Relationships

```text
QUESTION
 ├── QUESTION OPTIONS
 ├── QUESTION MEDIA
 ├── QUESTION TAGS
 ├── QUESTION VERSION
 ├── QUESTION SOURCE
 ├── QUESTION BANK
 ├── ACADEMIC CONTEXT
 └── LEARNING OBJECTIVE
```

Usage:

```text
QUESTION
 ↓
TEST QUESTION
 ↓
ATTEMPT QUESTION
 ↓
STUDENT ANSWER
```

---

# 97. Final Question Bank Architecture

```text
                         QUESTION BANK
                               │
                    ┌──────────┴──────────┐
                    │                     │
              PLATFORM BANK           SCHOOL BANK
                    │                     │
              TEACHER BANK          TEACHER BANK
                    │                     │
                    └──────────┬──────────┘
                               │
                           QUESTIONS
                               │
              ┌────────────────┼────────────────┐
              │                │                │
            OPTIONS          MEDIA          EXPLANATION
              │
              └────────────────┬────────────────┘
                               │
                     ACADEMIC CONTEXT
                               │
                    CLASS / SUBJECT / TOPIC
                               │
                         TEST / PRACTICE
                               │
                           STUDENT
                               │
                            RESULT
```

---

# 98. Final Principles

The Aspirian Question Bank must be:

> **Reusable, curriculum-aware, board-aware, versioned, permission-controlled, multilingual, AI-ready, analytics-ready, and scalable from Nursery to Class 12.**

The question should exist as a reusable academic asset, while tests and student attempts reference it rather than duplicating it.

---

# 99. Document Status

**File:** `QUESTION_BANK_MODEL.md`
**Phase:** C
**Module:** C3 — Question Bank Model

**File:** `QUESTION_BANK_MODEL.md`
**Version:** 1.0
**Status:** Final Question Bank Data Model Blueprint
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Question Bank data model for the Aspirian Student Platform.
