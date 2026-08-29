# Aspirian Student Platform — School Administration

**Version:** 1.0
**Status:** Final School Administration System Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

The School Administration module provides schools with a dedicated administrative environment for managing their complete academic ecosystem inside the Aspirian Student Platform.

The module connects:

```text
School
├── Administrators
├── Teachers
├── Students
├── Parents
├── Classes
├── Sections
├── Subjects
├── Curriculum
├── Tests
├── Results
├── Assignments
├── Learning Progress
├── Content
├── AI Services
├── Notifications
└── Analytics
```

---

# 2. Vision

The School Admin Panel should become a school's centralized digital education management center.

```text
                         SCHOOL ADMIN
                              ↓
              ┌───────────────┼───────────────┐
              ↓               ↓               ↓
            USERS          ACADEMICS        CONTENT
              ↓               ↓               ↓
       Students/Teachers   Classes/Tests    Notes/Media
              └───────────────┼───────────────┘
                              ↓
                         PERFORMANCE
                              ↓
                           ANALYTICS
                              ↓
                         AI SERVICES
```

---

# 3. School Administration URL

Recommended route:

```text
app.aspirian.pk/school
```

The exact production route may be changed for security reasons.

---

# 4. School Admin Roles

The platform should support multiple school-level roles.

```text
School Owner
School Administrator
Principal
Vice Principal
Academic Coordinator
Exam Coordinator
Content Coordinator
Teacher Coordinator
School Accountant
School Support Staff
```

Permissions must be configurable.

---

# 5. School Tenant

Each school operates inside an isolated tenant.

```text
PLATFORM
   │
   ├── SCHOOL A
   │     ├── Users
   │     ├── Classes
   │     └── Academic Data
   │
   ├── SCHOOL B
   │     ├── Users
   │     ├── Classes
   │     └── Academic Data
   │
   └── SCHOOL C
         ├── Users
         ├── Classes
         └── Academic Data
```

A school must never access another school's private data.

---

# 6. School Dashboard

The dashboard provides an overview of school activity.

Possible KPIs:

```text
Total Students
Total Teachers
Total Parents
Total Classes
Active Students
Active Teachers
Tests Completed
Assignments
Average Performance
AI Usage
Content Usage
```

---

# 7. School Profile

School administrators can manage:

```text
School Name
School Code
Logo
Address
Contact Information
Email
Phone
Website
Academic Session
Timezone
Language
```

---

# 8. School Status

Possible states:

```text
Pending
Active
Suspended
Inactive
Archived
```

---

# 9. School Verification

If schools register themselves, the platform may use:

```text
Registration
 ↓
Verification
 ↓
Approval
 ↓
Activation
```

---

# 10. School Admin Account

School administrators can manage:

```text
Profile
Password
MFA
Notifications
Sessions
Security
```

---

# 11. School User Management

School administrators can manage authorized:

```text
Students
Teachers
Parents
School Staff
School Administrators
```

---

# 12. Student Management

School Admin can:

```text
Create Student
Invite Student
Edit Student
Assign Class
Assign Section
Transfer Student
Deactivate Student
```

---

# 13. Student Import

Bulk student import may support:

```text
CSV
Excel
```

with validation before importing.

---

# 14. Student Import Workflow

```text
Upload
 ↓
Validate
 ↓
Preview
 ↓
Confirm
 ↓
Import
 ↓
Import Report
```

---

# 15. Student Data Validation

Validate:

```text
Required Fields
Duplicate Accounts
Class
Section
Student ID
Email Where Applicable
```

---

# 16. Student ID

Schools may define their own internal student identifiers.

Example:

```text
SCH-2026-00001
```

---

# 17. Student Transfer

School administrators may transfer students between:

```text
Classes
Sections
Academic Sessions
```

according to school policy.

---

# 18. Student Withdrawal

A withdrawn student should not have their historical academic records automatically deleted.

---

# 19. Teacher Management

School administrators can:

```text
Create Teacher
Invite Teacher
Assign Teacher
Assign Subject
Assign Class
Deactivate Teacher
```

---

# 20. Teacher Onboarding

```text
Invite Teacher
      ↓
Registration
      ↓
Verification
      ↓
Role Assignment
      ↓
Subject Assignment
      ↓
Class Assignment
      ↓
Active
```

---

# 21. Teacher Assignment

