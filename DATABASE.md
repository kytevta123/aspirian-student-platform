# Aspirian Student Platform — Database Design

**Version:** 1.0
**Status:** Initial Database Blueprint
**Database:** PostgreSQL
**Project:** Aspirian Student Platform
**Academic Range:** Nursery to Class 12

---

# 1. Database Design Goals

The database must be:

* Scalable
* Normalized
* Maintainable
* Secure
* Extensible
* Auditable
* Multi-board capable
* Multi-session capable
* Multi-school capable

The database must not contain assumptions that limit the platform to Classes 9–12.

---

# 2. Core Database Domains

```text
Database
│
├── Identity & Access
├── Academic Structure
├── Educational Content
├── Knowledge Bank
├── Question Bank
├── Assessments
├── Student Learning
├── Personalization
├── AI
├── Language
├── Practicals & Activities
├── Coding
├── Media
├── Teachers
├── Parents
├── Schools
├── Notifications
├── Subscriptions
└── Auditing
```

---

# 3. Database Naming Conventions

Use:

* `snake_case` for table and column names
* Singular conceptual entities with plural table names
* UUID primary keys where appropriate
* Foreign keys for relationships
* Timestamps for important records
* Soft deletion where historical records must be preserved

Example:

```text
users
students
subjects
chapters
questions
tests
test_attempts
```

---

# 4. Primary Key Strategy

The preferred primary key strategy is:

**UUID**

Example:

```text
id UUID PRIMARY KEY
```

UUIDs reduce predictable sequential identifiers and are suitable for distributed systems and future integrations.

---

# 5. Identity & Access

## 5.1 users

Stores platform user accounts.

Suggested fields:

```text
id
name
email
phone
password_hash
status
email_verified_at
last_login_at
created_at
updated_at
```

---

## 5.2 roles

```text
id
name
description
created_at
updated_at
```

Possible roles:

* student
* teacher
* parent
* editor
* reviewer
* school_admin
* platform_admin

---

## 5.3 permissions

```text
id
name
description
created_at
updated_at
```

---

## 5.4 role_permissions

```text
role_id
permission_id
```

---

## 5.5 user_roles

```text
user_id
role_id
```

This allows a user to have multiple roles where appropriate.

---

# 6. Student Profiles

## 6.1 students

```text
id
user_id
date_of_birth
gender
avatar
current_grade_id
current_board_id
current_academic_session_id
created_at
updated_at
```

Sensitive fields should only be collected where genuinely required.

---

## 6.2 student_subjects

Stores subjects selected by the student.

```text
student_id
subject_id
status
created_at
```

---

## 6.3 student_preferences

Stores learning preferences.

```text
id
student_id
language
daily_study_minutes
notification_preferences
created_at
updated_at
```

---

# 7. Academic Structure

## 7.1 education_systems

```text
id
name
country
status
```

Examples:

* Pakistan
* International

---

## 7.2 boards

```text
id
education_system_id
name
code
status
```

Examples may include:

* Punjab Boards
* Federal Board
* Sindh Boards
* KPK Boards

The architecture must support individual boards rather than assuming only Punjab Board.

---

## 7.3 academic_sessions

```text
id
name
start_date
end_date
status
```

Example:

```text
2026
2026-27
```

---

## 7.4 grades

```text
id
name
code
level
sort_order
status
```

Examples:

```text
Nursery
KG
Prep
Class 1
Class 2
...
Class 12
```

---

## 7.5 subjects

```text
id
name
code
description
status
```

---

## 7.6 grade_subjects

Maps subjects to grades.

```text
id
grade_id
subject_id
board_id
academic_session_id
status
```

This allows different boards and sessions to have different subject structures.

---

# 8. Books & Syllabus

## 8.1 books

```text
id
board_id
grade_id
subject_id
academic_session_id
title
publisher
edition
status
```

---

## 8.2 chapters

```text
id
book_id
chapter_number
title
description
sort_order
status
```

---

## 8.3 topics

