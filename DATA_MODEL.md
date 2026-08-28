# Aspirian Student Platform — Complete Domain & Data Model

**Version:** 1.0
**Status:** Final Data Model Blueprint
**Project:** Aspirian Student Platform
**Primary Application:** `app.aspirian.pk`
**Existing Website:** `aspirian.pk`
**Academic Range:** Nursery → Class 12

---

# 1. Purpose

This document defines the complete domain and data model for the Aspirian Student Platform.

It establishes:

* Core entities
* Relationships
* Academic hierarchy
* User and role structure
* Learning data
* Question bank data
* Assessment data
* Result data
* Revision data
* AI-related data
* Teacher data
* Parent data
* School data
* Media data
* Career data
* Subscription data
* Analytics data
* Audit and system data

This document defines **what data the platform needs and how the major entities relate to each other**.

Detailed database implementation, indexes, migrations, and database-specific optimization will be defined separately in `DATABASE.md`.

---

# 2. Data Modeling Principles

The data model follows these principles:

1. Keep core entities normalized.
2. Avoid unnecessary duplication.
3. Use stable identifiers for major entities.
4. Separate users from role-specific profiles.
5. Keep academic structure independent from individual users.
6. Support multiple boards and curricula.
7. Support multiple academic sessions.
8. Preserve historical assessment records.
9. Design for Nursery → Class 12.
10. Allow future educational expansion.
11. Keep AI-generated data distinguishable from trusted content.
12. Keep financial records auditable.
13. Protect student-related data.
14. Support future mobile applications through the same backend.
15. Avoid hard-coding academic structures into application logic.

---

# 3. High-Level Domain Map

```text
ASPIRIAN PLATFORM
│
├── Identity & Access
│   ├── Users
│   ├── Roles
│   └── Permissions
│
├── Academic Domain
│   ├── Boards
│   ├── Academic Sessions
│   ├── Education Levels
│   ├── Classes
│   ├── Subjects
│   ├── Books
│   ├── Chapters
│   └── Topics
│
├── Learning Domain
│   ├── Learning Materials
│   ├── Lessons
│   ├── Resources
│   └── Student Progress
│
├── Assessment Domain
│   ├── Questions
│   ├── Question Options
│   ├── Question Banks
│   ├── Tests
│   ├── Test Questions
│   ├── Attempts
│   └── Answers
│
├── Revision Domain
│   ├── Mistakes
│   ├── Revision Items
│   ├── Flashcards
│   └── Study Plans
│
├── AI Domain
│   ├── AI Sessions
│   ├── AI Messages
│   ├── AI Generations
│   └── AI Usage
│
├── People & Institutions
│   ├── Students
│   ├── Teachers
│   ├── Parents
│   ├── Schools
│   ├── Classes
│   └── Enrollments
│
├── Media Domain
│   ├── Videos
│   ├── Audio
│   ├── Radio Programs
│   └── Live Events
│
├── Career Domain
│   ├── Career Paths
│   ├── Skills
│   ├── Jobs
│   ├── Internships
│   └── Scholarships
│
├── Monetization
│   ├── Plans
│   ├── Subscriptions
│   ├── Payments
│   └── Entitlements
│
└── Platform
    ├── Notifications
    ├── Analytics
    ├── Audit Logs
    └── System Settings
```

---

# 4. Identity Domain

## 4.1 User

The `User` entity represents an authenticated platform account.

Core attributes:

```text
id
name
email
phone
password_hash
status
email_verified_at
phone_verified_at
last_login_at
created_at
updated_at
```

A user may have one or more roles.

---

# 5. Roles

Supported initial roles:

```text
STUDENT
TEACHER
PARENT
SCHOOL_ADMIN
PLATFORM_ADMIN
```

Future roles may be added without redesigning the user entity.

---

# 6. Permissions

Permissions should be separated from roles where appropriate.

Examples:

```text
question.create
question.update
question.publish
test.create
test.assign
result.view
student.manage
school.manage
subscription.manage
```

Relationship:

```text
User
 ↓
Role
 ↓
Permissions
```

---

# 7. Student Domain

