# Aspirian Student Platform — Project Specification

**Document Status:** Master Specification
**Project:** Aspirian Student Platform
**Primary Application:** `app.aspirian.pk`
**Existing Website:** `aspirian.pk`
**Backend API:** `api.aspirian.pk`
**Target Academic Range:** Nursery, Prep, Class 1–12
**Initial Board Focus:** Punjab Board
**Document Version:** 1.1

---

# 1. Purpose

This document defines the functional scope, product requirements, learning architecture, and long-term product direction of the Aspirian Student Platform.

It provides the functional foundation for:

* Architecture
* Database design
* Backend development
* API development
* Frontend development
* Question Bank
* Practice Engine
* Test Engine
* Learning Analytics
* AI integration
* Personalized learning
* Teacher features
* Parent features
* School features
* Future mobile applications

This document should be updated and versioned whenever a major product decision changes the approved product direction.

---

# 2. Product Vision

Aspirian Student Platform is intended to become a complete digital learning platform serving students from:

* Nursery
* Prep
* Class 1
* Class 2
* Class 3
* Class 4
* Class 5
* Class 6
* Class 7
* Class 8
* Class 9
* Class 10
* Class 11
* Class 12

The platform should support the complete learning journey:

```text
Discover
   ↓
Select Academic Structure
   ↓
Study
   ↓
Practice
   ↓
Test
   ↓
Evaluate
   ↓
Identify Mistakes
   ↓
Revise
   ↓
Track Progress
   ↓
Improve
```

The system should progressively introduce personalization, AI, teacher tools, parent tools, school functionality, media, practical learning, coding, and other advanced capabilities.

---

# 3. Product Scope

The platform will consist of interconnected but independently maintainable educational domains.

```text
Aspirian Student Platform
│
├── Authentication
├── Student Profile
├── Dashboard
├── Study Center
├── Knowledge Bank
├── Question Bank
├── Universal Practice Engine
├── Test Engine
├── Results
├── Mistakes
├── Learning Analytics
├── Personalized Revision
├── Learning Progress
├── AI Tutor
├── AI Content Studio
├── Language Lab
├── Practical & Activity Engine
├── Coding Lab
├── Virtual Lab
├── Media Network
├── Teacher Platform
├── Parent Platform
├── School Platform
├── Notifications
├── Gamification
├── Subscriptions
└── Administration
```

Not all modules will be implemented simultaneously.

Long-term product scope must not force unnecessary complexity into the current development phase.

---

# 4. Product Architecture Principle

Aspirian should follow this principle:

> **Design the foundation for the complete platform, but implement only what the current development phase requires.**

Long-term requirements should influence architecture and data relationships.

However:

* Future modules should not automatically receive database tables.
* Future services should not automatically become separate applications.
* Future AI features should not automatically become production dependencies.
* Future mobile features should not duplicate backend business logic.
* Features should be implemented progressively according to the approved roadmap.

---

# 5. User Roles

The platform should support role-based access.

## 5.1 Student

Students can:

* Create an account
* Complete onboarding
* Select academic level
* Select class
* Select board
* Select subjects
* Study educational content
* Practice questions
* Take formal tests
* View results
* Review mistakes
* Use revision
* Track progress
* Use AI Tutor
* Use language tools
* Practice coding
* Complete activities
* Use practical learning
* View learning analytics
* Access supported media
* Earn achievements where gamification is enabled

---

## 5.2 Teacher

Teachers may:

* Manage assigned classes
* View assigned students
* Create tests
* Create assignments
* Use the Question Bank
* Build examination papers
* Review student performance
* Monitor class analytics
* Review AI-generated content
* Use teacher AI tools
* Assign practice activities
* Review student learning progress

---

## 5.3 Parent

Parents may:

* View linked students
* View student progress
* View performance
* View learning activity
* View reports
* Receive important notifications
* Monitor revision progress

Parents must only access information for students they are authorized to view.

---

## 5.4 School Administrator

School administrators may:

* Manage school information
* Manage teachers
* Manage students
* Manage classes
* Manage institutional settings
* View school analytics
* Generate reports
* Manage school-level learning activities

School access must respect tenant and authorization boundaries.

---

## 5.5 Content Editor

Content editors may:

* Create educational content
* Edit educational content
* Organize content
* Add metadata
* Submit content for review
* Maintain educational resources

---

## 5.6 Reviewer

Reviewers may:

* Review questions
* Review educational content
* Review AI-generated material
* Approve content
* Reject content
* Request corrections
* Validate educational quality