```text
id
chapter_id
title
description
sort_order
status
```

---

# 9. Learning Objectives

## 9.1 learning_objectives

```text
id
topic_id
title
description
difficulty
status
```

Learning objectives can later connect content, questions, tests, and student mastery.

---

# 10. Educational Content

## 10.1 content_items

General educational content entity.

```text
id
title
slug
content_type
body
grade_id
subject_id
chapter_id
topic_id
board_id
academic_session_id
source_id
status
version
created_by
reviewed_by
published_at
created_at
updated_at
```

Content types may include:

* Note
* Explanation
* Definition
* Example
* Summary
* Formula
* Activity
* Practical
* Revision Material

---

# 11. Content Sources

## 11.1 sources

```text
id
title
source_type
reference
publisher
copyright_status
uploaded_by
created_at
```

Source types may include:

* Textbook
* PDF
* Document
* Official material
* Teacher material
* Aspirian original content

---

# 12. Content Versions

## 12.1 content_versions

```text
id
content_item_id
version_number
content
change_summary
created_by
created_at
```

This preserves historical versions.

---

# 13. Knowledge Bank

The Knowledge Bank may reuse `content_items` while maintaining structured educational relationships.

## 13.1 knowledge_items

```text
id
content_item_id
knowledge_type
difficulty
importance
status
created_at
updated_at
```

Possible knowledge types:

* Concept
* Definition
* Fact
* Formula
* Procedure
* Example

---

# 14. Question Bank

## 14.1 questions

```text
id
question_type
question_text
explanation
marks
difficulty
grade_id
subject_id
chapter_id
topic_id
board_id
academic_session_id
source_id
status
created_by
reviewed_by
approved_at
created_at
updated_at
```

---

# 15. Question Options

## 15.1 question_options

Used for MCQs and similar question types.

```text
id
question_id
option_text
sort_order
is_correct
```

---

# 16. Question Answers

For questions requiring structured answer information.

## 16.1 question_answers

```text
id
question_id
answer_type
answer_data
created_at
updated_at
```

Answer data may contain structured information where necessary.

---

# 17. Question Tags

## 17.1 tags

```text
id
name
slug
```

## 17.2 question_tags

```text
question_id
tag_id
```

---

# 18. Question Review

## 18.1 question_reviews

```text
id
question_id
reviewer_id
status
comments
created_at
```

Statuses:

* pending
* approved
* rejected
* revision_required

---

# 19. Duplicate Detection

## 19.1 question_similarity_records

```text
id
question_id
similar_question_id
similarity_score
detection_method
status
created_at
```

Detection methods:

* exact
* normalized
* lexical
* semantic

The system must distinguish between genuine duplicates and valid variations.

---

# 20. Tests

## 20.1 tests

```text
id
title
description
test_type
grade_id
subject_id
chapter_id
topic_id
board_id
academic_session_id
duration_minutes
total_marks
status
created_by
created_at
updated_at
```

Test types:

* Practice
* Topic
* Chapter
* Subject
* Mock Exam
* Board Style
* Teacher Test

---

# 21. Test Questions

## 21.1 test_questions

```text
id
test_id
question_id
question_order
marks
```

A question may appear in many different tests.

---

# 22. Test Attempts

## 22.1 test_attempts

```text
id
test_id
student_id
started_at
submitted_at
status
total_marks
obtained_marks
percentage
time_spent_seconds
```

---

# 23. Student Answers

## 23.1 student_answers

```text
id
attempt_id
question_id
answer_data
is_correct
marks_awarded
time_spent_seconds
answered_at
```

---

# 24. Mistakes Notebook

## 24.1 student_mistakes

```text
id
student_id
question_id
attempt_id
topic_id
student_answer
correct_answer
mistake_count
last_mistake_at
mastered_at
status
created_at
updated_at
```

Statuses:

* active
* reviewing
* mastered

---

# 25. Revision Queue

## 25.1 revision_items

