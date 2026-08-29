# Aspirian Student Platform — Result Engine

**Version:** 1.0
**Status:** Final Result Engine Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the functional architecture of the Result Engine for the Aspirian Student Platform.

The Result Engine is responsible for processing completed assessment attempts and converting student performance data into reliable, structured and reusable results.

It manages:

* Score calculation
* Marks calculation
* Percentage calculation
* Correct/incorrect analysis
* Grade calculation
* Pass/fail determination
* Ranking where configured
* Result status
* Result publication
* Result history
* Result summaries
* Subject performance
* Chapter/topic performance
* Result verification
* Result corrections
* Result finalization
* Result analytics integration
* Result reporting

The underlying assessment data model is defined in:

```text
ASSESSMENT_MODEL.md
```

The Test Engine responsible for test execution is defined in:

```text
TEST_ENGINE.md
```

The learning data model is defined in:

```text
LEARNING_PROGRESS_MODEL.md
```

The analytics data model is defined in:

```text
ANALYTICS_DATA_MODEL.md
```

---

# 2. Result Engine Principle

The Result Engine converts finalized assessment attempts into authoritative result records.

```text
COMPLETED TEST ATTEMPT
        ↓
ANSWER VALIDATION
        ↓
QUESTION EVALUATION
        ↓
SCORE CALCULATION
        ↓
GRADE / PERCENTAGE
        ↓
PASS / FAIL
        ↓
RESULT FINALIZATION
        ↓
RESULT PUBLICATION
        ↓
LEARNING + ANALYTICS
```

---

# 3. Result Engine Scope

The Result Engine owns:

```text
Score Processing
Result Calculation
Grade Calculation
Pass/Fail Calculation
Result Finalization
Result Publication
Result Verification
Result Summaries
Result History
```

It does not own:

```text
Question Bank
Test Execution
Student Identity
Teacher Identity
School Identity
Learning Model
Analytics Infrastructure
AI Infrastructure
```

---

# 4. Assessment vs Test vs Result

The platform must keep these concepts separate.

```text
ASSESSMENT
"What should be tested?"

TEST ENGINE
"How does the student take it?"

RESULT ENGINE
"What was the student's outcome?"
```

Example:

```text
Assessment:
Class 9 Biology Test

Test Engine:
Student answers 20 questions

Result Engine:
Score = 17/20
Percentage = 85%
Grade = A
Status = Pass
```

---

# 5. Result Sources

Results may originate from:

```text
Online Test
Class Test
Chapter Test
Subject Test
Mock Exam
School Exam
Board Preparation Test
Practice Assessment
Diagnostic Assessment
```

---

# 6. Result Lifecycle

```text
ATTEMPT COMPLETED
       ↓
RESULT PROCESSING
       ↓
RESULT CALCULATED
       ↓
RESULT REVIEW
       ↓
RESULT FINAL
       ↓
RESULT PUBLISHED
```

---

# 7. Result Status

Possible result states:

```text
PENDING
PROCESSING
CALCULATED
REVIEW_REQUIRED
FINAL
PUBLISHED
WITHHELD
CANCELLED
```

---

# 8. Result Creation

A result should normally be generated after a valid assessment attempt has been finalized.

```text
TEST ATTEMPT
      ↓
VALIDATE
      ↓
CALCULATE
      ↓
CREATE RESULT
```

---

# 9. Result Identity

Every result should have a unique identifier.

Conceptually:

```text
Result ID
Attempt ID
Assessment ID
Student ID
Academic Context
Result Version
Result Status
```

---

# 10. Result Attempt Relationship

One attempt should produce one authoritative result for the applicable scoring state.

```text
STUDENT
   ↓
ASSESSMENT
   ↓
ATTEMPT
   ↓
RESULT
```

If a result is recalculated due to an authorized correction, the system should preserve the appropriate result history/version.

---

# 11. Question-Level Scoring

The Result Engine evaluates each answer.

Example:

```text
Question 1 → Correct → +1
Question 2 → Wrong → 0
Question 3 → Correct → +1
```

Question-level outcomes should be retained where required.

---

# 12. Correct Answers

For automatically gradable questions:

```text
Student Answer
      ↓
Correct Answer
      ↓
Evaluation
      ↓
Score
```

The correct answer should come from the appropriate question version/snapshot used by the assessment.

---

# 13. Incorrect Answers

