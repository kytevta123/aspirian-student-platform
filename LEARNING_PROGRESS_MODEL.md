# Aspirian Student Platform — Learning Progress Model

**Version:** 1.0
**Status:** Final Learning Progress Data Model Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the domain-level learning progress model for the Aspirian Student Platform.

The Learning Progress system tracks how a student learns, practices, improves, and progresses through the academic structure.

It connects:

* Student
* Academic Structure
* Lessons
* Topics
* Questions
* Practice
* Assessments
* Results
* Skills
* Learning Objectives
* Weak Areas
* Strengths
* Recommendations

The system is designed to support students from:

> **Nursery → Class 12**

and remain extensible for future competitive exams and advanced learning programs.

---

# 2. Learning Progress Philosophy

Learning progress should represent more than examination marks.

The platform should understand:

```text
WHAT the student studied
        ↓
WHAT the student practiced
        ↓
HOW the student performed
        ↓
WHERE the student is strong
        ↓
WHERE the student is weak
        ↓
WHAT the student should learn next
```

---

# 3. Core Learning Progress Entity

The central conceptual entity is:

```text
LEARNING PROGRESS
```

It represents the student's progress within an academic context.

Conceptual attributes:

```text
id
student_id
academic_context
progress_status
completion_percentage
mastery_level
last_activity_at
created_at
updated_at
```

Exact database implementation belongs to `DATABASE.md`.

---

# 4. Student Learning Profile

Every student may have a learning profile containing progress information.

```text
STUDENT
   ↓
LEARNING PROFILE
   ↓
LEARNING PROGRESS
```

The learning profile may aggregate:

* Academic progress
* Topic mastery
* Practice activity
* Assessment performance
* Learning streaks
* Strengths
* Weaknesses
* Recommendations

---

# 5. Academic Context

Learning progress should be connected to the student's academic context.

Possible context:

```text
Board
Academic Session
Class
Group / Stream
Subject
Book
Chapter
Topic
```

Not every level is required for every student or academic stage.

---

# 6. Nursery → Early Education Progress

For Nursery, KG and early grades, progress may be organized around:

```text
Learning Area
 ↓
Skill
 ↓
Activity
 ↓
Progress
```

Example:

```text
English
 ↓
Alphabet Recognition
 ↓
Practice Activity
 ↓
Progress
```

---

# 7. Primary Progress

Primary-level progress may follow:

```text
Class
 ↓
Subject
 ↓
Chapter
 ↓
Topic
 ↓
Learning Objective
 ↓
Progress
```

---

# 8. Secondary Progress

Secondary-level progress may include:

```text
Board
 ↓
Class
 ↓
Group
 ↓
Subject
 ↓
Chapter
 ↓
Topic
 ↓
Progress
```

---

# 9. Higher Secondary Progress

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
Chapter
 ↓
Topic
 ↓
Progress
```

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
```

---

# 10. Learning Activity

A learning activity represents an action performed by a student.

Examples:

```text
Lesson Viewed
Question Attempted
Quiz Started
Quiz Completed
Test Completed
Video Watched
Note Read
Topic Practiced
Revision Completed
```

Concept:

```text
STUDENT
 ↓
LEARNING ACTIVITY
 ↓
PROGRESS
```

---

# 11. Activity Types

Initial activity types:

```text
LESSON_VIEW
NOTE_VIEW
VIDEO_VIEW
QUESTION_ATTEMPT
PRACTICE_START
PRACTICE_COMPLETE
QUIZ_ATTEMPT
TEST_ATTEMPT
ASSESSMENT_COMPLETE
REVISION_ACTIVITY
```

Additional activity types may be added later.

---

# 12. Activity Timestamp

Every important learning activity may record:

```text
started_at
completed_at
```

or an appropriate event timestamp.

This supports learning history and analytics.

---

# 13. Activity Duration

Where meaningful, the system may record:

```text
duration
time_spent
```

Example:

```text
Video Watched
 ↓
Time Spent = 14 minutes
```

Time spent should be treated as an engagement signal, not automatically as proof of learning.

---

# 14. Learning Completion

