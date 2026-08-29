# Aspirian Student Platform — Test Engine

**Version:** 1.0
**Status:** Final Test Engine Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the functional architecture of the Test Engine for the Aspirian Student Platform.

The Test Engine is responsible for executing online tests and assessments after they have been created and configured.

It manages the complete test-taking lifecycle:

* Test availability
* Student access
* Question delivery
* Test sessions
* Timer
* Question navigation
* Answer submission
* Auto-save
* Attempt management
* Auto-evaluation
* Result calculation
* Test completion
* Security
* Test recovery
* Performance events

The underlying assessment data model is defined in:

```text
ASSESSMENT_MODEL.md
```

The Question Bank functionality is defined in:

```text
QUESTION_BANK_MODULE.md
```

The Test Engine consumes these domains and executes the actual student test experience.

---

# 2. Test Engine Principle

The Test Engine converts a configured assessment into a controlled student testing session.

```text
ASSESSMENT
    ↓
TEST CONFIGURATION
    ↓
ELIGIBILITY
    ↓
TEST SESSION
    ↓
QUESTION DELIVERY
    ↓
STUDENT ANSWERS
    ↓
AUTO-SAVE
    ↓
SUBMISSION
    ↓
EVALUATION
    ↓
RESULT
    ↓
LEARNING + ANALYTICS
```

---

# 3. Test Engine Scope

The Test Engine is responsible for:

```text
Test Session
Question Delivery
Timer
Navigation
Answer Saving
Submission
Evaluation
Result Calculation
Attempt Control
Test Security
Recovery
```

It does not own:

```text
Question Bank
Student Master Data
Teacher Master Data
School Master Data
Learning Progress
Analytics Infrastructure
AI Infrastructure
```

---

# 4. Assessment vs Test Engine

The platform should clearly separate assessment definition from test execution.

```text
ASSESSMENT
"What test should exist?"

TEST ENGINE
"How does the student actually take it?"
```

Example:

```text
Assessment:
Class 9 Biology Chapter 1 Test
20 MCQs
30 Minutes

Test Engine:
Starts session
Shows questions
Runs timer
Saves answers
Submits test
Calculates result
```

---

# 5. Test Types

The Test Engine may support:

```text
Practice Test
Quiz
Class Test
Chapter Test
Subject Test
Mock Exam
School Exam
Board Preparation Test
Diagnostic Test
Revision Test
```

---

# 6. Test Modes

Possible execution modes:

```text
Timed
Untimed
Practice
Exam
Randomized
Adaptive
```

Not every mode needs to be available for every assessment type.

---

# 7. Test Session

Every student test execution should create a test session.

Conceptually:

```text
STUDENT
   ↓
TEST
   ↓
TEST SESSION
   ↓
QUESTIONS
   ↓
ANSWERS
```

The test session represents one execution of a test.

---

# 8. Test Attempt

An attempt represents the student's participation in a test.

Example:

```text
Attempt 1
Attempt 2
Attempt 3
```

The number of attempts must follow the assessment configuration.

---

# 9. Attempt Status

Possible attempt states:

```text
NOT_STARTED
IN_PROGRESS
SUBMITTED
AUTO_SUBMITTED
EXPIRED
CANCELLED
INVALIDATED
```

---

# 10. Test Session Lifecycle

```text
ELIGIBILITY CHECK
       ↓
SESSION CREATED
       ↓
TEST STARTED
       ↓
IN PROGRESS
       ↓
SUBMISSION
       ↓
EVALUATION
       ↓
RESULT GENERATED
       ↓
COMPLETED
```

---

# 11. Test Eligibility

Before starting a test, the system should verify:

```text
Authenticated User
Student Identity
Assessment Availability
Academic Context
Attempt Limit
Start Time
End Time
Enrollment
Access Permission
```

---

# 12. Test Access

A student should only access tests for which they are authorized.

```text
STUDENT
 ↓
AUTHORIZATION
 ↓
ASSESSMENT ELIGIBILITY
 ↓
TEST SESSION
```

---

# 13. Test Availability

An assessment may define:

```text
Start Date
Start Time
End Date
End Time
Timezone
```

The Test Engine must enforce the configured availability window.

---

# 14. Scheduled Test

For scheduled tests:

```text
BEFORE START
→ NOT AVAILABLE

DURING WINDOW
→ AVAILABLE

AFTER END
→ CLOSED
```

---

# 15. Attempt Limit

An assessment may allow:

```text
1 Attempt
2 Attempts
3 Attempts
Unlimited Practice Attempts
```

The Test Engine must enforce the configured attempt policy.

---

# 16. Attempt Number

Every attempt should have a sequential attempt number within the relevant assessment/student context.

Example:

```text
Student
 ↓
Biology Test
 ├── Attempt 1
 ├── Attempt 2
 └── Attempt 3
```

---

# 17. Test Start

When the student starts a test:

```text
START REQUEST
      ↓
AUTHORIZATION
      ↓
ELIGIBILITY
      ↓
ATTEMPT CHECK
      ↓
SESSION CREATION
      ↓
QUESTION PREPARATION
      ↓
TEST INTERFACE
```

---

# 18. Test Initialization

The system should initialize:

```text
Session ID
Attempt ID
Student ID
Assessment ID
Start Time
Expiry Time
Question Set
Question Order
Test Configuration
```

---

# 19. Question Snapshot

Questions used during a test should reference the appropriate question version or snapshot.

This protects historical test integrity.

```text
QUESTION BANK
      ↓
QUESTION VERSION
      ↓
TEST SNAPSHOT
      ↓
STUDENT SESSION
```

---

# 20. Randomization

The Test Engine may randomize:

```text
Question Order
Option Order
Question Pool Selection
```

Randomization must be deterministic enough to reproduce the student's test when required.

---

# 21. Question Pool

An assessment may define a larger question pool than the number presented to a student.

Example:

```text
Question Pool = 50
Questions Presented = 20
```

The Test Engine selects the configured number.

---

# 22. Randomized Question Selection

```text
ASSESSMENT
 ↓
QUESTION POOL
 ↓
FILTER
 ↓
RANDOM SELECTION
 ↓
STUDENT QUESTION SET
```

Selection must respect required constraints.

---

# 23. Question Distribution

The engine may enforce question distribution rules.

Example:

```text
Easy = 40%
Medium = 40%
Hard = 20%
```

The exact blueprint is defined by the assessment configuration.

---

# 24. Question Navigation

Students may navigate between questions according to the test configuration.

Possible navigation:

```text
Next
Previous
Question Number
Review
```

---

# 25. Navigation Modes

The assessment may configure:

```text
Free Navigation
Sequential Navigation
No Backtracking
```

The Test Engine must enforce the configured mode.

---

# 26. Question Status

Each question within a test session may have a state such as:

```text
NOT_VISITED
VISITED
ANSWERED
MARKED_FOR_REVIEW
SKIPPED
```

---

# 27. Answer State

The system should distinguish between:

```text
No Answer
Answered
Changed Answer
Marked for Review
Final Submitted Answer
```

---

# 28. Auto-Save

Student answers should be saved automatically.

Conceptual flow:

```text
STUDENT ANSWER
      ↓
CLIENT STATE
      ↓
SERVER SAVE
      ↓
SESSION ANSWER
```

---

# 29. Auto-Save Frequency

The exact interval may be configurable.

Auto-save may occur:

```text
On Answer Change
On Navigation
At Regular Intervals
Before Submission
```

---

# 30. Answer Recovery

If the browser or network disconnects:

```text
CONNECTION LOST
      ↓
LOCAL / SESSION STATE
      ↓
RECONNECT
      ↓
SERVER SYNC
      ↓
TEST CONTINUES
```

Where technically and securely supported.

---

# 31. Test Resume

A student with an interrupted active session may be allowed to resume if the assessment policy permits.

```text
ACTIVE SESSION
      ↓
INTERRUPTION
      ↓
LOGIN AGAIN
      ↓
SESSION VALIDATION
      ↓
RESUME TEST
```

---

# 32. Resume Restrictions

Resume behavior should consider:

```text
Test Expiry
Attempt Status
Security Policy
Time Remaining
Assessment Configuration
```

---

# 33. Timer

Timed assessments require a server-authoritative timer.

Example:

```text
Duration = 30 minutes

Start:
10:00

Expiry:
10:30
```

The browser timer should not be treated as the ultimate authority.

---

