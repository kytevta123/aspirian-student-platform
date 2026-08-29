# Aspirian Student Platform — Question Management

**Version:** 1.0
**Status:** Final Question Management System Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

The Question Management module provides a centralized system for creating, importing, organizing, reviewing, approving, publishing, maintaining, and analyzing questions across the Aspirian Student Platform.

It connects the Question Bank with:

```text
Students
Teachers
Schools
Tests
Exams
Paper Builder
AI Question Generator
AI Paper Generator
Revision Engine
Flashcards
Viva
Analytics
```

---

# 2. Vision

The Question Management System should become the central question lifecycle engine of Aspirian.

```text
                         QUESTION MANAGEMENT
                                  ↓
             ┌────────────────────┼────────────────────┐
             ↓                    ↓                    ↓
           CREATE               IMPORT              AI GENERATE
             ↓                    ↓                    ↓
             └────────────────────┼────────────────────┘
                                  ↓
                               REVIEW
                                  ↓
                              APPROVAL
                                  ↓
                              PUBLISH
                                  ↓
                  ┌───────────────┼───────────────┐
                  ↓               ↓               ↓
                TESTS           PAPERS          REVISION
                  ↓               ↓               ↓
                  └───────────────┼───────────────┘
                                  ↓
                              ANALYTICS
```

---

# 3. Question Sources

Questions may originate from:

```text
Teacher
School Admin
Platform Admin
Content Team
AI Question Generator
Imported Question Bank
Manually Created
```

---

# 4. Question Types

The system should support:

```text
MCQ
True / False
Fill in the Blank
Short Answer
Long Answer
Essay
Matching
Ordering
Numerical
Descriptive
Coding
Practical
Viva
Case Study
Scenario Based
```

---

# 5. MCQ Structure

An MCQ may contain:

```text
Question
Option A
Option B
Option C
Option D
Correct Answer
Explanation
Marks
Difficulty
```

The number of options should be configurable.

---

# 6. True / False

Example structure:

```text
Statement
Correct Answer
Explanation
Marks
```

---

# 7. Fill in the Blank

Support:

```text
Question
Expected Answer
Accepted Alternatives
Explanation
Marks
```

---

# 8. Short Answer

Support:

```text
Question
Expected Answer
Marking Guidance
Marks
```

---

# 9. Long Answer

Support:

```text
Question
Expected Answer
Marking Scheme
Key Points
Marks
```

---

# 10. Essay Questions

Support:

```text
Prompt
Instructions
Word Limit
Marking Criteria
Marks
```

---

# 11. Coding Questions

Support:

```text
Problem Statement
Input
Output
Constraints
Starter Code
Programming Language
Test Cases
Expected Output
Marks
```

---

# 12. Practical Questions

Support:

```text
Task
Instructions
Required Materials
Expected Result
Assessment Criteria
Marks
```

---

# 13. Viva Questions

Support:

```text
Question
Expected Answer
Difficulty
Topic
Follow-up Questions
Marks
```

---

# 14. Question Metadata

Each question should support appropriate metadata.

```text
Question ID
Question Type
Question Text
Class
Subject
Chapter
Topic
Learning Objective
Difficulty
Language
Marks
Time Estimate
Source
Author
Reviewer
Status
Visibility
Created At
Updated At
```

---

# 15. Question ID

Every question must have a unique identifier.

Example:

```text
Q-2026-000001
```

---

# 16. Question Status

Recommended lifecycle:

```text
Draft
In Review
Changes Requested
Approved
Scheduled
Published
Deprecated
Archived
```

---

# 17. Question Lifecycle

```text
CREATE
  ↓
DRAFT
  ↓
REVIEW
  ↓
CORRECTION
  ↓
APPROVAL
  ↓
PUBLISH
  ↓
USE
  ↓
REVIEW / UPDATE
  ↓
ARCHIVE
```

---

# 18. Draft Questions

Draft questions are not available for official tests unless explicitly permitted.

---

# 19. Review Queue

Reviewers can see questions waiting for approval.

---

# 20. Reviewer Actions

```text
Approve
Reject
Request Changes
Edit
Comment
Flag
```

---

# 21. Approval

