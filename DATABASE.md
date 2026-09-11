# Aspirian Student Platform — Database Design

**Version:** 1.1

**Status:** Master Database Blueprint — Updated for Universal Practice Architecture

**Database:** MariaDB 10.6.5

**Project:** Aspirian Student Platform

**Academic Range:** Nursery, Prep, Class 1–12

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

The database must not contain assumptions that limit the platform to a small range of classes or to a single type of learner.

The Aspirian database must support learners from **Nursery and Prep through Class 12**.

The system must support both early-years learning and advanced secondary-level academic learning without requiring a separate database architecture for different age groups.

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
* UUID primary keys where appropriate at the conceptual architecture level
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

learning_activities
```

Naming conventions must remain consistent with the actual Laravel implementation.

---

# 4. Primary Key Strategy

The database blueprint may use UUIDs where appropriate at the conceptual architecture level. However, the current Laravel 12 implementation uses BIGINT UNSIGNED primary and foreign keys where required by the existing application schema.

The existing `users.id` is a BIGINT UNSIGNED primary key. Related tables must therefore use compatible BIGINT UNSIGNED foreign keys.

Primary key types must remain consistent across related tables and must be compatible with the actual Laravel 12 and MariaDB 10.6.5 implementation.

UUIDs are not mandatory for the current implementation and must not be introduced where they would conflict with the existing database schema.

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

Authorization must always be enforced at the server/application level.

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

Stores subjects selected or associated with the student.

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

The architecture must support individual boards rather than assuming only one board.

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

Supported academic levels include:

```text
Nursery
Prep
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

Classes must be stored as data rather than hard-coded into application logic.

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

Learning objectives can later connect content, questions, activities, tests, practice sessions, and student mastery.

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

The `questions` entity is the universal educational question entity used by the Question Bank, formal assessments, Practice Engine, revision activities, and other learning experiences.

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

The question architecture must remain extensible so that new question types can be introduced without creating a separate question table for every interaction style.

---

## 14.2 Universal Practice Question Types

The Aspirian Practice Engine must support learners from **Nursery and Prep through Class 12**.

The question architecture must not be limited to traditional MCQ, Short Answer, and Long Answer questions.

Supported and planned practice question types include:

### Traditional Questions

* MCQ
* Short Answer
* Long Answer
* Fill in the Blank
* True / False
* Yes / No
* Multiple Select
* Correct Word
* Spelling

### Matching Questions

* Matching
* Drag and Drop Matching
* Alphabet Matching
* Haroof-e-Tahajji Matching
* Word Matching
* Picture-to-Word Matching
* Word-to-Picture Matching

### Language Practice

* English to Urdu
* Urdu to English
* Translation
* Word Meaning
* Sentence Formation

### Early Years Practice

Early years practice must support:

* Nursery
* Prep

Examples include:

* Alphabet Recognition
* Haroof-e-Tahajji Recognition
* Missing Letter
* Missing Harf
* Picture Identification
* Picture Selection
* Picture Matching
* Word Matching
* Simple True / False
* Simple Yes / No
* Simple Drag and Drop activities

### Image-Based Questions

The question system must support:

* Image Identification
* Image Selection
* Image-Based MCQ
* Picture-to-Word Questions
* Word-to-Picture Questions
* Picture Matching
* Image-Based Matching

### Interactive Questions

The architecture must support interactive question interfaces including:

* Drag and Drop
* Matching
* Ordering / Arrange
* Multiple Selection
* Interactive Choice

### Audio / Listening Questions

The architecture should remain extensible for future audio-based practice including:

* Listen and Select
* Listen and Match
* Listening Comprehension
* Audio-to-Word
* Audio-to-Picture

The database design must not require a separate question table for every question type.

A universal question entity should be used, while type-specific configuration and answer data determine how the question is rendered and evaluated.

The system should be capable of supporting future question types without redesigning the complete Question Bank.

---

# 15. Question Options

## 15.1 question_options

Stores selectable options for questions that require one or more choices.