# 34. Server Time

The Test Engine should calculate remaining time using server-side timestamps.

This prevents simple client-side manipulation.

---

# 35. Timer States

Possible timer states:

```text
NOT_STARTED
RUNNING
PAUSED
EXPIRED
COMPLETED
```

Whether pause is allowed depends on the assessment configuration.

---

# 36. Pause Function

Some practice tests may support pause/resume.

Exam-mode tests may disable pause.

```text
PRACTICE
→ Pause Allowed

EXAM
→ Pause Normally Disabled
```

---

# 37. Timer Expiry

When time expires:

```text
TIMER EXPIRES
      ↓
ANSWER STATE FINALIZED
      ↓
AUTO-SUBMIT
      ↓
EVALUATION
      ↓
RESULT
```

---

# 38. Auto Submission

Auto-submission should occur when:

```text
Time Expires
Assessment Window Closes
System Policy Requires It
```

---

# 39. Manual Submission

Students may manually submit when permitted.

```text
STUDENT
 ↓
SUBMIT TEST
 ↓
CONFIRMATION
 ↓
FINALIZE ATTEMPT
 ↓
EVALUATE
```

---

# 40. Submission Confirmation

The interface should clearly warn the student that submission may be final.

Example:

```text
"You are about to submit your test.
After submission, you may not be able to change your answers."
```

---

# 41. Finalization

After final submission:

```text
ANSWER CHANGES
      ↓
LOCKED
```

unless the assessment explicitly supports post-submission changes.

---

# 42. Evaluation

The Test Engine evaluates answers according to question and assessment rules.

```text
SUBMITTED ANSWERS
       ↓
EVALUATION ENGINE
       ↓
QUESTION SCORES
       ↓
TOTAL SCORE
       ↓
RESULT
```

---

# 43. Automatic Evaluation

Suitable question types may be automatically evaluated.

Examples:

```text
MCQ
True / False
Matching
Fill in the Blank
```

Exact evaluation rules depend on the question type.

---

# 44. Manual Evaluation

Questions requiring human judgment may enter manual grading.

Examples:

```text
Short Answer
Long Answer
Essay
```

The Test Engine should mark such results as pending where appropriate.

---

# 45. Partial Marks

The engine may support partial scoring where the assessment configuration permits.

Example:

```text
Question = 4 marks
Student earns = 3 marks
```

---

# 46. Negative Marking

The Test Engine may support negative marking.

Example:

```text
Correct = +1
Wrong = -0.25
Unanswered = 0
```

Negative marking must be explicitly configured.

---

# 47. Scoring Rules

Scoring configuration may include:

```text
Correct Score
Incorrect Score
Unanswered Score
Partial Score
Negative Marking
```

---

# 48. Result Calculation

The engine may calculate:

```text
Raw Score
Maximum Score
Percentage
Correct Answers
Incorrect Answers
Unanswered Questions
```

---

# 49. Result Status

Possible result states:

```text
PENDING
PROCESSING
AVAILABLE
REVIEW_REQUIRED
FINAL
WITHHELD
```

---

# 50. Result Publication

Results should only become visible according to assessment policy.

Possible modes:

```text
Immediately
After Submission
After Teacher Review
After Exam Completion
Scheduled Publication
```

---

# 51. Result Integrity

Completed results must remain historically reproducible.

Later changes to question-bank content should not alter completed test results.

---

# 52. Test Review

After submission, the student may optionally review:

```text
Score
Correct Answers
Explanations
Question Performance
```

This depends on assessment configuration.

---

# 53. Answer Review

The platform may show:

```text
Your Answer
Correct Answer
Explanation
```

Only when permitted.

---

# 54. Practice Mode

Practice tests may provide immediate feedback.

```text
ANSWER
 ↓
EVALUATE
 ↓
SHOW FEEDBACK
```

Exam mode may delay feedback until completion.

---

# 55. Exam Mode

Exam mode should prioritize:

```text
Controlled Timing
Restricted Navigation
Answer Security
Question Security
Minimal Feedback
Strict Submission
Audit Logging
```

---

# 56. Practice Mode vs Exam Mode

