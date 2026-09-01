# Aspirian Student Platform — API Specification

**Version:** 1.0
**Status:** Initial API Blueprint
**API Domain:** `api.aspirian.pk`
**Application:** `app.aspirian.pk`

---

# 1. API Purpose

The Aspirian Student Platform API provides a secure communication layer between the frontend application and backend services.

```text
Student
   ↓
app.aspirian.pk
   ↓
HTTPS API
   ↓
api.aspirian.pk
   ↓
Business Logic
   ↓
Database / Services
```

The API will provide access to:

* Authentication
* Student profiles
* Academic structure
* Educational content
* Question Bank
* Tests
* Results
* Mistakes
* Personalized Revision
* AI services
* Practicals
* Activities
* Coding
* Media
* Teacher features
* Parent features
* School features
* Notifications
* Subscriptions

---

# 2. API Design Principles

The API should be:

* Secure
* Versioned
* Consistent
* Documented
* Validated
* Testable
* Scalable
* Backward-compatible where practical

---

# 3. Base URL

Production:

```text
https://api.aspirian.pk/api/v1
```

Development:

```text
http://localhost/api/v1
```

The development URL will be finalized according to the local development environment.

---

# 4. API Versioning

Current version:

```text
/api/v1
```

Future breaking changes:

```text
/api/v2
```

Breaking changes should not be silently introduced into an existing API version.

---

# 5. Request Format

Default request format:

```http
Content-Type: application/json
Accept: application/json
```

Example:

```json
{
  "email": "student@example.com",
  "password": "********"
}
```

---

# 6. Response Format

Successful response example:

```json
{
  "success": true,
  "message": "Request successful",
  "data": {}
}
```

Error response example:

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": [
      "The email field is required."
    ]
  }
}
```

The exact response envelope will be standardized before implementation.

---

# 7. HTTP Methods

The API will use standard HTTP methods.

```text
GET     Retrieve data
POST    Create / execute action
PUT     Replace resource
PATCH   Partially update resource
DELETE  Remove resource where permitted
```

---

# 8. Authentication

Authentication endpoints:

```text
POST /auth/register
POST /auth/login
POST /auth/logout
POST /auth/forgot-password
POST /auth/reset-password
POST /auth/verify-email
GET  /auth/me
```

---

# 9. Registration

```text
POST /auth/register
```

Example request:

```json
{
  "name": "Student Name",
  "email": "student@example.com",
  "password": "********"
}
```

The API should validate:

* Name
* Email
* Password
* Duplicate account
* Required fields

---

# 10. Login

```text
POST /auth/login
```

Example:

```json
{
  "email": "student@example.com",
  "password": "********"
}
```

Successful authentication returns the appropriate authentication/session information.

---

# 11. Current User

```text
GET /auth/me
```

Returns the authenticated user's basic account information and roles.

---

# 12. Student Profile

```text
GET   /student/profile
PATCH /student/profile
```

Possible information:

* Name
* Grade
* Board
* Academic session
* Language preference
* Learning preferences

Sensitive information should only be exposed where necessary.

---

# 13. Academic Structure API

## Boards

```text
GET /boards
GET /boards/{board}
```

## Academic Sessions

```text
GET /academic-sessions
```

## Grades

```text
GET /grades
GET /grades/{grade}
```

## Subjects

```text
GET /subjects
GET /subjects/{subject}
```

---

# 14. Academic Hierarchy

The API should allow navigation through:

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
```

Example:

```text
GET /grades/{grade}/subjects
GET /subjects/{subject}/books
GET /books/{book}/chapters
GET /chapters/{chapter}/topics
```

---

# 15. Content API

```text
GET /content
GET /content/{content}
```

Filtering:

```text
GET /content?grade_id=
GET /content?subject_id=
GET /content?chapter_id=
GET /content?topic_id=
GET /content?type=
```

Content may include:

* Notes
* Explanations
* Definitions
* Examples
* Formulas
* Activities
* Practicals
* Revision material

---

# 16. Question Bank API

```text
GET /questions
GET /questions/{question}
```

Filtering:

```text
GET /questions?grade_id=
GET /questions?subject_id=
GET /questions?chapter_id=
GET /questions?topic_id=
GET /questions?difficulty=
GET /questions?type=
```

---

# 17. Question Practice

```text
POST /practice/questions/start
POST /practice/questions/{question}/answer
POST /practice/questions/finish
```

Practice sessions should be tracked separately from formal examinations.

---

# 18. Tests API

```text
GET  /tests
GET  /tests/{test}
POST /tests/{test}/start
POST /tests/{test}/submit
GET  /tests/{test}/result
```