An incorrect response should be evaluated according to the assessment scoring policy.

Possible score:

```text
0
```

or a configured negative score.

---

# 14. Unanswered Questions

Unanswered questions may receive:

```text
0 Marks
```

unless another assessment rule is explicitly configured.

---

# 15. Negative Marking

The Result Engine may support negative marking.

Example:

```text
Correct = +1
Wrong = -0.25
Unanswered = 0
```

The exact scoring policy belongs to the assessment configuration.

---

# 16. Partial Marks

The Result Engine may support partial marks.

Example:

```text
Maximum = 5
Awarded = 3
```

Partial scoring must follow the configured evaluation rules.

---

# 17. Raw Score

Raw score represents the total marks earned before additional transformations.

Example:

```text
Correct Marks = 17
Negative Marks = 1

Raw Score = 16
```

---

# 18. Maximum Score

The maximum possible score must be calculated from the finalized assessment configuration.

Example:

```text
Maximum Score = 20
```

---

# 19. Percentage

Percentage may be calculated as:

```text
Percentage =
(Obtained Score / Maximum Score) × 100
```

Example:

```text
16 / 20 × 100 = 80%
```

---

# 20. Percentage Precision

The platform should define consistent rounding rules.

Example:

```text
79.6666%
→ 79.67%
```

The exact display precision should be configurable.

---

# 21. Grade Calculation

Grades may be determined through an assessment or academic grading scheme.

Example:

```text
90–100 = A+
80–89  = A
70–79  = B
60–69  = C
50–59  = D
Below 50 = F
```

The actual grading scheme must be configurable by academic context.

---

# 22. Grading Scheme

Different boards, schools and assessments may use different grading systems.

Therefore:

```text
RESULT
 ↓
GRADING SCHEME
 ↓
GRADE
```

The grading scheme should not be hard-coded into the Result Engine.

---

# 23. Pass / Fail

Pass/fail status should be determined from configured rules.

Possible rules:

```text
Overall Percentage
Minimum Marks
Subject Minimum
Section Minimum
Custom Assessment Rule
```

---

# 24. Pass Status

Possible values:

```text
PASS
FAIL
CONDITIONAL
NOT_APPLICABLE
```

---

# 25. Subject Result

For subject-based assessments, the Result Engine may generate subject-level performance.

Example:

```text
Biology
Score: 42/50
Percentage: 84%
Grade: A
```

---

# 26. Multi-Subject Result

For examinations containing multiple subjects:

```text
EXAM
 ├── English
 ├── Mathematics
 ├── Physics
 ├── Chemistry
 └── Biology
```

The Result Engine may calculate:

```text
Subject Results
Overall Result
Total Marks
Overall Percentage
Overall Grade
```

---

# 27. Section-Level Results

Assessments may contain sections.

Example:

```text
Section A = MCQs
Section B = Short Questions
Section C = Long Questions
```

The Result Engine may calculate scores for each section.

---

# 28. Question-Type Performance

Results may contain performance by question type.

Example:

```text
MCQ Accuracy = 90%
Short Answer = 75%
Long Answer = 68%
```

This information can support learning analytics.

---

# 29. Chapter Performance

Where questions are linked to chapters, the Result Engine may calculate chapter-level performance.

Example:

```text
Chapter 1 = 90%
Chapter 2 = 65%
Chapter 3 = 82%
```

---

# 30. Topic Performance

The engine may calculate topic-level outcomes.

Example:

```text
Cell Structure = 88%
Cell Division = 62%
Genetics = 74%
```

---

# 31. Learning Objective Performance

Where questions have learning objectives, results may aggregate performance.

Example:

```text
Recall = 92%
Understand = 80%
Apply = 64%
Analyze = 58%
```

---

# 32. Result Summary

A standard result summary may contain:

```text
Student
Assessment
Attempt
Obtained Marks
Maximum Marks
Percentage
Grade
Pass/Fail
Correct
Incorrect
Unanswered
Time Taken
Result Status
```

---

# 33. Result Details

Detailed results may include:

```text
Question-Level Score
Question-Level Answer
Question-Level Status
Chapter
Topic
Difficulty
Explanation
```

Visibility depends on assessment policy.

---

# 34. Result Visibility

Results may be visible to:

```text
Student
Parent
Teacher
School
Platform Administrator
```

according to authorization.

---