A teacher can be assigned:

```text
Class
Section
Subject
Department
```

---

# 22. Multiple Teachers

A class/subject may have:

```text
Primary Teacher
Assistant Teacher
Co-Teacher
```

where supported.

---

# 23. Parent Management

School Admin can manage parent/guardian accounts.

```text
Create
Invite
Link Student
Unlink Student
Deactivate
```

---

# 24. Parent-Student Relationship

```text
PARENT
  ↓
STUDENT
  ↓
SCHOOL
```

Parent access must be limited to linked students.

---

# 25. Parent Verification

Where required, schools may use verification workflows before granting access to student information.

---

# 26. Staff Management

Future versions may support:

```text
Academic Staff
Administrative Staff
Support Staff
IT Staff
```

---

# 27. Academic Structure

School administrators manage:

```text
Academic Sessions
Classes
Sections
Subjects
Departments
Curriculum
```

---

# 28. Academic Session

Example:

```text
2026–2027
```

A school may have one active academic session and historical sessions.

---

# 29. Class Management

Supported structure:

```text
Nursery
Prep
Class 1
Class 2
...
Class 12
```

---

# 30. Section Management

Example:

```text
Class 9
├── 9-A
├── 9-B
└── 9-C
```

---

# 31. Subject Management

Schools can configure subjects appropriate to their curriculum.

Examples:

```text
English
Urdu
Mathematics
Physics
Chemistry
Biology
Computer Science
Pakistan Studies
Islamiyat
```

---

# 32. Subject Teacher Assignment

Each subject may have one or more assigned teachers.

---

# 33. Department Management

Schools may create departments:

```text
Science
Mathematics
Computer Science
Languages
Humanities
```

---

# 34. Curriculum Management

School administrators may configure:

```text
Syllabus
Chapters
Topics
Learning Objectives
```

---

# 35. Curriculum Mapping

Every academic resource should be mapped where possible to:

```text
Class
Subject
Chapter
Topic
Learning Objective
```

---

# 36. Question Bank

Schools can manage their school-level question bank.

---

# 37. Question Sources

Questions may originate from:

```text
Teacher
School Admin
Platform Content
AI Generator
Imported Content
```

---

# 38. Question Review

School reviewers may:

```text
Review
Edit
Approve
Reject
Publish
Archive
```

---

# 39. Question Ownership

System should distinguish:

```text
Creator
Reviewer
Publisher
School
Platform
```

---

# 40. AI Question Generator

School-authorized users can generate draft questions.

Inputs:

```text
Class
Subject
Chapter
Topic
Difficulty
Question Type
Quantity
```

---

# 41. AI Question Approval

AI-generated questions must not automatically become official examination content.

Workflow:

```text
AI Generated
 ↓
Teacher Review
 ↓
School Review Where Required
 ↓
Approved
 ↓
Published
```

---

# 42. Test Management

School administrators can manage:

```text
Class Tests
Quizzes
Unit Tests
Mid-Term Exams
Final Exams
Mock Exams
Practice Tests
```

---

# 43. Test Configuration

```text
Title
Class
Section
Subject
Duration
Marks
Question Distribution
Start Time
End Time
Attempts
```

---

# 44. School Examination Workflow

```text
Paper Preparation
       ↓
Review
       ↓
Approval
       ↓
Scheduling
       ↓
Exam
       ↓
Results
       ↓
Analytics
```

---

# 45. Examination Security

Possible controls:

```text
Attempt Limits
Time Limits
Question Randomization
Option Randomization
Access Control
Exam Window
```

---

# 46. Paper Builder

School administrators and authorized teachers may create papers using:

```text
Question Bank
Teacher Questions
AI-Generated Questions
Imported Questions
```

---

# 47. AI Paper Generator

School may generate a draft examination paper using:

```text
Class
Subject
Chapters
Marks
Difficulty
Question Types
```

Human review remains mandatory before official publishing.

---

# 48. Result Management

School administrators can monitor:

```text
Exam Results
Class Results
Subject Results
Student Results
```

---

# 49. Result Dashboard

Possible metrics:

```text
Average Marks
Percentage
Pass Rate
Highest Score
Lowest Score
Question Accuracy
Topic Performance
```

---

# 50. Class Performance

Example:

```text
Class 9-A

Students: 38
Average: 72%
Pass Rate: 89%
Weak Area: Functions
Strong Area: Variables
```

---

# 51. Subject Performance

School administrators can compare academic performance by subject.

---

# 52. Student Performance

Authorized school staff can view student academic progress.

---

# 53. Performance Trends

View progress across:

```text
Tests
Assignments
Chapters
Subjects
Academic Sessions
```

---

# 54. Weak Topic Analysis

The system can identify areas requiring additional support.

---

# 55. Revision Management

School administrators may create school-wide revision programs.

---

# 56. Revision Plans

Plans may include:

```text
Class
Subject
Chapter
Topic
Material
Practice
Test
Deadline
```

---

# 57. AI Revision Engine

Schools may use AI to create:

```text
Revision Notes
Practice Questions
Weak Topic Exercises
Study Plans
```

AI output requires appropriate review.

---

# 58. Assignment Management

Schools may monitor assignments across classes.

---

# 59. Assignment Types

```text
Homework
Worksheet
Project
Essay
Coding Task
Practical Task
Research Task
```

---

# 60. Assignment Analytics

View:

```text
Assigned
Submitted
Pending
Late
Reviewed
Average Marks
```

---

# 61. Practicals

School administrators may manage practical education.

Supported areas:

```text
Computer Practical
Science Practical
Laboratory Work
Projects
```

---

# 62. Practical Assessment

Track:

```text
Activity
Student
Completion
Marks
Teacher Feedback
```

---

# 63. Coding Lab

For computer science schools:

```text
Coding Exercises
Programming Assignments
Code Submission
Test Cases
Results
```

---

# 64. Coding Security

Student code must execute in an isolated sandbox.

It must never execute directly on the production application server.

---

# 65. Flashcards

Schools may create or approve flashcard sets.

```text
Subject
Class
Chapter
Topic
Cards
```

---

# 66. Writing Practice

Schools may provide:

```text
Essay Practice
Letter Writing
Paragraph Writing
Applications
Comprehension
Creative Writing
```

---

# 67. Viva Management

Schools may manage viva activities.

```text
Viva Schedule
Subject
Class
Teacher
Students
Questions
Marks
Feedback
```

---

# 68. AI Viva

AI may provide practice viva sessions.

Official assessment should remain under appropriate school/teacher oversight.

---

# 69. Content Management

Schools can manage educational resources.

Types:

```text
Notes
Study Guides
Worksheets
Lessons
PDFs
Presentations
Videos
Audio
```

---

# 70. Content Workflow

```text
Draft
 ↓
Review
 ↓
Approved
 ↓
Published
```

---

# 71. School Content Visibility

Content may be:

```text
Private to School
Specific Class
Specific Section
Specific Subject
Public
```

depending on permissions.

---

# 72. Media Management

School administrators may manage:

```text
Images
Videos
Audio
Documents
```

---

# 73. Video Lessons

Schools can organize video lessons by:

```text
Class
Subject
Chapter
Topic
Teacher
```

---

# 74. Audio Learning

Supported:

```text
Audio Notes
Revision Audio
Recorded Lessons
Pronunciation Practice
```

---

# 75. Internet Radio

If the school participates in the Aspirian radio ecosystem, authorized administrators may manage school-related broadcasts.

---

# 76. Live Sessions

Schools may schedule educational live sessions.

Possible:

```text
Teacher Lecture
Revision Session
Exam Preparation
Guest Lecture
```

---

# 77. YouTube Live Integration

Where integrated, school administrators can manage approved school live streams.

---

# 78. Notification System

Schools can send:

```text
Announcements
Test Reminders
Assignment Reminders
Exam Notices
Revision Notices
Emergency Notices
```

---

# 79. Notification Audience

```text
Entire School
Class
Section
Teachers
Parents
Students
Selected Users
```

---

# 80. Notification Scheduling

Notifications may be scheduled for a future date/time.

---

# 81. Parent Communication

School administrators can send approved academic communications to parents.

---

# 82. Communication Privacy

Parent communications must only expose information for linked students and authorized school relationships.

---

# 83. Gamification

Schools may configure:

```text
Points
Badges
Achievements
Challenges
Streaks
Rewards
```

---

# 84. School Gamification

School-level achievements can be created without affecting platform-wide rules.

---

# 85. Leaderboards

School leaderboards must respect privacy and school policy.