## 7.1 Student Profile

A student profile extends the base user.

Attributes may include:

```text
id
user_id
current_class_id
current_academic_session_id
preferred_language
date_of_birth
status
created_at
updated_at
```

Only necessary personal information should be stored.

---

# 8. Teacher Domain

## 8.1 Teacher Profile

Attributes:

```text
id
user_id
school_id
employee_reference
status
created_at
updated_at
```

A teacher may belong to one or more institutions depending on future requirements.

---

# 9. Parent Domain

## 9.1 Parent Profile

Attributes:

```text
id
user_id
status
created_at
updated_at
```

Parent-to-student relationships should be represented through a dedicated relationship entity rather than storing a single parent directly on the student.

---

# 10. Parent-Student Relationship

Entity:

```text
parent_student
```

Attributes:

```text
id
parent_id
student_id
relationship_type
is_primary
status
created_at
updated_at
```

Possible relationship values:

```text
parent
guardian
other_authorized_guardian
```

---

# 11. Academic Domain

The academic domain defines the educational structure independently from users.

Primary hierarchy:

```text
Board
 ↓
Academic Session
 ↓
Education Level
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
```

---

# 12. Education Level

Education levels provide a broad grouping.

Examples:

```text
Early Education
Primary
Middle
Secondary
Higher Secondary
```

---

# 13. Class

Classes represent academic grades.

Examples:

```text
Nursery
KG
Class 1
Class 2
...
Class 12
```

Core attributes:

```text
id
education_level_id
name
code
display_order
status
created_at
updated_at
```

The model must not assume that class names are always numeric.

---

# 14. Board

Represents an educational board or curriculum authority.

Attributes:

```text
id
name
code
country
region
status
created_at
updated_at
```

The model should allow multiple boards.

---

# 15. Academic Session

Represents an academic year/session.

Attributes:

```text
id
name
start_date
end_date
status
created_at
updated_at
```

Example:

```text
2026–27
```

---

# 16. Class Curriculum

A class may have different subjects depending on board and academic session.

Entity:

```text
class_curriculum
```

Attributes:

```text
id
board_id
academic_session_id
class_id
status
```

---

# 17. Subject

Represents a subject.

Examples:

```text
English
Mathematics
Physics
Chemistry
Biology
Computer Science
Urdu
```

Attributes:

```text
id
name
code
description
status
created_at
updated_at
```

---

# 18. Curriculum Subject

Connects a subject to a particular curriculum.

Attributes:

```text
id
class_curriculum_id
subject_id
display_order
is_core
status
```

This allows the same subject to appear in different curricula.

---

# 19. Book

Represents a textbook or learning book.

Attributes:

```text
id
subject_id
board_id
class_id
academic_session_id
title
publisher
edition
status
created_at
updated_at
```

---

# 20. Chapter

Represents a chapter within a book.

Attributes:

```text
id
book_id
chapter_number
title
description
display_order
status
created_at
updated_at
```

Relationship:

```text
Book
 ↓
Chapters
```

---

# 21. Topic

Represents a smaller learning unit.

Attributes:

```text
id
chapter_id
title
description
display_order
status
created_at
updated_at
```

Relationship:

```text
Chapter
 ↓
Topics
```

---

# 22. Learning Content

Learning content represents educational material attached to an academic location.

Possible types:

```text
TEXT
NOTE
IMAGE
DIAGRAM
VIDEO
AUDIO
DOCUMENT
EXTERNAL_RESOURCE
```

Core attributes:

```text
id
topic_id
title
content_type
content
resource_url
status
created_by
published_at
created_at
updated_at
```

---

# 23. Lesson

A lesson is a structured learning experience.

Attributes may include:

```text
id
topic_id
title
description
estimated_minutes
difficulty
status
created_at
updated_at
```

A lesson may contain multiple content blocks.

---

# 24. Learning Content Blocks

A lesson may consist of:

```text
Introduction
Explanation
Example
Diagram
Practice
Summary
```

This can be represented through a content-block entity.

---

# 25. Student Progress

Student progress should be stored independently from content.

Entity:

```text
student_progress
```

Attributes:

```text
id
student_id
topic_id
status
completion_percentage
last_accessed_at
completed_at
created_at
updated_at
```

Possible statuses:

```text
NOT_STARTED
IN_PROGRESS
COMPLETED
```

---

# 26. Student Learning Activity

Learning activity may record meaningful interactions.

Examples:

```text
lesson_viewed
topic_completed
resource_opened
video_watched
audio_played
practice_started
```

Activity data should be designed with retention and privacy considerations.

---

# 27. Question Domain

Questions are reusable assessment assets.

A question may belong to:

```text
Board
Class
Subject
Book
Chapter
Topic
```

---

# 28. Question

Core attributes:

```text
id
question_type
question_text
explanation
marks
difficulty
status
source_type
created_by
reviewed_by
created_at
updated_at
published_at
```

Possible question types:

```text
MCQ
TRUE_FALSE
SHORT_ANSWER
LONG_ANSWER
FILL_BLANK
MATCHING
PRACTICAL
VIVA
```

---

# 29. Question Options

For multiple-choice questions:

```text
id
question_id
option_text
display_order
is_correct
```

Correct answers must be securely handled.

---

# 30. Question Classification

Questions should have academic classification.

Possible relationships:

```text
question
 ↓
subject
chapter
topic
board
class
academic_session
```

This allows targeted test generation.

---

# 31. Question Bank

A question bank is a collection of questions.

Attributes:

```text
id
name
description
owner_type
owner_id
visibility
status
created_at
updated_at
```

Possible ownership:

```text
PLATFORM
TEACHER
SCHOOL
```

---

# 32. Question Bank Membership

Questions can belong to multiple collections.

Entity:

```text
question_bank_question
```

Attributes:

```text
id
question_bank_id
question_id
display_order
created_at
```

---

# 33. Test Domain

Tests represent assessments created from questions.

Core attributes:

```text
id
title
description
test_type
class_id
subject_id
board_id
academic_session_id
duration_minutes
total_marks
passing_marks
question_count
attempt_limit
status
created_by
published_at
created_at
updated_at
```

---

# 34. Test Types

Possible types:

```text
PRACTICE
TOPIC_TEST
CHAPTER_TEST
SUBJECT_TEST
MOCK_EXAM
ASSIGNMENT
SCHOOL_EXAM
```

---

# 35. Test Questions

A test should reference questions through a junction entity.

```text
test_questions
```

Attributes:

```text
id
test_id
question_id
display_order
marks
created_at
```

This allows the same question to be reused across tests.

---

# 36. Question Randomization

Tests may support:

```text
random_question_order
random_option_order
```

Randomization settings should belong to the test configuration.

---

# 37. Test Assignment

Teachers and schools may assign tests.

Entity:

```text
test_assignments
```

Attributes:

```text
id
test_id
assigned_by
target_type
target_id
start_at
due_at
status
created_at
```

Target may be:

```text
STUDENT
CLASS
SCHOOL
```

---

# 38. Test Attempt

Every student test attempt should be stored.

Attributes:

```text
id
test_id
student_id
attempt_number
started_at
submitted_at
status
score
percentage
time_used_seconds
```

Possible statuses:

```text
STARTED
SUBMITTED
AUTO_SUBMITTED
ABANDONED
```

---

# 39. Student Answer

Each answer belongs to a test attempt.

Attributes:

```text
id
attempt_id
question_id
selected_option_id
answer_text
is_correct
marks_awarded
time_spent_seconds
answered_at
```

---

# 40. Result

A result is the evaluated outcome of an attempt.

Core data:

```text
attempt_id
student_id
test_id
total_marks
obtained_marks
percentage
correct_count
incorrect_count
skipped_count
rank
result_status
created_at
```

Historical results must remain immutable after finalization except through controlled administrative correction processes.

---

# 41. Performance Domain

Performance can be calculated at multiple levels.

```text
Student
 ↓
Subject
 ↓
Chapter
 ↓
Topic
```

Performance metrics may include:

```text
Attempts
Accuracy
Average Score
Completion
Improvement
Weakness
```