Progress may include completion.

Example:

```text
Chapter
 ↓
10 Topics
 ↓
7 Completed
 ↓
70% Completion
```

Completion percentage may be calculated from underlying learning activities.

---

# 15. Mastery

Mastery represents how well a student understands a learning area.

Possible conceptual levels:

```text
NOT_STARTED
INTRODUCED
DEVELOPING
PRACTICING
PROFICIENT
MASTERED
```

The exact mastery algorithm may evolve.

---

# 16. Mastery vs Completion

Completion and mastery must remain separate.

Example:

```text
Student watched all lessons
        ↓
Completion = 100%

But assessment accuracy is low
        ↓
Mastery = Developing
```

Therefore:

> Completing content does not automatically mean mastering it.

---

# 17. Topic Progress

Topic-level progress is one of the most important learning indicators.

Concept:

```text
Student
 ↓
Subject
 ↓
Chapter
 ↓
Topic
 ↓
Progress
```

Possible indicators:

```text
Completion
Practice Attempts
Accuracy
Average Score
Mastery
Last Activity
```

---

# 18. Chapter Progress

Chapter progress may aggregate topic-level progress.

Example:

```text
Chapter 1
 ├── Topic 1 → 100%
 ├── Topic 2 → 80%
 ├── Topic 3 → 60%
 └── Topic 4 → 40%
```

The chapter-level progress can be calculated from its underlying topics.

---

# 19. Subject Progress

Subject progress may aggregate chapter and topic information.

```text
Subject
 ↓
Chapters
 ↓
Topics
 ↓
Learning Progress
```

---

# 20. Overall Academic Progress

A student's overall progress may be represented as:

```text
Student
 ├── Mathematics
 ├── Biology
 ├── Physics
 ├── Chemistry
 └── English
```

The platform should avoid reducing the entire learning journey to one simplistic score.

---

# 21. Question Practice Progress

Question attempts provide important learning signals.

Example:

```text
Topic
 ↓
100 Questions Attempted
 ↓
78 Correct
 ↓
78% Accuracy
```

Possible indicators:

```text
Attempts
Correct
Incorrect
Skipped
Accuracy
Average Time
```

---

# 22. Question Accuracy

Accuracy may be calculated as:

```text
Correct Answers
---------------- × 100
Evaluated Attempts
```

The exact calculation should account for the assessment/question type.

---

# 23. Practice Progress

Practice progress may track:

```text
Practice Sessions
Questions Attempted
Questions Correct
Topics Practiced
Time Spent
Average Accuracy
```

---

# 24. Assessment Progress

Assessment performance may contribute to learning progress.

```text
Assessment
 ↓
Attempt
 ↓
Result
 ↓
Learning Progress
```

The system should distinguish formal examination results from informal practice performance.

---

# 25. Learning Streak

The platform may optionally track consecutive learning activity.

Example:

```text
Day 1 → Activity
Day 2 → Activity
Day 3 → Activity
Day 4 → Activity

Current Streak = 4 Days
```

Possible values:

```text
Current Streak
Longest Streak
Last Activity Date
```

Streaks are engagement indicators rather than academic mastery measures.

---

# 26. Learning Goals

Students may have learning goals.

Example:

```text
Goal
 ↓
Complete Chapter 1
 ↓
Practice 100 MCQs
 ↓
Reach 80% Accuracy
```

Goals may be:

```text
Daily
Weekly
Monthly
Academic
Exam-Based
```

---

# 27. Goal Progress

Each goal may track:

```text
Target
Current Value
Completion Percentage
Start Date
Target Date
Status
```

Example:

```text
Target = 100 Questions
Completed = 70
Progress = 70%
```

---

# 28. Goal Status

Possible states:

```text
NOT_STARTED
IN_PROGRESS
COMPLETED
PAUSED
CANCELLED
EXPIRED
```

---

# 29. Learning Objectives

Topics may have learning objectives.

```text
Topic
 ↓
Learning Objective
 ↓
Student Progress
```

Example:

```text
Objective:
Understand Photosynthesis

Student
 ↓
Practice
 ↓
Assessment
 ↓
Mastery
```