Only authorized users may approve questions for official use.

---

# 22. Publication

Publishing makes a question available to authorized question-bank consumers.

---

# 23. Question Visibility

Possible visibility:

```text
Private
Teacher Only
School Only
Class
Section
Platform
Public
```

---

# 24. Multi-Tenant Isolation

School-private questions must never become visible to another school unless explicitly shared.

---

# 25. Question Ownership

The system should track:

```text
Creator
Owner
School
Reviewer
Publisher
```

---

# 26. Question Author

Every manually created question should record its creator.

---

# 27. Question Source

Source metadata may identify:

```text
Teacher Created
School Created
Platform Created
AI Generated
Imported
```

---

# 28. AI-Generated Questions

AI-generated questions must enter a controlled review workflow.

```text
AI GENERATION
      ↓
DRAFT
      ↓
HUMAN REVIEW
      ↓
CORRECTION
      ↓
APPROVAL
      ↓
PUBLISH
```

AI-generated questions should not automatically become official examination questions.

---

# 29. AI Question Generator Integration

The Question Management system integrates with:

```text
AI_QUESTION_GENERATOR.md
```

Inputs may include:

```text
Class
Subject
Chapter
Topic
Learning Objective
Difficulty
Question Type
Quantity
Language
```

---

# 30. AI Question Validation

AI-generated questions should be checked for:

```text
Correctness
Relevance
Duplicate Content
Age Appropriateness
Difficulty
Curriculum Alignment
Answer Accuracy
Language Quality
```

---

# 31. Answer Validation

The system should ensure that:

```text
MCQ → Correct Option Exists
True/False → Valid Boolean Answer
Short Answer → Expected Answer Exists
Coding → Test Cases Exist Where Required
```

---

# 32. Question Difficulty

Recommended levels:

```text
Very Easy
Easy
Medium
Hard
Very Hard
```

Optional numeric difficulty:

```text
1 → 5
```

---

# 33. Difficulty Calibration

Actual difficulty can later be estimated from student performance.

---

# 34. Question Tags

Questions may use tags:

```text
python
variables
class-9
programming
mcq
```

---

# 35. Categories

Questions may be grouped by meaningful categories.

---

# 36. Curriculum Mapping

Every official question should ideally map to:

```text
Class
Subject
Chapter
Topic
Learning Objective
```

---

# 37. Learning Objective

Questions may measure specific learning objectives.

Example:

```text
Identify variables
Explain data types
Write basic Python code
```

---

# 38. Bloom's Taxonomy

Where useful, questions may be classified as:

```text
Remember
Understand
Apply
Analyze
Evaluate
Create
```

---

# 39. Cognitive Level

Cognitive-level metadata can help create balanced papers.

---

# 40. Question Language

Supported languages:

```text
English
Urdu
Roman Urdu
```

Future languages may be added.

---

# 41. Multilingual Questions

A question may have linked language versions.

```text
Question
├── English
├── Urdu
└── Roman Urdu
```

---

# 42. Translation Relationship

Translated questions should remain linked to the original question.

---

# 43. Question Explanation

Questions should support explanations where appropriate.

For example:

```text
Correct Answer
Why Correct
Why Other Options Are Incorrect
```

---

# 44. Student Explanation

Explanations can be displayed after an attempt according to test settings.

---

# 45. Teacher Explanation

Teachers may add detailed teaching explanations.

---

# 46. Answer Key

Each applicable question must define its answer key.

---

# 47. Marking Scheme

Descriptive questions may require structured marking schemes.

Example:

```text
Definition = 2 marks
Explanation = 2 marks
Example = 1 mark
```

---

# 48. Partial Marks

The system should support partial marking where applicable.

---

# 49. Negative Marking

Tests may optionally define negative marking.

The question management system should store relevant configuration without forcing it globally.

---

# 50. Question Time Estimate

Questions may have an estimated completion time.

Example:

```text
MCQ → 1 minute
Short Answer → 3 minutes
Essay → 15 minutes
```

---

# 51. Media Questions

Questions may include:

```text
Images
Audio
Video
Diagrams
Tables
```

---

# 52. Image-Based Questions

