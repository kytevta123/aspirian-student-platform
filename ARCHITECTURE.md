# Aspirian Student Platform — Technical Architecture

**Document Version:** 1.1

**Status:** Master Architecture Blueprint — Updated for Universal Practice Architecture

**Project:** Aspirian Student Platform

**Primary Application:** `app.aspirian.pk`

**Backend API:** `api.aspirian.pk`

**Existing Website:** `aspirian.pk`

---

# 1. Architecture Vision

Aspirian Student Platform will be built as a **standalone, modular, API-driven educational application**.

The architecture must support the complete long-term vision:

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
* Multiple boards
* Multiple academic sessions
* Large educational content libraries
* Large Question Bank
* AI services
* Personalized learning
* Tests and assessments
* Practicals
* Coding
* Language learning
* Educational media
* Teacher platform
* Parent platform
* School platform
* Future mobile applications

The architecture should allow new modules to be added without requiring a complete rewrite of the existing system.

The platform must not be architecturally limited to any particular class range, board, subject, question type, or learning method.

---

# 2. System Separation

Aspirian will consist of separate but connected systems.

```text
                         ASPIRIAN ECOSYSTEM

                                │

              ┌─────────────────┴─────────────────┐
              │                                   │
       ASPIRIAN.PK                         APP.ASPIRIAN.PK
       WordPress Website                   Student Platform
              │                                   │
       Public Content                         Frontend
       SEO                                    Backend API
       Free Tools                            AI Services
       Career Hub                            Database
       Tutorials                             Learning Engine
       Downloads                             Assessment
              │                                   │
              └─────────────────┬─────────────────┘
                                │
                         External Services
                                │
                 ┌──────────────┼──────────────┐
                 │              │              │
              YouTube          AI        Email/Other
```

The WordPress website and Student Platform will remain technically independent.

The Student Platform must not become dependent on WordPress for core student accounts, learning records, Question Bank data, assessments, progress, or other core educational operations.

---

# 3. Domain Architecture

## Public Website

```text
https://aspirian.pk
```

Responsibilities:

* Public educational content
* SEO
* Articles
* Notes
* Free tools
* Job & Career Hub
* Tutorials
* Downloads
* Student discovery
* Organic traffic

---

## Student Application

```text
https://app.aspirian.pk
```

Responsibilities:

* Student accounts
* Dashboard
* Study Center
* Question Bank
* Universal Practice Engine
* Tests
* Results
* AI
* Personalization
* Revision
* Analytics
* Practicals
* Coding
* Language Lab
* Media
* Teacher features
* Parent features

The Student Application is the primary learning experience.

---

## Backend API

```text
https://api.aspirian.pk
```

Responsibilities:

* Authentication
* Authorization
* Business logic
* Database access
* Student services
* Academic services
* Question services
* Practice services
* Test services
* AI orchestration
* Analytics
* Notifications
* External integrations

The API should be treated as a separate application/service boundary.

---

# 4. High-Level Architecture

```text
                       ┌─────────────────────┐
                       │     ASPIRIAN.PK     │
                       │      WordPress      │
                       └──────────┬──────────┘
                                  │
                           Discovery / Content
                                  │
                                  ▼
                       ┌─────────────────────┐
                       │  APP.ASPIRIAN.PK    │
                       │   Web Application   │
                       └──────────┬──────────┘
                                  │
                              HTTPS/API
                                  │
                                  ▼
                       ┌─────────────────────┐
                       │   API.ASPIRIAN.PK   │
                       │    Laravel Backend  │
                       └──────────┬──────────┘
                                  │
              ┌───────────────────┼───────────────────┐
              │                   │                   │
              ▼                   ▼                   ▼
       ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
       │  Database   │     │ AI Services │     │ File/Media  │
       │             │     │             │     │   Storage   │
       └─────────────┘     └─────────────┘     └─────────────┘
```

The architecture follows a layered model:

```text
Presentation
     ↓
API / Application Interface
     ↓
Application / Business Logic
     ↓
Domain Services
     ↓
Data Access
     ↓
Database / External Services
```

---

# 5. Architectural Principles

The system will follow these principles.

## 5.1 Modular

Each major feature should have clear boundaries.

Modules should have defined responsibilities and should avoid unnecessary coupling.

## 5.2 API-Driven

Frontend applications should communicate with the backend through documented APIs.

The same backend services should eventually support:

* Web
* Android
* iOS
* Other approved clients

## 5.3 Secure by Design

Authentication, authorization, validation, rate limiting, and auditing should be considered from the beginning.

## 5.4 Scalable

The system should support growth without requiring a complete architectural rewrite.

## 5.5 Maintainable

Code should be organized into logical modules with clear responsibilities.

## 5.6 Testable

Business logic should be independently testable.

