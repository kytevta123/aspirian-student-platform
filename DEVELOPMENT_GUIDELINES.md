# Aspirian Student Platform — Development Guidelines

**Version:** 1.0
**Status:** Technical Design Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12

---

# 1. Purpose

This document defines the development standards and engineering rules for the Aspirian Student Platform.

All developers, contributors, AI coding assistants, and future development tools should follow these guidelines.

The objective is to maintain:

* Clean code
* Secure code
* Maintainable architecture
* Consistent development
* Scalable infrastructure
* Testable features
* Clear documentation

---

# 2. Core Development Principle

> **Build small, testable, documented modules instead of one large monolithic feature.**

Every feature should be designed with:

```text
Requirement
 ↓
Architecture
 ↓
Database
 ↓
Backend
 ↓
API
 ↓
Frontend
 ↓
Testing
 ↓
Documentation
```

---

# 3. Technology Architecture

The platform will be developed as a separate application from the existing WordPress website.

```text
aspirian.pk
        │
        │ Public Website
        ▼
app.aspirian.pk
        │
        ▼
api.aspirian.pk
        │
        ▼
Backend Services
        │
        ▼
Database / AI / Storage
```

The exact production technology stack will be finalized during implementation.

---

# 4. Existing WordPress Website

The existing:

```text
aspirian.pk
```

will continue to focus on:

* Educational Articles
* Notes
* Tutorials
* Free Online Tools
* Job & Career Hub
* Downloads
* SEO
* Organic Traffic
* Public Educational Content
* Student Discovery

The application must remain architecturally independent.

---

# 5. Application Domain

The main application will use:

```text
app.aspirian.pk
```

The API will use:

```text
api.aspirian.pk
```

These services should be developed and deployed independently from WordPress.

---

# 6. Repository Structure

The repository should maintain a clean structure.

Initial conceptual structure:

```text
aspirian-student-platform/
│
├── docs/
│
├── backend/
│
├── frontend/
│
├── database/
│
├── tests/
│
├── scripts/
│
├── storage/
│
├── .env.example
├── .gitignore
├── README.md
└── documentation files
```

The exact framework-specific structure will be finalized during implementation.

---

# 7. Backend Architecture

The backend should follow modular architecture.

Conceptually:

```text
Backend
│
├── Authentication
├── Users
├── Students
├── Teachers
├── Parents
├── Schools
├── Academic
├── Content
├── Questions
├── Tests
├── Results
├── Revision
├── Practicals
├── Activities
├── Coding
├── Media
├── AI
├── Notifications
├── Subscriptions
└── Administration
```

---

# 8. Modular Development

Modules should be loosely coupled.

For example:

```text
Question Bank
      ↓
Tests
      ↓
Results
      ↓
Mistake Analysis
      ↓
Revision
```

Each module should have clearly defined responsibilities.

---

# 9. Single Responsibility

A class, service, controller, or function should have one clear responsibility.

Avoid:

```text
One Controller
 ↓
Authentication
 ↓
Payment
 ↓
AI
 ↓
Database
 ↓
Notifications
```

Prefer dedicated services.

---

# 10. Naming Conventions

Use descriptive and consistent names.

Examples:

```text
StudentProfile
QuestionBank
TestAttempt
RevisionQueue
AiTutor
```

Avoid unclear names such as:

```text
Data1
Temp
Test2
Thing
HelperNew
```

---

# 11. Database Naming

Database naming should be consistent.

Preferred style:

```text
users
student_profiles
subjects
chapters
questions
test_attempts
test_results
revision_items
```

Foreign keys should use predictable naming:

```text
student_id
subject_id
chapter_id
question_id
```

---

# 12. Database Rules

Database changes must use migrations.

Never manually modify production database structure without a controlled migration.

Example workflow:

```text
Migration
 ↓
Test
 ↓
Review
 ↓
Deploy
```

---

# 13. Seed Data

Development and testing should use seeders/factories where supported.