---

# 19. Test Attempt API

```text
GET /attempts/{attempt}
POST /attempts/{attempt}/answer
POST /attempts/{attempt}/submit
GET /attempts/{attempt}/result
```

---

# 20. Results API

```text
GET /results
GET /results/{result}
```

Student-specific filtering:

```text
GET /student/results
```

Possible result data:

* Total marks
* Obtained marks
* Percentage
* Correct answers
* Incorrect answers
* Time spent
* Topic performance

---

# 21. Mistakes Notebook API

```text
GET   /student/mistakes
GET   /student/mistakes/{mistake}
PATCH /student/mistakes/{mistake}
```

The system may automatically create mistake records after incorrect answers.

---

# 22. Personalized Revision API

```text
GET /student/revision
POST /student/revision/{item}/complete
PATCH /student/revision/{item}
```

The revision queue may be generated from:

* Mistakes
* Weak topics
* Spaced revision
* Upcoming exams
* AI recommendations

---

# 23. Topic Mastery API

```text
GET /student/mastery
GET /student/mastery/{topic}
```

Possible information:

```text
mastery_score
confidence_score
attempt_count
correct_count
incorrect_count
last_practiced_at
```

---

# 24. Learning Activity API

```text
POST /student/activity
GET  /student/activity
```

Activity examples:

* Reading
* Watching video
* Taking test
* Practicing questions
* Revision
* Flashcards
* Coding

---

# 25. Recommendations API

```text
GET /student/recommendations
POST /student/recommendations/{recommendation}/complete
```

Recommendations may be generated using rules, analytics, or AI.

---

# 26. Flashcards API

```text
GET /flashcard-decks
GET /flashcard-decks/{deck}
GET /flashcard-decks/{deck}/cards
POST /flashcards/{card}/review
```

---

# 27. Language Lab API

```text
GET /language/vocabulary
GET /language/vocabulary/{word}
GET /language/exercises
POST /language/exercises/{exercise}/submit
```

Future features may include:

* Pronunciation
* Speaking practice
* Grammar
* Vocabulary
* Translation

---

# 28. Writing Practice API

Writing categories:

```text
Essay
Letter
Application
Story
Dialogue
Paragraph
Summary
Report
Notice
Speech
```

Endpoints:

```text
GET /writing
GET /writing/{item}
POST /writing/{item}/submit
```

AI evaluation may be introduced later.

---

# 29. Practicals API

```text
GET /practicals
GET /practicals/{practical}
```

Filtering:

```text
GET /practicals?grade_id=
GET /practicals?subject_id=
GET /practicals?chapter_id=
```

---

# 30. Activities API

```text
GET /activities
GET /activities/{activity}
POST /activities/{activity}/submit
```

Activity types may include:

* Interactive
* Matching
* Drag & Drop
* Simulation
* Problem Solving
* Diagram
* Quiz

---

# 31. Coding Lab API

```text
GET  /coding/problems
GET  /coding/problems/{problem}
POST /coding/problems/{problem}/submit
GET  /coding/submissions/{submission}
```

Code execution must occur inside a secure sandbox.

---

# 32. Media API

```text
GET /media
GET /media/{media}
```

Filtering:

```text
GET /media?type=video
GET /media?type=audio
GET /media?type=live
```

Media may be hosted by:

* YouTube
* External streaming provider
* Aspirian infrastructure

---

# 33. YouTube Live Integration

The platform may expose current live information through:

```text
GET /media/live
```

The API may return:

```json
{
  "is_live": true,
  "title": "Aspirian Live Class",
  "provider": "youtube",
  "video_id": "EXAMPLE_ID"
}
```

The actual YouTube integration details will be documented separately.

---

# 34. Internet Radio API

```text
GET /radio
GET /radio/programs
GET /radio/schedule
GET /radio/current
```

Possible response:

```json
{
  "is_live": true,
  "program": "Aspirian Student Radio",
  "stream_url": "STREAM_REFERENCE"
}
```

Private or sensitive streaming credentials must never be exposed to clients.

---

# 35. Video Quiz API

```text
GET /media/{media}/quiz-markers
POST /media/{media}/quiz/{question}/answer
```

This allows questions to appear at selected points in a video.

---

# 36. AI Tutor API

```text
POST /ai/chat
GET  /ai/conversations
GET  /ai/conversations/{conversation}
```

Example:

```json
{
  "message": "Explain photosynthesis in simple words.",
  "context": {
    "grade_id": "...",
    "subject_id": "...",
    "topic_id": "..."
  }
}
```