```text
id
student_id
topic_id
source_type
source_id
priority_score
recommended_at
due_at
completed_at
status
created_at
updated_at
```

Source types may include:

* Mistake
* Weak Topic
* Spaced Revision
* Upcoming Exam
* AI Recommendation

---

# 26. Topic Mastery

## 26.1 student_topic_mastery

```text
id
student_id
topic_id
mastery_score
confidence_score
attempt_count
correct_count
incorrect_count
last_practiced_at
last_revised_at
updated_at
```

This table is a key component of personalized learning.

---

# 27. Learning Activity

## 27.1 learning_activities

```text
id
student_id
activity_type
resource_type
resource_id
started_at
completed_at
duration_seconds
metadata
```

Activity types may include:

* Reading
* Video
* Test
* Practice
* Revision
* Flashcard
* Activity
* Coding

---

# 28. Student Recommendations

## 28.1 student_recommendations

```text
id
student_id
recommendation_type
resource_type
resource_id
reason
priority
status
created_at
expires_at
```

---

# 29. Flashcards

## 29.1 flashcard_decks

```text
id
title
description
grade_id
subject_id
chapter_id
topic_id
created_by
status
created_at
```

---

## 29.2 flashcards

```text
id
deck_id
front
back
sort_order
created_at
updated_at
```

---

## 29.3 student_flashcard_progress

```text
id
student_id
flashcard_id
review_count
correct_count
next_review_at
last_reviewed_at
```

---

# 30. Language Lab

## 30.1 vocabulary

```text
id
word
language
meaning
urdu_meaning
roman_urdu_meaning
pronunciation
example_sentence
created_at
updated_at
```

---

## 30.2 vocabulary_relations

```text
id
vocabulary_id
relation_type
related_word
```

Relation types:

* synonym
* antonym
* related

---

## 30.3 grammar_exercises

```text
id
title
exercise_type
content
answer_data
grade_id
status
created_at
updated_at
```

---

# 31. Writing Practice

## 31.1 writing_templates

```text
id
type
title
content
grade_id
status
created_at
updated_at
```

Supported types:

* Essay
* Letter
* Application
* Story
* Dialogue
* Paragraph
* Summary
* Report
* Notice
* Speech

---

# 32. Practicals & Activities

## 32.1 practicals

```text
id
title
subject_id
grade_id
chapter_id
topic_id
description
materials
procedure
observations
result
safety_notes
status
created_at
updated_at
```

---

## 32.2 activities

```text
id
title
activity_type
grade_id
subject_id
chapter_id
topic_id
instructions
configuration
status
created_at
updated_at
```

Activity types may include:

* Interactive
* Matching
* Drag and Drop
* Simulation
* Problem Solving
* Diagram
* Quiz

---

# 33. Viva

## 33.1 viva_questions

```text
id
question_id
expected_concepts
difficulty
status
```

---

# 34. Coding Lab

## 34.1 coding_problems

```text
id
title
description
language
difficulty
grade_id
subject_id
topic_id
constraints
examples
test_cases
status
created_at
updated_at
```

---

## 34.2 coding_submissions

```text
id
problem_id
student_id
language
source_code
status
execution_time
memory_used
output
error_message
submitted_at
```

Student code must never be executed directly on the main application server.

---

# 35. Media

## 35.1 media_items

```text
id
title
media_type
provider
external_id
url
description
grade_id
subject_id
chapter_id
topic_id
duration_seconds
status
created_at
updated_at
```

Media types:

* Video
* Audio
* Podcast
* Live Stream
* Radio Program

Providers may include:

* YouTube
* External Streaming Provider
* Aspirian

---

# 36. Video Quiz Markers

## 36.1 video_quiz_markers

```text
id
media_item_id
question_id
timestamp_seconds
required
created_at
```

---

# 37. Audio & Transcript Processing

## 37.1 media_transcripts

```text
id
media_item_id
language
transcript
status
created_at
updated_at
```

---

# 38. AI System

## 38.1 ai_conversations

```text
id
user_id
context_type
context_id
created_at
updated_at
```

