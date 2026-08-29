# Aspirian Student Platform — Paper Builder

**Version:** 1.0
**Status:** Final Paper Builder Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the functional architecture of the Paper Builder for the Aspirian Student Platform.

The Paper Builder enables authorized teachers and administrators to create, configure, assemble, preview, manage and publish academic question papers using the platform's Question Bank and Assessment systems.

The Paper Builder is designed to make paper creation:

```text
Structured
Flexible
Curriculum-Aligned
Reusable
Secure
Scalable
```

---

# 2. Paper Builder Principle

```text
CURRICULUM
   ↓
SUBJECT
   ↓
CHAPTER / TOPIC
   ↓
QUESTION BANK
   ↓
QUESTION SELECTION
   ↓
PAPER STRUCTURE
   ↓
MARKS / TIME
   ↓
PREVIEW
   ↓
VALIDATION
   ↓
PUBLISH
   ↓
ASSESSMENT / TEST
```

---

# 3. Module Scope

The Paper Builder owns:

```text
Paper Creation
Paper Configuration
Question Selection
Question Arrangement
Sections
Marks Distribution
Paper Rules
Paper Templates
Paper Preview
Paper Validation
Paper Versioning
Paper Publishing
Paper Duplication
Paper Export
```

It does not own:

```text
Question Bank Master Data
Student Identity
Official Assessment Results
Learning Progress
Revision Logic
School Master Data
Teacher Master Data
```

---

# 4. Primary Users

The Paper Builder supports:

```text
Teacher
School Administrator
Authorized Content Creator
Platform Administrator
```

Student access is normally limited to published papers assigned through the appropriate assessment/test system.

---

# 5. Paper Types

The system should support:

```text
Class Test
Quiz
Monthly Test
Weekly Test
Chapter Test
Unit Test
Midterm Exam
Final Exam
Annual Exam
Board-Style Paper
Practice Paper
Mock Exam
Entry Test
Diagnostic Test
Practical Paper
Custom Assessment Paper
```

---

# 6. Academic Range

Paper creation should support:

```text
Nursery
Prep / KG
Class 1 → Class 12
```

The structure should remain extensible for future academic levels.

---

# 7. Curriculum Alignment

Every paper should optionally be aligned with:

```text
Board
Curriculum
Class
Subject
Academic Year
Term
Chapter
Topic
Learning Objective
```

---

# 8. Paper Metadata

A paper may contain:

```text
Paper ID
Title
Paper Type
Class
Subject
Board
Academic Year
Term
Duration
Total Marks
Passing Marks
Difficulty
Language
Status
Created By
Created Date
Updated Date
```

---

# 9. Paper Status

Possible statuses:

```text
DRAFT
UNDER_REVIEW
APPROVED
PUBLISHED
LOCKED
ARCHIVED
CANCELLED
```

---

# 10. Draft Paper

A paper begins as a draft.

```text
CREATE
 ↓
DRAFT
 ↓
EDIT
 ↓
VALIDATE
 ↓
REVIEW
 ↓
PUBLISH
```

---

# 11. Paper Sections

A paper may contain multiple sections.

Example:

```text
Section A — MCQs
Section B — Short Questions
Section C — Long Questions
Section D — Practical / Application
```

---

# 12. Section Configuration

Each section may define:

```text
Section Name
Instructions
Question Count
Marks Per Question
Total Marks
Question Type
Selection Rules
Optional Questions
```

---

# 13. Question Types

The Paper Builder should support questions from the Question Bank such as:

```text
MCQ
True / False
Fill in the Blank
Matching
Short Question
Long Question
Essay
Numerical
Problem Solving
Diagram-Based
Case Study
Scenario-Based
Coding Question
Practical Question
```

---

# 14. Question Bank Integration

The Paper Builder must reference questions from the Question Bank rather than duplicate question master records.

```text
QUESTION BANK
      ↓
PAPER BUILDER
      ↓
PAPER
```

---

# 15. Question Selection

Teachers may select questions using:

```text
Manual Selection
Search
Filters
Random Selection
Blueprint Rules
Difficulty
Chapter
Topic
Learning Objective
Question Type
Marks
```

---

# 16. Manual Question Selection

Teachers may browse the Question Bank and add individual questions.