Possible visibility:

```text
Disabled
Private to Student
Class Only
School-wide
```

---

# 86. Student Engagement

School dashboard can monitor:

```text
Login Activity
Tests
Assignments
Video Learning
Revision
Flashcards
AI Usage
```

---

# 87. Learning Analytics

Analytics may include:

```text
Student Engagement
Class Performance
Subject Performance
Chapter Performance
Assessment Performance
```

---

# 88. Teacher Analytics

School administrators may view appropriate teaching activity:

```text
Tests Created
Assignments
Content
Student Engagement
Assessment Activity
```

Analytics should not automatically determine employment decisions.

---

# 89. School Analytics Dashboard

Recommended sections:

```text
Students
Teachers
Classes
Assessments
Performance
Engagement
AI Usage
Content Usage
```

---

# 90. Academic Reports

Reports may include:

```text
Class Report
Student Report
Subject Report
Teacher Report
Exam Report
Progress Report
```

---

# 91. Report Export

Authorized administrators may export:

```text
PDF
CSV
Excel
```

subject to privacy and school policy.

---

# 92. Data Privacy

School administrators must only access data necessary for their role.

---

# 93. Sensitive Data

Sensitive information should have additional access controls.

---

# 94. Role-Based Access Control

Example:

```text
School Admin
 ↓
School Permissions
 ↓
Module Permissions
 ↓
Resource Permissions
```

---

# 95. School Permission Examples

```text
students.view
students.create
students.edit

teachers.view
teachers.assign

questions.review
questions.publish

tests.create
tests.publish

results.view
results.export

reports.view
reports.export
```

---

# 96. School Admin Delegation

School administrators may delegate limited permissions to:

```text
Academic Coordinator
Exam Coordinator
Teacher Coordinator
Content Coordinator
```

---

# 97. Permission Boundaries

Delegated administrators must not automatically inherit full School Admin privileges.

---

# 98. Audit Logs

Important actions must be logged.

Examples:

```text
Student Created
Teacher Assigned
Question Published
Exam Published
Result Changed
User Suspended
Report Exported
```

---

# 99. Audit Log Fields

Conceptually:

```text
Action
Actor
Resource
Resource ID
Timestamp
Security Context
Previous Value Where Appropriate
New Value Where Appropriate
```

---

# 100. School Security

School administration should support:

```text
Strong Authentication
MFA
Session Management
Rate Limiting
Access Control
Audit Logging
```

---

# 101. Active Sessions

Authorized administrators may view and revoke active sessions.

---

# 102. Account Suspension

School Admin may deactivate school users according to school policy and permissions.

---

# 103. Bulk Operations

Supported operations may include:

```text
Bulk Student Import
Bulk Class Assignment
Bulk Notification
Bulk Content Management
Bulk Report Export
```

---

# 104. Bulk Operation Safety

Use:

```text
Validation
Preview
Confirmation
Audit Logging
```

for important bulk operations.

---

# 105. Search

Global school search may cover:

```text
Students
Teachers
Parents
Classes
Questions
Tests
Assignments
Content
Results
```

Only authorized school data should be searchable.

---

# 106. School Calendar

Calendar can display:

```text
Exams
Tests
Assignments
Events
Revision Sessions
Live Classes
```

---

# 107. Scheduling

School administrators may schedule:

```text
Tests
Exams
Assignments
Viva
Revision
Notifications
Live Sessions
```

---

# 108. Academic Year Transition

At the end of an academic session:

```text
Current Session
      ↓
Archive Historical Data
      ↓
Create New Session
      ↓
Promote Students
      ↓
Assign Classes
      ↓
Assign Teachers
```

---

# 109. Student Promotion

Support:

```text
Promote
Repeat
Transfer
Graduate
Withdraw
```

according to school policy.

---

# 110. Promotion Workflow

```text
Review Results
 ↓
Promotion Decision
 ↓
Approve
 ↓
New Class Assignment
 ↓
Academic History Preserved
```

---

# 111. Graduation

Students completing Class 12 may be marked as graduated.

Historical records should remain available according to retention policy.

---

# 112. School Archive

Historical:

```text
Students
Teachers
Classes
Results
Tests
Content
```

should remain appropriately archived.

---

# 113. School Settings

Configure:

```text
School Name
Logo
Timezone
Language
Academic Session
Notification Preferences
Privacy Settings
AI Settings
```

---

# 114. AI Settings

Schools may configure approved AI capabilities:

```text
AI Tutor
Question Generator
Paper Generator
Revision
Viva
Audio Notes
Video Learning
```

---

# 115. AI Enable / Disable

School administrators may enable or disable available AI features according to platform permissions.

---

# 116. AI Usage Limits

Possible controls:

```text
Daily Limit
Monthly Limit
Teacher Limit
Student Limit
School Limit
```

---

# 117. AI Safety

All school AI features must follow:

```text
AI_SAFETY.md
```

including:

```text
Privacy
Safety
Human Review
Data Minimization
Output Validation
Audit Logging
```

---

# 118. AI Data Isolation

School AI requests must remain isolated from other schools.

---

# 119. AI Reporting

School administrators may view:

```text
AI Requests
Usage
Errors
Generated Content
Safety Events
```

subject to permissions.

---

# 120. AI Kill Switch

Authorized administrators may disable AI functionality for the school if necessary.

---

# 121. Media Settings

School may configure approved:

```text
Video
Audio
Radio
Live Streaming
```

features.

---

# 122. Storage

School storage usage may be monitored:

```text
Documents
Images
Audio
Video
Generated Content
```

---

# 123. Storage Limits

School plans may have configurable storage limits.

---

# 124. Subscription Management

If school subscriptions are introduced:

```text
Plan
Subscription
Renewal
Usage
Invoice
Payment
```

may be visible to authorized administrators.

---

# 125. School Plans

Potential platform plans:

```text
Free
Basic
Professional
Enterprise
```

Actual pricing is outside this document.

---

# 126. Feature Entitlements

Plan-based access may control:

```text
Number of Students
Number of Teachers
AI Usage
Storage
Video
Analytics
Advanced Reports
```

---

# 127. Billing Security

Financial information must only be visible to authorized users.

---

# 128. School Support

School administrators can access:

```text
Support Tickets
Technical Issues
Account Issues
AI Issues
Billing Issues
```

---

# 129. Support Ticket

Possible fields:

```text
Ticket ID
Category
Priority
Description
Attachments
Status
```

---

# 130. Ticket Status

```text
Open
In Progress
Waiting
Resolved
Closed
```

---

# 131. System Health

School Admin may see school-relevant service status:

```text
Platform
AI
Media
Notifications
```

but should not receive unrestricted infrastructure access.

---

# 132. Maintenance

Platform maintenance messages should be visible to school administrators.

---

# 133. API Architecture

```text
SCHOOL ADMIN PANEL
        ↓
SCHOOL ADMIN API
        ↓
AUTHORIZATION
        ↓
TENANT VALIDATION
        ↓
SERVICE LAYER
        ↓
DATABASE / AI / MEDIA
```

---

# 134. Server-Side Authorization

All permissions must be enforced on the backend.

Frontend permission checks are not sufficient.

---

# 135. Tenant Validation

Every request must validate:

```text
School
User
Role
Permission
Resource Ownership
```

---

# 136. Data Isolation

School-level APIs must prevent:

```text
School A → School B Data
```

access.

---

# 137. Performance

School Admin should use:

```text
Pagination
Filtering
Indexing
Caching
Background Jobs
```

where appropriate.

---

# 138. Background Jobs

Heavy operations:

```text
Bulk Import
Bulk Export
Large Reports
AI Generation
Media Processing
Mass Notifications
```

should run asynchronously.

---

# 139. Error Handling

The interface should:

```text
Show Clear Error
Preserve Work
Allow Retry
Prevent Duplicate Actions
Log Important Failures
```

---

# 140. Autosave

Important drafts should support autosave where appropriate.

---

# 141. Accessibility

School Admin must support:

```text
Keyboard Navigation
Accessible Forms
Readable Typography
Screen Readers
Clear Error Messages
```

---

# 142. Responsive Design

The interface should work on:

```text
Desktop
Laptop
Tablet
Mobile
```

---

# 143. Localization

Future interface support:

```text
English
Urdu
Roman Urdu
```

---

# 144. Recommended Navigation