---

# 42. Student Mistakes

Incorrect answers can generate mistake records.

Entity:

```text
student_mistakes
```

Attributes:

```text
id
student_id
question_id
attempt_id
topic_id
mistake_type
first_seen_at
last_seen_at
resolved_at
status
```

Possible status:

```text
OPEN
IN_REVISION
RESOLVED
```

---

# 43. Revision Item

A revision item represents something the student should review.

Attributes:

```text
id
student_id
topic_id
question_id
source_type
priority
scheduled_for
completed_at
status
created_at
updated_at
```

Possible source:

```text
MISTAKE
WEAK_TOPIC
SAVED_ITEM
AI_RECOMMENDATION
MANUAL
```

---

# 44. Flashcards

Flashcards may be linked to academic content.

Attributes:

```text
id
student_id
topic_id
front
back
source_type
status
created_at
updated_at
```

Future shared/public flashcard collections can be added.

---

# 45. Study Plan

A study plan represents a structured learning schedule.

Attributes:

```text
id
student_id
title
description
start_date
end_date
status
created_by_type
created_at
updated_at
```

---

# 46. Study Plan Items

Each study plan may contain:

```text
id
study_plan_id
topic_id
activity_type
scheduled_date
estimated_minutes
status
completed_at
```

---

# 47. AI Domain

AI data must be separated from ordinary learning data.

Primary entities:

```text
AI Session
AI Message
AI Generation
AI Usage
```

---

# 48. AI Session

Represents an AI learning interaction.

Attributes:

```text
id
user_id
student_id
session_type
subject_id
topic_id
started_at
ended_at
status
```

Possible session types:

```text
TUTOR
REVISION
WRITING
VIVA
STUDY_PLAN
GENERAL_LEARNING
```

---

# 49. AI Message

Represents an individual AI interaction.

Attributes:

```text
id
session_id
role
content
model_reference
input_tokens
output_tokens
created_at
```

Possible roles:

```text
USER
ASSISTANT
SYSTEM
```

Sensitive data should not be retained unnecessarily.

---

# 50. AI Generation

Generated educational assets may include:

```text
Questions
Flashcards
Study Plans
Summaries
Explanations
Tests
```

Generation records should contain:

```text
id
created_by
generation_type
input_reference
output_reference
model_reference
status
created_at
```

---

# 51. AI Content Review

AI-generated educational content should be distinguishable from reviewed/trusted content.

Possible statuses:

```text
GENERATED
PENDING_REVIEW
REVIEWED
APPROVED
REJECTED
```

AI-generated questions should not automatically become trusted question-bank content without appropriate validation.

---

# 52. AI Usage

AI usage should be trackable for cost and entitlement management.

Attributes:

```text
id
user_id
subscription_id
feature
model_reference
input_units
output_units
estimated_cost
created_at
```

---

# 53. Teacher Domain

Teacher-specific relationships include:

```text
Teacher
 ↓
School
 ↓
Classes
 ↓
Subjects
 ↓
Students
```

Teachers may also own question banks and create assessments.

---

# 54. Teacher-Class Assignment

Entity:

```text
teacher_class_assignments
```

Attributes:

```text
id
teacher_id
class_id
subject_id
academic_session_id
school_id
status
created_at
updated_at
```

---

# 55. Student Enrollment

Students may enroll in a school/class context.

Entity:

```text
student_enrollments
```

Attributes:

```text
id
student_id
school_id
class_id
academic_session_id
section
roll_number
start_date
end_date
status
```

This preserves historical academic records.

---

# 56. School Domain

School entity:

```text
id
name
code
address
contact_information
status
created_at
updated_at
```

School-specific data should remain separate from the general student profile.

---

# 57. School Membership

Teachers, students, and administrators may have institutional memberships.

Concept:

```text
School
 ├── Students
 ├── Teachers
 └── Administrators
```

Membership records should preserve historical relationships.

---

# 58. School Classes

A school may have multiple sections.

Example:

```text
Class 9
 ├── Section A
 ├── Section B
 └── Section C
```

A school class/section entity should be used where institutional functionality requires it.