```text
SEARCH
 ↓
PREVIEW
 ↓
SELECT
 ↓
ADD TO PAPER
```

---

# 17. Question Search

Search may use:

```text
Question Text
Question ID
Chapter
Topic
Subject
Class
Difficulty
Question Type
Tags
Learning Objective
```

---

# 18. Question Filters

Example:

```text
Class = 9
Subject = Biology
Chapter = 1
Type = MCQ
Difficulty = Medium
```

---

# 19. Random Question Selection

The system may randomly select questions based on configured rules.

Example:

```text
Chapter 1 → 5 questions
Chapter 2 → 5 questions
Chapter 3 → 5 questions
```

---

# 20. Randomization Principle

Random selection must respect:

```text
Question Type
Marks
Difficulty
Curriculum
Chapter
Topic
Exclusions
Question Status
```

---

# 21. Blueprint-Based Paper Generation

Teachers may define a blueprint.

Example:

```text
MCQs                  20%
Short Questions       30%
Long Questions        50%
```

The system then selects questions according to the blueprint.

---

# 22. Difficulty Distribution

A paper may define:

```text
Easy       30%
Medium     50%
Hard       20%
```

The builder should attempt to satisfy these rules.

---

# 23. Cognitive Distribution

Future-compatible paper blueprints may include:

```text
Remember
Understand
Apply
Analyze
Evaluate
Create
```

---

# 24. Chapter Weightage

Example:

```text
Chapter 1 → 20%
Chapter 2 → 30%
Chapter 3 → 25%
Chapter 4 → 25%
```

---

# 25. Topic Weightage

The builder may define topic-level distribution.

---

# 26. Learning Objective Distribution

A paper may be designed to assess specific learning objectives.

```text
Objective A → 30%
Objective B → 40%
Objective C → 30%
```

---

# 27. Marks Distribution

The builder must calculate:

```text
Question Marks
+
Section Marks
=
Paper Total Marks
```

---

# 28. Automatic Marks Validation

The system should detect:

```text
Total Marks Mismatch
Section Marks Mismatch
Missing Marks
Invalid Question Marks
```

---

# 29. Passing Marks

The creator may define passing marks.

```text
Total Marks = 100
Passing Marks = 40
```

Passing rules should remain compatible with the Result Engine.

---

# 30. Optional Questions

A section may allow optional questions.

Example:

```text
Attempt any 5 out of 7 questions.
```

The system must calculate maximum obtainable marks correctly.

---

# 31. Choice Rules

Possible rules:

```text
Attempt All
Attempt Any N
Attempt One From Each Group
Attempt Any N From Section
```

---

# 32. Question Groups

Questions may be grouped.

Example:

```text
Group A
 ├── Q1
 ├── Q2
 └── Q3

Student attempts any 2.
```

---

# 33. Either / Or Questions

The system may support:

```text
Q5 OR Q6
```

without duplicating question data.

---

# 34. Question Ordering

Questions may be ordered by:

```text
Manual Order
Question Number
Difficulty
Topic
Random Order
```

---

# 35. Question Numbering

The system should automatically number questions.

Example:

```text
Q1
Q2
Q3
...
Q20
```

---

# 36. Sub-Questions

Questions may contain sub-parts.

Example:

```text
Q5:
a) Define...
b) Explain...
c) Give an example...
```

Each sub-question may have independent marks.

---

# 37. Question Instructions

The paper may contain:

```text
General Instructions
Section Instructions
Question Instructions
```

---

# 38. General Paper Instructions

Example:

```text
Read all questions carefully.
Attempt questions according to the instructions.
Show necessary working where required.
```

---

# 39. Time Allocation

The paper may define:

```text
Duration
Suggested Section Time
```

Future versions may calculate suggested time automatically.

---

# 40. Paper Difficulty

Overall paper difficulty may be:

```text
Easy
Medium
Hard
Mixed
```

---

# 41. Language

Papers may support:

```text
English
Urdu
Roman Urdu
Other Supported Languages
```

Language availability depends on the question content.

---

# 42. Bilingual Papers

The system may support bilingual presentation.

Example:

```text
English Question
Urdu Translation
```

---

# 43. Question Media

Questions may include:

```text
Images
Diagrams
Tables
Audio
Video
Mathematical Expressions
Code
```

The Paper Builder should reference media rather than duplicate media storage.

---

# 44. Mathematical Expressions

The paper should support formatted mathematical notation.

---

# 45. Diagram Placement

Teachers should be able to preview where diagrams and images appear in the paper.

---

# 46. Paper Layout

The builder should support configurable layouts:

```text
A4
A5
Portrait
Landscape
```

---

# 47. Paper Header

A paper header may include:

```text
School Name
Logo
Board
Class
Subject
Exam Name
Academic Year
```

---

# 48. Paper Footer

A footer may contain:

```text
Page Number
Paper Code
Confidentiality Notice
School Information
```

---

# 49. Paper Code

Each generated paper may have a unique paper code.

Example:

```text
BIO-09-FINAL-2026-A
```

---

# 50. Paper Variants

The builder may generate multiple variants:

```text
Version A
Version B
Version C
```

---

# 51. Variant Generation

Variants may use:

```text
Different Question Order
Different MCQ Options
Different Question Selection
```

The underlying question bank records remain unchanged.

---

# 52. Anti-Cheating Randomization

For suitable assessments:

```text
Question Order Randomization
Option Randomization
Variant Generation
```

must remain compatible with the Test Engine.

---

# 53. Paper Template

Teachers may save reusable templates.

Example:

```text
Class 9 Biology Test Template
```

---

# 54. Template Components

Templates may store:

```text
Sections
Marks Distribution
Question Types
Instructions
Layout
Header
Footer
Blueprint Rules
```

---

# 55. Template Reuse

Workflow:

```text
TEMPLATE
 ↓
CREATE NEW PAPER
 ↓
MODIFY
 ↓
VALIDATE
 ↓
PUBLISH
```

---

# 56. Paper Duplication

Existing papers may be duplicated.

```text
OLD PAPER
 ↓
DUPLICATE
 ↓
NEW PAPER
 ↓
EDIT
```

The duplicated paper must receive a new identity.

---

# 57. Paper Versioning

Major changes should create versions.

```text
Version 1
Version 2
Version 3
```

---

# 58. Version History

The system should record important changes such as:

```text
Question Added
Question Removed
Question Replaced
Marks Changed
Instruction Changed
Section Changed
```

---

# 59. Paper Locking

Once an assessment paper is published or locked, editing should be restricted.

---

# 60. Paper Approval

Schools may optionally require approval.

```text
TEACHER
 ↓
DRAFT
 ↓
SUBMIT FOR REVIEW
 ↓
ADMIN / REVIEWER
 ↓
APPROVE
 ↓
PUBLISH
```

---

# 61. Review Workflow

Reviewers may check:

```text
Curriculum Alignment
Question Accuracy
Marks
Difficulty
Instructions
Formatting
Answer Key
```

---

# 62. Paper Validation

Before publishing, the system should validate:

```text
Total Marks
Question Count
Missing Questions
Duplicate Questions
Section Rules
Question Availability
Answer Keys
Time
Curriculum Alignment
```

---

# 63. Duplicate Question Detection

The builder should detect duplicate questions within the same paper.

---

# 64. Question Availability

Questions must be active and accessible to the paper creator.

---

# 65. Answer Key Integration

Objective questions may have answer keys stored in the Question Bank.

The Paper Builder should reference them rather than create conflicting copies.

---

# 66. Subjective Questions

For subjective questions, marking guidance may be attached through the assessment/evaluation system.

---

# 67. Marking Scheme Integration

A paper may include a marking scheme where authorized.

```text
QUESTION
 ↓
MARKING SCHEME
 ↓
ASSESSMENT
```

---

# 68. Answer Sheet Configuration

Future versions may support:

```text
MCQ Answer Sheet
Written Answer Sheet
Mixed Answer Sheet
Digital Answer Interface
```

---

# 69. Digital Paper

The paper may be delivered digitally through the Test Engine.

```text
PAPER BUILDER
 ↓
PUBLISHED PAPER
 ↓
TEST ENGINE
 ↓
STUDENT
```

---

# 70. Printable Paper

The paper may be exported for printing.

Possible formats:

```text
PDF
DOCX
```