Support questions where students must interpret an image or diagram.

---

# 53. Audio Questions

Useful for:

```text
Language Learning
Listening Tests
Pronunciation
Viva Practice
```

---

# 54. Video Questions

Questions may be linked to a video segment.

---

# 55. Mathematical Questions

Support mathematical expressions and formulas.

---

# 56. Code Questions

Support syntax-highlighted code blocks.

---

# 57. Question Attachments

Questions may contain authorized attachments.

---

# 58. Attachment Security

All uploaded files must undergo appropriate validation and security controls.

---

# 59. Question Search

Search by:

```text
Question ID
Question Text
Keyword
Class
Subject
Chapter
Topic
Question Type
Difficulty
Language
Tag
Author
Status
```

---

# 60. Question Filters

Advanced filtering:

```text
Class
Subject
Chapter
Topic
Difficulty
Question Type
Learning Objective
Bloom Level
Language
Status
Source
```

---

# 61. Question Bank Integration

Question Management is the administrative layer over the Question Bank.

```text
QUESTION MANAGEMENT
        ↓
QUESTION BANK
        ↓
TEST ENGINE
        ↓
RESULT ENGINE
```

---

# 62. Question Collections

Questions can be grouped into collections.

Example:

```text
Class 9 Computer Science
 ├── Programming
 ├── Data Types
 ├── Variables
 └── Control Structures
```

---

# 63. Question Sets

Teachers may create temporary or reusable question sets.

---

# 64. Question Pools

A question pool allows tests to randomly select questions.

Example:

```text
Pool: Class 9 Variables
Questions: 100
Test selects: 20
```

---

# 65. Random Selection

Tests may select questions based on:

```text
Topic
Difficulty
Question Type
Marks
Learning Objective
```

---

# 66. Balanced Question Selection

The system should support rules such as:

```text
5 Easy
10 Medium
5 Hard
```

---

# 67. Duplicate Detection

The system should identify potentially duplicate questions.

Methods may include:

```text
Exact Text Matching
Normalized Text Matching
Semantic Similarity
```

---

# 68. Duplicate Review

Potential duplicates should be flagged for human review rather than automatically deleted.

---

# 69. Similar Question Detection

The system may identify questions testing the same concept.

---

# 70. Question Reuse

Approved questions can be reused across multiple:

```text
Tests
Exams
Practice Sets
Revision Activities
Flashcards
```

subject to permissions.

---

# 71. Question Usage Tracking

Track:

```text
Times Used
Tests
Papers
Practice Sessions
```

---

# 72. Question Performance

Track:

```text
Attempts
Correct Answers
Incorrect Answers
Accuracy
Average Time
```

---

# 73. Difficulty Validation

Actual performance can indicate whether a question is:

```text
Too Easy
Appropriate
Too Difficult
```

---

# 74. Question Quality Score

The platform may calculate a quality indicator based on:

```text
Review Status
Performance
Reported Issues
Duplicate Risk
Curriculum Alignment
```

This should be advisory, not automatically determinative.

---

# 75. Student Feedback

Students may report:

```text
Wrong Answer
Ambiguous Question
Typo
Technical Issue
Incorrect Explanation
```

---

# 76. Teacher Feedback

Teachers may flag:

```text
Incorrect Question
Wrong Difficulty
Poor Wording
Curriculum Mismatch
```

---

# 77. Question Flagging

Flagged questions enter a review queue.

---

# 78. Question Correction

Authorized reviewers can correct:

```text
Question Text
Options
Correct Answer
Explanation
Metadata
```

---

# 79. Correction History

Important changes must be recorded.

---

# 80. Versioning

Questions should support versions.

```text
Version 1
 ↓
Version 2
 ↓
Version 3
```

---

# 81. Version Rules

A published question should not be silently modified when historical test integrity depends on the original version.

---

# 82. Exam Snapshot

When a question is used in an official exam, the system should preserve the relevant question version/snapshot.

---

# 83. Historical Integrity

Past results must continue to reference the question version used during the original attempt.

---

# 84. Question Retirement

Questions may be marked:

```text
Deprecated
Archived
Retired
```

---

# 85. Retirement Reasons