```text
id
question_id
option_text
sort_order
is_correct
```

Question options may support:

* MCQ
* True / False
* Yes / No
* Multiple Select
* Image-Based MCQ
* Picture Selection
* Interactive Choice
* Other future choice-based question types

Options may also reference media or file metadata when an option is represented by an image, audio file, or other supported media.

Actual binary media content must not be stored directly in MariaDB.

Correct-option information must never be exposed to students before evaluation.

---

# 16. Question Answers

## 16.1 question_answers

Stores structured answer information for questions where a simple option list is insufficient.

```text
id
question_id
answer_type
answer_data
created_at
updated_at
```

Possible `answer_type` values include:

* text
* single_choice
* multiple_choice
* true_false
* fill_blank
* matching
* ordering
* translation
* image_selection
* drag_drop

`answer_data` may contain:

* accepted text answers
* multiple accepted answers
* matching pairs
* correct ordering
* drag-and-drop mappings
* translation answers
* image identifiers
* option identifiers
* other structured evaluation data

Correct answer data must never be exposed to students before submission.

Answer evaluation must be performed server-side where applicable.

The answer architecture must allow future question types without creating a separate answer table for every question type.

---

# 17. Question Tags

## 17.1 tags

```text
id
name
slug
```

---

## 17.2 question_tags

```text
question_id
tag_id
```

Tags may be used for filtering, search, practice selection, difficulty analysis, and personalization.

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

Questions generated or imported from external or AI sources must not automatically become approved educational content.

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

Duplicate detection should occur before final approval where applicable.

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

### Practice Test Clarification

The `Practice` test type represents practice-oriented learning configuration.

However, Practice Engine sessions are conceptually different from formal examination attempts.

Practice may use questions directly from the Question Bank without creating a formal exam result.

Practice sessions may provide:

* Instant answer checking
* Immediate feedback
* Correct answer after submission
* Explanations
* Question-by-question progress
* Topic-wise progress
* Correct/wrong/unanswered tracking
* Completion percentage

Formal tests continue to use the formal Test Attempt and Result architecture.

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

The same Question Bank question may therefore be reused for formal tests, practice configurations, revision activities, and other learning experiences where appropriate.

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

Formal test attempts must remain separate from ordinary practice learning activity records where practice does not represent a formal examination.

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

Student answer records for formal tests must preserve the submitted answer and evaluation result.

Correct answer information must not be exposed to the student before the appropriate evaluation stage.

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

Mistakes may originate from formal tests, practice sessions, assignments, or other evaluated learning activities depending on the implementation.

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

Revision recommendations should be based on actual student learning data where possible.

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

Practice activity may contribute to topic mastery without creating a formal examination result.

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

## 27.2 Practice Learning Records

Practice activity may generate application-level learning records such as:

```text
Practice Session Started

Question Attempted

Question Answered

Question Skipped

Question Checked

Correct Answer

Incorrect Answer

Practice Session Completed

Topic Practiced
```

These records are learning events and should not automatically be treated as formal examination results.

The implementation may initially track these events using existing application-level learning behavior and `learning_activities`.

A dedicated persistent practice-session table should only be introduced if long-term practice history, analytics, synchronization, or cross-device recovery requires it.

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

AI-generated recommendations should ultimately create records in the normal recommendation system.

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

Grammar exercises may later integrate with the Universal Practice Engine.

---

# 31. Writing Practice

The Writing Practice system provides a structured environment for students to practice academic and creative writing from **Nursery and Prep through Class 12**.

The architecture must support:

```text
Writing Prompt
      ↓
Writing Workspace
      ↓
Draft / Submit
      ↓
Self Review
      ↓
Evaluation
      ↓
Feedback
      ↓
Improvement
      ↓
Retry / New Attempt
      ↓
Student Writing Progress
```

Writing Practice must support teacher-created, platform-created, and future AI-assisted writing activities while keeping student submissions, evaluations, rubrics, and writing content logically separated.

The system must support multiple attempts without overwriting previous student writing.