Seed data may include:

* Sample users
* Sample grades
* Subjects
* Chapters
* Questions
* Tests

Real student information must never be used as development seed data.

---

# 14. API Development

All APIs must follow the rules defined in:

```text
API.md
```

API endpoints must have:

* Validation
* Authentication where required
* Authorization
* Consistent responses
* Appropriate HTTP status codes
* Error handling

---

# 15. API Controllers

Controllers should remain thin.

Preferred:

```text
Request
 ↓
Controller
 ↓
Service
 ↓
Repository / Model
 ↓
Database
```

Avoid putting large business logic directly inside controllers.

---

# 16. Service Layer

Complex business logic should live inside dedicated services.

Examples:

```text
TestEvaluationService
RevisionRecommendationService
QuestionGenerationService
PaperBuilderService
ScoreForecastService
```

---

# 17. Validation

Every external input must be validated.

Validation must happen on the backend even when frontend validation exists.

---

# 18. Authorization

Every protected action must verify permissions.

Example:

```text
Student
 ↓
Request Result
 ↓
Check Ownership
 ↓
Allow / Deny
```

Never rely only on frontend restrictions.

---

# 19. Authentication

Authentication implementation must follow:

```text
SECURITY.md
```

Authentication logic should not be duplicated across modules.

---

# 20. Error Handling

Errors must be handled consistently.

Users should receive useful messages without exposing internal technical details.

Never expose:

* Database queries
* Stack traces
* Secrets
* Server paths
* Internal credentials

---

# 21. Logging

Application logs should provide enough information for debugging and monitoring.

Do not log:

* Passwords
* Authentication tokens
* API keys
* Payment secrets
* Sensitive personal data

---

# 22. Frontend Architecture

The frontend should be component-based.

Conceptually:

```text
Pages
 ↓
Layouts
 ↓
Components
 ↓
Services/API Client
 ↓
API
```

Reusable components should be preferred over duplicated UI code.

---

# 23. UI Components

Common components should be reusable.

Examples:

```text
Button
Input
Modal
Card
Table
QuestionCard
QuizTimer
ProgressBar
VideoPlayer
AudioPlayer
Flashcard
```

---

# 24. Responsive Design

The application must work across:

* Desktop
* Laptop
* Tablet
* Mobile

Mobile-first principles should be considered for student-facing interfaces.

---

# 25. Accessibility

The application should aim for accessible design.

Consider:

* Keyboard navigation
* Readable typography
* Appropriate contrast
* Labels
* Alternative text
* Focus states
* Screen-reader compatibility

---

# 26. Performance

Performance must be considered from the beginning.

Use:

* Pagination
* Lazy loading
* Caching
* Optimized queries
* Image optimization
* Background jobs
* CDN where appropriate

---

# 27. Database Query Performance

Avoid unnecessary database queries.

Watch for:

```text
N + 1 Queries
Large Unfiltered Queries
Missing Indexes
Repeated Queries
```

---

# 28. Caching

Caching may be used for relatively stable information such as:

* Academic structure
* Public content
* Question metadata
* Configuration

Private student-specific data must be handled carefully.

---

# 29. Background Jobs

Long-running tasks should use queues/background workers.

Examples:

```text
Video Processing
Audio Transcription
AI Generation
Email Sending
Large Report Generation
Notifications
```

---

# 30. AI Development Rules

All AI-related development must follow:

```text
AI_ARCHITECTURE.md
```

AI functionality must not be scattered randomly throughout the codebase.

Use dedicated AI services.

---

# 31. AI Provider Abstraction

Avoid hard-coding one AI provider throughout the application.

Prefer:

```text
AiServiceInterface
       ↓
Provider Adapter
       ↓
AI Provider
```

This allows future provider changes.

---

# 32. AI Generated Code

AI coding assistants may be used for development.

However:

> **AI-generated code must never be accepted blindly.**

Every AI-generated change must be:

```text
Generated
 ↓
Read
 ↓
Understood
 ↓
Tested
 ↓
Security Checked
 ↓
Committed
```

---

# 33. AI Coding Assistant Rules

AI coding tools should:

* Follow repository documentation
* Respect architecture
* Avoid unnecessary dependencies
* Avoid modifying unrelated files
* Follow naming conventions
* Write tests where appropriate
* Explain major architectural changes

---

# 34. No Blind Refactoring

Do not allow AI tools or developers to perform large unrelated refactors during a feature task.

Bad:

```text
Add Login
+
Rewrite Database
+
Change UI
+
Replace Framework
```

Good:

```text
Add Login
 ↓
Test Login
 ↓
Commit
```

---

# 35. Git Workflow

Git must be used for all development.

Recommended flow:

```text
main
 │
 ├── feature/authentication
 ├── feature/question-bank
 ├── feature/ai-tutor
 └── fix/test-submission
```

---

# 36. Main Branch

The `main` branch should represent stable code.

Avoid directly pushing experimental changes to `main` once active team development begins.

---

# 37. Feature Branches

New features should preferably use feature branches.

Examples:

```text
feature/student-dashboard
feature/question-bank
feature/ai-tutor
feature/paper-builder
```

---

# 38. Bug Fix Branches

Bug fixes should use:

```text
fix/login-validation
fix/test-result-calculation
fix/mobile-navigation
```

---

# 39. Commit Messages

Commit messages should clearly describe the change.

Examples:

```text
feat: add student registration
feat: add question bank API
fix: correct test score calculation
docs: update API specification
refactor: simplify revision service
test: add authentication tests
```

---

# 40. Small Commits

Prefer small logical commits.

Bad:

```text
update everything
```

Better:

```text
feat: add student profile migration
feat: add student profile API
test: add student profile tests
```

---

# 41. Pull Requests

When collaborative development begins, pull requests should include:

* Purpose
* Changes
* Tests
* Screenshots where appropriate
* Known limitations

---

# 42. Code Review

Review should check:

```text
Correctness
Security
Performance
Architecture
Tests
Documentation
```

---

# 43. Dependency Management

Do not add dependencies without a reason.

Before adding a package consider:

* Is it necessary?
* Is it maintained?
* Is it secure?
* Does the framework already provide the feature?
* What is its license?
* Does it increase complexity?

---

# 44. Environment Configuration

Use separate environments:

```text
Development
Testing
Staging
Production
```

Never use production credentials in development.

---

# 45. Environment Files

Use:

```text
.env
.env.example
```

`.env` must remain private.

`.env.example` should contain variable names without real secrets.

---

# 46. Configuration

Environment-specific settings should be configurable.

Examples:

```text
APP_ENV
APP_URL
DATABASE_URL
CACHE_DRIVER
QUEUE_DRIVER
AI_PROVIDER
AI_MODEL
```

---

# 47. Testing Requirement

Every important feature should have tests.

Minimum expectation:

```text
Feature
 ↓
Implementation
 ↓
Test
```

Testing details are defined in:

```text
TESTING.md
```

---

# 48. Test Data

Tests should use isolated test data.

Tests must not modify production data.

---

# 49. Educational Accuracy

Educational features require special attention.

For:

* Questions
* Answers
* Formulas
* Notes
* Practicals
* Exam papers

the system should prefer verified sources.

AI-generated educational content must not automatically be considered correct.

---

# 50. Content Review

AI-generated content intended for permanent publication should follow:

```text
AI Generation
 ↓
Validation
 ↓
Human Review where required
 ↓
Approval
 ↓
Publication
```

---

# 51. Academic Integrity

The platform should promote learning.

Features such as:

* AI Tutor
* Writing Assistant
* Coding Assistant
* Cheat-Sheet Builder

should be designed to support understanding rather than academic dishonesty.

---

# 52. Student Experience

Development should always consider the student's journey.

Example:

```text
Learn
 ↓
Practice
 ↓
Make Mistakes
 ↓
Understand Mistakes
 ↓
Revise
 ↓
Practice Again
 ↓
Test
 ↓
Improve
```

---

# 53. Feature Completion Definition

A feature is not complete simply because the UI works.

Definition of Done:

```text
[ ] Requirement implemented
[ ] Database changes complete
[ ] Backend complete
[ ] API complete
[ ] Frontend complete
[ ] Validation implemented
[ ] Authorization implemented
[ ] Tests written
[ ] Security reviewed
[ ] Documentation updated
[ ] No known critical errors
```

---

# 54. Documentation Rule

Important architectural decisions must be documented.

Documentation should be updated when:

* Architecture changes
* API changes
* Database changes
* Security changes
* Deployment changes
* Major AI features are introduced

---

# 55. No Undocumented Architecture Changes

Developers should not silently introduce:

* New databases
* New frameworks
* New authentication systems
* New major dependencies
* New infrastructure

without documenting the reason.

---

# 56. Database Change Rule

Any structural database change must include:

```text
Migration
 ↓
Model Update
 ↓
Validation
 ↓
Tests
 ↓
Documentation
```

---

# 57. API Change Rule

When API behavior changes:

```text
Backend Change
 ↓
API Documentation
 ↓
Tests
 ↓
Frontend Update
```

All breaking changes must be handled carefully.

---

# 58. Frontend/API Contract

Frontend developers should not assume API behavior.

The API specification should be the contract.

```text
API.md
   ↓
Backend
   ↓
Frontend
```

---

# 59. Security Rule

Security-sensitive code should be reviewed carefully.

Especially:

* Authentication
* Authorization
* Payments
* File uploads
* Code execution
* AI access
* Admin functions
* Student data

---

# 60. Performance Rule

Do not optimize blindly.

First identify the problem:

```text
Measure
 ↓
Identify Bottleneck
 ↓
Optimize
 ↓
Measure Again
```

---

# 61. Scalability Rule

Build for future growth but avoid premature complexity.

The architecture should allow future:

* Android App
* iOS App
* More students
* More schools
* More teachers
* More AI features
* More content
* More media
* More traffic

without requiring a complete rewrite.

---

# 62. WordPress Integration Rule

The application must not directly depend on WordPress's internal database tables unless there is a documented architectural reason.

Prefer controlled interfaces such as:

```text
REST API
Webhooks
Content Synchronization
```

---

# 63. Media Integration

For large media such as educational videos, the platform should avoid unnecessary duplication.

Possible providers:

```text
YouTube
CDN
Object Storage
Streaming Service
```

The architecture should remain provider-independent where practical.

---

# 64. Internet Radio Development

The radio system should be treated as a separate media service.

Conceptually:

```text
Radio Source
 ↓
Streaming Server
 ↓
CDN / Public Stream
 ↓
Aspirian App
```

Administrative controls must remain protected.

---

# 65. YouTube Live Integration

YouTube Live can be integrated for educational broadcasts.

The application may provide:

* Live status
* Program information
* Embedded player
* Schedule
* Notifications

Private API credentials must remain server-side.

---

# 66. Logging and Monitoring

Production systems should be observable.

Monitor:

* Errors
* API latency
* Database performance
* Queue failures
* AI failures
* Server resources
* Authentication anomalies

---

# 67. Production Safety

Never perform experimental changes directly on production.

Preferred:

```text
Development
 ↓
Testing
 ↓
Staging
 ↓
Production
```

---

# 68. Rollback

Every production deployment should have a rollback strategy.

Possible rollback mechanisms:

* Previous application version
* Database migration rollback where safe
* Configuration rollback
* Deployment versioning

---

# 69. Backups

Before important production changes:

```text
Backup
 ↓
Deploy
 ↓
Verify
```

Backups must be tested periodically.

---

# 70. Code Quality

Code should prioritize:

```text
Readable
Simple
Maintainable
Testable
Secure
```

over clever or unnecessarily complex implementations.