Export permissions should be controlled.

---

# 71. PDF Generation

Generated PDFs should preserve:

```text
Formatting
Images
Tables
Mathematical Expressions
Page Numbers
Question Numbering
```

---

# 72. Paper Preview

Teachers should be able to preview the final paper before publishing.

Preview modes:

```text
Student View
Print View
Answer-Key View
```

---

# 73. Student View

Student View should hide:

```text
Correct Answers
Internal Notes
Marking Scheme
Teacher Comments
```

---

# 74. Answer-Key View

Authorized users may see:

```text
Correct Answers
Marks
Marking Notes
```

---

# 75. Paper Analytics Preview

Before publication, the builder may display:

```text
Total Marks
Question Count
Difficulty Distribution
Chapter Distribution
Question Type Distribution
```

---

# 76. Paper Quality Score

Future versions may calculate a quality indicator based on configured blueprint rules.

Example:

```text
Curriculum Coverage: 95%
Difficulty Balance: 90%
Marks Balance: 100%
```

This is a design aid, not an official academic score.

---

# 77. AI Paper Builder

Future AI integration may assist teachers with:

```text
Question Suggestions
Paper Blueprint Suggestions
Difficulty Balancing
Chapter Coverage
Question Rewording
Instruction Generation
Paper Quality Analysis
```

---

# 78. AI Question Selection

AI may suggest questions based on:

```text
Class
Subject
Chapter
Difficulty
Learning Objectives
Previous Paper Usage
```

Teachers should retain final control.

---

# 79. AI Paper Generation

Conceptually:

```text
TEACHER REQUIREMENTS
 ↓
AI SUGGESTION
 ↓
QUESTION BANK
 ↓
PAPER DRAFT
 ↓
TEACHER REVIEW
 ↓
PUBLISH
```

AI-generated selection must not bypass validation.

---

# 80. AI Integrity

The AI system must not invent a question ID or falsely claim that a question exists in the Question Bank.

All selected questions must be validated against actual Question Bank records.

---

# 81. Question Reuse Tracking

The platform may track how frequently a question is used.

This can help prevent excessive repetition.

---

# 82. Question Exposure

For secure assessments, the system may track previous exposure of questions.

Example:

```text
Question Used in:
Exam A
Exam B
Practice Test
```

---

# 83. Question Exclusion Rules

Teachers may exclude:

```text
Previously Used Questions
Specific Questions
Specific Topics
Specific Difficulty Levels
```

---

# 84. Paper Blueprint

A blueprint may contain:

```text
Section
Question Type
Question Count
Marks
Difficulty
Chapter
Topic
Learning Objective
```

---

# 85. Blueprint Example

```text
SECTION A
MCQ
10 Questions
1 Mark Each
Easy / Medium

SECTION B
Short Questions
5 Questions
2 Marks Each
Medium

SECTION C
Long Questions
3 Questions
5 Marks Each
Medium / Hard
```

---

# 86. Blueprint Validation

The system should identify when the blueprint cannot be fulfilled.

Example:

```text
Required:
10 Hard MCQs

Available:
6 Hard MCQs
```

The system should show a clear warning instead of silently generating an invalid paper.

---

# 87. Paper Generation Failure

If automatic generation cannot satisfy requirements:

```text
GENERATION FAILED
 ↓
SHOW REASON
 ↓
SUGGEST ADJUSTMENT
```

---

# 88. Paper Builder Dashboard

Teacher dashboard may show:

```text
My Papers
Drafts
Pending Review
Published
Templates
Recent Papers
```

---

# 89. Paper Search

Users may search by:

```text
Paper Title
Class
Subject
Exam Type
Academic Year
Status
Created By
```

---

# 90. Paper Filters

Example:

```text
Class = 9
Subject = Biology
Status = Published
Year = 2026
```

---

# 91. Paper Permissions

Permissions may include:

```text
Create
View
Edit
Duplicate
Delete
Review
Approve
Publish
Export
Lock
Archive
```

---

# 92. Teacher Permissions

Teachers may manage papers within their authorized academic scope.

---

# 93. School Permissions

Authorized school administrators may review and manage school-level papers according to permissions.

---

# 94. Platform Administrator

Platform administrators may have broader access for system administration and support.