---

## 5.7 Platform Administrator

Platform administrators may:

* Manage users
* Manage roles
* Manage permissions
* Manage academic structure
* Manage content
* Manage Question Bank
* Manage AI systems
* Manage subscriptions
* Manage settings
* View audit logs
* Manage platform security

---

# 6. Academic Structure

The academic structure must be dynamic and database-driven.

The platform must not hard-code classes such as Class 9, Class 10, Class 11, or Class 12.

The structure should follow:

```text
Education System
      ↓
Board
      ↓
Academic Session
      ↓
Grade / Class
      ↓
Subject
      ↓
Book / Course
      ↓
Chapter
      ↓
Topic
      ↓
Learning Content
```

Supported academic range:

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

The architecture must also support:

* Multiple boards
* Multiple academic sessions
* Multiple syllabus versions
* Different books
* Different curricula
* Future education systems

---

# 7. Student Onboarding

A new student should complete an onboarding flow.

```text
Create Account
      ↓
Select Academic Level
      ↓
Select Class
      ↓
Select Board
      ↓
Select Subjects
      ↓
Learning Preferences
      ↓
Student Dashboard
```

The student should be able to update academic information when required.

Academic changes should not casually destroy historical learning records.

---

# 8. Student Dashboard

The dashboard is the primary student workspace.

It may provide:

* Continue Learning
* Recommended Learning
* Today's Tasks
* Practice
* Personalized Revision
* Mistakes
* Upcoming Tests
* Recent Results
* Weak Topics
* Strong Topics
* Study Progress
* AI Tutor
* Vocabulary
* Media Content
* Achievements

The dashboard should become increasingly personalized as learning data becomes available.

Current implemented learning intelligence includes:

* Test performance
* Recent results
* Weak topic detection
* Revision queue

Future intelligence may include:

* Topic mastery
* Recommendations
* Study planning
* Performance trends
* Personalized practice

---

# 9. Study Center

The Study Center provides structured educational learning material.

Students should be able to browse by:

* Class
* Subject
* Chapter
* Topic

A topic may contain:

* Notes
* Explanations
* Definitions
* Examples
* Important points
* Questions
* Practice
* Videos
* Flashcards
* Activities
* Practicals
* Tests
* Vocabulary

The same educational topic should be reusable across multiple learning experiences.

---

# 10. Knowledge Bank

The Knowledge Bank is the structured educational foundation of the platform.

Knowledge items should be associated with appropriate:

* Education system
* Board
* Academic session
* Class
* Subject
* Book
* Chapter
* Topic
* Source
* Version
* Review status

Knowledge items may include:

* Concepts
* Definitions
* Explanations
* Examples
* Facts
* Formulas
* Procedures
* Learning notes
* Important points

The Knowledge Bank should become the trusted source for approved Aspirian educational information.

---

# 11. Question Bank

The Question Bank is a central reusable repository of educational questions.

A single question may be reused in:

* Practice
* Formal Tests
* Revision
* Assignments
* Teacher papers
* Interactive activities
* Other learning experiences

The Question Bank should not be duplicated for every learning mode.

---

# 12. Universal Question Architecture

Aspirian must support different learner interaction requirements without creating a separate question table for every question type.

The conceptual architecture is:

```text
Question
   │
   ├── Question Options
   ├── Question Answers
   ├── Media / Files
   └── Tags
          │
          ↓
Universal Practice Engine
          │
          ├── Nursery
          ├── Prep
          └── Class 1–12
```

The question entity should be extensible.

Question behavior should be determined by:

* Question type
* Options
* Answer configuration
* Media
* Evaluation rules
* Educational metadata

---

# 13. Universal Practice Question Types

The Practice Engine should be designed to support the following question types.

## 13.1 Traditional Questions

* MCQ
* Short Answer
* Long Answer
* Fill in the Blank
* True / False
* Yes / No
* Multiple Select
* Correct Word
* Spelling

---

## 13.2 Matching Questions

* Matching
* Drag and Drop Matching
* Alphabet Matching
* Haroof-e-Tahajji Matching
* Word Matching
* Picture-to-Word Matching
* Word-to-Picture Matching

---

## 13.3 Language Questions

* English → Urdu
* Urdu → English
* Translation
* Word Meaning
* Sentence Formation
* Grammar-based questions
* Vocabulary-based questions

---

## 13.4 Early Years Questions

For Nursery and Prep, the system should support age-appropriate interactions such as:

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
* Simple Drag and Drop