# 35. Student Result Access

Students may view their own authorized results.

```text
STUDENT
 ↓
MY RESULTS
 ↓
RESULT
 ↓
DETAILS
```

---

# 36. Parent Result Access

Parents may view results of linked students where permitted.

```text
PARENT
 ↓
LINKED STUDENT
 ↓
RESULTS
```

---

# 37. Teacher Result Access

Teachers may view results for assessments within their authorized scope.

```text
TEACHER
 ↓
MY ASSESSMENTS
 ↓
STUDENT RESULTS
```

---

# 38. School Result Access

Authorized school staff may access aggregated or individual results according to school permissions.

---

# 39. Platform Administrator Access

Platform administrators may access results according to platform governance and privacy policies.

---

# 40. Result Privacy

A student should not be able to access another student's private result.

Authorization must be enforced server-side.

---

# 41. Result Publication

The Result Engine may publish results according to assessment policy.

Possible modes:

```text
Immediately
After Submission
After Manual Review
After Exam Completion
Scheduled Publication
```

---

# 42. Immediate Result

For simple practice tests:

```text
SUBMIT
 ↓
AUTO EVALUATE
 ↓
RESULT
 ↓
SHOW STUDENT
```

---

# 43. Delayed Result

For formal examinations:

```text
SUBMIT
 ↓
PROCESSING
 ↓
MANUAL REVIEW
 ↓
FINALIZE
 ↓
PUBLISH
```

---

# 44. Result Withholding

A result may temporarily be withheld.

Possible reasons:

```text
Manual Review
Administrative Decision
Result Verification
Technical Investigation
Assessment Policy
```

---

# 45. Result Finalization

Once finalized:

```text
RESULT
 ↓
FINAL
```

Important result fields should not be changed without an authorized correction process.

---

# 46. Result Correction

Authorized users may correct a result when a legitimate issue is identified.

Examples:

```text
Incorrect Answer Key
Manual Grading Error
Assessment Configuration Error
Technical Processing Error
```

---

# 47. Result Correction Principle

Corrections must be:

```text
Authorized
Auditable
Versioned
Traceable
```

---

# 48. Result Versioning

Example:

```text
Result
 ├── Version 1
 └── Version 2
```

The system should preserve relevant historical information.

---

# 49. Result Audit

Important actions should be logged.

Examples:

```text
Result Created
Result Calculated
Result Finalized
Result Published
Result Withheld
Result Corrected
Result Recalculated
Result Cancelled
```

---

# 50. Recalculation

The Result Engine may recalculate results when an authorized correction occurs.

Example:

```text
Original:
Question 5 = Wrong

Corrected Answer Key:
Question 5 = Correct

↓
Recalculate

Updated Result
```

---

# 51. Bulk Recalculation

If an assessment configuration or answer key error affects many students, authorized administrators may initiate controlled bulk recalculation.

The operation must be audited.

---

# 52. Result Integrity

Results should be calculated from immutable or versioned assessment data.

```text
TEST ATTEMPT
      ↓
QUESTION SNAPSHOT
      ↓
SCORING RULE
      ↓
RESULT
```

---

# 53. Historical Integrity

Changing a question later must not silently change an already finalized result.

---

# 54. Score Calculation Pipeline

```text
FINALIZED ATTEMPT
       ↓
LOAD ANSWERS
       ↓
LOAD QUESTION SNAPSHOTS
       ↓
LOAD SCORING RULES
       ↓
EVALUATE
       ↓
CALCULATE MARKS
       ↓
CALCULATE PERCENTAGE
       ↓
CALCULATE GRADE
       ↓
PASS/FAIL
       ↓
CREATE RESULT
```

---

# 55. Automatic Result Pipeline

```text
TEST SUBMITTED
      ↓
AUTO EVALUATION
      ↓
SCORE
      ↓
PERCENTAGE
      ↓
GRADE
      ↓
PASS/FAIL
      ↓
RESULT AVAILABLE
```

---

# 56. Manual Result Pipeline

```text
TEST SUBMITTED
      ↓
AUTO-GRADABLE QUESTIONS
      ↓
AUTO SCORE
      ↓
MANUAL QUESTIONS
      ↓
TEACHER GRADING
      ↓
FINAL SCORE
      ↓
RESULT FINAL
      ↓
PUBLISH
```

---

# 57. Result Calculation Example