Examples:

```text
Outdated Curriculum
Incorrect Content
Duplicate
Poor Performance
Curriculum Change
```

---

# 86. Archived Questions

Archived questions should not appear in new tests unless explicitly restored or allowed.

---

# 87. Question Restoration

Authorized users may restore archived questions after review.

---

# 88. Import

Questions may be imported from:

```text
CSV
Excel
JSON
Structured Question Banks
```

---

# 89. Import Workflow

```text
Upload
 ↓
Parse
 ↓
Validate
 ↓
Preview
 ↓
Confirm
 ↓
Import
 ↓
Report
```

---

# 90. Import Validation

Check:

```text
Required Fields
Question Type
Correct Answer
Class
Subject
Duplicate Questions
Invalid References
```

---

# 91. Import Error Report

The system should show:

```text
Successful
Skipped
Failed
Duplicate
Invalid
```

records.

---

# 92. Bulk Question Operations

Authorized users may:

```text
Approve
Reject
Publish
Archive
Tag
Move
Assign
Export
```

questions in bulk.

---

# 93. Bulk Safety

Important bulk actions require:

```text
Preview
Confirmation
Permission Check
Audit Log
```

---

# 94. Export

Authorized users may export selected question data.

Supported formats may include:

```text
CSV
Excel
JSON
PDF
```

depending on requirements.

---

# 95. Question Paper Integration

Approved questions can be sent to:

```text
PAPER_BUILDER.md
```

for examination paper construction.

---

# 96. AI Paper Generator Integration

Approved question pools may be used by:

```text
AI_PAPER_GENERATOR.md
```

to create draft papers.

---

# 97. Test Engine Integration

Questions can be delivered to:

```text
TEST_ENGINE.md
```

for student assessments.

---

# 98. Result Engine Integration

Student answers and question metadata feed:

```text
RESULT_ENGINE.md
```

for scoring and analytics.

---

# 99. Revision Engine Integration

Incorrectly answered questions can be recommended for revision.

---

# 100. Flashcard Integration

Question concepts may be converted into flashcards where appropriate.

---

# 101. Viva Integration

Viva questions can use the same question-management lifecycle.

---

# 102. Coding Lab Integration

Coding questions can connect with the Coding Lab execution environment.

---

# 103. Practical Integration

Practical questions can connect with practical assessments.

---

# 104. Question Analytics

Administrative dashboard may show:

```text
Total Questions
Published
Draft
Pending Review
Archived
AI Generated
Reported
Duplicate Candidates
```

---

# 105. Question Performance Dashboard

Metrics:

```text
Total Attempts
Average Accuracy
Average Time
Difficulty Distribution
Question Type Distribution
```

---

# 106. Class Analytics

Analyze question performance by class.

---

# 107. Subject Analytics

Analyze question performance by subject.

---

# 108. Topic Analytics

Analyze performance by topic.

---

# 109. Learning Objective Analytics

Determine whether students are mastering specific objectives.

---

# 110. Difficulty Distribution

Example:

```text
Easy       30%
Medium     50%
Hard       20%
```

---

# 111. Question Type Distribution

Example:

```text
MCQ             60%
Short Answer    20%
Long Answer     10%
Coding          10%
```

---

# 112. Teacher Question Analytics

Teachers may view performance of questions they created where authorized.

---

# 113. School Question Analytics

School administrators may view school-owned question performance.

---

# 114. Platform Question Analytics

Platform administrators may view aggregate question analytics according to access policy.

---

# 115. Privacy

Analytics should avoid exposing unnecessary student-identifying information.

---

# 116. Question Security

Protect against:

```text
Unauthorized Access
Question Leakage
Unauthorized Export
Unauthorized Modification
Privilege Escalation
```

---

# 117. Exam Question Security

Questions used in upcoming exams require stronger access controls.

---

# 118. Question Locking

Questions may be locked while being used in an official examination workflow.

---

# 119. Exam Access

Students should not access official examination questions before the configured exam window.

---

# 120. Audit Logging

Record important actions:

```text
Created
Edited
Reviewed
Approved
Published
Used
Exported
Archived
Restored
Deleted
```

---

# 121. Audit Fields