The Practice Engine should therefore not be designed only around older-student MCQs.

---

## 13.5 Image-Based Questions

Possible types include:

* Image Identification
* Image Selection
* Image-Based MCQ
* Picture-to-Word
* Word-to-Picture
* Picture Matching
* Image-Based Matching

---

## 13.6 Interactive Questions

Possible interactions include:

* Drag and Drop
* Matching
* Ordering / Arrange
* Multiple Selection
* Interactive Choice

---

## 13.7 Audio / Listening Questions

The architecture should remain future-ready for:

* Listen and Select
* Listen and Match
* Listening Comprehension
* Audio-to-Word
* Audio-to-Picture

Audio functionality may be introduced later without redesigning the core question architecture.

---

# 14. Practice Engine

The Universal Practice Engine is a dedicated learning experience built around the Question Bank.

It is conceptually separate from the formal examination result system.

```text
Question Bank
      ↓
Practice Selection
      ↓
Practice Session
      ↓
Question
      ↓
Student Answer
      ↓
Evaluation
      ↓
Immediate Feedback
      ↓
Progress
      ↓
Learning Data
```

Practice may support:

* Question-by-question learning
* Instant answer checking
* Correct / incorrect feedback
* Explanations
* Progress indicators
* Topic-wise practice
* Difficulty-based practice
* Question-type-specific interactions
* Practice completion tracking
* Weak-topic practice
* Revision-linked practice

---

# 15. Practice Engine — Academic Range

The same Practice Engine must serve:

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

Different classes may use different question interactions.

For example:

```text
Nursery / Prep
    ↓
Pictures
Alphabet
Haroof-e-Tahajji
Matching
Drag & Drop
Simple Choices

Older Classes
    ↓
MCQs
Short Questions
Long Questions
Numericals
Translation
Problem Solving
Subject-specific Questions
```

The platform must therefore select appropriate interactions according to the question and learner context rather than hard-coding one practice interface for every class.

---

# 16. Practice Data Principle

The Practice Engine should initially reuse the existing Question Bank.

A separate `practice_questions` table is not required simply because practice exists.

Practice sessions, selection, answer evaluation, and progress may initially be implemented as application-level learning behavior around the existing question architecture.

A dedicated persistent practice-session table may be introduced later only if requirements such as:

* Long-term practice history
* Advanced analytics
* Cross-device recovery
* Session synchronization
* Detailed practice reporting

justify it.

Practice data must not unnecessarily pollute formal test result history.

---

# 17. Practice and Formal Tests Separation

Formal tests and practice are related but different learning experiences.

```text
Question Bank
     │
     ├───────────────┐
     ↓               ↓
Practice          Formal Test
     ↓               ↓
Practice Data     Test Attempt
     ↓               ↓
Learning Data     Test Result
```

Practice should generally provide:

* Immediate feedback
* Learning-oriented interaction
* Flexible question selection
* Repeated attempts
* Explanations
* Topic practice

Formal tests should provide:

* Controlled attempt
* Timing
* Submission
* Scoring
* Result storage
* Formal result history

Practice results should not automatically appear as formal examination results.

---

# 18. Question Lifecycle

Questions should follow a controlled lifecycle.

```text
Draft
   ↓
Generated / Imported
   ↓
Duplicate Detection
   ↓
Quality Check
   ↓
Review
   ↓
Approved
   ↓
Published
   ↓
Archived
```

A question should not become trusted educational content without passing the appropriate workflow.

---

# 19. Duplicate Detection

Question duplication should be checked at multiple levels.

## Level 1 — Exact Match

Detect identical question text.

## Level 2 — Normalized Match

Normalize differences such as:

* Capitalization
* Extra spaces
* Basic punctuation

## Level 3 — Similarity

Detect highly similar wording.

## Level 4 — Semantic Similarity

Detect questions that substantially test the same concept using different wording.

Legitimate variations should remain possible when they test different learning outcomes.

---

# 20. Test Engine

The Test Engine handles formal assessments.

Students may take:

* Topic Tests
* Chapter Tests
* Subject Tests
* Practice Tests
* Mock Exams
* Board-style Tests
* Timed Tests
* Teacher Tests
* AI-assisted Tests

Test configuration may include:

* Question count
* Marks
* Duration
* Difficulty
* Chapters
* Topics
* Question types

---

# 21. Formal Test Lifecycle

The formal test flow should be:

```text
Test Definition
      ↓
Question Selection
      ↓
Student Starts Test
      ↓
Test Attempt
      ↓
Answer Submission
      ↓
Timer / Expiry
      ↓
Final Submission
      ↓
Score Calculation
      ↓
Result Storage
      ↓
Result Display
      ↓
Learning Analysis
```

The current platform implementation has established the foundation for:

* Test model
* Question selection
* Test start
* Answer submission
* Timer
* Auto-submit
* Manual submission
* Score calculation
* Result storage
* Result display
* Result history

---

# 22. Test Attempt

A formal test attempt should track information such as:

* Test
* Student
* Start time
* Expiry time
* Submission time
* Status
* Answers
* Marks
* Result relationship

Possible attempt statuses include:

```text
In Progress
Submitted
Expired
```

The system must prevent unauthorized users from accessing another student's attempt.

---

# 23. Test Results

After completion, students should be able to see:

* Total marks
* Obtained marks
* Percentage
* Correct answers
* Wrong answers
* Unanswered questions
* Test status
* Test information

Future result analysis may include:

* Time used
* Topic performance
* Weak areas
* Strong areas
* Recommended revision

Results should contribute to the student's learning profile where appropriate.

---

# 24. Result History

Students should be able to review previous formal test results.

Result history should support:

* Search
* Status filtering
* Pagination
* Result details
* Recent performance review

Formal test results should remain separate from ordinary practice interactions.

---

# 25. Mistakes Notebook

Incorrect answers should be recorded when appropriate.

A mistake record may contain:

* Question
* Student answer
* Correct answer
* Topic
* Explanation
* Date
* Number of previous mistakes
* Revision status

Students should be able to review mistakes independently.

Correct answers must not be exposed before the appropriate evaluation stage.

---

# 26. Personalized Revision Queue

The Revision Queue should prioritize learning areas based on available learning data.

Potential factors include:

* Incorrect answers
* Weak topics
* Previous mistakes
* Time since revision
* Topic importance
* Upcoming examination
* Student performance

Example:

```text
Repeated Mistakes
       ↓
Weak Concepts
       ↓
High Revision Priority
       ↓
Practice
       ↓
Improvement
```

The current Revision Queue is built from detected weak topics and assigns:

* Queue position
* Priority
* Performance
* Recommendation

---

# 27. Weak Topic Detection

The platform should identify topics where a student demonstrates weak performance.

Potential signals include:

* Wrong answers
* Unanswered questions
* Repeated mistakes
* Low accuracy
* Low topic performance

Weak-topic detection should remain reusable by:

* Dashboard
* Revision Queue
* Practice
* Recommendations
* Learning Analytics

---

# 28. Personalized Learning Engine

The Personalized Learning Engine should gradually create a student learning profile.

Potential signals include:

* Test results
* Question attempts
* Practice activity
* Revision activity
* Time spent
* Topic mastery
* Mistake frequency
* Practice frequency
* Learning activity

The system may recommend:

* Topics
* Questions
* Practice sessions
* Tests
* Revision
* Learning content
* Videos
* Flashcards

Personalization should improve progressively as reliable learning data becomes available.

---

# 29. Learning Activities

Learning activities provide a general event layer for student learning.

Possible activity types include:

* Reading
* Video
* Test
* Practice
* Revision
* Flashcard
* Activity
* Coding

Practice-related events may include:

* Practice Session Started
* Question Attempted
* Question Answered
* Question Skipped
* Question Checked
* Correct Answer
* Incorrect Answer
* Practice Session Completed
* Topic Practiced

These events are learning data and should not automatically become formal examination results.

---

# 30. AI Tutor

The AI Tutor should support educational conversations.

It may:

* Explain concepts
* Simplify difficult topics
* Provide examples
* Give hints
* Ask practice questions
* Explain mistakes
* Recommend revision
* Guide problem solving

For approved Aspirian educational material, the AI Tutor should prioritize trusted Knowledge Bank content.

---

# 31. AI Knowledge Retrieval

The AI Tutor should eventually use retrieval-based architecture.

```text
Student Question
      ↓
Intent Detection
      ↓
Knowledge Retrieval
      ↓
Relevant Approved Content
      ↓
Context Construction
      ↓
AI Generation
      ↓
Educational Response
```

The retrieval system should be capable of evolving from database search toward semantic or vector search when justified.

---

# 32. AI Question Generator

The platform may generate questions from approved educational sources.

Inputs may include:

* Class
* Subject
* Chapter
* Topic
* Question type
* Difficulty
* Number of questions