## 5.7 Documentation-First

Important architectural decisions should be documented before implementation.

## 5.8 Reusable Learning Architecture

Educational entities should be reusable across multiple learning experiences.

A Question Bank question may be reused by:

* Formal Tests
* Practice
* Revision
* Assignments
* Interactive Activities
* Other approved learning experiences

without unnecessarily duplicating the question.

## 5.9 Future-Ready Without Premature Complexity

The architecture should provide extension points for future functionality without creating unnecessary tables, services, or infrastructure before they are actually required.

---

# 6. Recommended Technology Direction

The technology stack for the Aspirian Student Platform is based on the current approved implementation direction.

```text
Frontend

    ↓

React / Next.js

Backend

    ↓

Laravel 12 / PHP

Database

    ↓

MariaDB 10.6.5

Cache / Queue

    ↓

Redis

Search

    ↓

MariaDB Search initially

    ↓

Dedicated Search Engine later if required

Storage

    ↓

S3-Compatible Object Storage

AI

    ↓

Provider-Agnostic AI Service Layer

Authentication

    ↓

Backend-managed Authentication

Deployment

    ↓

Linux VPS / Cloud Infrastructure
```

The current primary application stack is:

**Laravel 12 / PHP with MariaDB 10.6.5**

Technology choices must remain aligned with the actual application implementation and approved architecture decisions.

Any future change to the primary database or core technology stack must be reviewed and formally approved before implementation.

The architecture should also remain compatible with Laravel's standard application organization and testing approach. Laravel supports API-backend applications as well as JavaScript-based frontends and provides structured application directories for controllers, models, jobs, policies, tests, and related application code.

---

# 7. Frontend Architecture

The frontend will be responsible for:

* User interface
* Navigation
* Student experience
* Forms
* Dashboards
* Test interface
* Practice interface
* Learning interface
* AI interaction
* Media experience
* Progress visualization

The frontend should not directly access the database.

```text
Frontend

    ↓

API

    ↓

Business Logic

    ↓

Database
```

The frontend should also not contain authoritative educational evaluation logic.

For example, the frontend may display whether an answer is correct, but the authoritative evaluation must be performed by trusted backend logic.

---

# 8. Frontend Application Areas

Potential frontend areas:

```text
/

├── Landing
├── Authentication
├── Dashboard
├── Study Center
├── Subjects
├── Chapters
├── Topics
├── Questions
├── Practice
├── Tests
├── Results
├── Revision
├── Mistakes
├── AI Tutor
├── Language Lab
├── Practical Lab
├── Coding Lab
├── Media
├── Profile
└── Settings
```

Teacher, parent, school, and administration areas should have separate protected routes/interfaces.

The Practice area should support different interfaces according to question type and learner level.

For example:

```text
Early Years
    ↓
Picture / Alphabet / Matching / Simple Interaction

Middle Grades
    ↓
MCQ / Matching / Language / Fill Blank / Ordering

Secondary Grades
    ↓
MCQ / Short / Long / Translation / Subject-Specific Questions
```

The frontend must not hard-code the entire practice experience around one question type.

---

# 9. Backend Architecture

The backend will contain the main business logic.

Major backend domains:

```text
Backend

│
├── Authentication
├── Users
├── Roles & Permissions
├── Academic Structure
├── Knowledge
├── Content
├── Questions
├── Question Validation
├── Duplicate Detection
├── Universal Practice Engine
├── Practice Evaluation
├── Tests
├── Attempts
├── Results
├── Student Learning Profile
├── Learning Activities
├── Revision
├── Analytics
├── AI
├── Language
├── Practicals
├── Coding
├── Media
├── Notifications
├── Subscriptions
├── Schools
├── Teachers
├── Parents
└── Administration
```

The Universal Practice Engine is an application-level learning domain around the existing Question Bank.

It should not become a duplicate Question Bank.

---

# 10. Modular Monolith Strategy

The initial backend should preferably be developed as a **modular monolith** rather than immediately splitting everything into microservices.

This provides:

* Simpler development
* Lower infrastructure complexity
* Easier debugging
* Easier deployment
* Strong module boundaries
* Lower initial cost

The architecture should maintain clean internal boundaries so selected services can later be extracted if scale requires it.

The initial implementation should prioritize correctness, maintainability, testing, and clear domain boundaries over premature distributed infrastructure.

---

# 11. Future Service Extraction

If a component becomes large enough, it may be separated.

Potential future services:

```text
Main API

   │

   ├── AI Service
   ├── Search Service
   ├── Media Processing Service
   ├── Code Execution Service
   ├── Notification Service
   └── Analytics Service
```

The Universal Practice Engine may remain inside the main application unless actual scale or operational requirements justify extraction.

Service extraction should happen only when justified by:

* Scale
* Performance
* Security isolation
* Independent deployment needs
* Operational requirements
* Team ownership boundaries

---

# 12. Database Architecture

The Aspirian Student Platform uses a relational database architecture based on **MariaDB 10.6.5**.

The database architecture must support:

* Academic structure
* User and identity management
* Student profiles
* Teachers and parents
* Schools
* Educational content
* Question Bank
* Tests and assessments
* Results and performance
* Learning progress
* Practice
* Revision
* AI-related data
* Media metadata
* Notifications
* Subscriptions and payments
* Audit and system records

## Database Principles

The implementation must follow:

* Normalized relational design
* Foreign key integrity
* Appropriate indexes
* Unique constraints
* Referential integrity
* Soft deletion where historical preservation is required
* Timestamped records
* Scalable relationships
* Secure data access
* Laravel migration compatibility
* MariaDB 10.6.5 compatibility

The database schema must be implemented incrementally according to the approved development roadmap rather than creating all future tables at once.

The database architecture is documented in `DATABASE.md`.

The database should model the educational system rather than only the current feature list.

---

# 13. Academic Data Model

The academic structure should be hierarchical.

```text
Education System

      ↓

Board

      ↓

Academic Session

      ↓

Grade

      ↓

Subject

      ↓

Book / Course

      ↓

Chapter

      ↓

Topic
```

The Grade structure must support:

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

The application must not hard-code assumptions that limit the platform to only secondary or higher-secondary classes.

Boards, academic sessions, subjects, and educational structures should remain data-driven.

---

# 14. Content Architecture

Educational content should be reusable.

A single topic may connect to:

* Notes
* Questions
* Tests
* Practice
* Videos
* Flashcards
* Practicals
* Activities
* Vocabulary
* AI explanations

Example:

```text
Topic

 │

 ├── Notes
 ├── Questions
 ├── Practice
 ├── Tests
 ├── Flashcards
 ├── Practical
 ├── Video
 └── Activities
```

The same educational content should be reusable across multiple learning experiences where appropriate.

---

# 15. Question Architecture

Questions should be treated as structured entities rather than simple text records.

A question may have:

* Type
* Text
* Options
* Correct answer data
* Explanation
* Marks
* Difficulty
* Grade
* Subject
* Chapter
* Topic
* Board
* Academic session
* Source
* Review status
* Version
* Duplicate detection metadata
* Media references
* Tags

The conceptual question architecture must remain extensible.

The system should not create a separate primary Question table for every question type.

---

# 16. Universal Practice Question Types

The Universal Practice Engine should support an extensible family of question interactions.

## Traditional

* MCQ
* Short Answer
* Long Answer
* Fill in the Blank
* True / False
* Yes / No
* Multiple Select
* Correct Word
* Spelling

## Matching

* Matching
* Drag and Drop Matching
* Alphabet Matching
* Haroof-e-Tahajji Matching
* Word Matching
* Picture-to-Word Matching
* Word-to-Picture Matching

## Language

* English → Urdu
* Urdu → English
* Translation
* Word Meaning
* Sentence Formation

## Early Years

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

## Image-Based

* Image Identification
* Image Selection
* Image-Based MCQ
* Picture-to-Word
* Word-to-Picture
* Picture Matching
* Image-Based Matching

## Interactive

* Drag and Drop
* Matching
* Ordering / Arrange
* Multiple Selection
* Interactive Choice

## Future Audio / Listening

* Listen and Select
* Listen and Match
* Listening Comprehension
* Audio-to-Word
* Audio-to-Picture

The architecture should allow new interaction types to be added without creating a completely separate learning system.

---

# 17. Universal Practice Engine Architecture

The Universal Practice Engine is a reusable learning layer built around the Question Bank.

```text
                    QUESTION BANK

                         │

                         ▼

                ┌───────────────────┐
                │ Universal Practice│
                │      Engine       │
                └─────────┬─────────┘
                          │
          ┌───────────────┼────────────────┐
          │               │                │
          ▼               ▼                ▼
       Selection       Evaluation       Progress
          │               │                │
          └───────────────┼────────────────┘
                          │
                          ▼
                  Learning Activity
                          │
                          ▼
                  Student Learning
```

The Practice Engine should provide:

* Practice session initialization
* Question selection
* Question ordering
* Question presentation metadata
* Answer submission
* Server-side answer evaluation
* Immediate feedback
* Explanation display where appropriate
* Correct/wrong tracking
* Unanswered/skipped tracking
* Completion tracking
* Topic-wise progress
* Practice performance data
* Learning activity recording where required

---

# 18. Practice and Formal Test Separation

Practice and formal assessment are related but different learning experiences.

## Formal Test

```text
Test
 ↓
Test Attempt
 ↓
Answers
 ↓
Submission
 ↓
Result
 ↓
Formal Result History
```