```text
Actor
Action
Question ID
Version
Timestamp
School
Previous State
New State
```

where appropriate.

---

# 122. Role-Based Permissions

Recommended permissions:

```text
questions.view
questions.create
questions.edit
questions.review
questions.approve
questions.publish
questions.archive
questions.restore
questions.delete
questions.import
questions.export
```

---

# 123. Content Creator Role

May:

```text
Create
Edit Own Drafts
Submit for Review
```

---

# 124. Reviewer Role

May:

```text
View
Edit
Review
Request Changes
Approve
Reject
```

---

# 125. Publisher Role

May:

```text
Publish
Unpublish
Schedule
```

---

# 126. School Admin Role

May manage school-level questions according to assigned permissions.

---

# 127. Platform Admin Role

May manage platform-wide question systems and policies.

---

# 128. Student Access

Students receive questions through authorized:

```text
Tests
Practice
Revision
Viva
Coding
Practical
```

interfaces.

---

# 129. Parent Access

Parents should not receive restricted examination questions.

They may receive appropriate learning progress information.

---

# 130. API Architecture

```text
QUESTION UI
     ↓
QUESTION API
     ↓
AUTHORIZATION
     ↓
TENANT VALIDATION
     ↓
QUESTION SERVICE
     ↓
QUESTION DATABASE
     ↓
TEST / PAPER / AI SERVICES
```

---

# 131. Server-Side Authorization

All question permissions must be enforced on the backend.

Frontend controls alone are insufficient.

---

# 132. Tenant Validation

Every school-level question request must validate:

```text
User
School
Role
Permission
Question Ownership
Visibility
```

---

# 133. Performance

Use:

```text
Pagination
Filtering
Database Indexing
Caching
Background Jobs
```

where appropriate.

---

# 134. Background Jobs

Suitable for:

```text
Large Imports
Large Exports
Duplicate Detection
Semantic Analysis
AI Generation
Analytics Processing
```

---

# 135. Search Performance

Search indexes may be used for large question banks.

---

# 136. Availability

Question Management should be designed to support large numbers of:

```text
Schools
Teachers
Questions
Students
Assessments
```

---

# 137. Accessibility

Administrative question interfaces should support:

```text
Keyboard Navigation
Accessible Forms
Screen Readers
Readable Labels
Clear Validation
```

---

# 138. Mobile Support

Question management should be responsive on:

```text
Desktop
Tablet
Mobile
```

---

# 139. Error Handling

The system should:

```text
Show Clear Errors
Prevent Data Loss
Allow Retry
Prevent Duplicate Submission
Log Important Failures
```

---

# 140. Autosave

Question drafts should support autosave where appropriate.

---

# 141. Question Preview

Authorized users can preview questions exactly as students will see them.

---

# 142. Preview Modes

```text
Student View
Teacher View
Print View
Mobile View
```

---

# 143. Print Formatting

Questions may support print-friendly formatting for paper exams.

---

# 144. Question Paper Export

Approved questions may be exported into paper-building workflows.

---

# 145. AI Safety

All AI-generated questions must follow:

```text
AI_SAFETY.md
```

and appropriate human-review requirements.

---

# 146. Academic Integrity

The system must protect examination content from premature disclosure.

---

# 147. Question Quality Principles

Questions should be:

```text
Accurate
Clear
Curriculum-Aligned
Age-Appropriate
Unambiguous
Fair
Accessible
```

---

# 148. Bias Review

Questions should be reviewed for inappropriate or unnecessary bias.

---

# 149. Sensitive Content

Potentially sensitive content should have appropriate classification and access controls.

---

# 150. Question Health Monitoring

The system may identify:

```text
High Complaint Rate
Very Low Accuracy
Very High Accuracy
Duplicate Questions
Outdated Questions
Missing Answers
Missing Explanations
```

---

# 151. Automatic Flags

Automated systems may flag potential issues for human review.

They should not automatically remove educational content solely on statistical signals.

---

# 152. Curriculum Updates

When curriculum changes, affected questions should be identifiable.

---

# 153. Question Migration

Questions may be remapped to new:

```text
Class
Subject
Chapter
Topic
Learning Objective
```