Generated questions must pass:

```text
Generation
    ↓
Validation
    ↓
Duplicate Detection
    ↓
Quality Evaluation
    ↓
Human Review
    ↓
Approval
```

AI-generated questions must not automatically become trusted questions.

---

# 33. AI Content Studio

The AI Content Studio may process approved educational sources.

Potential inputs:

* PDF
* Documents
* Chapters
* Structured educational content

Potential outputs:

* MCQs
* Short Questions
* Long Questions
* Definitions
* Important points
* Flashcards
* Revision notes
* Activities
* Formula sheets

Generated content must retain source traceability and appropriate review status.

---

# 34. Teacher Paper Builder

Teachers should eventually be able to define:

* Class
* Subject
* Board
* Chapters
* Topics
* Marks
* Duration
* Question types
* Difficulty

The system may generate a paper from approved questions.

Workflow:

```text
Configure Paper
      ↓
Generate
      ↓
Review
      ↓
Edit
      ↓
Approve
      ↓
Export
```

Future export formats may include:

* PDF
* DOCX

---

# 35. Formula Sheet Builder

The platform may create formula sheets from approved content.

Each formula may contain:

* Formula
* Variables
* Units
* Explanation
* Example
* Related topic

---

# 36. Language Lab

The Language Lab should support vocabulary, grammar, writing, and translation.

## Vocabulary

* English meaning
* Urdu meaning
* Roman Urdu
* Synonyms
* Antonyms
* Examples
* Pronunciation

## Grammar

* Grammar correction
* Spelling
* Punctuation
* Tenses
* Articles
* Prepositions
* Sentence structure

## Writing

* Essays
* Letters
* Applications
* Stories
* Dialogues
* Paragraphs
* Comprehension
* Summaries
* Precis
* Translation
* Reports
* Notices
* Messages
* Speeches
* Articles

---

# 37. Practical & Activity Engine

The platform should support interactive educational activities.

## Computer

* Number systems
* Python
* Algorithms
* Programming exercises

## Physics

* Experiments
* Numericals
* Simulations
* Viva

## Chemistry

* Reactions
* Experiments
* Practical questions
* Viva

## Biology

* Diagrams
* Labelling
* Observation
* Practical questions

## Mathematics

* Problem solving
* Numerical activities
* Concept challenges

Interactive activities may integrate with the Universal Practice Engine when they require question selection, evaluation, or progress tracking.

---

# 38. Coding Lab

The initial programming language is:

**Python**

Potential features:

* Browser code editor
* Code execution
* Output
* Test cases
* Error detection
* AI hints
* Coding challenges
* Guided problem solving

Student code must never execute directly on the main application server.

Execution must eventually use an isolated sandbox with restrictions on:

* Network
* File system
* CPU
* Memory
* Execution time
* Process privileges

---

# 39. Virtual Lab

Future virtual laboratories may provide simulations for:

* Physics
* Chemistry
* Biology
* Computer Science

Virtual laboratory modules should be independently extensible.

---

# 40. Smart Video Quiz

Educational videos may contain interactive quiz markers.

```text
Video
  ↓
Quiz Marker
  ↓
Question
  ↓
Answer
  ↓
Feedback
  ↓
Continue
```

Student responses may contribute to learning analytics.

---

# 41. Audio-to-Notes

The platform may process educational audio.

Potential outputs:

* Transcript
* Structured notes
* Key concepts
* Summary
* Questions
* Flashcards

Processing may occur asynchronously.

---

# 42. Video-to-Flashcards

Educational videos may be processed to identify:

* Key concepts
* Definitions
* Important facts
* Questions

These may be converted into flashcards.

---

# 43. AI Exam Voice Summary

Students may eventually request spoken revision summaries.

```text
Topic
  ↓
Approved Content
  ↓
AI Summary
  ↓
Voice Generation
  ↓
Audio Revision
```

---

# 44. AI Score Forecaster

The platform may estimate future performance using historical learning data.

It may:

* Analyze previous results
* Consider recent performance
* Identify weak areas
* Produce a performance range
* Explain improvement opportunities

Forecasts must never be presented as guaranteed examination results.

---

# 45. AI Study Planner

The planner may consider:

* Class
* Subjects
* Exam date
* Available study time
* Weak areas
* Revision requirements
* Current performance

Study plans may be dynamically adjusted according to new learning data.

---

# 46. AI Viva

The AI Viva module may:

* Ask questions
* Accept text answers
* Accept voice answers
* Evaluate conceptual understanding
* Identify missing concepts
* Recommend revision

---

# 47. AI Vision / OCR

The platform may process:

* Textbook pages
* Printed questions
* Handwritten questions
* Educational diagrams

Potential workflow:

```text
Image
  ↓
OCR / Vision
  ↓
Question / Content Detection
  ↓
Knowledge Retrieval
  ↓
Learning Assistance
```

---

# 48. Handwritten Answer Assistance

Students may eventually upload handwritten answers.

Potential processing may include:

* OCR
* Content extraction
* Concept coverage
* Missing points
* General feedback
* Grammar feedback

This feature must be positioned as learning assistance rather than guaranteed official examination marking.

---

# 49. Media Network

The platform may integrate:

* Educational videos
* YouTube
* YouTube Live
* Internet Radio
* Podcasts
* Audio learning
* Live classes

The initial live-streaming strategy should use YouTube rather than building a complete independent streaming platform.

---

# 50. Internet Radio

The Internet Radio may provide:

* Educational programs
* Teacher discussions
* Student programs
* Interviews
* Exam preparation
* Educational news
* Motivation
* Learning tips

The radio experience should form part of the wider Aspirian Media Network.

---

# 51. Virtual Study Rooms

Future functionality may include:

* Study rooms
* Shared timers
* Group quizzes
* Collaborative learning
* Study goals
* AI assistance

Community functionality must include moderation and safety controls.

---

# 52. Gamification

Potential features include:

* Points
* Badges
* Levels
* Streaks
* Achievements
* Daily challenges
* Subject mastery

Gamification should encourage learning without promoting unhealthy competition.

---

# 53. Smart Search

Search should eventually cover:

* Knowledge
* Notes
* Questions
* Topics
* Tests
* Practicals
* Videos
* Vocabulary
* Flashcards
* Learning resources

Future search may support:

* Semantic search
* AI-assisted discovery
* Typo tolerance
* Advanced filtering
* Knowledge retrieval

---

# 54. Notifications

Notifications may include:

* Revision reminders
* Test results
* Assignments
* Learning recommendations
* Live classes
* New educational content
* Important announcements

Notifications should remain useful and non-intrusive.

---

# 55. Teacher System

Teacher functionality will eventually include:

* Teacher Dashboard
* Classes
* Students
* Question Bank
* Paper Builder
* Test Builder
* Assignments
* Homework
* Practice Assignment
* Analytics
* Reports
* AI Teacher Assistant

Teacher permissions must be limited to authorized classes, students, and resources.

---

# 56. Parent System

Parent functionality will eventually include:

* Linked students
* Progress
* Test results
* Learning activity
* Weak subjects
* Revision progress
* Reports

Parent access must always be authorized against the student's relationship.

---

# 57. School System

The architecture should support multi-school deployment.

Potential features:

* Schools
* School administrators
* Teachers
* Students
* Classes
* Subjects
* Tests
* Assignments
* Practice
* Reports
* Analytics
* Institutional subscriptions

Tenant boundaries must be enforced server-side.

---

# 58. Career Integration

The public Aspirian.pk Job & Career Hub may provide:

* Job information
* Career guidance
* Career resources
* Public career content

The Student Platform may eventually connect learning information with:

* Career exploration
* Skills
* Career roadmaps
* University guidance
* Skill recommendations

---

# 59. Free Tools Integration

Free educational tools will remain an important part of Aspirian.pk.

Potential integrations include:

* GPA Calculator
* Age Calculator
* Percentage Calculator
* Unit Converters
* Educational Calculators

Public versions may remain available through Aspirian.pk.

---

# 60. Mobile Application

The platform should expose stable APIs so future mobile applications can consume the same backend services.

Potential mobile features:

* Dashboard
* Study Center
* Practice
* Tests
* AI Tutor
* Revision
* Notifications
* Vocabulary
* Progress
* Media

Mobile applications should not duplicate core educational business logic.

---

# 61. Authentication

Authentication should support:

* Registration
* Login
* Logout
* Password reset
* Email verification
* Session management

Future authentication methods may include:

* Google
* Apple
* Phone verification

These should be introduced only when required.

---

# 62. Authorization

Every protected resource must be checked against user permissions.

Example:

```text
User
 ↓
Role
 ↓
Permission
 ↓
Resource Access
```

Frontend restrictions alone are not sufficient.

Server-side authorization is mandatory.

---

# 63. Student Privacy