| Feature            | Practice     | Exam             |
| ------------------ | ------------ | ---------------- |
| Pause              | Configurable | Usually disabled |
| Immediate Feedback | Possible     | Usually disabled |
| Navigation         | Flexible     | Configurable     |
| Randomization      | Possible     | Common           |
| Attempt Limit      | Flexible     | Strict           |
| Result Timing      | Immediate    | Configurable     |
| Security           | Standard     | Enhanced         |

---

# 57. Test Security

The Test Engine should protect:

```text
Question Content
Answer Keys
Correct Answers
Test Configuration
Active Sessions
Results
```

---

# 58. Server-Side Validation

All important operations must be validated server-side.

Examples:

```text
Start Test
Save Answer
Navigate
Submit
Resume
View Result
```

The client must not be trusted as the authority.

---

# 59. Authorization

Every test operation must verify:

```text
Authenticated Student
 ↓
Assessment Access
 ↓
Session Ownership
 ↓
Operation Permission
```

---

# 60. Session Ownership

A student must not be able to access another student's test session by modifying an identifier.

Example:

```text
/session/12345
```

must verify ownership before returning data.

---

# 61. Anti-Tampering

The engine should protect against attempts to manipulate:

```text
Timer
Score
Question IDs
Answers
Attempt Number
Submission State
```

---

# 62. Duplicate Submission

The engine should safely handle repeated submission requests.

```text
SUBMIT
 ↓
PROCESSING
 ↓
COMPLETED
```

A repeated request should not create duplicate results.

---

# 63. Idempotent Submission

Submission operations should be designed to avoid:

```text
Double Scoring
Duplicate Results
Duplicate Attempts
```

---

# 64. Network Failure During Submission

If submission is interrupted:

```text
SUBMIT REQUEST
      ↓
SERVER RECEIVES
      ↓
PROCESSING
      ↓
NETWORK FAILURE
      ↓
CLIENT RETRIES
      ↓
SERVER RECOGNIZES EXISTING REQUEST
      ↓
NO DUPLICATE RESULT
```

---

# 65. Test Session Heartbeat

Active timed sessions may periodically communicate with the server.

Purpose:

```text
Session Activity
Time Validation
Connection Monitoring
Recovery
```

---

# 66. Session Expiry

A session may expire because:

```text
Test Time Expired
Assessment Closed
Session Timeout
Security Event
Administrative Cancellation
```

---

# 67. Session Recovery

The system should be able to determine whether an interrupted session can be recovered.

```text
SESSION FOUND
 ↓
STATUS CHECK
 ↓
TIME CHECK
 ↓
ASSESSMENT POLICY
 ↓
RESUME / EXPIRE
```

---

# 68. Browser Refresh

Refreshing the browser should not automatically lose a valid test session.

The student should be able to resume where policy permits.

---

# 69. Multiple Devices

The platform should define how simultaneous access is handled.

Possible policy:

```text
ONE ACTIVE SESSION
```

A student attempting to open the same test on another device may receive a controlled warning.

---

# 70. Concurrent Sessions

The engine should prevent unauthorized concurrent attempts when the assessment configuration requires single-session access.

---

# 71. Test Question Delivery

Questions should be delivered according to:

```text
Question Set
Question Order
Randomization
Navigation Policy
```

---

# 72. Question API

A conceptual API flow:

```text
GET TEST SESSION
        ↓
GET CURRENT QUESTION
        ↓
SAVE ANSWER
        ↓
GET NEXT QUESTION
```

Actual API naming belongs to the API architecture.

---

# 73. Answer API

Conceptual request:

```text
SESSION
 ↓
QUESTION
 ↓
ANSWER
 ↓
VALIDATE
 ↓
SAVE
```

The server should verify that the question belongs to the student's active session.

---

# 74. Answer Validation

Validation should confirm:

```text
Question Belongs to Session
Answer Format Valid
Question Still Active
Session Still Active
Student Owns Session
```

---

# 75. Test Completion

A test is completed when:

```text
Manual Submission
OR
Automatic Submission
```

has successfully finalized the attempt.

---

# 76. Completion Flow

```text
FINAL ANSWERS
      ↓
SUBMISSION
      ↓
VALIDATION
      ↓
FINALIZE
      ↓
EVALUATE
      ↓
RESULT
      ↓
ANALYTICS EVENT
```

---

# 77. Result Generation