---

# 59. Assignment Domain

Assignments may be created by teachers.

Attributes:

```text
id
teacher_id
school_id
class_id
subject_id
title
instructions
due_at
total_marks
status
created_at
updated_at
```

---

# 60. Assignment Submission

Students submit assignment work.

Attributes:

```text
id
assignment_id
student_id
submission_content
submitted_at
status
marks
feedback
graded_at
```

---

# 61. Media Domain

Media entities may include:

```text
Video
Audio
Document
Image
Live Event
Radio Program
```

---

# 62. Video

Attributes may include:

```text
id
title
description
topic_id
provider
external_reference
duration_seconds
status
created_by
published_at
created_at
updated_at
```

---

# 63. Audio

Attributes may include:

```text
id
title
description
topic_id
provider
external_reference
duration_seconds
status
created_by
published_at
created_at
updated_at
```

---

# 64. Internet Radio

Radio-related entities may include:

```text
Radio Station
Radio Program
Radio Episode
Radio Schedule
```

These should remain separate from ordinary educational audio lessons.

---

# 65. Live Event

Live educational events may represent:

```text
Live Class
Career Session
Q&A
Exam Preparation
Educational Event
```

Attributes:

```text
id
title
description
host_user_id
start_at
end_at
platform
external_reference
status
created_at
updated_at
```

---

# 66. Career Domain

Career data may include:

```text
Career
Skill
Job
Internship
Scholarship
Course
```

---

# 67. Career Path

Attributes:

```text
id
title
description
education_requirements
skill_requirements
status
created_at
updated_at
```

---

# 68. Skills

Skills may be associated with careers and learning resources.

Attributes:

```text
id
name
description
category
status
created_at
updated_at
```

---

# 69. Job

Job listings may contain:

```text
id
title
organization
description
location
employment_type
application_url
closing_at
status
created_at
updated_at
```

Paid/featured listings should be distinguishable from ordinary listings.

---

# 70. Scholarship

Scholarship records may include:

```text
id
title
organization
description
eligibility
deadline
application_url
status
created_at
updated_at
```

---

# 71. Notification Domain

Notifications may be generated for:

```text
Test Results
Assignments
Revision
Teacher Activity
System Announcements
Subscriptions
```

Entity:

```text
notifications
```

Attributes:

```text
id
user_id
type
title
message
data
read_at
created_at
```

---

# 72. Saved Content

Students may save:

```text
Questions
Topics
Lessons
Videos
Audio
Notes
```

A generalized bookmark/saved-content relationship may be used.

---

# 73. Subscription Domain

Monetization entities:

```text
Plan
Subscription
Entitlement
Payment
Transaction
```

---

# 74. Plan

Represents a commercial plan.

Attributes:

```text
id
name
description
billing_interval
price
currency
status
created_at
updated_at
```

Possible plans:

```text
FREE
STUDENT_PREMIUM
FAMILY
TEACHER
SCHOOL
```

---

# 75. Subscription

Attributes:

```text
id
user_id
plan_id
status
start_at
end_at
renewal_at
provider
provider_reference
created_at
updated_at
```

---

# 76. Entitlement

Entitlements determine feature access.

Examples:

```text
ai.tutor
ai.paper_generator
advanced.analytics
advanced.revision
premium.tests
```

Relationship:

```text
Plan
 ↓
Entitlements
 ↓
User Access
```

---

# 77. Payment

Payment records should be immutable financial records.

Attributes:

```text
id
user_id
subscription_id
amount
currency
provider
provider_reference
status
paid_at
created_at
updated_at
```

---

# 78. Transaction

Transactions provide a financial audit trail.

Possible types:

```text
PAYMENT
REFUND
ADJUSTMENT
```

---

# 79. Analytics Domain

Analytics should support educational and product analysis.

Examples:

```text
Learning Activity
Test Activity
Feature Usage
Conversion
Retention
Performance
```

Analytics data should be designed with privacy and retention policies.

---

# 80. Audit Domain

Important administrative actions should be recorded.

Entity:

```text
audit_logs
```

Attributes:

```text
id
actor_user_id
action
entity_type
entity_id
metadata
ip_reference
created_at
```

Sensitive audit information should be protected.

---

# 81. System Settings

Platform-level configuration may include:

```text
Application Settings
Feature Flags
Academic Settings
Notification Settings
AI Settings
Monetization Settings
```

Configuration should not require code changes where dynamic administration is appropriate.

---

# 82. Content Ownership

Educational content should have clear ownership.

Possible ownership:

```text
PLATFORM
TEACHER
SCHOOL
PARTNER
```

Ownership should determine editing and publishing permissions.

---

# 83. Content Lifecycle

Major educational content should follow:

```text
DRAFT
 ↓
REVIEW
 ↓
APPROVED
 ↓
PUBLISHED
 ↓
ARCHIVED
```

This applies especially to:

* Questions
* Tests
* Learning materials
* AI-generated content

---

# 84. Historical Data Principle

The platform must preserve important historical records.

Examples:

```text
Previous Class
Previous Academic Session
Past Test
Past Result
Past Enrollment
Past Teacher Assignment
Past Subscription
```

Historical records should not be overwritten simply because a student progresses to another class.

---

# 85. Soft Deletion

For important entities, deletion should generally be handled through controlled status/archival mechanisms where historical integrity matters.

Examples:

```text
Questions
Tests
Results
Enrollments
Payments
Subscriptions
Audit Logs
```

Permanent deletion should be restricted.

---

# 86. Multi-Tenancy Direction

The platform should be capable of supporting institutional tenants.

Concept:

```text
Platform
 │
 ├── Public Students
 │
 ├── School A
 │    ├── Teachers
 │    └── Students
 │
 ├── School B
 │    ├── Teachers
 │    └── Students
 │
 └── Future Institutions
```

Institutional data must remain appropriately isolated.

---

# 87. API-Oriented Data Model

The data model must support multiple clients:

```text
Web Application
      │
      ▼
     API
      │
 ┌────┼────┐
 │    │    │
Web Android iOS
```

Future mobile applications should not require a separate database model.

---

# 88. External Content References

Where content is hosted externally, store references rather than unnecessarily duplicating external data.

Examples:

```text
YouTube Video ID
Audio Provider Reference
Live Stream Reference
External Career URL
```

External references must be validated and monitored.

---

# 89. Data Relationships — Core

The most important relationship chain is:

```text
Student
 ↓
Enrollment
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
```

Assessment chain:

```text
Topic
 ↓
Question
 ↓
Test
 ↓
Attempt
 ↓
Answer
 ↓
Result
```

Learning improvement chain:

```text
Result
 ↓
Mistake
 ↓
Revision
 ↓
Retest
 ↓
Improvement
```

AI chain:

```text
Student
 ↓
AI Session
 ↓
AI Message
 ↓
AI Generation
 ↓
Learning Asset
```

---

# 90. Core Entity Relationship Summary

```text
USER
 │
 ├── STUDENT
 │     ├── ENROLLMENT
 │     ├── PROGRESS
 │     ├── ATTEMPTS
 │     ├── MISTAKES
 │     ├── REVISION
 │     ├── FLASHCARDS
 │     └── AI SESSIONS
 │
 ├── TEACHER
 │     ├── SCHOOL
 │     ├── CLASSES
 │     ├── QUESTION BANKS
 │     └── TESTS
 │
 └── PARENT
       └── STUDENT RELATIONSHIP


BOARD
 │
 └── ACADEMIC SESSION
       │
       └── CLASS
             │
             └── SUBJECT
                   │
                   └── BOOK
                         │
                         └── CHAPTER
                               │
                               └── TOPIC
                                     │
                         ┌───────────┼────────────┐
                         │           │            │
                    CONTENT      QUESTIONS      VIDEOS
                                      │
                                      ▼
                                    TEST
                                      │
                                      ▼
                                   ATTEMPT
                                      │
                                      ▼
                                    ANSWER
                                      │
                                      ▼
                                    RESULT
                                      │
                                      ▼
                                   MISTAKE
                                      │
                                      ▼
                                   REVISION
```