Student data must be treated as private educational data.

The platform should implement:

* Access controls
* Secure storage
* Minimal data collection
* Audit logging
* Secure APIs
* Appropriate retention policies

Additional care is required when the platform serves younger students.

---

# 64. Content Safety

AI-generated and user-generated educational content should pass appropriate safety and quality controls.

Moderation mechanisms should eventually cover:

* Student-generated content
* Community features
* AI outputs
* Uploaded material

---

# 65. Monetization

The learning engine should remain independent from monetization logic.

Potential models include:

* Free
* Premium
* Teacher subscription
* School subscription
* Partnerships
* Advertising where appropriate

Premium access should eventually use a subscription and entitlement system.

---

# 66. Analytics

Analytics may include:

## Student

* Learning activity
* Practice performance
* Test performance
* Topic mastery
* Mistakes
* Revision
* Progress

## Teacher

* Class performance
* Student performance
* Assignment completion
* Practice performance

## Platform

* User growth
* Content usage
* Question usage
* Practice usage
* Test usage
* AI usage
* Feature usage

Analytics must respect privacy and authorization.

---

# 67. Audit System

Important actions should be recorded.

Examples:

* Login
* Role changes
* Content approval
* Question approval
* Question editing
* Test creation
* Administrative changes
* Subscription changes

Audit records must be protected against unauthorized modification.

---

# 68. Backup & Recovery

The platform must eventually maintain backups for:

* Database
* Educational content
* Configuration
* Important files
* AI-related metadata

Recovery procedures should be documented and tested.

---

# 69. API Requirements

The backend API should provide controlled access to:

* Authentication
* Users
* Students
* Academic structure
* Content
* Knowledge
* Questions
* Practice
* Tests
* Results
* Revision
* Analytics
* AI services
* Media
* Notifications

API contracts will be documented separately in `API.md`.

---

# 70. External Integrations

Potential integrations include:

* YouTube
* YouTube Live
* Email services
* AI providers
* Speech services
* Storage providers
* Payment gateways
* Analytics services

External dependencies should be isolated behind service interfaces where practical.

---

# 71. Non-Functional Requirements

The platform should prioritize:

## Performance

* Fast page loads
* Responsive interactions
* Efficient database queries
* Efficient APIs

## Scalability

The system should grow without requiring major architectural rewrites.

## Security

Authentication, authorization, API protection, and data security must be considered throughout development.

## Reliability

The system should provide graceful failure and recovery.

## Maintainability

Code should remain modular, documented, and testable.

## Accessibility

Interfaces should support students with different accessibility needs.

## Mobile-first Design

The student experience should work well on mobile devices.

---

# 72. MVP Strategy

The entire long-term vision will not be implemented at once.

The first useful learning loop should remain:

```text
Student
   ↓
Login
   ↓
Select Class / Subject
   ↓
Study Content
   ↓
Practice Questions
   ↓
Take Test
   ↓
View Result
   ↓
See Mistakes
   ↓
Revise
```

The MVP should focus on creating a reliable learning loop before introducing advanced AI and large-scale platform features.

---

# 73. Current Development Progress

The current development roadmap has already established the foundation for:

```text
T032  Test Model
T033  Test Question Selection
T034  Test Start
T035  Answer Submission
T036  Test Timer / Auto-submit
T037  Test Submission
T038  Score Calculation
T039  Result Storage
T040  Result Display
T041  Result History
T042  Progress Tracking
T043  Weak Topic Detection
T044  Revision Queue
```

The next major learning-engine feature is:

```text
T045  Practice Questions
```

T045 should build upon the existing Question Bank rather than creating an unnecessary parallel question architecture.

---

# 74. Current Practice Development Direction

T045 should establish the first practical version of the Universal Practice Engine.

Initial implementation should focus on:

* Practice mode
* Question selection
* Answer checking
* Immediate feedback
* Progress tracking
* Topic-aware practice
* Reusable Question Bank integration

The implementation should remain extensible for future question types.

The first implementation does not need to activate every future question type immediately.

---

# 75. Practice Engine Evolution

The Practice Engine should evolve progressively.

```text
Phase 1
Basic Practice
    ↓
Question Selection
    ↓
Answer Checking
    ↓
Progress

Phase 2
Topic / Difficulty Practice
    ↓
Weak Topic Practice
    ↓
Revision Integration

Phase 3
Advanced Question Types
    ↓
Matching
    ↓
Drag & Drop
    ↓
Images
    ↓
Language
    ↓
Interactive Learning

Phase 4
Audio / Listening
    ↓
Voice
    ↓
Advanced Media

Phase 5
AI-Powered Personalized Practice
```