---

## 38.2 ai_messages

```text
id
conversation_id
role
content
model
token_usage
created_at
```

Roles:

* user
* assistant
* system

---

# 39. AI Generation Jobs

## 39.1 ai_generation_jobs

```text
id
job_type
requested_by
source_type
source_id
status
input_data
output_data
error_message
created_at
completed_at
```

Job types may include:

* Question Generation
* Summary
* Flashcards
* Quiz
* Notes
* Audio Summary
* Video Processing

---

# 40. AI Source References

## 40.1 ai_source_references

```text
id
job_id
source_type
source_id
relevance_score
created_at
```

This helps maintain source traceability.

---

# 41. AI Recommendations

AI recommendations should ultimately create records in the normal recommendation system rather than existing only inside AI logs.

```text
AI Analysis
    ↓
Recommendation
    ↓
student_recommendations
```

---

# 42. Teacher System

## 42.1 teachers

```text
id
user_id
qualification
bio
status
created_at
updated_at
```

---

## 42.2 teacher_classes

```text
id
teacher_id
grade_id
subject_id
school_id
academic_session_id
```

---

# 43. Parent System

## 43.1 parents

```text
id
user_id
created_at
updated_at
```

---

## 43.2 parent_students

```text
parent_id
student_id
relationship
status
created_at
```

---

# 44. Schools

## 44.1 schools

```text
id
name
code
email
phone
address
status
created_at
updated_at
```

---

## 44.2 school_users

```text
school_id
user_id
role
status
created_at
```

---

## 44.3 school_classes

```text
id
school_id
grade_id
name
academic_session_id
status
```

---

# 45. Assignments

## 45.1 assignments

```text
id
teacher_id
class_id
title
description
due_at
status
created_at
updated_at
```

---

## 45.2 assignment_submissions

```text
id
assignment_id
student_id
submission_data
submitted_at
status
feedback
```

---

# 46. Notifications

## 46.1 notifications

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

# 47. Subscriptions

## 47.1 plans

```text
id
name
description
billing_interval
price
currency
status
```

---

## 47.2 subscriptions

```text
id
user_id
plan_id
status
starts_at
ends_at
provider
provider_reference
created_at
updated_at
```

---

## 47.3 entitlements

```text
id
name
description
```

---

## 47.4 plan_entitlements

```text
plan_id
entitlement_id
```

This keeps premium access separate from core learning logic.

---

# 48. Audit Logs

## 48.1 audit_logs

```text
id
user_id
action
entity_type
entity_id
old_values
new_values
ip_address
user_agent
created_at
```

Important administrative and security-related actions should be logged.

---

# 49. System Settings

## 49.1 settings

```text
id
key
value
type
description
updated_at
```

Sensitive secrets should NOT be stored as ordinary settings.

---

# 50. File Metadata

## 50.1 files

```text
id
owner_id
storage_provider
storage_key
original_name
mime_type
size
visibility
created_at
```

Actual large files should be stored in object storage rather than PostgreSQL.

---

# 51. Core Relationships

The most important relationships are:

```text
Board
  ↓
Academic Session
  ↓
Grade
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
  ├── Questions
  ├── Practicals
  ├── Activities
  ├── Videos
  ├── Flashcards
  └── Tests
```

Student learning:

```text
Student
  ↓
Learning Activity
  ↓
Question Attempt
  ↓
Result
  ↓
Mistake
  ↓
Topic Mastery
  ↓
Revision Queue
  ↓
Recommendation
```

---

# 52. Important Database Rules

## Rule 1

Do not hard-code classes.

## Rule 2

Do not hard-code boards.

## Rule 3

Do not hard-code academic years.

## Rule 4

Do not store AI-generated content as automatically approved content.

## Rule 5

Do not store large media files directly inside the database.

## Rule 6

Do not execute student code on the main application server.

## Rule 7

Do not rely on frontend authorization.

## Rule 8

Important historical educational data should not be casually deleted.