---

# 30. Skill Progress

The platform may track academic skills separately from content completion.

Examples:

```text
Problem Solving
Calculation
Reading
Writing
Analysis
Memory
Concept Application
```

This is especially useful for personalized learning.

---

# 31. Strength Detection

The system may identify strengths from repeated performance.

Example:

```text
Mathematics
 ↓
Algebra
 ↓
Accuracy = High
 ↓
Potential Strength
```

Strength detection should use sufficient evidence rather than one isolated result.

---

# 32. Weak Area Detection

The system may identify weak areas.

Example:

```text
Biology
 ↓
Cell Structure
 ↓
Repeated Incorrect Answers
 ↓
Weak Area
```

Possible signals:

```text
Low Accuracy
Repeated Mistakes
Low Assessment Score
High Hint Usage
Repeated Attempts
```

---

# 33. Weak Area Confidence

The system should avoid labeling a topic as weak from insufficient data.

Concept:

```text
Few Attempts
 ↓
Insufficient Evidence

Many Attempts + Low Accuracy
 ↓
Higher Confidence Weak Area
```

---

# 34. Performance Trend

The system may track performance over time.

Example:

```text
Week 1 → 55%
Week 2 → 62%
Week 3 → 71%
Week 4 → 78%
```

This indicates improvement even if mastery has not yet been reached.

---

# 35. Performance Decline

The system may also detect declining performance.

Example:

```text
Week 1 → 82%
Week 2 → 79%
Week 3 → 70%
Week 4 → 64%
```

This may trigger recommendations for revision.

---

# 36. Learning Trend

Possible trend states:

```text
IMPROVING
STABLE
DECLINING
INSUFFICIENT_DATA
```

---

# 37. Revision Progress

The system may track revision activities.

```text
Topic
 ↓
Revision
 ↓
Practice
 ↓
Assessment
```

Revision may be recommended when performance declines or mastery decreases.

---

# 38. Spaced Revision

Future versions may support spaced revision.

Concept:

```text
Learn
 ↓
Review
 ↓
Practice
 ↓
Review Again
 ↓
Mastery
```

Revision scheduling should be based on learning evidence where possible.

---

# 39. Learning Path

The platform may create a learning path.

Example:

```text
Subject
 ↓
Chapter 1
 ↓
Topic 1
 ↓
Topic 2
 ↓
Topic 3
 ↓
Chapter 2
```

Prerequisites may determine the recommended sequence.

---

# 40. Prerequisite Progress

Some topics depend on earlier topics.

Example:

```text
Basic Algebra
      ↓
Linear Equations
      ↓
Quadratic Equations
```

The platform should be able to identify prerequisite completion/mastery.

---

# 41. Personalized Learning

Learning progress provides the foundation for personalization.

```text
Student Progress
       ↓
Performance Analysis
       ↓
Strengths / Weaknesses
       ↓
Recommended Content
       ↓
Practice
       ↓
Updated Progress
```

---

# 42. AI Learning Recommendations

Future AI may recommend:

```text
Next Topic
Revision
Practice Questions
Videos
Notes
Tests
Explanations
```

Recommendations should be based on available evidence.

---

# 43. Recommendation Example

```text
Student
 ↓
Physics
 ↓
Topic: Motion
 ↓
Accuracy: 52%
 ↓
Weak Area Detected
 ↓
Recommendation:
Review Motion Notes
 ↓
Practice 15 Questions
 ↓
Take Topic Quiz
```

---

# 44. Recommendation Tracking

The system may record:

```text
Recommendation
 ↓
Presented
 ↓
Accepted / Ignored
 ↓
Activity
 ↓
Outcome
```

This can help improve future recommendation quality.

---

# 45. Learning Session

A learning session represents a period of active platform learning.

Concept:

```text
SESSION
 ├── Lesson
 ├── Questions
 ├── Practice
 └── Assessment
```

Possible attributes:

```text
started_at
ended_at
duration
activity_count
```

---

# 46. Session Quality

The platform should avoid treating raw session duration as equivalent to learning.

Useful signals may include:

```text
Completed Activities
Questions Attempted
Accuracy
Topic Progress
Assessment Performance
```

---

# 47. Daily Progress

The dashboard may show:

```text
Today's Learning
 ├── Lessons Completed
 ├── Questions Practiced
 ├── Tests Completed
 ├── Time Spent
 └── Goals Progress
```

---

# 48. Weekly Progress

Weekly summaries may include:

```text
Questions Attempted
Average Accuracy
Topics Completed
Assessments Completed
Learning Streak
Performance Trend
```

---

# 49. Monthly Progress

Monthly progress may show:

```text
Subjects Studied
Topics Completed
Average Performance
Improvement
Weak Areas
Strong Areas
```

---

# 50. Academic Progress Dashboard

The student dashboard may represent:

```text
Overall Progress
      ↓
Subjects
      ↓
Chapters
      ↓
Topics
      ↓
Mastery
```

---

# 51. Parent Progress View

Authorized parents may see an appropriate summary:

```text
Student
 ↓
Subjects
 ↓
Progress
 ↓
Assessment Performance
 ↓
Strengths / Weak Areas
```

Sensitive or internal system information should not automatically be exposed.

---

# 52. Teacher Progress View

Teachers may view progress for students they are authorized to manage.

Possible information:

```text
Student Progress
Topic Mastery
Assessment Results
Practice Activity
Weak Areas
Performance Trends
```

---

# 53. School Progress View

Authorized school administrators may view aggregated information.

Examples:

```text
Class Progress
Subject Progress
Assessment Performance
Participation
```

Individual student data must remain access-controlled.

---

# 54. Progress Aggregation

Progress may be aggregated:

```text
Topic
 ↓
Chapter
 ↓
Subject
 ↓
Class
 ↓
Academic Session
```

Aggregated values should preferably be derived from underlying records.

---

# 55. Historical Progress

The system should preserve meaningful historical progress.

Example:

```text
Academic Session 2026–27
 ↓
Class 9
 ↓
Biology Progress
```

When the student moves to another class/session, previous progress should remain available as historical data.

---

# 56. Class Promotion

When a student moves:

```text
Class 8
   ↓
Class 9
```

the previous academic progress should not simply be overwritten.

Instead:

```text
Historical Progress
+
Current Academic Progress
```

should remain distinguishable.

---

# 57. Academic Session Transition

At the start of a new academic session:

```text
Previous Session
      ↓
Archived / Historical
      ↓
New Session
      ↓
New Progress
```

Student identity remains continuous.

---

# 58. Progress Reset

Progress should not normally be physically deleted.

If a student restarts a course or learning path, the system should create a new progress context or attempt rather than destroying historical records.

---

# 59. Progress Privacy

Learning progress is student-related data and must be protected.

Access should be limited according to:

```text
Student
Parent Authorization
Teacher Authorization
School Authorization
Platform Administration
```

---

# 60. Progress Audit

Important progress-affecting events may be auditable.

Examples:

```text
Activity Recorded
Progress Updated
Result Imported
Assessment Evaluated
Goal Completed
Recommendation Generated
Progress Corrected
```

---

# 61. Progress Corrections

If incorrect data is discovered, the system should correct the source record where possible rather than silently modifying historical summaries.

---

# 62. Derived Metrics

Many progress values can be derived from underlying activity and assessment data.

Examples:

```text
Completion %
Accuracy
Average Score
Topic Mastery
Performance Trend
```

The system should avoid unnecessary duplication of calculated values.

---

# 63. Cached Metrics

For performance reasons, some calculated metrics may later be cached.

Example:

```text
Raw Activity Data
       ↓
Calculation
       ↓
Cached Summary
```

Cached summaries must remain rebuildable from authoritative data.

---

# 64. Learning Progress and Question Bank

Question performance contributes to learning progress.

```text
QUESTION BANK
      ↓
QUESTION ATTEMPT
      ↓
PERFORMANCE
      ↓
TOPIC PROGRESS
```

Detailed question structure is defined in:

```text
QUESTION_BANK_MODEL.md
```

---

# 65. Learning Progress and Assessment