The AI service should use relevant educational context whenever available.

---

# 37. AI Question Generator

Teacher/admin functionality:

```text
POST /ai/questions/generate
```

Possible request:

```json
{
  "grade_id": "...",
  "subject_id": "...",
  "topic_id": "...",
  "question_type": "mcq",
  "count": 10
}
```

Generated questions must pass through validation and review before becoming trusted question-bank content.

---

# 38. AI Summary API

```text
POST /ai/summarize
```

Possible outputs:

* Short summary
* Detailed notes
* Key points
* Revision notes

---

# 39. Audio-to-Notes API

```text
POST /ai/audio/transcribe
POST /ai/audio/notes
POST /ai/audio/summary
```

Processing may be asynchronous.

---

# 40. Video-to-Flashcards API

```text
POST /ai/video/flashcards
```

Pipeline:

```text
Video
 ↓
Transcript
 ↓
Key Concepts
 ↓
Flashcards
 ↓
Review
```

---

# 41. Video Quiz Generator API

```text
POST /ai/video/quiz
```

The system may generate:

* MCQs
* Short questions
* Concept questions
* Timestamp-based questions

Generated content must be validated.

---

# 42. Predictive Score API

```text
GET /student/score-forecast
```

Possible output:

```text
Estimated Score
Confidence Range
Strong Topics
Weak Topics
Recommended Actions
```

The forecast must be clearly presented as an estimate, not a guaranteed result.

---

# 43. Teacher Paper Builder API

```text
POST /teacher/papers
GET  /teacher/papers
GET  /teacher/papers/{paper}
PATCH /teacher/papers/{paper}
DELETE /teacher/papers/{paper}
POST /teacher/papers/{paper}/generate
POST /teacher/papers/{paper}/export
```

The Paper Builder may use:

* Question Bank
* Blueprint
* Marks distribution
* Difficulty distribution
* Chapters
* Topics

---

# 44. Teacher Dashboard API

```text
GET /teacher/dashboard
GET /teacher/classes
GET /teacher/students
GET /teacher/results
```

---

# 45. Assignments API

```text
POST /teacher/assignments
GET  /teacher/assignments
GET  /teacher/assignments/{assignment}
PATCH /teacher/assignments/{assignment}
DELETE /teacher/assignments/{assignment}
```

Student:

```text
GET  /student/assignments
POST /student/assignments/{assignment}/submit
```

---

# 46. Parent API

```text
GET /parent/children
GET /parent/children/{student}
GET /parent/children/{student}/progress
GET /parent/children/{student}/results
GET /parent/children/{student}/attendance
```

Parent access must be restricted to authorized children only.

---

# 47. School API

Future school endpoints:

```text
GET  /school
GET  /school/classes
GET  /school/teachers
GET  /school/students
POST /school/classes
POST /school/enrollments
```

School APIs will be expanded when the multi-tenant school platform is implemented.

---

# 48. Notifications API

```text
GET /notifications
POST /notifications/{notification}/read
POST /notifications/read-all
```

---

# 49. Subscription API

```text
GET /plans
GET /subscription
POST /subscription/subscribe
POST /subscription/cancel
```

Payment-provider-specific implementation will be documented separately.

---

# 50. Admin API

Administrative endpoints will be protected by role and permission checks.

Examples:

```text
GET /admin/users
GET /admin/questions
GET /admin/content
GET /admin/reports
GET /admin/audit-logs
```

---

# 51. Pagination

Large collections must use pagination.

Example:

```text
GET /questions?page=1&per_page=20
```

Response may contain:

```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "per_page": 20,
    "total": 100
  }
}
```

---

# 52. Filtering

Filtering should use query parameters.

Example:

```text
/questions?grade_id=9&subject_id=biology&difficulty=medium
```

Filters should be validated by the backend.

---

# 53. Sorting

Example:

```text
GET /questions?sort=created_at&direction=desc
```

Only approved sortable fields should be accepted.

---

# 54. Search

Example:

```text
GET /questions?search=photosynthesis
```

Future semantic search may be exposed through dedicated endpoints if required.

---

# 55. Rate Limiting

Rate limits should be applied especially to:

* Login
* Registration
* Password reset
* AI
* Code execution
* File uploads
* Public APIs

Different endpoints may have different limits.

---

# 56. Authorization

Every protected endpoint must verify:

```text
Authentication
       ↓
User
       ↓
Role
       ↓
Permission
       ↓
Resource Ownership
```

Example:

A student must not be able to access another student's private results simply by changing an ID in the URL.

---

# 57. Resource Ownership

