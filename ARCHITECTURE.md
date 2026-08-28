# Aspirian Student Platform — Technical Architecture

**Document Version:** 1.0
**Status:** Initial Architecture
**Project:** Aspirian Student Platform
**Primary Application:** `app.aspirian.pk`
**Backend API:** `api.aspirian.pk`
**Existing Website:** `aspirian.pk`

---

# 1. Architecture Vision

Aspirian Student Platform will be built as a **standalone, modular, API-driven educational application**.

The architecture must support the complete long-term vision:

* Nursery to Class 12
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

---

# 2. System Separation

Aspirian will consist of separate but connected systems.

```text id="gq1p3v"
                         ASPIRIAN ECOSYSTEM
                                │
              ┌─────────────────┴─────────────────┐
              │                                   │
       ASPIRIAN.PK                         APP.ASPIRIAN.PK
       WordPress Website                   Student Platform
              │                                   │
       Public Content                        Frontend
       SEO                                   Backend API
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
              YouTube          AI          Email/Other
```

The WordPress website and Student Platform will remain technically independent.

---

# 3. Domain Architecture

## Public Website

```text id="6g2w7h"
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

```text id="w1d8v6"
https://app.aspirian.pk
```

Responsibilities:

* Student accounts
* Dashboard
* Study Center
* Question Bank
* Tests
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

---

## Backend API

```text id="9g9xgc"
https://api.aspirian.pk
```

Responsibilities:

* Authentication
* Authorization
* Business logic
* Database access
* Student services
* Question services
* Test services
* AI orchestration
* Analytics
* Notifications
* External integrations

The API should be treated as a separate application/service boundary.

---

# 4. High-Level Architecture

```text id="6r4x6y"
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
                       │    Backend API      │
                       └──────────┬──────────┘
                                  │
                ┌─────────────────┼─────────────────┐
                │                 │                 │
                ▼                 ▼                 ▼
        ┌─────────────┐   ┌─────────────┐   ┌─────────────┐
        │  Database   │   │ AI Services │   │ File/Media  │
        │             │   │             │   │   Storage   │
        └─────────────┘   └─────────────┘   └─────────────┘
```

---

# 5. Architectural Principles

The system will follow these principles:

## 5.1 Modular

Each major feature should have clear boundaries.

## 5.2 API-Driven

Frontend applications should communicate with the backend through documented APIs.

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

---

# 6. Recommended Technology Direction

The exact technology stack will be finalized before implementation begins.

The initial recommended direction is:

```text id="q5wxed"
Frontend
    ↓
React / Next.js

Backend
    ↓
Laravel / PHP

Database
    ↓
PostgreSQL

Cache / Queue
    ↓
Redis

Search
    ↓
PostgreSQL Search initially
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

Technology choices must be validated against actual project requirements before final implementation.

---

# 7. Frontend Architecture

The frontend will be responsible for:

* User interface
* Navigation
* Student experience
* Forms
* Dashboards
* Test interface
* Learning interface
* AI interaction
* Media experience

The frontend should not directly access the database.

```text id="4t5p3s"
Frontend
    ↓
API
    ↓
Business Logic
    ↓
Database
```

---

# 8. Frontend Application Areas

Potential frontend areas:

```text id="4e8r8p"
/
├── Landing
├── Authentication
├── Dashboard
├── Study Center
├── Subjects
├── Chapters
├── Topics
├── Questions
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

---

# 9. Backend Architecture

The backend will contain the main business logic.

Major backend domains:

```text id="v4c1mb"
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
├── Tests
├── Attempts
├── Results
├── Student Learning Profile
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

---

# 11. Future Service Extraction

If a component becomes large enough, it may be separated.

Potential future services:

```text id="2k7c7d"
Main API
   │
   ├── AI Service
   ├── Search Service
   ├── Media Processing Service
   ├── Code Execution Service
   ├── Notification Service
   └── Analytics Service
```

This should happen only when justified by scale or operational requirements.

---

# 12. Database Architecture

The primary database will store structured application data.

Major domains:

```text id="6xkt1j"
Users
Academic Structure
Content
Knowledge
Questions
Tests
Attempts
Results
Learning Profiles
Revision
Analytics
Media
Subscriptions
Schools
Notifications
Audit Logs
```

Database design will be documented separately in:

**`DATABASE.md`**

---

# 13. Academic Data Model

The academic structure should be hierarchical.

```text id="x3wq0p"
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

This must support Nursery–12 without hard-coded assumptions.

---

# 14. Content Architecture

Educational content should be reusable.

A single topic may connect to:

* Notes
* Questions
* Tests
* Videos
* Flashcards
* Practicals
* Activities
* Vocabulary
* AI explanations

Example:

```text id="kgf2wq"
Topic
 │
 ├── Notes
 ├── MCQs
 ├── Short Questions
 ├── Long Questions
 ├── Flashcards
 ├── Practical
 ├── Video
 └── Test