---

# 95. Student Access

Students should only receive papers assigned or made available through the appropriate assessment/test system.

---

# 96. Parent Access

Parents normally do not create papers.

They may see assessment information only through authorized parent features.

---

# 97. Paper Security

Unpublished papers should be protected from unauthorized access.

---

# 98. Confidential Papers

Exam papers may be marked:

```text
CONFIDENTIAL
```

Access must be restricted.

---

# 99. Secure Publishing

Publishing workflow:

```text
DRAFT
 ↓
VALIDATE
 ↓
APPROVE
 ↓
LOCK
 ↓
PUBLISH
```

---

# 100. Audit Logging

Important actions should be logged:

```text
PAPER_CREATED
PAPER_UPDATED
QUESTION_ADDED
QUESTION_REMOVED
QUESTION_REPLACED
PAPER_VALIDATED
PAPER_SUBMITTED_FOR_REVIEW
PAPER_APPROVED
PAPER_PUBLISHED
PAPER_LOCKED
PAPER_EXPORTED
PAPER_DUPLICATED
PAPER_ARCHIVED
```

---

# 101. Paper Analytics

The system may track:

```text
Papers Created
Papers Published
Questions Used
Question Reuse
Average Difficulty
Chapter Coverage
```

---

# 102. Assessment Integration

The Paper Builder connects to the Assessment system.

```text
PAPER BUILDER
 ↓
ASSESSMENT
```

---

# 103. Test Engine Integration

Digital papers may be delivered through the Test Engine.

```text
PAPER BUILDER
 ↓
PUBLISHED PAPER
 ↓
TEST ENGINE
 ↓
STUDENT TEST
```

---

# 104. Result Engine Integration

The Result Engine receives evaluated assessment data.

```text
PAPER
 ↓
TEST
 ↓
RESPONSES
 ↓
EVALUATION
 ↓
RESULT ENGINE
```

---

# 105. Question Bank Integration

```text
QUESTION BANK
 ↓
SEARCH / FILTER
 ↓
PAPER BUILDER
 ↓
SELECT QUESTIONS
```

---

# 106. Learning Progress Integration

Assessment results may later contribute to Learning Progress.

The Paper Builder itself should not calculate learning progress.

---

# 107. Revision Integration

Assessment performance may generate revision recommendations through the Revision Engine.

The Paper Builder should not duplicate revision logic.

---

# 108. Analytics Integration

Paper creation and usage events may be sent to Analytics.

```text
PAPER EVENTS
 ↓
ANALYTICS
 ↓
REPORTING
```

---

# 109. Media Integration

Questions may reference media managed by the Media system.

---

# 110. Notification Integration

The Paper Builder may trigger notifications for:

```text
Review Required
Paper Approved
Paper Rejected
Paper Published
```

---

# 111. API Boundary

Conceptual services:

```text
Create Paper
Get Paper
Update Paper
Duplicate Paper
Add Question
Remove Question
Reorder Questions
Create Section
Update Section
Validate Paper
Preview Paper
Submit For Review
Approve Paper
Publish Paper
Lock Paper
Archive Paper
Create Template
Generate Variant
Export Paper
```

Exact API endpoint naming belongs to the API architecture.

---

# 112. Paper Builder Components

Core components:

```text
Paper Manager
Paper Editor
Section Manager
Question Selector
Blueprint Manager
Question Filter
Marks Calculator
Difficulty Analyzer
Coverage Analyzer
Validation Engine
Preview Renderer
Template Manager
Version Manager
Approval Manager
Publishing Manager
Export Manager
Audit Logger
```

---

# 113. Complete Paper Builder Architecture

```text
                         TEACHER
                            │
                            ↓
                    PAPER BUILDER
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
        PAPER CONFIG     BLUEPRINT      TEMPLATE
             │              │              │
             └──────────────┼──────────────┘
                            ↓
                      QUESTION BANK
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
         SEARCH          FILTER         RANDOM
             │              │              │
             └──────────────┼──────────────┘
                            ↓
                   QUESTION SELECTION
                            ↓
                    PAPER ASSEMBLY
                            ↓
                 MARKS / RULE VALIDATION
                            ↓
                         PREVIEW
                            ↓
                    REVIEW / APPROVAL
                            ↓
                          LOCK
                            ↓
                        PUBLISH
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
        TEST ENGINE     PRINT / PDF     ARCHIVE
             │
             ↓
          STUDENT
             │
             ↓
         RESPONSES
             │
             ↓
        RESULT ENGINE
```