```text
Total Questions = 20
Correct = 16
Incorrect = 3
Unanswered = 1

Maximum Marks = 20
Obtained Marks = 16

Percentage = 80%

Grade = A

Status = PASS
```

---

# 58. Time Performance

The result may include:

```text
Allowed Time
Time Taken
Remaining Time
Average Time Per Question
```

This can support learning analytics.

---

# 59. Attempt Performance

If multiple attempts are allowed, the system may retain:

```text
Attempt 1
Attempt 2
Attempt 3
```

and calculate attempt-specific results.

---

# 60. Best Attempt

For assessments that permit multiple attempts, the assessment configuration may define whether the platform should identify:

```text
Best Score
Latest Score
First Score
Average Score
```

The Result Engine should follow the configured policy.

---

# 61. Attempt Comparison

Students may optionally compare attempts where permitted.

Example:

```text
Attempt 1 = 62%
Attempt 2 = 74%
Attempt 3 = 86%
```

---

# 62. Result History

Students may access historical results.

```text
MY RESULTS
 ├── Test 1
 ├── Test 2
 ├── Test 3
 └── Mock Exam
```

---

# 63. Result Filtering

Users may filter authorized results by:

```text
Class
Subject
Assessment
Date
Academic Session
Result Status
```

---

# 64. Result Sorting

Results may be sorted by:

```text
Date
Score
Percentage
Assessment
Subject
```

---

# 65. Result Search

Authorized users may search results by relevant identifiers such as:

```text
Assessment
Student
Attempt
Result ID
```

Search must respect permissions.

---

# 66. Result Dashboard

A student result dashboard may display:

```text
Average Percentage
Tests Completed
Passed Tests
Failed Tests
Best Score
Recent Results
Subject Performance
```

---

# 67. Teacher Result Dashboard

Teachers may see:

```text
Class Average
Highest Score
Lowest Score
Pass Rate
Question Performance
Student Performance
```

---

# 68. School Result Dashboard

Schools may see authorized aggregated information such as:

```text
Assessment Participation
Average Score
Pass Rate
Subject Performance
Class Performance
```

---

# 69. Ranking

Ranking may be supported where explicitly configured.

Possible ranking types:

```text
Assessment Rank
Class Rank
School Rank
Group Rank
```

Ranking should never be assumed to be appropriate for every assessment.

---

# 70. Rank Calculation

If enabled:

```text
STUDENT SCORES
 ↓
RANKING POLICY
 ↓
SORT
 ↓
RANK
```

Tie handling must be configurable.

---

# 71. Ranking Privacy

Public ranking should be disabled by default.

The platform should avoid exposing unnecessary student information.

---

# 72. Percentile

Future results may include percentile calculations.

Example:

```text
Percentile = 91
```

Percentile methodology must be clearly defined.

---

# 73. Leaderboards

Practice assessments may optionally support leaderboards.

Leaderboards should be:

```text
Opt-In / Configurable
Privacy-Aware
Assessment-Specific
```

---

# 74. Result Reports

The Result Engine may generate reports such as:

```text
Student Result Report
Assessment Result Report
Class Result Report
Subject Result Report
School Result Report
```

---

# 75. Student Result Report

A student report may contain:

```text
Student Name
Assessment
Date
Marks
Percentage
Grade
Pass/Fail
Performance Summary
```

---

# 76. Detailed Performance Report

A detailed report may contain:

```text
Subject
Chapter
Topic
Correct Answers
Incorrect Answers
Unanswered
Accuracy
Time
Weak Areas
```

---

# 77. Result Export

Authorized users may export result data.

Possible formats:

```text
CSV
XLSX
PDF
JSON
```

Export permissions must be enforced.

---

# 78. Result Printing

The platform may provide printable result reports.

Possible documents:

```text
Result Card
Mark Sheet
Assessment Report
Student Performance Report
```

---

# 79. Result Card

A result card may contain:

```text
Student
Class
Subject
Assessment
Obtained Marks
Maximum Marks
Percentage
Grade
Status
```

---

# 80. Result Notifications

The platform may notify users when results become available.

Possible recipients:

```text
Student
Parent
Teacher
School
```

according to notification settings.

---

# 81. Result Events

The Result Engine may emit:

```text
RESULT_CREATED
RESULT_CALCULATED
RESULT_FINALIZED
RESULT_PUBLISHED
RESULT_WITHHELD
RESULT_CORRECTED
RESULT_RECALCULATED
RESULT_CANCELLED
```

---

# 82. Learning Progress Integration

Result data may contribute to student learning progress.

```text
RESULT
 ↓
TOPIC PERFORMANCE
 ↓
LEARNING PROGRESS
```

The Result Engine should send structured performance data rather than duplicate the complete learning system.

---

# 83. Analytics Integration

Results may feed analytics.

```text
RESULT
 ↓
ANALYTICS
 ↓
AGGREGATED PERFORMANCE
```

The Result Engine should provide authoritative result data to the analytics domain.

---

# 84. AI Integration

AI may consume authorized result information for:

```text
Performance Insights
Weak Topic Detection
Personalized Recommendations
Study Suggestions
Adaptive Learning
```

AI should not modify official results without an authorized result-processing workflow.

---

# 85. Result Verification

Authorized users may verify a result.

Possible information:

```text
Result ID
Assessment
Student
Score
Result Status
Verification Status
```

---

# 86. Result Integrity Token

Future implementations may provide a secure verification mechanism for official result documents.

Example:

```text
Result ID
Verification Code
QR Code
```

This should be implemented with appropriate security controls.

---

# 87. Result Security

The Result Engine must protect:

```text
Student Results
Scores
Grades
Rankings
Result Documents
Result History
Correction Records
```

---

# 88. Authorization Flow

```text
REQUEST
 ↓
AUTHENTICATION
 ↓
USER ROLE
 ↓
RESULT ACCESS POLICY
 ↓
OWNERSHIP / SCOPE CHECK
 ↓
ALLOW / DENY
```

---

# 89. Result Ownership

Results belong to the relevant assessment/attempt and student context.

Users must not be able to alter result ownership through client-side parameters.

---

# 90. Result Immutability

Finalized result data should be treated as immutable.

Corrections should create controlled updates/version records rather than silently overwriting history.

---

# 91. Transaction Safety

Result finalization should protect against:

```text
Duplicate Results
Partial Calculation
Double Processing
Inconsistent Scores
```

---

# 92. Idempotent Result Processing

If the same completed attempt is processed more than once, the engine should not accidentally create multiple authoritative results.

---

# 93. Processing Queue

Large-scale result processing may use background workers.

```text
SUBMITTED ATTEMPTS
       ↓
PROCESSING QUEUE
       ↓
RESULT WORKERS
       ↓
RESULTS
```

---

# 94. High-Concurrency Results

The Result Engine should support large numbers of simultaneous submissions.

Example:

```text
1,000 Students
10,000 Students
100,000 Students
```

depending on infrastructure capacity.

---

# 95. Performance

The engine should optimize:

```text
Score Calculation
Database Queries
Result Generation
Aggregation
Report Generation
Caching Where Safe
Background Processing
```

---

# 96. Error Handling

The system should provide safe user-facing messages.

Examples:

```text
"Your test was submitted successfully. Your result is being processed."

"Your result is currently under review."

"Your result is temporarily unavailable."
```

Technical implementation details should not be exposed.

---

# 97. Failed Processing

If result calculation fails:

```text
ATTEMPT COMPLETED
      ↓
PROCESSING ERROR
      ↓
RETRY / REVIEW
      ↓
RESULT
```

The original attempt must remain safe.

---

# 98. Result Recovery

The system should support recovery from:

```text
Worker Failure
Database Failure
Temporary Service Failure
Network Failure
Application Restart
```

---

# 99. Result Data Consistency

The following should remain consistent:

```text
Attempt
Answers
Question Snapshot
Scoring Rules
Score
Result
```

---

# 100. Complete Result Engine Architecture

```text
                         TEST ATTEMPT
                              │
                              ↓
                       FINALIZED ATTEMPT
                              │
                              ↓
                       ANSWER VALIDATION
                              │
                              ↓
                     QUESTION EVALUATION
                              │
                              ↓
                       SCORE CALCULATION
                              │
                 ┌────────────┼────────────┐
                 ↓            ↓            ↓
              MARKS       PERCENTAGE      GRADE
                 │            │            │
                 └────────────┼────────────┘
                              ↓
                         PASS / FAIL
                              ↓
                       RESULT FINALIZATION
                              ↓
                       RESULT PUBLICATION
                       ┌──────┴──────┐
                       ↓             ↓
                  LEARNING       ANALYTICS
                       │             │
                       └──────┬──────┘
                              ↓
                             AI
```