```text
Dashboard

School
 ├── School Profile
 ├── Settings
 └── Academic Sessions

Users
 ├── Students
 ├── Teachers
 ├── Parents
 └── Staff

Academics
 ├── Classes
 ├── Sections
 ├── Subjects
 ├── Curriculum
 ├── Question Bank
 ├── Tests
 ├── Exams
 └── Results

Learning
 ├── Assignments
 ├── Revision
 ├── Practicals
 ├── Coding Lab
 ├── Flashcards
 ├── Writing Practice
 └── Viva

AI
 ├── AI Tutor
 ├── Question Generator
 ├── Paper Generator
 ├── Revision
 ├── Viva
 ├── Audio
 ├── Video
 └── Safety

Content
 ├── Notes
 ├── Lessons
 ├── Videos
 └── Audio

Engagement
 ├── Notifications
 └── Gamification

Analytics
Reports

Calendar

Billing

Support

Security
 ├── Roles
 ├── Permissions
 ├── Sessions
 └── Audit Logs
```

---

# 145. Testing

School Administration should be tested for:

```text
Authentication
Authorization
Tenant Isolation
Student Management
Teacher Management
Parent Management
Class Management
Question Management
Test Management
Result Management
AI Integration
Bulk Operations
Reports
```

---

# 146. Security Testing

Test specifically:

```text
School A → School B Access
Unauthorized Teacher Access
Unauthorized Parent Access
Privilege Escalation
Result Modification
Unauthorized Export
Bulk Operation Abuse
```

---

# 147. Data Recovery

Important school data should have recovery mechanisms according to platform backup policy.

---

# 148. Disaster Recovery

School data should remain recoverable after:

```text
Database Failure
Infrastructure Failure
Human Error
Security Incident
```

---

# 149. School Data Retention

Retention policies should define how long:

```text
Student Records
Results
Tests
Assignments
Logs
Content
```

are retained.

---

# 150. Final School Administration Architecture

```text
                         SCHOOL ADMIN
                              ↓
                       AUTH / MFA
                              ↓
                     SCHOOL DASHBOARD
                              ↓
       ┌──────────────────────┼──────────────────────┐
       ↓                      ↓                      ↓
     USERS                 ACADEMICS                AI
       ↓                      ↓                      ↓
 Students / Teachers    Tests / Results       Tutor / Generator
       ↓                      ↓                      ↓
    Parents              Question Bank          AI Safety
       └──────────────────────┼──────────────────────┘
                              ↓
                          CONTENT
                              ↓
                       MEDIA / STREAMING
                              ↓
                         ANALYTICS
                              ↓
                       REPORTS / EXPORT
                              ↓
                       AUDIT / SECURITY
```

---

# 151. Complete School Digital Ecosystem

```text
                         SCHOOL
                           ↓
                    SCHOOL ADMIN
                           ↓
        ┌──────────────────┼──────────────────┐
        ↓                  ↓                  ↓
     TEACHERS           STUDENTS            PARENTS
        ↓                  ↓                  ↓
     TEACHING          LEARNING          MONITORING
        ↓                  ↓                  ↓
     CONTENT             TESTS            REPORTS
        ↓                  ↓                  ↓
       AI              RESULTS           NOTICES
        └──────────────────┼──────────────────┘
                           ↓
                       ANALYTICS
                           ↓
                    BETTER LEARNING
```

---

# 152. Future Expansion

Future versions may include:

```text
Attendance Management
Timetable Management
Fee Management
Transport Management
Library Management
Hostel Management
HR Management
Payroll Integration
Parent-Teacher Meetings
School Website Integration
Mobile School App
Advanced LMS
Digital Certificates
School Marketplace
```

These remain future extensions and should not alter the current core architecture.

---

# 153. Final Design Principles

```text
1. School Data Isolation
2. Student Privacy
3. Role-Based Administration
4. Academic Accuracy
5. Teacher Empowerment
6. Parent Access Control
7. AI With Human Oversight
8. Secure Assessment
9. Complete Auditability
10. Scalable Multi-School Architecture
```

---

# 154. Final Rule

> **School Administration must provide a complete digital management environment for schools while maintaining strict tenant isolation, student privacy, academic integrity, security and human oversight.**

---

# 155. Document Status

**File:** `SCHOOL_ADMIN.md`
**Version:** 1.0
**Status:** Final School Administration System Blueprint
**Phase:** G
**Module:** G3 — School Administration
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official School Administration architecture for the Aspirian Student Platform.