The architecture should allow this evolution without replacing the core Question Bank.

---

# 76. Development Rule

A feature may appear in this long-term specification without being part of the current development phase.

This is intentional.

The specification defines the product direction.

The roadmap defines implementation priority.

Architecture defines technical boundaries.

Database design defines persistent data requirements.

These documents should remain aligned but should not be treated as identical documents.

---

# 77. Definition of Done

A module should not be considered complete merely because its UI exists.

A feature is considered complete when the applicable areas have been addressed:

* Database structure
* Backend logic
* API
* Frontend
* Validation
* Authorization
* Error handling
* Testing
* Documentation
* Logging
* Security considerations

Not every future feature requires all layers immediately, but production-ready modules must satisfy the relevant requirements.

---

# 78. Development Workflow

The preferred development lifecycle is:

```text
Requirement
    ↓
Specification
    ↓
Architecture
    ↓
Database
    ↓
API
    ↓
Implementation
    ↓
Testing
    ↓
Browser Verification
    ↓
Review
    ↓
Documentation
    ↓
Deployment
```

Development should avoid implementing features based only on assumptions.

---

# 79. Quality Principles

The platform should follow these development principles:

1. Do not hard-code academic classes.
2. Do not hard-code boards.
3. Do not hard-code academic sessions.
4. Do not create separate question tables for every question type.
5. Do not duplicate Question Bank data unnecessarily.
6. Do not expose correct answers before evaluation.
7. Do not allow AI-generated content to bypass review.
8. Do not execute untrusted code on the main application server.
9. Do not rely only on frontend authorization.
10. Do not unnecessarily pollute formal result history with practice data.
11. Do not introduce future infrastructure without a current requirement.
12. Do not casually delete historical educational data.
13. Validate and test important business logic.
14. Keep the architecture extensible.
15. Prefer simple implementations when they satisfy current requirements.

---

# 80. Product Evolution

The platform should evolve through controlled stages.

```text
Foundation
    ↓
Core Student Learning
    ↓
Universal Practice
    ↓
Assessment Intelligence
    ↓
Personalization
    ↓
AI Learning
    ↓
Teacher Platform
    ↓
Parent Platform
    ↓
School Platform
    ↓
Mobile Applications
    ↓
Large Educational Ecosystem
```

Each stage should build upon stable foundations rather than repeatedly replacing previous architecture.

---

# 81. Future Technology Readiness

The platform should remain ready for:

* Semantic search
* Vector search
* AI agents
* Voice interaction
* OCR
* Computer vision
* Advanced recommendation systems
* Audio learning
* Interactive media
* Mobile applications
* School integrations
* Multi-tenant infrastructure
* New educational technologies

Future readiness should not justify unnecessary implementation before the relevant requirement exists.

---

# 82. Product Success Criteria

The platform will ultimately be successful if it can:

1. Help students learn effectively.
2. Support students from Nursery through Class 12.
3. Provide meaningful practice.
4. Support multiple question interaction types.
5. Improve examination preparation.
6. Identify learning weaknesses.
7. Personalize revision.
8. Provide reliable educational AI assistance.
9. Support teachers.
10. Support parents.
11. Support schools.
12. Scale into a sustainable educational ecosystem.

---

# 83. Specification Status

**File:** `PROJECT_SPEC.md`
**Phase:** A
**Module:** A3 — Product Requirements
**Version:** 1.1
**Status:** Master Product Specification
**Scope:** Nursery, Prep, Class 1–12
**Initial Board:** Punjab Board
**Primary Platform:** `app.aspirian.pk`
**Current Development Focus:** T045 — Universal Practice Engine Foundation

This specification is the functional foundation for the Aspirian Student Platform.

Future changes should be documented and versioned rather than silently changing established requirements.

---

# 84. Final Product Principle

> **Build the first version simply, but make the foundation capable of supporting the complete learning journey.**

Aspirian should begin as a manageable student learning platform while maintaining a strong foundation for:

```text
Nursery
   ↓
Prep
   ↓
Class 1–12
   ↓
Practice
   ↓
Tests
   ↓
Revision
   ↓
Personalized Learning
   ↓
AI
   ↓
Teachers
   ↓
Parents
   ↓
Schools
   ↓
Complete Educational Ecosystem
```

The platform should model the educational journey rather than merely the current feature list.