Assessment results contribute to progress.

```text
ASSESSMENT
 ↓
ATTEMPT
 ↓
RESULT
 ↓
LEARNING PROGRESS
```

Detailed assessment structure is defined in:

```text
ASSESSMENT_MODEL.md
```

---

# 66. Learning Progress and Education Structure

Progress depends on the academic hierarchy.

```text
Education Structure
        ↓
Class
        ↓
Subject
        ↓
Chapter
        ↓
Topic
        ↓
Student Progress
```

Detailed academic hierarchy is defined in:

```text
EDUCATION_STRUCTURE.md
```

---

# 67. Learning Progress and Users

Progress belongs to a student identity.

```text
USER
 ↓
STUDENT PROFILE
 ↓
LEARNING PROFILE
 ↓
PROGRESS
```

User/student data is defined in:

```text
USER_DATA_MODEL.md
```

---

# 68. Learning Progress and AI

AI services may consume authorized progress signals.

```text
Learning Progress
      ↓
AI Analysis
      ↓
Recommendation
      ↓
Student Action
      ↓
New Progress
```

AI should not be treated as the authoritative source of academic records.

---

# 69. AI Progress Analysis

Future AI analysis may identify:

```text
Weak Concepts
Strong Concepts
Learning Gaps
Performance Trends
Revision Needs
Recommended Questions
Recommended Lessons
```

---

# 70. Learning Gap

A learning gap represents missing or insufficient understanding.

Example:

```text
Prerequisite Skill
      ↓
Low Performance
      ↓
Learning Gap
      ↓
Remedial Content
```

---

# 71. Remedial Learning

The system may recommend easier or prerequisite material.

```text
Weak Topic
 ↓
Prerequisite Topic
 ↓
Basic Practice
 ↓
Topic Practice
 ↓
Assessment
```

---

# 72. Enrichment Learning

Students demonstrating strong mastery may receive advanced practice.

```text
Mastered Topic
 ↓
Advanced Questions
 ↓
Higher Difficulty
 ↓
Enrichment
```

---

# 73. Learning Difficulty Adaptation

Future adaptive learning may adjust:

```text
Question Difficulty
Content Sequence
Practice Quantity
Revision Frequency
```

according to student progress.

---

# 74. Progress Milestones

Students may achieve milestones.

Examples:

```text
First Quiz Completed
100 Questions Practiced
Chapter Completed
80% Accuracy Achieved
Subject Completed
Exam Preparation Completed
```

Milestones may support motivation.

---

# 75. Achievement Data

Achievements should be separate from academic truth.

Example:

```text
Achievement:
"100 Questions Completed"

Academic Metric:
"Topic Accuracy = 78%"
```

An achievement should not imply mastery unless the academic metric supports it.

---

# 76. Progress Notifications

The system may notify students about:

```text
Goal Completed
Topic Completed
Improvement
Recommended Revision
Assessment Result
Learning Streak
```

---

# 77. Progress API

Learning progress should be available through authorized APIs for:

```text
Web Application
Android Application
Teacher Dashboard
Parent Dashboard
School Dashboard
AI Services
Reporting
```

API permissions must prevent unauthorized access.

---

# 78. Progress Synchronization

If multiple clients are used:

```text
Web
Android
Future Apps
```

progress should synchronize through the central backend rather than relying on local-only progress.

---

# 79. Offline Progress

Future mobile applications may support limited offline learning.

Offline activities should eventually synchronize with the central platform.

```text
Offline Activity
 ↓
Local Queue
 ↓
Synchronization
 ↓
Server
 ↓
Progress Update
```

Conflict handling must be defined at the technical implementation level.

---

# 80. Progress Data Integrity

The system should ensure:

```text
Valid Student
Valid Academic Context
Valid Activity
Valid Assessment Result
Valid Question Attempt
Valid Progress Relationship
```

before accepting progress records.

---

# 81. Progress Scalability

The model should support:

```text
Large Student Population
Millions of Learning Activities
Large Question Bank
Multiple Schools
Multiple Boards
Multiple Academic Sessions
```