## Practice

```text
Question Bank
 ↓
Practice Session
 ↓
Question
 ↓
Answer
 ↓
Immediate Evaluation
 ↓
Feedback
 ↓
Learning Activity / Progress
```

Practice should not unnecessarily create formal `TestAttempt` or `TestResult` records.

This prevents practice activity from polluting formal examination history.

A Practice configuration may reuse questions that are also available in formal tests, but the learning experience and persistence model remain conceptually separate.

---

# 19. Practice Question Selection

The Practice Engine should eventually support question selection based on:

* Grade
* Subject
* Chapter
* Topic
* Question type
* Difficulty
* Board
* Academic session
* Learning objective
* Weak topic
* Previous mistakes
* Revision priority
* Student progress
* Teacher-selected criteria
* AI-generated recommendations where approved

Question selection should remain server-controlled.

The frontend should not decide which questions are educationally valid for a student without backend validation.

---

# 20. Practice Evaluation

Answer evaluation should be type-aware.

Examples:

```text
MCQ
    ↓
Option comparison

True / False
    ↓
Boolean / option comparison

Fill in the Blank
    ↓
Accepted answer comparison

Matching
    ↓
Pair validation

Ordering
    ↓
Sequence validation

Translation
    ↓
Accepted answer / evaluation rules

Drag & Drop
    ↓
Mapping validation
```

The evaluation system should be extensible.

A single generic comparison method should not be assumed to work for every future question type.

Correct answers must not be exposed to the learner before the appropriate evaluation stage.

---

# 21. Practice Learning Flow

The standard practice flow should be:

```text
Student

   ↓

Select Grade / Subject / Topic

   ↓

Choose Practice

   ↓

Practice Configuration

   ↓

Question Selection

   ↓

Question Display

   ↓

Student Answer

   ↓

Server Evaluation

   ↓

Immediate Feedback

   ↓

Next Question

   ↓

Practice Completion

   ↓

Performance Summary

   ↓

Learning Activity / Progress

   ↓

Weak Topic / Revision Logic
```

For younger learners, the flow may include visual and interactive experiences.

For older learners, the flow may include text-based academic questions and subject-specific interactions.

---

# 22. Student Intelligence Layer

Student intelligence should be a dedicated application domain.

It will process:

* Test results
* Question attempts
* Practice activity
* Mistakes
* Revision activity
* Learning activity
* Topic mastery

It may produce:

* Weak topics
* Strong topics
* Revision priorities
* Recommendations
* Performance trends
* Practice recommendations
* Personalized learning suggestions

Practice data should contribute to student intelligence only according to approved learning rules.

---

# 23. Learning Activity Architecture

Learning activities provide a common way to record meaningful student learning events.

Potential activity types include:

```text
Reading
Video
Test
Practice
Revision
Flashcard
Activity
Coding
```

Practice-related events may include:

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

Learning activities are learning records, not automatically formal examination results.

A persistent dedicated Practice Session table should only be introduced if long-term history, analytics, synchronization, or cross-device recovery requires it.

---

# 24. Question Generation Pipeline

AI-generated questions should pass through controlled processing.

```text
Educational Source

       ↓

Content Extraction

       ↓

AI Generation

       ↓

Validation

       ↓

Duplicate Detection

       ↓

Quality Evaluation

       ↓

Human Review

       ↓

Approved Question

       ↓

Question Bank
```

AI-generated material should not automatically become trusted educational content.

The same approval principles apply to AI-generated Practice questions.

---

# 25. Knowledge Retrieval Architecture

The AI Tutor should use a retrieval-based architecture.

```text
Student Question

       ↓

Intent Detection

       ↓

Search / Retrieval

       ↓

Relevant Knowledge

       ↓

Context Construction

       ↓

AI Generation

       ↓

Response
```

The retrieval layer should be designed so it can evolve from database search to vector/semantic search when required.

Practice recommendations may eventually use the same knowledge and student-intelligence layers.

---

# 26. AI Service Layer

The application should not tightly couple business logic to one AI provider.

Instead:

```text
Aspirian Application

        ↓

AI Service Interface

        ↓

AI Provider Adapter

        ↓

Selected AI Provider
```

This allows future provider changes without rewriting the entire platform.

---

# 27. AI Capabilities

The AI layer may eventually support:

* AI Tutor
* Question Generation
* Content Generation
* Duplicate Detection
* Semantic Similarity
* Personalized Recommendations
* Study Planner
* Score Forecaster
* Voice
* OCR
* Video Processing
* Audio-to-Notes
* Flashcard Generation
* AI Viva
* Handwritten Answer Assistance
* Practice Recommendations
* Adaptive Question Selection

AI-generated educational content must remain subject to validation and approval rules.