## Rule 9

Question duplication must be checked before approval.

## Rule 10

Student learning data must be access-controlled.

---

# 53. Indexing Strategy

Important foreign keys and frequently searched fields should be indexed.

Likely indexes include:

```text
users.email
students.user_id
questions.subject_id
questions.topic_id
questions.difficulty
tests.subject_id
test_attempts.student_id
student_mistakes.student_id
student_topic_mastery.student_id
revision_items.student_id
learning_activities.student_id
notifications.user_id
```

Composite indexes will be added based on actual query patterns.

---

# 54. Foreign Key Strategy

Foreign keys should be used to maintain data integrity.

Example:

```text
questions.topic_id
        ↓
topics.id
```

Delete behavior must be selected carefully.

Historical educational and assessment records should generally not cascade-delete accidentally.

---

# 55. Soft Deletion

Soft deletion may be used for:

* Content
* Questions
* Users
* Schools
* Tests

where historical records are important.

Example:

```text
deleted_at
```

---

# 56. Data Integrity

The database must enforce:

* Unique constraints
* Foreign keys
* Required fields
* Valid status values
* Appropriate check constraints
* Transaction boundaries

Business validation must also exist in the application layer.

---

# 57. Transactions

Transactions should be used for multi-step operations.

Examples:

* Test submission
* Subscription changes
* Content approval
* Question approval
* Student enrollment

This prevents partially completed operations.

---

# 58. Security

Database security must include:

* Strong credentials
* Restricted access
* Encrypted connections
* Least privilege
* Regular backups
* Monitoring
* Secret management

Database credentials must never be committed to Git.

---

# 59. Future Vector / Semantic Search

The initial database can support normal relational and full-text search.

As AI retrieval requirements grow, vector search may be introduced.

Possible future architecture:

```text
Knowledge
   ↓
Embedding
   ↓
Vector Index
   ↓
Semantic Retrieval
   ↓
AI Tutor
```

This should be added only when required.

---

# 60. Future Analytics Warehouse

The operational database should not eventually become overloaded by large analytical workloads.

At larger scale:

```text
Operational Database
       ↓
Event / Analytics Pipeline
       ↓
Analytics Storage
       ↓
Reports / Dashboards
```

This is a future optimization.

---

# 61. Database Migration Strategy

All schema changes must use version-controlled migrations.

Never modify production database structure manually without a corresponding migration.

Example workflow:

```text
Migration
   ↓
Test
   ↓
Review
   ↓
Staging
   ↓
Production
```

---

# 62. Backup Strategy

Database backups should be:

* Automated
* Encrypted
* Retained according to policy
* Stored separately from the primary server
* Periodically tested

A backup that has never been restored should not be considered fully reliable.

---

# 63. Initial Database Scope

The first implementation should not create every future table immediately.

MVP tables should focus on:

```text
users
roles
user_roles
students

education_systems
boards
academic_sessions
grades
subjects
grade_subjects
books
chapters
topics

content_items

questions
question_options

tests
test_questions
test_attempts
student_answers

student_mistakes
student_topic_mastery
revision_items
learning_activities
```

Additional modules will be introduced progressively.

---

# 64. Database Evolution

The database will evolve through controlled versions.

```text
v1
 ↓
MVP
 ↓
v1.1
 ↓
AI Features
 ↓
v1.2
 ↓
Teacher Features
 ↓
v1.3
 ↓
Parent Features
 ↓
v2
 ↓
School / Multi-Tenant Platform
```

Existing data must be protected during migrations.

---

# 65. Database Status

**Version:** 1.0
**Status:** Initial Master Database Blueprint

This document defines the conceptual database architecture.

Exact SQL migrations and implementation details will be created during development.

---

# Final Database Principle

> **The database should model the educational system, not the current feature list.**

Aspirian's database must be capable of supporting the student's complete journey from **Nursery to Class 12**, while remaining flexible enough for future boards, schools, AI systems, teachers, parents, mobile applications, and new educational technologies.