---

# 71. Avoid Premature Abstraction

Do not create complicated abstractions before they are needed.

Prefer simple code that can evolve cleanly.

---

# 72. Reusability

Reusable functionality should be extracted when there is a real pattern.

Examples:

```text
QuestionCard
QuizTimer
Pagination
API Client
Notification Component
```

---

# 73. Internationalization

The architecture should allow future multilingual support.

Potential languages:

```text
English
Urdu
Roman Urdu
```

The implementation should avoid hard-coding user-facing text throughout business logic.

---

# 74. Localization

Future localization may include:

* Language
* Date format
* Number format
* Academic terminology

---

# 75. Accessibility and Younger Students

Because the platform supports Nursery → Class 12:

Interfaces should consider:

* Simple navigation
* Large readable controls
* Clear instructions
* Visual feedback
* Age-appropriate interaction

---

# 76. Mobile Considerations

Students may access the platform primarily through mobile devices.

Therefore:

* Pages should load efficiently
* Touch targets should be usable
* Forms should be simple
* Videos should adapt to mobile
* Tests should work reliably on mobile

---

# 77. Offline Capability

Future versions may support limited offline functionality.

Potential features:

* Downloaded notes
* Saved questions
* Offline practice
* Cached content

Offline architecture will be documented when implementation begins.

---

# 78. Feature Flags

Large or experimental features may use feature flags.

Example:

```text
AI_VIVA_ENABLED=true
VIDEO_QUIZ_ENABLED=false
```

This allows controlled rollout.

---

# 79. Experimental Features

Experimental features should not automatically become production defaults.

Lifecycle:

```text
Experimental
 ↓
Internal Testing
 ↓
Beta
 ↓
Production
```

---

# 80. Documentation Hierarchy

The repository documentation should remain organized.

Core documents include:

```text
README.md
PROJECT_SPEC.md
ARCHITECTURE.md
DATABASE.md
API.md
AI_ARCHITECTURE.md
SECURITY.md
DEVELOPMENT_GUIDELINES.md
TESTING.md
DEPLOYMENT.md
CHANGELOG.md
```

---

# 81. Change Management

Major changes should be recorded in:

```text
CHANGELOG.md
```

Examples:

* New modules
* API changes
* Database changes
* Security changes
* AI features
* Infrastructure changes

---

# 82. Development Workflow

Standard workflow:

```text
1. Read Documentation
        ↓
2. Understand Requirement
        ↓
3. Plan
        ↓
4. Create Branch
        ↓
5. Implement
        ↓
6. Test
        ↓
7. Security Review
        ↓
8. Documentation
        ↓
9. Commit
        ↓
10. Push
```

---

# 83. AI-Assisted Development Workflow

When using an AI coding assistant:

```text
Requirement
 ↓
Give AI Repository Context
 ↓
Ask for Plan
 ↓
Review Plan
 ↓
Implement Small Step
 ↓
Review Code
 ↓
Run Tests
 ↓
Fix Problems
 ↓
Commit
```

Never ask an AI tool to blindly rewrite the entire project.

---

# 84. Repository Context for AI Tools

AI coding assistants should be instructed to read relevant documentation before making architectural changes.

At minimum:

```text
PROJECT_SPEC.md
ARCHITECTURE.md
DATABASE.md
API.md
AI_ARCHITECTURE.md
SECURITY.md
DEVELOPMENT_GUIDELINES.md
```

---

# 85. Development Rule for Future Contributors

Before modifying a module:

```text
Read
 ↓
Understand
 ↓
Modify
 ↓
Test
 ↓
Document
```

Do not modify code simply because an AI tool suggests a change.

---

# 86. Final Engineering Principle

> **Every line of code should serve a clear requirement, respect the architecture, protect the student, and remain understandable to the next developer.**

---

# 87. Document Status

**Version:** 1.0
**Status:** Technical Design Blueprint

This document will evolve as the platform moves from architecture into implementation.