For automatically gradable tests:

```text
SUBMISSION
 ↓
AUTO EVALUATION
 ↓
SCORE
 ↓
RESULT
```

For manually graded tests:

```text
SUBMISSION
 ↓
PENDING REVIEW
 ↓
TEACHER GRADING
 ↓
FINAL RESULT
```

---

# 78. Learning Progress Integration

Test results may contribute to learning progress.

```text
TEST RESULT
 ↓
TOPIC PERFORMANCE
 ↓
LEARNING PROGRESS
```

The authoritative learning model is:

```text
LEARNING_PROGRESS_MODEL.md
```

---

# 79. Analytics Integration

The Test Engine may emit events such as:

```text
TEST_STARTED
QUESTION_VIEWED
ANSWER_SAVED
QUESTION_SKIPPED
QUESTION_REVIEWED
TEST_SUBMITTED
TEST_AUTO_SUBMITTED
TEST_COMPLETED
```

These events can feed analytics.

---

# 80. AI Integration

The Test Engine may later integrate with AI for:

```text
Adaptive Testing
Question Recommendation
Difficulty Adjustment
Performance Insights
Personalized Practice
```

AI must not bypass test security or assessment rules.

---

# 81. Adaptive Testing

Future adaptive tests may follow:

```text
QUESTION
 ↓
ANSWER
 ↓
PERFORMANCE ANALYSIS
 ↓
NEXT QUESTION SELECTION
 ↓
QUESTION
```

Adaptive selection should remain integrated with the Question Bank and Learning systems.

---

# 82. Test Accessibility

The test interface should support:

```text
Keyboard Navigation
Screen Readers
Accessible Controls
Readable Text
Focus Management
Accessible Timer
Clear Error Messages
```

---

# 83. Mobile Testing

Students should be able to take appropriate tests on:

```text
Desktop
Laptop
Tablet
Mobile
```

Exam requirements may determine whether certain devices are permitted.

---

# 84. Responsive Test Interface

The interface should adapt to screen sizes without changing assessment meaning.

```text
Desktop
    ↓
Tablet
    ↓
Mobile
```

---

# 85. Test UI Components

The Test Engine interface may include:

```text
Test Header
Timer
Question Area
Answer Options
Question Navigator
Progress Indicator
Review Marker
Save Indicator
Submit Button
```

---

# 86. Progress Indicator

Example:

```text
Question 7 of 20

Answered: 6
Unanswered: 1
Remaining: 13
```

---

# 87. Test Confirmation

Before starting, the student may see:

```text
Test Name
Subject
Number of Questions
Duration
Maximum Marks
Attempt Number
Instructions
```

---

# 88. Test Instructions

Assessment creators may define instructions such as:

```text
Read every question carefully.
Do not refresh the page unnecessarily.
Submit before the timer expires.
```

Instructions should be displayed before test start.

---

# 89. Test Attempt Summary

Before final submission, the engine may show:

```text
Answered: 18
Unanswered: 2
Marked for Review: 3
```

This helps students verify their attempt.

---

# 90. Test Submission Receipt

After successful submission, the platform may provide:

```text
Submission Status
Attempt ID
Submission Time
Result Status
```

---

# 91. Result Access

Students may access results when authorized.

Parents and teachers may access results through their respective modules and permissions.

---

# 92. Teacher Integration

Teachers may monitor active or completed test sessions where authorized.

Possible information:

```text
Student
Test
Attempt
Status
Submission
Score
```

---

# 93. School Integration

Schools may monitor assessment execution at authorized institutional scope.

---

# 94. Parent Integration

Parents may view completed results where the Parent Module and school policies permit.

---

# 95. Question Bank Integration

```text
QUESTION BANK
 ↓
QUESTION VERSION
 ↓
TEST ENGINE
 ↓
STUDENT SESSION
```

The Test Engine must not duplicate the master question bank.

---

# 96. Assessment Integration

```text
ASSESSMENT
 ↓
CONFIGURATION
 ↓
TEST ENGINE
 ↓
EXECUTION
```

---

# 97. Student Integration

```text
STUDENT
 ↓
ELIGIBILITY
 ↓
TEST SESSION
 ↓
ATTEMPT
```

---

# 98. Teacher Integration