---

# 91. Data Integrity Rules

The platform must enforce:

1. Foreign key integrity.
2. Valid ownership.
3. Valid academic relationships.
4. Valid user permissions.
5. Valid test/question relationships.
6. Valid subscription entitlements.
7. Historical result integrity.
8. Financial transaction integrity.

---

# 92. Security Rules

Sensitive information must be protected.

Examples:

```text
Passwords
Authentication Tokens
Payment References
Student Personal Data
AI Conversation Data
Audit Data
```

Passwords must never be stored in plaintext.

---

# 93. Privacy Principles

The platform should follow:

```text
Data Minimization
Purpose Limitation
Access Control
Retention Control
Secure Storage
Controlled Deletion
```

Student data should only be collected when necessary for legitimate platform functionality.

---

# 94. Performance Considerations

High-volume entities are expected to include:

```text
Questions
Test Attempts
Student Answers
Learning Activity
AI Usage
Notifications
Analytics
```

These entities should be designed for efficient querying and future scaling.

---

# 95. Reporting Data

Reports may aggregate information from:

```text
Students
Tests
Results
Subjects
Chapters
Topics
Classes
Schools
```

Reporting queries should avoid modifying source records.

---

# 96. AI Data Governance

AI-generated information should never automatically override trusted educational content.

The system should distinguish:

```text
Human-Created
AI-Generated
AI-Assisted
Human-Reviewed
Approved
```

---

# 97. Data Ownership & Access

Access should follow role and relationship.

Example:

```text
Student
 → Own Data

Teacher
 → Authorized Students / Classes

Parent
 → Authorized Child Data

School Admin
 → Authorized School Data

Platform Admin
 → Platform-Level Authorized Data
```

---

# 98. Future Expansion Compatibility

The model should allow future support for:

```text
Higher Education
Vocational Education
Competitive Exams
Professional Skills
International Curricula
Additional Languages
Additional Countries
```

These should be added without breaking the existing Nursery → Class 12 structure.

---

# 99. Data Model Completion Criteria

The data model will be considered ready for database implementation when:

```text
All Core Domains Identified
        +
Relationships Defined
        +
Ownership Defined
        +
Historical Data Considered
        +
Security Considered
        +
Scalability Considered
        +
Future Expansion Considered
```

---

# 100. Implementation Boundary

This document defines the **domain-level data model**.

The following details belong in `DATABASE.md`:

```text
Exact Table Definitions
Column Data Types
Primary Keys
Foreign Keys
Indexes
Unique Constraints
Check Constraints
Enum Implementation
Migrations
Database Engine Configuration
Query Optimization
Partitioning
Backup Strategy
```

---

# 101. Final Domain Model

The complete Aspirian platform can be represented as:

```text
                    ASPIRIAN PLATFORM
                           │
          ┌────────────────┼────────────────┐
          │                │                │
       USERS           ACADEMICS        INSTITUTIONS
          │                │                │
     ┌────┼────┐           │          ┌─────┼─────┐
     │    │    │           │        Schools Teachers
 Student Teacher Parent     │           │
     │                     │        Students
     │              Classes/Subjects
     │                     │
     │                  Topics
     │                     │
     ├────────────── Questions
     │                     │
     │                   Tests
     │                     │
     │                  Attempts
     │                     │
     │                   Results
     │                     │
     │                  Mistakes
     │                     │
     │                  Revision
     │
     ├────────────── AI Learning
     │
     ├────────────── Media
     │
     ├────────────── Career
     │
     └────────────── Subscriptions
```

---

# 102. Final Principle

The Aspirian data model must remain:

> **Structured enough for reliable assessment, flexible enough for Nursery → Class 12, scalable enough for future schools and mobile applications, and secure enough to protect student data.**

---

# 103. Document Status

**File:** `DATA_MODEL.md`
**Version:** 1.0
**Status:** Final Data Model Blueprint
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`
**Existing Website:** `aspirian.pk`

This document defines the complete domain-level data model for the Aspirian Student Platform.

Detailed database implementation will be defined separately in `DATABASE.md`.