structures.

---

# 154. Curriculum Versioning

Questions should retain information about the curriculum version under which they were created or approved.

---

# 155. Question Collections

Reusable collections can support:

```text
Board Preparation
Chapter Practice
Monthly Test
Mid-Term
Final Exam
Revision
```

---

# 156. Question Pool Examples

```text
Class 9 Mathematics
 ├── Algebra Pool
 ├── Geometry Pool
 └── Statistics Pool
```

---

# 157. Test Blueprint

Question Management should support test blueprints such as:

```text
Chapter 1 → 20%
Chapter 2 → 30%
Chapter 3 → 50%
```

---

# 158. Difficulty Blueprint

Example:

```text
Easy   → 30%
Medium → 50%
Hard   → 20%
```

---

# 159. Cognitive Blueprint

Example:

```text
Remember   → 30%
Understand → 30%
Apply      → 30%
Analyze    → 10%
```

---

# 160. Blueprint Validation

Before generating or publishing a paper, the system can verify whether the selected questions satisfy the blueprint.

---

# 161. Question Replacement

If a selected question is invalid or unavailable, authorized users can replace it while preserving the blueprint.

---

# 162. Final Question Architecture

```text
                         QUESTION MANAGEMENT
                                  ↓
                         AUTH / PERMISSIONS
                                  ↓
                         QUESTION LIFECYCLE
                                  ↓
       ┌──────────────────────────┼──────────────────────────┐
       ↓                          ↓                          ↓
     CREATE                    IMPORT                    AI GENERATE
       ↓                          ↓                          ↓
       └──────────────────────────┼──────────────────────────┘
                                  ↓
                               REVIEW
                                  ↓
                              APPROVAL
                                  ↓
                              QUESTION BANK
                                  ↓
             ┌────────────────────┼────────────────────┐
             ↓                    ↓                    ↓
            TEST                PAPER               REVISION
             ↓                    ↓                    ↓
             └────────────────────┼────────────────────┘
                                  ↓
                              ANALYTICS
                                  ↓
                               REPORTS
```

---

# 163. Complete Question Ecosystem

```text
                            QUESTIONS
                                ↓
       ┌────────────────────────┼────────────────────────┐
       ↓                        ↓                        ↓
    MANUAL                   IMPORTED                     AI
       ↓                        ↓                        ↓
       └────────────────────────┼────────────────────────┘
                                ↓
                              REVIEW
                                ↓
                             APPROVAL
                                ↓
                          QUESTION BANK
                                ↓
       ┌────────────────────────┼────────────────────────┐
       ↓                        ↓                        ↓
     TESTS                    PAPERS                  PRACTICE
       ↓                        ↓                        ↓
    RESULTS                  EXAMS                  REVISION
       └────────────────────────┼────────────────────────┘
                                ↓
                             ANALYTICS
                                ↓
                         BETTER QUESTIONS
```

---

# 164. Future Expansion

Future versions may include:

```text
AI Question Quality Scoring
Advanced Item Response Theory
Adaptive Question Selection
Automated Difficulty Calibration
Question Translation AI
Question Accessibility Checker
Advanced Plagiarism Detection
Question Marketplace
Board-Specific Question Libraries
Digital Question Authoring Tools
```

These are future extensions and do not alter the current core architecture.

---

# 165. Final Design Principles

```text
1. Academic Accuracy
2. Curriculum Alignment
3. Human Review
4. AI With Oversight
5. Secure Question Storage
6. Exam Integrity
7. Multi-Tenant Isolation
8. Version Control
9. Reusable Question Pools
10. Data-Driven Question Quality
```

---

# 166. Final Rule

> **Question Management must provide a secure, scalable and academically reliable lifecycle for every question on the Aspirian Student Platform—from creation and AI generation through review, approval, examination use, analytics, revision and retirement—while preserving academic integrity and historical accuracy.**

---

# 167. Document Status

**File:** `QUESTION_MANAGEMENT.md`
**Version:** 1.0
**Status:** Final Question Management System Blueprint
**Phase:** G
**Module:** G5 — Question Management
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Question Management architecture for the Aspirian Student Platform.