The detailed database indexing and scaling strategy belongs to `DATABASE.md`.

---

# 82. Core Progress Relationships

```text
STUDENT
   │
   ↓
LEARNING PROFILE
   │
   ├── LEARNING GOALS
   │
   ├── LEARNING ACTIVITIES
   │
   ├── TOPIC PROGRESS
   │
   ├── SKILL PROGRESS
   │
   ├── STRENGTHS
   │
   ├── WEAK AREAS
   │
   ├── MILESTONES
   │
   └── RECOMMENDATIONS
```

---

# 83. Academic Progress Relationships

```text
CLASS
  ↓
SUBJECT
  ↓
CHAPTER
  ↓
TOPIC
  ↓
LEARNING OBJECTIVE
  ↓
STUDENT PROGRESS
```

---

# 84. Activity-to-Progress Flow

```text
STUDENT ACTIVITY
       ↓
ACTIVITY RECORD
       ↓
PERFORMANCE SIGNAL
       ↓
PROGRESS CALCULATION
       ↓
TOPIC / SUBJECT PROGRESS
       ↓
LEARNING PROFILE
```

---

# 85. Complete Learning Progress Flow

```text
STUDENT
   ↓
LEARNING PROFILE
   ↓
ACADEMIC CONTEXT
   ↓
LEARNING CONTENT
   ↓
ACTIVITY
   ↓
PRACTICE / ASSESSMENT
   ↓
PERFORMANCE
   ↓
PROGRESS
   ↓
MASTERY
   ↓
STRENGTH / WEAKNESS
   ↓
RECOMMENDATION
   ↓
NEXT LEARNING ACTIVITY
```

---

# 86. Example — Nursery Student

```text
Nursery
 ↓
English
 ↓
Alphabet Recognition
 ↓
Learning Activity
 ↓
Practice
 ↓
Progress
 ↓
Skill Developing
```

---

# 87. Example — Class 5 Student

```text
Class 5
 ↓
Mathematics
 ↓
Fractions
 ↓
Lesson
 ↓
Practice Questions
 ↓
80% Accuracy
 ↓
Proficient
```

---

# 88. Example — Class 9 Student

```text
Class 9
 ↓
Biology
 ↓
Chapter 1
 ↓
Cell Structure
 ↓
Practice
 ↓
Multiple Attempts
 ↓
Low Accuracy
 ↓
Weak Area
 ↓
Revision Recommendation
```

---

# 89. Example — Class 11 Student

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
Assessment
 ↓
Result
 ↓
Mastery Update
 ↓
Personalized Practice
```

---

# 90. Final Learning Progress Architecture

```text
                         STUDENT
                            │
                     LEARNING PROFILE
                            │
          ┌─────────────────┼─────────────────┐
          │                 │                 │
       GOALS            ACTIVITIES       PROGRESS
                            │                 │
                            ↓                 ↓
                     PRACTICE / TEST      MASTERY
                            │                 │
                            └────────┬────────┘
                                     ↓
                           STRENGTHS / WEAKNESS
                                     ↓
                              AI / RULE ENGINE
                                     ↓
                              RECOMMENDATIONS
                                     ↓
                              NEXT ACTIVITY
                                     ↓
                              UPDATED PROGRESS
```

---

# 91. Final Principles

The Aspirian Learning Progress Model must be:

> **Student-centered, academic-context aware, measurable, historical, privacy-controlled, scalable, analytics-ready, AI-ready, and suitable from Nursery → Class 12.**

The system must distinguish:

* Activity from completion
* Completion from mastery
* Performance from engagement
* AI suggestions from official academic records
* Current progress from historical progress

This ensures that Aspirian can eventually provide meaningful personalized learning rather than simply displaying test scores.

---

# 92. Document Status

**File:** `LEARNING_PROGRESS_MODEL.md`
**Phase:** C
**Module:** C5 — Learning Progress Model

**File:** `LEARNING_PROGRESS_MODEL.md`
**Version:** 1.0
**Status:** Final Learning Progress Data Model Blueprint
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Student Learning/Progress Data Model for the Aspirian Student Platform.