---

# 28. Mistakes & Revision Architecture

```text
Question Attempt

      ↓

Evaluation

      ↓

Wrong Answer?

      ↓

Yes

      ↓

Mistake Record

      ↓

Topic Association

      ↓

Weakness Score

      ↓

Revision Priority

      ↓

Personalized Queue

      ↓

Practice / Revision
```

The Revision Queue may direct the student back into Practice.

Example:

```text
Weak Topic
    ↓
Revision Queue
    ↓
Practice This Topic
    ↓
Universal Practice Engine
    ↓
New Learning Evidence
    ↓
Updated Progress
```

This creates a continuous learning loop.

---

# 29. Assessment Architecture

The assessment system should separate:

* Test Definition
* Test Questions
* Student Attempt
* Answers
* Result
* Evaluation
* Analytics

This separation will allow multiple students to take the same test while maintaining independent attempts.

Formal assessment and Practice remain separate learning experiences even when they reuse the same Question Bank.

---

# 30. Coding Lab Architecture

Code execution must be isolated from the main application.

```text
Student

   ↓

Code Editor

   ↓

API

   ↓

Code Execution Queue

   ↓

Sandbox

   ↓

Execution

   ↓

Output / Error

   ↓

Student
```

The sandbox must restrict:

* Network access
* File system access
* CPU usage
* Memory usage
* Execution time
* Process privileges

The coding environment must never execute untrusted student code directly on the main application server.

---

# 31. Media Architecture

Educational media may include:

* Videos
* Audio
* Podcasts
* Live streams
* YouTube content
* Images
* Educational documents

The initial live video strategy will use YouTube.

```text
Aspirian

   ↓

YouTube Channel

   ↓

YouTube Live

   ↓

Student Platform Integration
```

The platform should store metadata and references rather than unnecessarily duplicating externally hosted video.

---

# 32. Internet Radio Architecture

The Internet Radio should initially use a dedicated streaming solution rather than being tightly coupled to the main application server.

Possible architecture:

```text
Audio Source

    ↓

Streaming Server / Provider

    ↓

Internet Radio

    ↓

Aspirian Player
```

The application should store:

* Stream URL
* Program schedule
* Current program
* Metadata

---

# 33. Audio Processing Architecture

```text
Audio

  ↓

Speech-to-Text

  ↓

Transcript

  ↓

AI Processing

  ↓

Notes / Summary / Questions

  ↓

Student
```

Audio processing may eventually integrate with listening-based Practice question generation.

---

# 34. Video Intelligence Architecture

```text
Video

  ↓

Transcript

  ↓

Topic Detection

  ↓

Key Concepts

  ↓

Quiz Generation

  ↓

Flashcards

  ↓

Notes
```

This processing may be asynchronous.

Generated questions must pass through the normal validation and approval pipeline.

---

# 35. Notification Architecture

Notifications should use a queue-based approach when scale increases.

```text
Application Event

      ↓

Notification Service

      ↓

Queue

      ↓

Delivery

 ┌────┼────┐
 ↓    ↓    ↓
Email Push In-App
```

---

# 36. File Storage

Large files should not be stored directly inside the application database.

Use object storage for:

* PDFs
* Images
* Audio
* Generated documents
* Educational media
* User uploads
* Practice media

The database should store metadata and secure references.

---

# 37. Caching

Caching may be used for frequently accessed data such as:

* Public educational content
* Academic structure
* Popular questions
* Configuration
* Search results
* Session-related data

Redis may be introduced where justified.

Caching must never compromise data correctness.

Student-specific learning data must not accidentally be served across users through improperly scoped caching.

---

# 38. Background Jobs

Long-running operations should not block normal web requests.

Examples:

* PDF processing
* AI content generation
* Duplicate analysis
* Video processing
* Audio transcription
* Email sending
* Report generation
* Analytics processing
* Large-scale Practice question preparation

These tasks should use background queues.

---

# 39. Search Architecture

Initial search may use the primary database.

As the content grows, dedicated search infrastructure may be introduced.

Potential future capabilities:

* Full-text search
* Typo tolerance
* Filters
* Semantic search
* Knowledge retrieval
* Question search
* Practice question discovery

Search architecture should remain replaceable.

---

# 40. Authentication Architecture

Authentication will be managed by the backend.

The system should support:

* Registration
* Login
* Logout
* Password reset
* Email verification
* Session management

Future options:

* Google login
* Apple login
* Phone verification

should be implemented only when required.

---

# 41. Authorization Architecture

Authorization must be enforced server-side.

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

Frontend restrictions alone are not sufficient for security.

This applies especially to:

* Student records
* Questions
* Correct answers
* Test results
* Practice evaluation
* Teacher resources
* Parent resources
* School resources
* Administrative functions