---

# 114. Complete Paper Creation Flow

```text
LOGIN
 ↓
CREATE PAPER
 ↓
SELECT CLASS
 ↓
SELECT SUBJECT
 ↓
SELECT PAPER TYPE
 ↓
SET TIME / MARKS
 ↓
CREATE SECTIONS
 ↓
DEFINE BLUEPRINT
 ↓
SELECT QUESTIONS
 ↓
ARRANGE QUESTIONS
 ↓
SET OPTIONS
 ↓
VALIDATE
 ↓
PREVIEW
 ↓
REVIEW
 ↓
APPROVE
 ↓
LOCK
 ↓
PUBLISH
```

---

# 115. Automatic Paper Generation Flow

```text
TEACHER BLUEPRINT
 ↓
CHECK QUESTION BANK
 ↓
MATCH QUESTIONS
 ↓
APPLY FILTERS
 ↓
SELECT QUESTIONS
 ↓
BALANCE DIFFICULTY
 ↓
BALANCE MARKS
 ↓
CHECK COVERAGE
 ↓
GENERATE PAPER
 ↓
VALIDATE
 ↓
TEACHER REVIEW
```

---

# 116. Paper Variant Flow

```text
MASTER PAPER
 ↓
VARIANT GENERATOR
 ↓
VERSION A
VERSION B
VERSION C
 ↓
VALIDATE EACH VERSION
 ↓
PUBLISH
```

---

# 117. AI Paper Assistance Flow

```text
TEACHER REQUEST
 ↓
AI ASSISTANT
 ↓
SUGGESTIONS
 ↓
QUESTION BANK VALIDATION
 ↓
PAPER DRAFT
 ↓
TEACHER REVIEW
 ↓
PUBLISH
```

---

# 118. Security Flow

```text
AUTHENTICATION
 ↓
ROLE CHECK
 ↓
ACADEMIC SCOPE
 ↓
PAPER PERMISSION
 ↓
CONFIDENTIALITY CHECK
 ↓
ALLOW / DENY
```

---

# 119. Future Features

The architecture should support:

```text
AI Paper Generator
Adaptive Paper Generation
Curriculum Coverage Intelligence
Question Exposure Analysis
Automatic Difficulty Balancing
Smart Blueprint Generator
Bilingual Paper Generation
Multiple Paper Variants
Advanced Equation Support
Digital Answer Sheet
OMR-Compatible Papers
Secure Exam Delivery
Question Leakage Detection
```

---

# 120. Testing Requirements

The Paper Builder should be tested for:

```text
Paper Creation
Paper Editing
Section Creation
Question Selection
Question Search
Question Filtering
Random Selection
Blueprint Generation
Difficulty Distribution
Chapter Distribution
Topic Distribution
Marks Calculation
Optional Questions
Question Groups
Sub-Questions
Question Numbering
Question Media
Bilingual Content
Templates
Duplication
Versioning
Validation
Preview
Approval
Publishing
Locking
Export
Paper Variants
Permissions
Confidentiality
Audit Logging
Question Reuse
Question Exposure
AI Assistance
Question Bank Integration
Assessment Integration
Test Engine Integration
Result Engine Integration
Analytics
Notifications
Security
Concurrency
Failure Recovery
```

---

# 121. Final Paper Builder Principle

The Aspirian Paper Builder must provide:

> **A secure and flexible academic paper construction system that allows authorized educators to build curriculum-aligned assessments from the Question Bank, configure sections, marks, difficulty and coverage, generate reusable paper variants, validate academic rules, preview final papers and publish them through the Assessment and Test systems without duplicating Question Bank or Result Engine responsibilities.**

---

# 122. Document Status

**File:** `PAPER_BUILDER.md`
**Version:** 1.0
**Status:** Final Paper Builder Blueprint
**Phase:** D
**Module:** D13 — Paper Builder
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Paper Builder for the Aspirian Student Platform.