```

---

# 15. Question Architecture

Questions should be treated as structured entities rather than simple text records.

A question may have:

* Type
* Text
* Options
* Correct answer
* Explanation
* Marks
* Difficulty
* Board
* Class
* Subject
* Chapter
* Topic
* Source
* Review status
* Version
* Duplicate detection metadata

---

# 16. Question Generation Pipeline

AI-generated questions should pass through controlled processing.

```text id="x2s6zq"
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
```

AI-generated material should not automatically become trusted educational content.

---

# 17. Knowledge Retrieval Architecture

The AI Tutor should use a retrieval-based architecture.

```text id="fmy7ri"
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

---

# 18. AI Service Layer

The application should not tightly couple business logic to one AI provider.

Instead:

```text id="q2a8ru"
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

# 19. AI Capabilities

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

---

# 20. Student Intelligence Layer

Student intelligence should be a dedicated application domain.

It will process:

* Test results
* Question attempts
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

---

# 21. Mistakes & Revision Architecture

```text id="h8ks0h"
Question Attempt
      ↓
Result
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
```

---

# 22. Assessment Architecture

The assessment system should separate:

* Test Definition
* Test Questions
* Student Attempt
* Answers
* Result
* Evaluation
* Analytics

This separation will allow multiple students to take the same test while maintaining independent attempts.

---

# 23. Coding Lab Architecture

Code execution must be isolated from the main application.

```text id="wl0n0b"
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

# 24. Media Architecture

Educational media may include:

* Videos
* Audio
* Podcasts
* Live streams
* YouTube content

The initial live video strategy will use YouTube.

```text id="h2z7ds"
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

# 25. Internet Radio Architecture

The Internet Radio should initially use a dedicated streaming solution rather than being tightly coupled to the main application server.

Possible architecture:

```text id="p8x4jd"
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

# 26. Audio Processing Architecture

```text id="r5g7cc"
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

---

# 27. Video Intelligence Architecture

```text id="0j0z7n"
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

---

# 28. Notification Architecture

Notifications should use a queue-based approach when scale increases.

```text id="4m6h1z"
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

# 29. File Storage

Large files should not be stored directly inside the application database.

Use object storage for:

* PDFs
* Images
* Audio
* Generated documents
* Educational media
* User uploads

The database should store metadata and secure references.

---

# 30. Caching

Caching may be used for frequently accessed data such as:

* Public educational content
* Academic structure
* Popular questions
* Configuration
* Search results
* Session-related data

Redis may be introduced where justified.

Caching must never compromise data correctness.

---

# 31. Background Jobs

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

These tasks should use background queues.

---

# 32. Search Architecture

Initial search may use the primary database.

As the content grows, dedicated search infrastructure may be introduced.

Potential future capabilities:

* Full-text search
* Typo tolerance
* Filters
* Semantic search
* Knowledge retrieval

Search architecture should remain replaceable.

---

# 33. Authentication Architecture

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

# 34. Authorization Architecture

Authorization must be enforced server-side.

Example:

```text id="6w8j8g"
User
 ↓
Role
 ↓
Permission
 ↓
Resource Access
```

Frontend restrictions alone are not sufficient for security.

---

# 35. API Architecture

All application communication should use documented APIs.

Example:

```text id="l4j3d4"
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

# 36. API Versioning

The API should support versioning.

Example:

```text id="g9o0xk"
/api/v1/
```

Future breaking changes can use:

```text id="zq7j3d"
/api/v2/
```

---

# 37. Security Architecture

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

---

# 38. AI Security

AI endpoints should include protections against:

* Abuse
* Excessive requests
* Prompt injection
* Sensitive data leakage
* Unauthorized model usage
* Excessive token consumption

AI usage should be monitored and rate-limited.

---

# 39. Observability

The system should eventually provide:

* Application logs
* Error logs
* API metrics
* Queue monitoring
* Database monitoring
* AI usage metrics
* Performance monitoring

Errors should be traceable across services.

---

# 40. Audit Logging

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

Audit logs should be protected from unauthorized modification.

---

# 41. Environment Strategy

Separate environments should be maintained.

```text id="j1s2cx"
Development
     ↓
Testing / Staging
     ↓
Production
```

Production credentials and data must never be used casually in development.

---

# 42. Configuration Management

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

# 43. Deployment Architecture

Initial deployment may use:

```text id="l3e4qf"
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

# 44. Scaling Strategy

Initial scaling:

**Vertical Scaling**

Increase server resources.

Later:

**Horizontal Scaling**

```text id="r4y9s3"
Load Balancer
      ↓
 ┌────┼────┐
 ↓    ↓    ↓
App1 App2 App3
      ↓
 Shared Services