---

# 42. API Architecture

All application communication should use documented APIs.

Example:

```text
Frontend

   ↓

HTTPS

   ↓

API

   ↓

Authentication

   ↓

Authorization

   ↓

Business Logic

   ↓

Database / Services
```

API specifications will be documented separately in `API.md`.

---

# 43. API Versioning

The API should support versioning.

Example:

```text
/api/v1/
```

Future breaking changes can use:

```text
/api/v2/
```

The Universal Practice Engine APIs should follow the same versioning policy.

---

# 44. Security Architecture

Security controls should include:

* HTTPS
* Secure authentication
* Password hashing
* Authorization
* Input validation
* Output validation
* Rate limiting
* CSRF protection where applicable
* Secure file handling
* API protection
* Audit logs
* Backup strategy
* Secret management

Correct answers and protected educational content must never be exposed simply because they are present in frontend payloads.

---

# 45. AI Security

AI endpoints should include protections against:

* Abuse
* Excessive requests
* Prompt injection
* Sensitive data leakage
* Unauthorized model usage
* Excessive token consumption

AI usage should be monitored and rate-limited.

AI should not be trusted as an unrestricted authority over educational content.

---

# 46. Observability

The system should eventually provide:

* Application logs
* Error logs
* API metrics
* Queue monitoring
* Database monitoring
* AI usage metrics
* Practice usage metrics
* Performance monitoring

Errors should be traceable across services.

Important Practice and assessment failures should be diagnosable without exposing sensitive student information unnecessarily.

---

# 47. Audit Logging

Important actions should be recorded.

Examples:

* Login
* Role changes
* Content approval
* Question approval
* Question modification
* Test creation
* Administrative changes
* Subscription changes
* Important Practice configuration changes

Audit logs should be protected from unauthorized modification.

---

# 48. Environment Strategy

Separate environments should be maintained.

```text
Development

     ↓

Testing / Staging

     ↓

Production
```

Production credentials and data must never be used casually in development.

Practice, test, and student data should be isolated appropriately between environments.

---

# 49. Configuration Management

Environment-specific configuration should use environment variables or secure configuration management.

Sensitive information must never be committed to Git.

Examples:

* Database passwords
* API keys
* AI keys
* Email credentials
* Storage credentials
* Payment credentials

---

# 50. Deployment Architecture

Initial deployment may use:

```text
Internet

   ↓

DNS

   ↓

Reverse Proxy

   ↓

Application Server

   ↓

Backend

   ↓

Database
```

As the platform grows, components can be separated.

---

# 51. Scaling Strategy

Initial scaling:

**Vertical Scaling**

Increase server resources.

Later:

**Horizontal Scaling**

```text
Load Balancer

      ↓

 ┌────┼────┐
 ↓    ↓    ↓
App1 App2 App3

      ↓

Shared Services
```

Stateless application design should be preferred where practical.

Practice and API services should avoid unnecessary server-local state so future horizontal scaling remains possible.

---

# 52. Database Scaling

Potential future strategies:

* Index optimization
* Query optimization
* Read replicas
* Connection pooling
* Partitioning
* Archiving

Database scaling should be introduced based on actual performance requirements.

---

# 53. CDN Strategy

A CDN may be used for:

* Images
* Public assets
* Static files
* Educational downloads
* Media metadata

Private student resources must use appropriate access controls.

---

# 54. Backup Architecture

Backups should cover:

* Database
* Educational content
* Configuration
* Important files

The backup strategy should include:

* Automated backups
* Retention policy
* Off-site backup
* Recovery testing

Practice and student learning records should be included in the database backup strategy.

---

# 55. Disaster Recovery

The platform should eventually document:

* Recovery procedure
* Backup restoration
* DNS recovery
* Server recovery
* Database recovery
* Critical service dependencies

Recovery procedures should preserve important historical educational and student learning data.

---

# 56. Integration with Aspirian.pk

The WordPress website and Student Platform may exchange selected information through controlled APIs or links.

Examples:

```text
Aspirian.pk

    ↓

"Practice This Topic"

    ↓

app.aspirian.pk
```

```text
app.aspirian.pk

    ↓

"Read Full Article"

    ↓

aspirian.pk
```

The systems should remain independently deployable.

Public content may introduce students to the Student Platform, while the Student Platform may link students back to public educational resources.

---

# 57. Integration with YouTube

YouTube may provide:

* Video hosting
* Live streaming
* Educational channel
* Public discovery

The Student Platform may embed or reference appropriate YouTube content.

The application should not depend entirely on YouTube for core educational data.

---

# 58. Mobile Architecture

Future mobile applications should consume the same API.

```text
                    Backend API

                   /     |     \

                  /      |      \

                 ↓       ↓       ↓

              Web     Android   iOS
```