---

# 101. Complete Result Flow

```text
STUDENT
 ↓
TEST
 ↓
ATTEMPT
 ↓
SUBMIT
 ↓
RESULT ENGINE
 ↓
EVALUATE ANSWERS
 ↓
CALCULATE SCORE
 ↓
CALCULATE PERCENTAGE
 ↓
CALCULATE GRADE
 ↓
PASS / FAIL
 ↓
FINAL RESULT
 ↓
PUBLISH
 ↓
STUDENT / TEACHER / PARENT / SCHOOL
```

---

# 102. Result Correction Flow

```text
RESULT
 ↓
ISSUE IDENTIFIED
 ↓
AUTHORIZED REVIEW
 ↓
CORRECTION
 ↓
RECALCULATION
 ↓
NEW RESULT VERSION
 ↓
FINALIZATION
 ↓
AUDIT LOG
```

---

# 103. Result Analytics Flow

```text
QUESTION PERFORMANCE
       ↓
TEST RESULT
       ↓
SUBJECT PERFORMANCE
       ↓
TOPIC PERFORMANCE
       ↓
LEARNING PROGRESS
       ↓
ANALYTICS
```

---

# 104. Result Quality Controls

The Result Engine should verify:

```text
Attempt Validity
Question Version
Answer Integrity
Scoring Rules
Maximum Marks
Obtained Marks
Grade Scheme
Pass Rule
Result Status
```

---

# 105. Result Testing Requirements

The Result Engine should be tested for:

```text
Automatic Scoring
Manual Scoring
Negative Marking
Partial Marks
Unanswered Questions
Percentage Calculation
Grade Calculation
Pass/Fail
Multiple Attempts
Best Attempt
Result Publication
Result Withholding
Result Correction
Result Recalculation
Result Versioning
Duplicate Processing
Idempotency
Ranking
Percentile
Result Export
Result Reports
Authorization
Privacy
Audit Logging
High Concurrency
Failure Recovery
Historical Integrity
```

---

# 106. Future Result Features

The architecture should support:

```text
Advanced Gradebooks
Transcript Generation
Digital Report Cards
QR-Based Result Verification
Board-Style Mark Sheets
Competency Scores
Skill Scores
AI Performance Reports
Predictive Performance Insights
Advanced Comparative Analytics
```

---

# 107. Digital Result Verification

Future official result documents may support:

```text
QR Code
Verification URL
Verification Code
Digital Signature
```

Security requirements must be defined before implementation.

---

# 108. Transcript Support

Future versions may generate long-term academic records.

```text
STUDENT
 ↓
ACADEMIC SESSIONS
 ↓
SUBJECT RESULTS
 ↓
FINAL RESULTS
 ↓
TRANSCRIPT
```

Transcript functionality should build on the Result Engine rather than duplicate result data.

---

# 109. Result Engine Boundaries

The Result Engine owns:

```text
Score Calculation
Grade Calculation
Pass/Fail
Result Processing
Result Finalization
Result Publication
Result Corrections
Result History
Result Reporting
```

It does not own:

```text
Question Authoring
Test Session Execution
Student Identity
Teacher Identity
School Identity
Learning Progress Storage
Analytics Infrastructure
AI Models
```

---

# 110. Core Result Engine Components

```text
Result Processor
Score Calculator
Grade Calculator
Pass/Fail Calculator
Result Finalizer
Result Publisher
Result Version Manager
Result Verification
Result Reporter
Result Exporter
Result Audit
```

---

# 111. Final Result Engine Principle

The Aspirian Result Engine must provide:

> **A reliable, secure, auditable and scalable result-processing system that converts finalized assessment attempts into accurate scores, percentages, grades, pass/fail outcomes and performance summaries while preserving historical integrity and supporting students, teachers, parents and schools through controlled result access.**

The Result Engine must remain separate from the Test Engine and Question Bank while integrating with Assessment, Learning Progress and Analytics through clearly defined boundaries.

---

# 112. Document Status

**File:** `RESULT_ENGINE.md`
**Version:** 1.0
**Status:** Final Result Engine Blueprint
**Phase:** D
**Module:** D8 — Result Engine
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Result Engine for the Aspirian Student Platform.