---

## 31.1 writing_templates

Stores reusable writing practice prompts and writing tasks.

```text
id

type

title

prompt

instructions

model_answer

grade_id

subject_id

chapter_id

topic_id

board_id

academic_session_id

language

difficulty

marks

minimum_words

maximum_words

writing_rubric_id

source_id

status

created_by

reviewed_by

published_at

created_at

updated_at
```

Supported writing types:

```text
essay

paragraph

letter

application

story

dialogue

summary

report

notice

speech

descriptive

creative

comprehension

short_answer

long_answer
```

Writing templates may be associated with:

```text
Grade

Subject

Chapter

Topic

Board

Academic Session

Language

Difficulty

Rubric

Source
```

### Writing Template Rules

A writing template may contain:

* Writing prompt
* Instructions
* Model answer
* Word-count requirements
* Marks
* Difficulty
* Academic classification
* Writing type
* Evaluation rubric

The `model_answer` is reference material and must not be exposed to the student before the appropriate learning or evaluation stage.

Writing templates should support:

```text
draft

published

archived
```

or an equivalent controlled status strategy.

Only approved and published writing templates should normally become available to students.

---

## 31.2 writing_attempts

Stores individual student writing attempts.

Each submission must remain a separate historical record.

```text
id

writing_template_id

student_id

attempt_number

content

word_count

character_count

status

self_review

improved_from_attempt_id

started_at

submitted_at

reviewed_at

created_at

updated_at
```

Supported statuses:

```text
draft

submitted

reviewed
```

### Multiple Attempt Architecture

A student may attempt the same writing task multiple times.

Example:

```text
Writing Template
      ↓
Attempt 1
      ↓
Review
      ↓
Attempt 2
      ↓
Improved Writing
      ↓
Attempt 3
```

Previous attempts must never be overwritten.

The `improved_from_attempt_id` field allows an improved attempt to reference the previous attempt from which it was developed.

Example:

```text
Attempt 1
improved_from_attempt_id = NULL

Attempt 2
improved_from_attempt_id = Attempt 1

Attempt 3
improved_from_attempt_id = Attempt 2
```

This creates a complete improvement history.

### Writing Workspace Data

The writing workspace should support:

* Writing area
* Word count
* Character count
* Clear/reset
* Save draft
* Submit
* Previous prompt
* Next prompt
* Self-review

Word and character counts may be calculated by the application and stored with the attempt for historical reporting and analytics.

---

## 31.3 writing_evaluations

Stores evaluation results for student writing attempts.

```text
id

writing_attempt_id

evaluator_type

evaluator_id

content_score

grammar_score

vocabulary_score

organization_score

spelling_score

relevance_score

overall_score

feedback

strengths

improvements

status

evaluated_at

created_at

updated_at
```

Supported evaluator types:

```text
teacher

ai

system
```

The `evaluator_id` may reference a platform user where applicable.

For system-generated or AI-generated evaluations where no user account exists, `evaluator_id` may remain nullable.

Evaluation statuses may include:

```text
pending

completed

revised
```

or an equivalent controlled status strategy.

### Evaluation Criteria

Writing evaluation should be capable of assessing:

```text
Content

Grammar

Vocabulary

Organization

Spelling

Relevance

Overall Performance
```

The architecture must remain ready for both manual teacher evaluation and future AI-assisted evaluation.

AI evaluation must not automatically be treated as authoritative teacher assessment unless the product explicitly defines that behavior.

---

## 31.4 writing_rubrics

Stores reusable writing evaluation rubrics.

```text
id

title

description

grade_id

subject_id

writing_type

status

created_at

updated_at
```

Rubrics allow different academic levels and writing types to use different evaluation criteria.

Examples:

```text
Class 5 Essay Rubric

Class 8 Paragraph Rubric

Class 9 Letter Writing Rubric

Class 10 Application Rubric

Class 11 English Essay Rubric

Class 12 Creative Writing Rubric
```

A rubric may be associated with a writing template through:

```text
writing_templates.writing_rubric_id
```

This allows the same rubric to be reused across multiple writing tasks.

---

## 31.5 writing_rubric_items

Stores individual criteria within a writing rubric.

```text
id

writing_rubric_id

criterion

description

maximum_marks

sort_order

created_at

updated_at
```

Example rubric:

```text
Writing Rubric
      │
      ├── Content
      ├── Grammar
      ├── Vocabulary
      ├── Organization
      ├── Spelling
      └── Relevance
```

Each rubric item may define:

* Criterion
* Description
* Maximum marks
* Evaluation order

This prevents evaluation criteria from being hard-coded into the application.

---

## 31.6 Writing Practice Relationships

The primary relationship is:

```text
Academic Structure
      ↓
Writing Template
      │
      ├── Prompt
      ├── Instructions
      ├── Model Answer
      ├── Difficulty
      ├── Marks
      └── Rubric
             ↓
      Student Writing Attempt
             │
             ├── Draft
             ├── Submit
             ├── Word Count
             ├── Character Count
             └── Self Review
                    ↓
              Evaluation
                    │
                    ├── Teacher
                    ├── AI
                    └── System
                    ↓
                 Feedback
                    ↓
               Improvement
                    ↓
              New Attempt
```

---

## 31.7 Writing Practice and Student Learning

Writing Practice should integrate with the existing learning architecture.

Conceptually:

```text
Student
   ↓
Writing Practice
   ↓
writing_attempts
   ↓
writing_evaluations
   ↓
Feedback / Score
   ↓
learning_activities
   ↓
Student Progress
```

Writing activity records may contribute to:

```text
Student Progress

Learning History

Topic Practice

Subject Progress

Recommendation System

Weak Area Detection

Revision Queue
```

Writing Practice must not unnecessarily create duplicate student-learning systems.

---

## 31.8 Writing History

The application should be capable of displaying a student's writing history.

Writing history may include:

```text
Date

Topic

Writing Type

Attempt Number

Word Count

Status

Score

Improvement Status
```

Example:

```text
Essay: My Best Friend
Attempt 1
Score: 62%

Essay: My Best Friend
Attempt 2
Score: 78%

Essay: My Best Friend
Attempt 3
Score: 88%
```

Historical attempts must remain available according to the platform's data-retention and privacy policies.

---

## 31.9 Self Review

Students may perform a self-review before or after submission.

The `self_review` field may store structured self-reflection data.

Possible self-review areas include:

```text
Did I answer the topic?

Did I follow the instructions?

Did I check grammar?

Did I check spelling?

Did I organize my writing?

Did I use appropriate vocabulary?

Did I meet the required word count?
```

Self-review is student-generated information and must remain separate from teacher, AI, or system evaluation.

---

## 31.10 Model Answers and Learning Guidance

Writing templates may contain:

```text
Model Answer

Important Points

Writing Instructions

Common Mistakes

Improvement Guidance
```

Where these elements are stored as part of the writing-template or related educational content architecture, they must be controlled according to the student's learning stage.

The model answer must not be automatically displayed before submission when doing so would undermine the intended writing practice.

The system should encourage students to produce their own writing before viewing reference material.

---

## 31.11 Writing Difficulty

Writing tasks may use:

```text
easy

medium

hard
```

Difficulty must remain data-driven rather than hard-coded by class.

Difficulty may later be used by:

```text
Practice Selection

Student Recommendations

Weak Area Detection

Adaptive Learning

AI Recommendations
```

---

## 31.12 Writing Language Support

The Writing Practice architecture must support multilingual educational content.

The `language` field may identify the primary language of the writing task.

The architecture should remain ready for:

```text
English

Urdu

Roman Urdu

Other supported languages
```

Language-specific evaluation rules may be introduced later without redesigning the writing database.

---

## 31.13 AI Writing Assistant Readiness

The database must remain ready for future AI-assisted writing evaluation.

Future AI capabilities may include:

```text
Grammar Error Detection

Spelling Detection

Vocabulary Suggestions

Sentence Improvement

Organization Feedback

Content Relevance

Rubric Evaluation

Writing Strengths

Writing Weaknesses

Improvement Suggestions
```

The AI Writing Assistant should function primarily as a learning assistant.

It should not simply replace the student's writing task by automatically producing the complete answer whenever the intended activity is student writing practice.

AI-generated evaluation must remain distinguishable from:

```text
Teacher Evaluation

System Evaluation
```

through `evaluator_type`.

---

## 31.14 Writing Progress

The platform should be capable of calculating student writing progress from historical attempts and evaluations.

Possible progress indicators include:

```text
Total Writings

Completed Writings

Average Score

Writing Streak

Average Word Count

Grammar Improvement

Vocabulary Improvement

Organization Improvement

Spelling Improvement

Content Improvement

Overall Improvement
```

These values should preferably be derived from historical writing attempts and evaluations rather than duplicated unnecessarily as permanent fields.

---

## 31.15 Writing Practice and Revision

Writing weaknesses may contribute to the existing revision architecture.

Conceptually:

```text
Writing Evaluation
       ↓
Weak Area
       ↓
Student Recommendation / Revision Queue
       ↓
Additional Writing Practice
       ↓
New Attempt
       ↓
Improvement Measurement
```

For example:

```text
Repeated Grammar Weakness
        ↓
Grammar Practice

Weak Vocabulary
        ↓
Vocabulary Practice

Poor Organization
        ↓
Structured Writing Practice
```

Writing Practice should therefore integrate with the existing personalization architecture without creating a separate revision system.

---

## 31.16 Writing Practice and Learning Activities

Writing Practice may be recorded through the existing `learning_activities` architecture.

Example:

```text
learning_activities

student_id
activity_type = Writing
resource_type = writing_attempt
resource_id = writing_attempts.id
started_at
completed_at
duration_seconds
metadata
```

The exact implementation may use the existing activity architecture rather than introducing a duplicate writing-activity history table.

---

## 31.17 Writing Data Integrity Rules

The Writing Practice system must enforce:

```text
A writing attempt must belong to a valid writing template.

A writing attempt must belong to a valid student.

Attempt numbers must remain logically ordered.

Previous attempts must never be overwritten.

Improved attempts must reference valid previous attempts.

Evaluations must belong to valid writing attempts.

Rubric items must belong to valid rubrics.

Writing templates must reference valid academic entities where applicable.

Model answers must not be exposed before the appropriate stage.

Student writing must be access-controlled.

Teacher evaluations must be access-controlled.

AI evaluations must remain distinguishable from teacher evaluations.
```

Foreign keys and application-level validation must work together to maintain integrity.

---

## 31.18 Writing Practice and Privacy

Student writing may contain personally identifiable or sensitive information.

Access must therefore be restricted according to the user's role and permissions.

Students should normally access their own writing attempts.

Teachers should only access writing belonging to students/classes they are authorized to evaluate.

Administrative access must follow the platform's authorization policies.

Writing content must not be exposed through unauthorized APIs, logs, debugging output, or public endpoints.

---

## 31.19 Writing Practice and Future Assignments

The Writing Practice architecture should remain reusable by the future Assignment system.

Conceptually:

```text
Writing Template
      ↓
Assignment
      ↓
Student Writing Attempt
      ↓
Writing Evaluation
```

The Assignment system should reuse writing attempts and evaluations where appropriate instead of creating a separate writing-submission architecture.

---

## 31.20 Writing Practice Core Principle

The Writing Practice system must separate:

```text
Writing Task

Student Attempt

Evaluation

Rubric

Feedback

Progress
```

The architecture must preserve historical attempts and support continuous improvement.

The core learning cycle is:

```text
Prompt
  ↓
Write
  ↓
Submit
  ↓
Review
  ↓
Improve
  ↓
Retry
  ↓
Measure Progress
```

Writing Practice is therefore a reusable learning system rather than a simple collection of model answers.