This avoids maintaining separate business logic for each platform.

The Universal Practice Engine should expose reusable backend behavior so mobile applications can support the same learning rules as the web application.

---

# 59. Multi-Tenant Future Architecture

School functionality may eventually require multi-tenancy.

Possible structure:

```text
Platform

   │

   ├── School A
   │    ├── Teachers
   │    └── Students
   │
   ├── School B
   │    ├── Teachers
   │    └── Students
   │
   └── School C
        ├── Teachers
        └── Students
```

Tenant boundaries must be enforced at the backend and database levels.

The Universal Practice Engine must respect tenant boundaries where school-specific content or question banks are introduced.

---

# 60. Content Versioning

Educational content must support versions.

```text
Content

   │

   ├── Version 1
   ├── Version 2
   └── Version 3
```

This is important when:

* Syllabus changes
* Textbooks change
* Academic sessions change
* Corrections are made
* Question versions change

Question revisions and approved content versions should preserve educational history where required.

---

# 61. Feature Flags

Future functionality may use feature flags.

Examples:

```text
AI Tutor: ON

Coding Lab: OFF

Virtual Lab: OFF

Study Rooms: OFF

Audio Practice: OFF
```

This allows controlled rollout of new functionality.

New Practice interaction types may also be introduced behind feature flags when appropriate.

---

# 62. Performance Goals

The platform should aim for:

* Fast initial loading
* Efficient API responses
* Optimized database queries
* Lazy loading for large resources
* Efficient caching
* Asynchronous heavy processing
* Efficient question selection
* Fast answer evaluation

Exact performance targets will be defined during implementation and testing.

Practice evaluation should remain responsive for normal question interactions, while expensive operations such as AI generation or media processing should be asynchronous.

---

# 63. Accessibility

The interface should consider:

* Keyboard navigation
* Readable typography
* Contrast
* Screen readers
* Clear navigation
* Accessible forms
* Appropriate media controls
* Accessible interactive elements

Accessibility should be considered especially for younger learners.

Interactive Practice questions must provide accessible alternatives where practical.

---

# 64. Internationalization

The architecture should eventually support:

* English
* Urdu
* Roman Urdu

The system should avoid hard-coding interface text into application logic.

Future languages can be added through localization resources.

Question content and educational answers should also be capable of supporting multilingual data where required.

---

# 65. Localization

The platform should support:

* Pakistan-specific academic structures
* Pakistani education boards
* Local terminology
* Urdu educational content
* Local date/time conventions
* Appropriate regional educational requirements

The Universal Practice Engine should support language-specific interaction types without creating separate practice systems for each language.

---

# 66. Development Workflow

The development lifecycle will be:

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

Review

    ↓

Documentation

    ↓

Deployment
```

For individual features, implementation should follow a controlled sequence:

```text
Requirement
    ↓
Existing Architecture Check
    ↓
Existing Schema / Code Check
    ↓
Minimal Implementation
    ↓
Automated Tests
    ↓
Browser / UI Verification
    ↓
Documentation
    ↓
Commit / Push
```

No new migration, table, service, or abstraction should be introduced merely because the long-term blueprint mentions it.

It should be introduced when the current feature actually requires it.

---

# 67. Architecture Decision Records

Important technology and architecture decisions should be documented.

Examples:

* Why Laravel?
* Why MariaDB?
* Why modular monolith?
* Why separate API?
* Why YouTube for initial live streaming?
* Why object storage?
* Why provider-agnostic AI?
* Why Universal Practice Engine?
* Why reuse the Question Bank for Practice?
* Why Practice is separated from formal Test Results?
* Why persistent Practice Session storage is deferred?

Future decisions should be recorded rather than relying on memory.

---

# 68. Universal Practice Architecture Decision

The approved Practice architecture is:

```text
Question Bank
      │
      ├── Question Options
      ├── Question Answers
      ├── Media / Files
      └── Tags
             │
             ▼
      Universal Practice Engine
             │
       ┌─────┴─────┐
       │           │
    Selection   Evaluation
       │           │
       └─────┬─────┘
             ▼
      Learning Activity
             │
             ▼
      Student Progress
             │
       ┌─────┴─────┐
       ▼           ▼
  Weak Topics   Mastery
       │
       ▼
 Revision Queue
       │
       ▼
 Practice / Revision
```

The Practice Engine initially reuses the existing Question Bank.

There will be **no separate `practice_questions` table** unless future requirements prove that a dedicated persistent practice structure is necessary.

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

# 69. Universal Practice Academic Coverage

The Practice Engine must support the complete academic range:

```text
ASPIRIAN PRACTICE ENGINE