```text
TEACHER
 ↓
ASSESSMENT
 ↓
MONITOR
 ↓
RESULTS
```

---

# 99. Parent Integration

```text
STUDENT
 ↓
TEST RESULT
 ↓
PARENT
```

Only authorized information should be exposed.

---

# 100. Complete Test Engine Architecture

```text
                         ASSESSMENT
                              │
                              ↓
                       TEST CONFIGURATION
                              │
                              ↓
                         ELIGIBILITY
                              │
                              ↓
                       TEST SESSION
                              │
                 ┌────────────┼────────────┐
                 ↓            ↓            ↓
              TIMER       QUESTIONS     NAVIGATION
                 │            │            │
                 └────────────┼────────────┘
                              ↓
                           ANSWERS
                              ↓
                           AUTO-SAVE
                              ↓
                          SUBMISSION
                              ↓
                         EVALUATION
                              ↓
                            RESULT
                       ┌──────┴──────┐
                       ↓             ↓
                  LEARNING       ANALYTICS
                       │             │
                       └──────┬──────┘
                              ↓
                             AI
```

---

# 101. Complete Student Test Flow

```text
LOGIN
 ↓
SELECT TEST
 ↓
ELIGIBILITY CHECK
 ↓
START TEST
 ↓
CREATE SESSION
 ↓
LOAD QUESTIONS
 ↓
START TIMER
 ↓
ANSWER QUESTIONS
 ↓
AUTO-SAVE
 ↓
NAVIGATE
 ↓
REVIEW
 ↓
SUBMIT
 ↓
FINALIZE
 ↓
EVALUATE
 ↓
RESULT
```

---

# 102. Interrupted Test Flow

```text
TEST IN PROGRESS
      ↓
NETWORK / BROWSER INTERRUPTION
      ↓
SESSION PRESERVED
      ↓
STUDENT RETURNS
      ↓
SESSION VALIDATION
      ↓
RESUME
      ↓
CONTINUE TEST
```

---

# 103. Time Expiry Flow

```text
TEST IN PROGRESS
      ↓
TIMER
      ↓
TIME = 0
      ↓
AUTO-SUBMIT
      ↓
FINALIZE
      ↓
EVALUATE
      ↓
RESULT
```

---

# 104. Manual Grading Flow

```text
TEST SUBMITTED
      ↓
AUTO-GRADABLE QUESTIONS
      ↓
AUTO SCORE
      ↓
MANUAL QUESTIONS
      ↓
TEACHER REVIEW
      ↓
FINAL SCORE
      ↓
RESULT PUBLISHED
```

---

# 105. Test Security Flow

```text
REQUEST
 ↓
AUTHENTICATION
 ↓
SESSION OWNERSHIP
 ↓
ASSESSMENT AUTHORIZATION
 ↓
SERVER VALIDATION
 ↓
ACTION
 ↓
AUDIT EVENT
```

---

# 106. Test Events

The Test Engine may emit:

```text
TEST_SESSION_CREATED
TEST_STARTED
QUESTION_VIEWED
ANSWER_SAVED
ANSWER_CHANGED
QUESTION_MARKED
QUESTION_SKIPPED
TEST_PAUSED
TEST_RESUMED
TEST_SUBMITTED
TEST_AUTO_SUBMITTED
TEST_EXPIRED
TEST_EVALUATED
TEST_COMPLETED
```

---

# 107. Audit Logging

Important events should be auditable.

Examples:

```text
Test Started
Test Submitted
Auto Submission
Session Resumed
Security Event
Result Generated
Attempt Invalidated
```

---

# 108. Security Monitoring

The platform may detect unusual activity such as:

```text
Repeated Session Changes
Multiple Device Access
Unexpected Request Patterns
Invalid Answer Requests
Unauthorized Session Access
```

Detection should generate security signals rather than automatically accuse a student of misconduct.

---

# 109. Test Integrity

The system should preserve:

```text
Question Version
Question Order
Selected Questions
Answers
Start Time
Submission Time
Score
Result
```

for completed attempts.

---

# 110. Historical Reproducibility

A completed test should remain reproducible even if:

```text
Question Text Changes
Question Bank Metadata Changes
Assessment Configuration Changes
```

The original attempt data must remain preserved.

---

# 111. Performance