It must remain compatible with the existing:

```text
Question Bank

Universal Practice Engine

Learning Activities

Student Progress

Recommendations

Revision Queue

AI System

Teacher System

Assignment System
```

without unnecessarily duplicating existing educational architecture.

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

Interactive activities may be integrated with the Universal Practice Engine where they require question selection, answer evaluation, and student progress tracking.

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

Viva questions may reuse the universal Question Bank architecture.

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

A sandboxed execution environment must be used for code execution.

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

Media may be associated with Questions, Activities, Content, Lessons, and Practice Engine interactions.

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

Video questions may reuse the Universal Question Bank.

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

Audio resources may later support the Practice Engine through listening-based question types.

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

AI-generated questions must pass the normal review and approval process before becoming approved educational content.

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

This keeps AI analysis separate from the student's actual learning recommendation records.

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

Assignments may later use Question Bank questions and Universal Practice Engine components where appropriate.

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

Sensitive secrets must NOT be stored as ordinary settings.

Application secrets should use appropriate environment and secret-management mechanisms.

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

Actual large files should be stored in object storage rather than the MariaDB database.

MariaDB should store file metadata and the object-storage reference, while actual file content should remain in object storage.

Files may be referenced by:

* Questions
* Question options
* Question answers
* Content
* Activities
* Audio resources
* Video resources
* Student submissions

---

# 51. Core Relationships

The most important academic relationships are:

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

Learning Content

  ├── Questions
  ├── Practicals
  ├── Activities
  ├── Videos
  ├── Flashcards
  ├── Tests
  └── Practice
```

Universal Question architecture:

```text
Question

   │
   ├── Question Options
   │
   ├── Question Answers
   │
   ├── Media / Files
   │
   └── Tags
          │
          ↓
   Universal Practice Engine
          │
          ├── Nursery
          ├── Prep
          └── Class 1–12
```

Student learning:

```text
Student

   ↓

Learning Activity

   ├── Test
   ├── Practice
   ├── Revision
   ├── Flashcard
   └── Activity

   ↓

Learning Progress

   ↓

Mistake / Weak Topic

   ↓

Topic Mastery

   ↓

Revision Queue

   ↓

Recommendation
```

Practice learning should remain logically separate from formal examination results unless the product explicitly defines a practice activity as a formal test.

---

# 52. Important Database Rules

## Rule 1

Do not hard-code classes.

## Rule 2

Do not hard-code boards.

## Rule 3

Do not hard-code academic years.

## Rule 4

Do not assume every student uses the same question interaction.

## Rule 5

Do not create a separate question table for every question type.

## Rule 6

Do not expose correct answers before the appropriate evaluation stage.

## Rule 7

Do not treat AI-generated content as automatically approved content.

## Rule 8

Do not store large media files directly inside the database.

## Rule 9

Do not execute student code on the main application server.

## Rule 10

Do not rely on frontend authorization.

## Rule 11

Important historical educational data should not be casually deleted.

## Rule 12

Question duplication must be checked before approval.

## Rule 13

Student learning data must be access-controlled.

## Rule 14

Practice data must not unnecessarily pollute formal test result history.

## Rule 15

The Universal Practice Engine must remain extensible for future interaction types.

---

# 53. Indexing Strategy

Important foreign keys and frequently searched fields should be indexed.

Likely indexes include:

```text
users.email

students.user_id

questions.grade_id

questions.subject_id

questions.chapter_id

questions.topic_id

questions.question_type

questions.difficulty

question_options.question_id

question_answers.question_id

tests.grade_id

tests.subject_id

tests.chapter_id

tests.topic_id

test_attempts.student_id

student_mistakes.student_id

student_mistakes.topic_id

student_topic_mastery.student_id

student_topic_mastery.topic_id

revision_items.student_id

revision_items.topic_id

learning_activities.student_id
learning_activities.activity_type