Student-specific resources should verify ownership.

Examples:

```text
/student/mistakes
/student/results
/student/revision
/student/recommendations
```

Teacher and parent resources must follow the same principle.

---

# 58. Validation

All incoming data must be validated server-side.

Validation should include:

* Required fields
* Data types
* Length
* Format
* Allowed values
* Relationships
* Permissions

Frontend validation is useful for UX but is never sufficient for security.

---

# 59. Error Codes

The API should use standard HTTP status codes.

Examples:

```text
200 OK
201 Created
204 No Content
400 Bad Request
401 Unauthorized
403 Forbidden
404 Not Found
409 Conflict
422 Validation Error
429 Too Many Requests
500 Internal Server Error
```

---

# 60. API Security

API security should include:

* HTTPS
* Authentication
* Authorization
* Input validation
* Rate limiting
* Secure headers
* Request logging
* Abuse detection
* Secure file handling

Secrets must never be exposed through API responses.

---

# 61. API Logging

Important API activity should be logged.

Examples:

* Authentication attempts
* Administrative actions
* AI usage
* Code execution
* Content approval
* Question approval
* Subscription actions

Sensitive data should not be unnecessarily written to logs.

---

# 62. API Idempotency

Operations that may be retried should consider idempotency.

Important examples:

* Payment operations
* Test submission
* Subscription actions

This prevents accidental duplicate operations.

---

# 63. Asynchronous APIs

Long-running tasks should return a job reference where appropriate.

Example:

```text
POST /ai/video/flashcards
```

Response:

```json
{
  "success": true,
  "job_id": "JOB-REFERENCE",
  "status": "processing"
}
```

Client can then check:

```text
GET /jobs/{job}
```

---

# 64. File Upload API

Possible endpoint:

```text
POST /files
```

Supported files may include:

* Images
* PDFs
* Audio
* Documents

Uploads must be:

* Validated
* Size-limited
* Virus/malware scanned where appropriate
* Access-controlled

---

# 65. API Documentation

The final implementation should generate machine-readable API documentation.

Preferred standard:

**OpenAPI**

Possible documentation:

```text
/api/docs
```

The exact documentation UI will be selected during implementation.

---

# 66. API Testing

Each important endpoint should have automated tests.

Testing levels:

```text
Unit Tests
    ↓
Feature Tests
    ↓
API Tests
    ↓
Integration Tests
    ↓
End-to-End Tests
```

Critical flows such as authentication and test submission require strong test coverage.

---

# 67. API Deprecation

When an API version becomes obsolete:

```text
Active
  ↓
Deprecated
  ↓
Migration Period
  ↓
Retired
```

Clients should receive appropriate deprecation information before removal.

---

# 68. API Performance

API performance should be monitored.

Potential optimizations:

* Database indexes
* Caching
* Pagination
* Query optimization
* Eager loading
* Background jobs
* Response compression

---

# 69. API Architecture

Final conceptual structure:

```text
                    Frontend
                       │
                       ▼
                 API Gateway /
                Reverse Proxy
                       │
                       ▼
                  Laravel API
                       │
        ┌──────────────┼──────────────┐
        │              │              │
        ▼              ▼              ▼
   Application      AI Layer       Media Layer
     Modules
        │
        ▼
    PostgreSQL
        │
        ├── Redis
        ├── Object Storage
        └── Search
```

---

# 70. Initial API Scope

The first development phase should focus on:

```text
Authentication
Student Profile
Academic Structure
Subjects
Chapters
Topics
Question Bank
Practice
Tests
Test Attempts
Results
Mistakes
Revision
Learning Activity
```

AI, teachers, parents, schools, media intelligence, subscriptions, and advanced analytics will be introduced progressively.

---

# 71. API Development Rule

No frontend feature should be considered complete until:

```text
Database
   ↓
Backend Logic
   ↓
API
   ↓
Validation
   ↓
Authorization
   ↓
Frontend
   ↓
Testing
```

has been properly implemented.

---

# 72. API Status

**File:** `API.md`
**Phase:** B
**Module:** B2 — API Design

**Version:** 1.0
**Status:** Initial API Blueprint

This document defines the planned API architecture and endpoint structure.

Exact request/response schemas, authentication implementation, validation rules, and OpenAPI definitions will be finalized during implementation.

---

# Final Principle

> **The API is the contract between Aspirian's applications and its backend.**

The API should remain predictable, secure, documented, and versioned so that the same backend can eventually serve:

* Web Application
* Android App
* iOS App
* Teacher Platform
* Parent Platform
* School Platform
* Future Aspirian applications