The Test Engine must be optimized for high concurrent activity.

It should support:

```text
Fast Question Loading
Efficient Answer Saving
Connection Recovery
Caching Where Safe
Queue-Based Processing
Horizontal Scaling
```

---

# 112. High-Concurrency Testing

The system should be capable of handling situations such as:

```text
100 Students Start
1,000 Students Start
10,000 Students Start
```

depending on infrastructure capacity.

---

# 113. Load Distribution

For large exams:

```text
STUDENTS
   ↓
LOAD BALANCER
   ↓
TEST ENGINE SERVICES
   ↓
DATABASE / CACHE
   ↓
RESULT PROCESSING
```

---

# 114. Background Processing

Non-critical synchronous work may be processed asynchronously.

Examples:

```text
Analytics Events
Report Generation
Large Result Processing
Notifications
```

Critical answer persistence should remain reliable.

---

# 115. Error Handling

The engine should provide safe user-facing errors.

Examples:

```text
Unable to save your answer. Please try again.
Your test session has expired.
This test is no longer available.
Your test has already been submitted.
```

Internal technical details must not be exposed.

---

# 116. Failure Recovery

The Test Engine should recover safely from:

```text
Network Failure
Server Restart
Browser Refresh
Temporary Service Failure
Database Retry
```

without corrupting the student's attempt.

---

# 117. Data Consistency

Critical test operations should maintain consistency between:

```text
Session
Answers
Submission
Evaluation
Result
```

---

# 118. Transactional Operations

Operations such as final submission and result finalization should use appropriate transactional safeguards.

---

# 119. Test Engine API Boundary

The Test Engine should expose controlled services for:

```text
Create Session
Get Session
Get Question
Save Answer
Mark Question
Resume Session
Submit Test
Evaluate Attempt
Get Result
```

Exact endpoint naming belongs to the API specification.

---

# 120. Testing Requirements

The Test Engine should be tested for:

```text
Test Start
Eligibility
Attempt Limits
Session Creation
Question Loading
Question Randomization
Question Navigation
Answer Saving
Auto-Save
Timer
Timer Expiry
Pause / Resume
Browser Refresh
Network Recovery
Manual Submission
Auto Submission
Duplicate Submission
Evaluation
Negative Marking
Partial Marks
Manual Grading
Result Generation
Result Publication
Authorization
Security
Concurrent Users
Mobile Testing
Accessibility
Performance
Failure Recovery
Historical Integrity
```

---

# 121. Future Test Engine Features

The architecture should support:

```text
Adaptive Testing
AI-Powered Testing
Live Proctoring Integration
Advanced Anti-Cheat Signals
Offline Practice
Voice-Based Questions
Interactive Questions
Coding Questions
Simulation Questions
Game-Based Assessment
Advanced Exam Monitoring
```

These features should be introduced as separate capabilities without breaking the core Test Engine.

---

# 122. Offline Practice

Future practice mode may allow selected tests to continue temporarily without connectivity.

Offline exam functionality should require much stronger security controls and should not be assumed by default.

---

# 123. Interactive Questions

Future question types may include:

```text
Drag and Drop
Image-Based Questions
Audio Questions
Video Questions
Interactive Diagrams
Coding Questions
```

The Test Engine should support extensible question rendering.

---

# 124. Extensible Question Renderer

Conceptually:

```text
QUESTION TYPE
      ↓
QUESTION RENDERER
      ↓
STUDENT INTERFACE
      ↓
ANSWER FORMATTER
      ↓
EVALUATION
```

This allows new question types to be introduced without redesigning the complete engine.

---

# 125. Final Test Engine Principle

The Aspirian Test Engine must provide:

> **A secure, reliable, scalable and student-friendly execution environment that converts configured assessments into controlled online testing sessions, manages questions, timing, answers, submissions and evaluation, and preserves the integrity of every completed attempt.**

The Test Engine must remain separate from the Question Bank, Assessment, Student, Learning, Analytics and AI domains while integrating with each through clearly defined interfaces.

---

# 126. Document Status

**File:** `TEST_ENGINE.md`
**Version:** 1.0
**Status:** Final Test Engine Blueprint
**Phase:** D
**Module:** D7 — Test Engine
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Test Engine for the Aspirian Student Platform.