├── Nursery
├── Prep
├── Class 1
├── Class 2
├── Class 3
├── Class 4
├── Class 5
├── Class 6
├── Class 7
├── Class 8
├── Class 9
├── Class 10
├── Class 11
└── Class 12
```

The system must not create separate Practice Engines for different class groups.

Instead:

```text
                Universal Practice Engine
                           │
          ┌────────────────┼────────────────┐
          │                │                │
      Early Years      Middle Grades    Secondary
          │                │                │
     Nursery/Prep       Class 1–8       Class 9–12
```

These are learning experience categories, not separate application architectures.

---

# 70. Future Practice Extensibility

The Practice Engine should remain extensible for future interaction types such as:

* Audio questions
* Listening comprehension
* Voice-based answers
* Image recognition
* Interactive diagrams
* Drag-and-drop activities
* Simulations
* AI-assisted evaluation
* Handwriting recognition
* Speech recognition
* Adaptive question selection
* Personalized practice plans

New interaction types should be integrated through extensible question configuration and evaluation rules rather than creating an entirely separate Practice application.

---

# 71. Architecture Status

**File:** `ARCHITECTURE.md`

**Phase:** B

**Module:** B1 — System Architecture

**Version:** 1.1

**Status:** Master Architecture Blueprint — Updated for Universal Practice Architecture

The architecture is intentionally designed to support the complete long-term Aspirian vision while allowing the first version to remain manageable.

The architecture now explicitly defines:

* Complete academic range from Nursery, Prep, Class 1 through Class 12
* Reusable Question Bank architecture
* Universal Practice Engine
* Practice and Formal Test separation
* Practice evaluation
* Learning Activity integration
* Weak Topic and Revision integration
* Future interactive question types
* Future audio/listening capabilities
* Mobile compatibility
* AI extensibility
* Future service extraction

The next technical design documents will define:

* Database schema
* API contracts
* AI architecture
* Development standards
* Security implementation
* Deployment strategy

---

# 72. Current Architectural Direction

At this stage, the approved architecture is:

```text
                    ┌──────────────────────┐
                    │      ASPIRIAN.PK     │
                    │      WordPress       │
                    └──────────┬───────────┘
                               │
                               │
                    ┌──────────▼───────────┐
                    │   APP.ASPIRIAN.PK    │
                    │   Web Application    │
                    └──────────┬───────────┘
                               │
                             HTTPS
                               │
                    ┌──────────▼───────────┐
                    │   API.ASPIRIAN.PK    │
                    │    Laravel Backend   │
                    └──────────┬───────────┘
                               │
               ┌───────────────┼────────────────┐
               │               │                │
               ▼               ▼                ▼
        MariaDB 10.6.5       Redis       Object Storage
               │
               ▼
        Academic Structure
               │
               ▼
          Question Bank
               │
               ▼
    Universal Practice Engine
               │
        ┌──────┼───────┐
        ▼      ▼       ▼
     Tests  Practice  Revision
        │      │       │
        └──────┼───────┘
               ▼
       Student Learning Data
               │
               ▼
       Student Intelligence
               │
               ▼
        AI Service Layer
```

---

# 73. Architecture Rules for Current Development

The following rules are now considered part of the approved architecture.

1. Do not hard-code classes.
2. Do not hard-code boards.
3. Do not hard-code academic years.
4. Do not assume every student uses the same question interaction.
5. Do not create a separate Question table for every question type.
6. Do not expose correct answers before the appropriate evaluation stage.
7. Do not treat AI-generated content as automatically approved.
8. Do not store large media files directly in MariaDB.
9. Do not execute student code on the main application server.
10. Do not rely on frontend authorization.
11. Historical educational data should not be casually deleted.
12. Question duplication must be checked before approval.
13. Student learning data must be access-controlled.
14. Practice data must not unnecessarily pollute formal test result history.
15. Universal Practice Engine must remain extensible for future interaction types.
16. Do not create unnecessary Practice-specific database duplication.
17. Do not introduce future architecture components before they are required.
18. Existing implementation must be inspected before introducing new migrations or structures.
19. Business logic should remain testable independently of the frontend.
20. Important architectural decisions should be documented.

---

# 74. Final Architecture Principle

> **Build the first version simply, but design the foundation for the future.**

Aspirian should start as a manageable modular platform and evolve into a large educational ecosystem without unnecessary architectural rewrites.

The architecture should model the complete educational journey:

```text
Nursery
   ↓
Prep
   ↓
Class 1–12
   ↓
Learning
   ↓
Practice
   ↓
Assessment
   ↓
Progress
   ↓
Weakness Detection
   ↓
Revision
   ↓
Mastery
   ↓
Personalized Learning
```

The platform should therefore remain:

**Universal, Modular, Reusable, Testable, Secure, Extensible, and Future-Ready.**

The core architectural principle is:

> **The architecture should model the educational system, not the current feature list.**