```

Stateless application design should be preferred where practical.

---

# 45. Database Scaling

Potential future strategies:

* Index optimization
* Query optimization
* Read replicas
* Connection pooling
* Partitioning
* Archiving

Database scaling should be introduced based on actual performance requirements.

---

# 46. CDN Strategy

A CDN may be used for:

* Images
* Public assets
* Static files
* Educational downloads
* Media metadata

Private student resources must use appropriate access controls.

---

# 47. Backup Architecture

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

---

# 48. Disaster Recovery

The platform should eventually document:

* Recovery procedure
* Backup restoration
* DNS recovery
* Server recovery
* Database recovery
* Critical service dependencies

---

# 49. Integration with Aspirian.pk

The WordPress website and Student Platform may exchange selected information through controlled APIs or links.

Examples:

```text id="v7x6m2"
Aspirian.pk
    ↓
"Practice This Topic"
    ↓
app.aspirian.pk
```

```text id="s7h2q9"
app.aspirian.pk
    ↓
"Read Full Article"
    ↓
aspirian.pk
```

The systems should remain independently deployable.

---

# 50. Integration with YouTube

YouTube may provide:

* Video hosting
* Live streaming
* Educational channel
* Public discovery

The Student Platform may embed or reference appropriate YouTube content.

The application should not depend entirely on YouTube for core educational data.

---

# 51. Mobile Architecture

Future mobile applications should consume the same API.

```text id="d2c9e4"
                    Backend API
                   /     |     \
                  /      |      \
                 ↓       ↓       ↓
              Web      Android   iOS
```

This avoids maintaining separate business logic for each platform.

---

# 52. Multi-Tenant Future Architecture

School functionality may eventually require multi-tenancy.

Possible structure:

```text id="p4k1nc"
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

---

# 53. Content Versioning

Educational content must support versions.

```text id="8k8q3x"
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

---

# 54. Feature Flags

Future functionality may use feature flags.

Examples:

```text id="d9z4mk"
AI Tutor: ON
Coding Lab: OFF
Virtual Lab: OFF
Study Rooms: OFF
```

This allows controlled rollout of new functionality.

---

# 55. Performance Goals

The platform should aim for:

* Fast initial loading
* Efficient API responses
* Optimized database queries
* Lazy loading for large resources
* Efficient caching
* Asynchronous heavy processing

Exact performance targets will be defined during implementation and testing.

---

# 56. Accessibility

The interface should consider:

* Keyboard navigation
* Readable typography
* Contrast
* Screen readers
* Clear navigation
* Accessible forms
* Appropriate media controls

Accessibility should be considered especially for younger learners.

---

# 57. Internationalization

The architecture should eventually support:

* English
* Urdu
* Roman Urdu

The system should avoid hard-coding interface text into application logic.

Future languages can be added through localization resources.

---

# 58. Localization

The platform should support:

* Pakistan-specific academic structures
* Pakistani education boards
* Local terminology
* Urdu educational content
* Local date/time conventions
* Appropriate regional educational requirements

---

# 59. Development Workflow

The development lifecycle will be:

```text id="0l1z9x"
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

---

# 60. Architecture Decision Records

Important technology and architecture decisions should be documented.

Examples:

* Why Laravel?
* Why PostgreSQL?
* Why modular monolith?
* Why separate API?
* Why YouTube for initial live streaming?
* Why object storage?
* Why provider-agnostic AI?

Future decisions should be recorded rather than relying on memory.

---

# 61. Current Architectural Direction

At this stage, the preferred architecture is:

```text id="x8j7w4"
                ┌──────────────────────┐
                │      ASPIRIAN.PK     │
                │      WordPress       │
                └──────────┬───────────┘
                           │
                           │
                ┌──────────▼───────────┐
                │   APP.ASPIRIAN.PK     │
                │   Web Application     │
                └──────────┬───────────┘
                           │
                         HTTPS
                           │
                ┌──────────▼───────────┐
                │   API.ASPIRIAN.PK     │
                │   Laravel Backend     │
                └──────────┬───────────┘
                           │
             ┌─────────────┼─────────────┐
             │             │             │
             ▼             ▼             ▼
        PostgreSQL       Redis      Object Storage
             │
             │
             ▼
      Student Learning Data
             │
             ▼
       AI Service Layer
```

---

# 62. Architecture Status

**Version:** 1.0

**Status:** Initial Architecture Blueprint

The architecture is intentionally designed to support the complete long-term Aspirian vision while allowing the first version to remain manageable.

The next technical design documents will define:

* Database schema
* API contracts
* AI architecture
* Development standards
* Security implementation
* Deployment strategy

---

# Final Principle

> **Build the first version simply, but design the foundation for the future.**

Aspirian should start as a manageable modular platform and evolve into a large educational ecosystem without unnecessary architectural rewrites.