notifications.user_id
```

Composite indexes will be added based on actual query patterns.

Indexes must be based on real application queries and should not be added blindly.

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

Reference data should preferably be archived or soft-deleted where historical relationships must remain valid.

---

# 55. Soft Deletion

Soft deletion may be used for:

* Content
* Questions
* Users
* Schools
* Tests
* Other entities where historical records are important

Example:

```text
deleted_at
```

Soft deletion should not be applied automatically to every table.

---

# 56. Data Integrity

The database must enforce:

* Unique constraints
* Foreign keys
* Required fields
* Valid status values
* Appropriate check constraints where supported
* Transaction boundaries

Business validation must also exist in the application layer.

Database constraints and application validation should complement each other.

---

# 57. Transactions

Transactions should be used for multi-step operations.

Examples:

* Test submission
* Subscription changes
* Content approval
* Question approval
* Student enrollment
* Other operations involving multiple related records

This prevents partially completed operations.

Practice answer submission should also use safe transactional behavior where multiple related records are updated together.

---

# 58. Security

Database security must include:

* Strong credentials
* Restricted access
* Encrypted connections where supported
* Least privilege
* Regular backups
* Monitoring
* Secret management

Database credentials must never be committed to Git.

Correct answers, answer keys, private student information, and administrative data must be protected from unauthorized access.

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

The conceptual database blueprint must not be interpreted as a requirement to immediately create every listed table.

Only tables required by the current development phase should be implemented.

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

## 63.1 Practice Engine Database Principle

The Practice Engine will initially reuse the existing Question Bank rather than creating a separate `practice_questions` table.

Practice sessions, question selection, answer evaluation, and progress tracking will be implemented as application-level learning behavior around the existing question architecture.

A separate persistent practice-session table may only be introduced later if long-term practice history, analytics, synchronization, or cross-device session recovery requires it.

The Practice Engine should therefore avoid unnecessary duplication of questions.

A single Question Bank question may be reused across:

```text
Formal Tests

Practice

Revision

Assignments

Interactive Activities

Other Learning Experiences
```

where appropriate.

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

Universal Practice Architecture

  ↓

AI Features

  ↓

Teacher Features

  ↓

Parent Features

  ↓

School / Multi-Tenant Platform

  ↓

Future Learning Technologies
```

Existing data must be protected during migrations.

New functionality should extend the architecture rather than unnecessarily replacing existing structures.

---

# 65. Database Status

**File:** `DATABASE.md`

**Phase:** B

**Module:** B8 — Database Architecture

**Version:** 1.1

**Status:** Master Database Blueprint — Updated for Universal Practice Architecture

This document defines the conceptual database architecture for the Aspirian Student Platform.

The architecture supports the complete academic range from **Nursery, Prep, and Class 1 through Class 12**.

The database is designed to support traditional questions, language exercises, matching, drag-and-drop, image-based questions, interactive activities, and future audio/listening practice without requiring a separate database table for every question type.

The architecture also separates the Question Bank from the learning experiences that consume questions.

The Universal Practice Engine is designed as a reusable learning layer around the Question Bank rather than as a duplicate question repository.

Exact SQL migrations and implementation details will be created progressively during development.

---

# Final Database Principle

> **The database should model the educational system, not the current feature list.**

The Aspirian Practice Engine must be capable of serving every learner level from **Nursery and Prep through Class 12**.

The system must not assume that every learner answers questions in the same way.

Young learners may require pictures, alphabet recognition, Haroof-e-Tahajji, matching, drag-and-drop, and simple interactive activities, while older students may require MCQs, short answers, long answers, translation, problem solving, and subject-specific questions.

Therefore, the database must provide a universal and extensible question architecture while keeping question content, answer evaluation, media, and student progress logically separated.

Aspirian's database must support the student's complete learning journey from **Nursery and Prep through Class 12**, while remaining flexible enough for future boards, schools, AI systems, teachers, parents, mobile applications, interactive learning, audio-based learning, and new educational technologies.

The database must evolve progressively without unnecessary duplication and without forcing every future feature into the initial MVP schema.
