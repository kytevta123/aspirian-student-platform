# Aspirian Student Platform — Parent Module

**Version:** 1.0
**Status:** Final Parent Module Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the functional architecture of the Parent Module for the Aspirian Student Platform.

The Parent Module provides parents and authorized guardians with a secure environment to monitor and support the educational journey of their children.

The module may provide:

* Parent identity
* Child/student linking
* Student overview
* Academic information
* Learning progress
* Assessment results
* Attendance information
* Teacher communication
* School communication
* Notifications
* Educational resources
* AI-assisted parent insights
* Reports
* Parent profile and settings

The Parent Module does not replace the underlying Student, Teacher, Assessment, Learning, Analytics or School domains.

---

# 2. Parent Module Principle

The Parent Module provides parents with a clear view of authorized student information.

```text
PARENT IDENTITY
       ↓
AUTHORIZED CHILD LINK
       ↓
STUDENT CONTEXT
       ↓
ACADEMIC INFORMATION
       ↓
LEARNING + ASSESSMENTS
       ↓
PROGRESS + INSIGHTS
       ↓
PARENT ACTION
```

---

# 3. Parent Identity

Every parent or guardian must have a unique platform identity.

The authoritative user structure is defined in:

```text
USER_DATA_MODEL.md
```

Authentication is defined in:

```text
AUTH_MODULE.md
```

The Parent Module must reference the authenticated user rather than create a separate authentication system.

---

# 4. Parent Profile

A parent profile may contain:

```text
Parent ID
User ID
Name
Profile Photo
Email
Phone
Preferred Language
Account Status
```

Only required information should be collected.

---

# 5. Parent / Guardian Relationship

A parent must only access students who are explicitly linked through an authorized relationship.

```text
PARENT
   ↓
AUTHORIZED RELATIONSHIP
   ↓
STUDENT
```

The relationship must be validated by the platform.

---

# 6. Multiple Children

One parent may be linked to multiple students.

Example:

```text
PARENT
 ├── Child A
 ├── Child B
 └── Child C
```

The parent dashboard should allow switching between authorized children.

---

# 7. Multiple Parents

A student may have multiple authorized parents or guardians.

Example:

```text
          STUDENT
         /       \
        ↓         ↓
   PARENT A    PARENT B
```

Each parent's access must be independently authorized.

---

# 8. Relationship Types

The platform may support relationship types such as:

```text
Parent
Guardian
Other Authorized Guardian
```

Exact relationship terminology may be configurable by deployment.

---

# 9. Relationship Status

Possible relationship states:

```text
PENDING
ACTIVE
SUSPENDED
REVOKED
```

Only active relationships should normally provide student access.

---

# 10. Parent Dashboard

The Parent Dashboard is the primary parent-facing interface.

Possible dashboard components:

```text
Children
Academic Overview
Learning Progress
Recent Results
Upcoming Assessments
Attendance
Teacher Updates
School Announcements
Notifications
Recommendations
```

---

# 11. Parent Dashboard Architecture

```text
PARENT LOGIN
      ↓
PARENT DASHBOARD
      ├── Children
      ├── Academic Overview
      ├── Learning
      ├── Results
      ├── Attendance
      ├── Teachers
      ├── Notifications
      └── Settings
```

---

# 12. Child Selection

For parents with multiple children:

```text
PARENT
 ↓
CHILD SELECTOR
 ↓
SELECT CHILD
 ↓
CHILD DASHBOARD
```

The active child context should always be clearly visible.

---

# 13. Student Overview

Parents may view an authorized child's basic academic overview.

Possible information:

```text
Student Name
Class
Section
School
Academic Session
Subjects
Enrollment Status
```

---

# 14. Academic Context

The student's academic context may include:

```text
Board
School
Campus
Class
Section
Academic Session
Subjects
Group / Stream
```

Academic structure is defined in:

```text
EDUCATION_STRUCTURE.md
```

---

# 15. Academic History

Where authorized, parents may view historical academic information.

Example:

```text
2024–25 → Class 7
2025–26 → Class 8
2026–27 → Class 9
```

Historical records must remain associated with the correct academic session.

---

# 16. Subject Overview

Parents may view their child's subjects.

Example:

```text
Mathematics
English
Physics
Chemistry
Biology
Computer Science
```

Actual subjects depend on academic context.

---

# 17. Learning Progress

Parents may view authorized learning progress.

Possible information:

```text
Subject Progress
Chapter Progress
Topic Progress
Learning Activity
Completion
Assessment Performance
```

The authoritative learning model is:

```text
LEARNING_PROGRESS_MODEL.md
```

---

# 18. Progress Dashboard

Example:

```text
Mathematics
████████░░ 80%

English
███████░░░ 70%

Biology
██████░░░░ 60%
```

Progress percentages are indicators and should not automatically be interpreted as mastery.

---

# 19. Chapter Progress

Parents may view chapter-level progress where enabled.

```text
SUBJECT
 ↓
CHAPTER
 ↓
TOPICS
 ↓
LEARNING ACTIVITIES
```

---

# 20. Learning Activity

Parents may see high-level learning activity such as:

```text
Lessons Completed
Practice Completed
Tests Attempted
Learning Time
Recent Activity
```

Detailed activity visibility should follow privacy and age policies.

---

# 21. Assessment Overview

Parents may view authorized assessments.

Examples:

```text
Quiz
Class Test
Chapter Test
Subject Test
Mock Exam
Exam
```

Assessment architecture is defined in:

```text
ASSESSMENT_MODEL.md
```

---

# 22. Assessment Results

Parents may view results when they are authorized and available.

Possible information:

```text
Assessment
Score
Percentage
Date
Subject
Performance
```

---

# 23. Result Visibility

Parents should only see results that the student/school/platform has made available to the parent role.

Possible result states:

```text
AVAILABLE
PENDING
REVIEWING
RESTRICTED
```

---

# 24. Performance Trends

The Parent Module may display performance trends.

Example:

```text
Assessment 1 → 62%
Assessment 2 → 68%
Assessment 3 → 74%
```

Trend data should come from authoritative assessment and analytics systems.

---

# 25. Subject Performance

Parents may view performance by subject.

Possible information:

```text
Average Score
Recent Score
Progress Trend
Assessment Completion
```

---

# 26. Attendance Integration

If connected to the school attendance system, parents may view:

```text
Present
Absent
Leave
Attendance Percentage
```

Attendance remains a separate domain.

---

# 27. Attendance Alerts

The platform may notify parents about relevant attendance events.

Example:

```text
"Your child's attendance has fallen below the configured threshold."
```

Thresholds should be configurable by school policy.

---

# 28. Teacher Information

Parents may view authorized teacher information relevant to their child.

Possible information:

```text
Teacher Name
Subject
Class
School
```

Private teacher information should not be exposed.

---

# 29. Teacher Communication

Where enabled, parents may communicate with authorized teachers.

```text
PARENT
 ↓
AUTHORIZED TEACHER
 ↓
MESSAGE
```

Communication must remain within the student's academic context.

---

# 30. Parent-Teacher Communication Rules

The system should enforce:

```text
Authorized Relationship
School Scope
Student Scope
Communication Permission
```

Parents should not be able to message unrelated teachers or students.

---

# 31. School Communication

Parents may receive official school communications.

Examples:

```text
School Announcement
Exam Notice
Holiday Notice
Event Notice
Academic Update
```

---

# 32. Parent Notifications

Parents may receive notifications for:

```text
Assessment Result
Attendance Event
Teacher Message
School Announcement
Learning Update
Important Academic Event
```

---

# 33. Notification Preferences

Parents may configure appropriate notification categories:

```text
Learning
Assessments
Results
Attendance
Teacher
School
System
```

Critical school notifications may remain mandatory.

---

# 34. Educational Resources

Parents may access selected educational resources to support their children.

Examples:

```text
Study Notes
Learning Guides
Videos
Practice Material
Exam Preparation
Parent Guides
```

---

# 35. Resource Recommendations

The platform may recommend resources based on authorized student context.

Example:

```text
Child's Subject
+
Learning Progress
+
Assessment Performance
↓
Recommended Resource
```

Recommendations should not expose unnecessary student information.

---

# 36. Parent AI Assistant

The platform may provide an AI assistant designed for parent support.

Possible capabilities:

```text
Explain Student Progress
Explain Assessment Results
Suggest Study Support
Explain Educational Terms
Suggest Study Routine
```

---

# 37. Parent AI Context

Where authorized, AI may receive limited context such as:

```text
Student Class
Subject
Learning Progress
Assessment Summary
```

Only the minimum required data should be shared.

---

# 38. AI Privacy

Parent AI functionality must respect:

```text
Parent Authorization
Student Privacy
School Policies
Data Minimization
AI Data Controls
```

Parents must not gain access to data merely because an AI assistant exists.

---

# 39. AI-Generated Insights

The system may provide insights such as:

```text
"Your child has completed most of the current Biology chapter."
```

Insights should be based on available evidence.

---

# 40. AI Safety

AI-generated educational guidance should be presented as assistance rather than professional or institutional authority.

Parents should be encouraged to contact teachers or school staff for matters requiring human judgment.

---

# 41. Learning Recommendations

The Parent Module may present supportive recommendations.

Examples:

```text
Encourage Revision
Practice Weak Topic
Review Missed Assessment
Complete Pending Activity
```

Recommendations should avoid stigmatizing language.

---

# 42. Student Strengths

The platform may highlight areas where a student is performing well.

Example:

```text
Strong performance in Mathematics practice.
```

This should be based on measurable learning data.

---

# 43. Possible Learning Gaps

The platform may identify possible areas needing attention.

```text
PERFORMANCE DATA
       ↓
ANALYTICS
       ↓
POSSIBLE LEARNING GAP
       ↓
PARENT INSIGHT
```

A learning-gap signal should not be treated as a diagnosis or permanent label.

---

# 44. Parent Reports

Parents may access reports such as:

```text
Academic Summary
Assessment Summary
Learning Progress
Attendance Summary
Subject Performance
```

---

# 45. Report Privacy

Reports must only contain information the parent is authorized to view.

The platform should not expose:

```text
Other Students
Other Families
Private Teacher Data
Unauthorized School Data
```

---

# 46. Report Export

Where permitted, parents may export selected reports.

Possible formats:

```text
PDF
CSV
XLSX
```

Export permissions must be controlled.

---

# 47. Parent Calendar

Future functionality may provide a calendar containing:

```text
Assessments
Exams
Assignments
School Events
Important Dates
```

---

# 48. Upcoming Events

The parent dashboard may display:

```text
Upcoming Test
Upcoming Exam
Assignment Deadline
School Event
Teacher Meeting
```

---

# 49. Student Schedule

Where school scheduling is integrated, parents may view their child's authorized schedule.

---

# 50. Parent Study Support

The platform may provide parent-facing guidance such as:

```text
How to support home study
How to review progress
How to encourage revision
How to use learning resources
```

---

# 51. Parent Activity

The system may track relevant parent actions for security and analytics.

Examples:

```text
Login
Child Selected
Result Viewed
Report Downloaded
Teacher Contacted
Notification Opened
```

Sensitive activity tracking must follow privacy policy.

---

# 52. Parent Security

Parent accounts must be protected by:

```text
Authentication
Authorization
Session Security
Rate Limiting
MFA Where Appropriate
Audit Logging
```

Authentication is defined in:

```text
AUTH_MODULE.md
```

---

# 53. Parent Authorization

Every student-data request must validate:

```text
Authenticated Parent
       ↓
Parent-Student Relationship
       ↓
Relationship Status
       ↓
Requested Data Permission
       ↓
Access Granted / Denied
```

---

# 54. Authorization Boundary

A parent must not be able to access another student's information by changing an ID in a URL or API request.

Example:

```text
GET /students/123
```

must verify that student `123` is actually authorized for the requesting parent.

---

# 55. Parent School Scope

Where required, parent access may also be scoped through the student's school relationship.

```text
PARENT
 ↓
STUDENT
 ↓
SCHOOL
 ↓
AUTHORIZED DATA
```

---

# 56. Multiple School Context

If children attend different schools:

```text
PARENT
 ├── Child A → School A
 └── Child B → School B
```

The platform must maintain separate academic contexts.

---

# 57. Parent Dashboard Data Flow

```text
PARENT
 ↓
AUTHENTICATION
 ↓
PARENT IDENTITY
 ↓
AUTHORIZED CHILDREN
 ↓
SELECT CHILD
 ↓
STUDENT CONTEXT
 ↓
LEARNING + ASSESSMENTS + ATTENDANCE
 ↓
ANALYTICS
 ↓
PARENT DASHBOARD
```

---

# 58. Parent Learning Flow

```text
PARENT
 ↓
SELECT CHILD
 ↓
VIEW SUBJECT
 ↓
VIEW PROGRESS
 ↓
VIEW PERFORMANCE
 ↓
VIEW RECOMMENDATIONS
```

---

# 59. Parent Assessment Flow

```text
PARENT
 ↓
SELECT CHILD
 ↓
ASSESSMENTS
 ↓
SELECT RESULT
 ↓
VIEW PERFORMANCE
```

---

# 60. Parent Communication Flow

```text
PARENT
 ↓
SELECT CHILD
 ↓
SELECT AUTHORIZED TEACHER
 ↓
MESSAGE
 ↓
TEACHER
```

---

# 61. Parent Notification Flow

```text
PLATFORM EVENT
      ↓
NOTIFICATION SERVICE
      ↓
PARENT
      ↓
NOTIFICATION
```

Only relevant and authorized notifications should be delivered.

---

# 62. Parent Analytics Flow

```text
STUDENT ACTIVITY
       ↓
LEARNING / ASSESSMENT DATA
       ↓
ANALYTICS
       ↓
PARENT-SAFE INSIGHT
       ↓
PARENT DASHBOARD
```

---

# 63. Parent Module and Student Module

The relationship is:

```text
PARENT
   ↓
AUTHORIZED CHILD
   ↓
STUDENT MODULE
   ↓
STUDENT DATA
```

The Parent Module consumes authorized student information rather than duplicating student records.

---

# 64. Parent Module and Teacher Module

```text
PARENT
   ↕
AUTHORIZED COMMUNICATION
   ↕
TEACHER
```

Communication must be governed by relationship and school policies.

---

# 65. Parent Module and Assessment

```text
STUDENT
 ↓
ASSESSMENT
 ↓
RESULT
 ↓
AUTHORIZED PARENT VIEW
```

---

# 66. Parent Module and Learning Progress

```text
STUDENT LEARNING
       ↓
PROGRESS
       ↓
AUTHORIZED PARENT VIEW
```

---

# 67. Parent Module and Analytics

```text
LEARNING + ASSESSMENT EVENTS
       ↓
ANALYTICS
       ↓
PARENT-SAFE METRICS
       ↓
PARENT DASHBOARD
```

---

# 68. Parent Module and AI

```text
PARENT
 ↓
AI ASSISTANT
 ↓
AUTHORIZED STUDENT CONTEXT
 ↓
AI PROCESSING
 ↓
PARENT-SAFE RESPONSE
```

---

# 69. Parent Module and Media

Parents may receive links to authorized educational media.

```text
MEDIA
 ↓
STUDENT LEARNING
 ↓
PARENT RECOMMENDATION
```

---

# 70. Parent Events

The module may emit events such as:

```text
PARENT_LOGIN
CHILD_SELECTED
RESULT_VIEWED
REPORT_VIEWED
REPORT_EXPORTED
TEACHER_MESSAGE_SENT
NOTIFICATION_OPENED
```

Relevant events may feed Analytics and Audit systems.

---

# 71. Parent Audit

Important actions should be auditable.

Examples:

```text
Student Record Viewed
Result Viewed
Report Exported
Teacher Contacted
Account Permission Changed
```

---

# 72. Parent Privacy

The Parent Module must follow strict student privacy principles.

Parents should only see information necessary for their authorized educational relationship.

---

# 73. Student Privacy Boundary

Parent access does not automatically provide access to every piece of student data.

The platform may restrict:

```text
Private Student Notes
Teacher Internal Notes
Administrative Data
AI Internal Data
Security Data
Other Students' Information
```

---

# 74. Child Age Considerations

The platform should support age-appropriate privacy and access controls.

Younger students may require stronger parental/school controls than older students.

Exact policies should be configurable according to deployment requirements.

---

# 75. Parent Account Lifecycle

Conceptual lifecycle:

```text
ACCOUNT CREATED
       ↓
VERIFIED
       ↓
STUDENT LINKED
       ↓
ACTIVE
       ↓
RELATIONSHIP UPDATED
       ↓
INACTIVE / REVOKED
```

---

# 76. Parent Onboarding

Parent onboarding may include:

```text
Account Creation
Identity Verification
Student Linking
Relationship Verification
Profile Setup
Security Setup
Notification Setup
```

---

# 77. Student Linking

Possible linking methods may include:

```text
School Invitation
Verification Code
Authorized School Process
Admin Approval
```

The final mechanism can depend on deployment.

---

# 78. Parent Relationship Verification

The platform should prevent unauthorized users from claiming a student.

```text
PARENT REQUEST
       ↓
VERIFICATION
       ↓
SCHOOL / SYSTEM VALIDATION
       ↓
RELATIONSHIP ACTIVE
```

---

# 79. Relationship Revocation

If authorization ends:

```text
RELATIONSHIP REVOKED
       ↓
STUDENT ACCESS REMOVED
       ↓
AUDIT RECORD PRESERVED
```

---

# 80. Parent Performance Summary

A parent summary may include:

```text
Overall Learning Activity
Assessment Summary
Attendance
Subject Progress
Recent Achievements
Upcoming Events
```

The summary should remain concise and actionable.

---

# 81. Parent Alerts

Important alerts may include:

```text
Missed Assessment
Low Attendance
Pending Assignment
New Result
Important School Notice
```

Alert thresholds should be configurable.

---

# 82. Parent Achievements View

Where the student platform supports achievements, parents may view selected achievements.

Examples:

```text
Chapter Completed
Practice Milestone
Learning Streak
Assessment Milestone
```

---

# 83. Parent Support Notifications

The system may notify parents when a child reaches a meaningful learning milestone.

Example:

```text
"Your child completed Chapter 4 Mathematics."
```

Notifications should avoid excessive messaging.

---

# 84. Parent Experience Principle

The Parent Module should prioritize:

> **Clarity, trust, student privacy, meaningful progress information and constructive parental support.**

Parents should receive useful information without being overwhelmed by technical or unnecessary data.

---

# 85. Performance

Parent dashboards should use efficient data retrieval.

The system should use:

```text
Pagination
Caching
Aggregated Metrics
Efficient Queries
Lazy Loading
```

where appropriate.

---

# 86. Scalability

The Parent Module should support:

```text
1 Parent → 1 Child
1 Parent → Multiple Children
Large School Population
Multiple Schools
Large Platform Population
```

---

# 87. Accessibility

Parent interfaces should support:

```text
Readable Typography
Keyboard Navigation
Accessible Forms
Screen Reader Support
Responsive Design
Mobile-Friendly Interface
```

---

# 88. Mobile Experience

The Parent Module should be usable on:

```text
Desktop
Laptop
Tablet
Android
iOS
```

Mobile access is particularly important for notifications and progress monitoring.

---

# 89. Error Handling

Parent-facing errors should be simple and safe.

Examples:

```text
Student information is unavailable.
You are not authorized to access this student.
The report could not be generated.
The connection was lost. Please try again.
```

Internal system information must never be exposed.

---

# 90. Testing Requirements

The Parent Module should be tested for:

```text
Parent Registration
Login
Profile
Student Linking
Relationship Verification
Multiple Children
Child Switching
Academic Overview
Learning Progress
Assessment Results
Attendance
Teacher Communication
School Notifications
Reports
AI Features
Authorization
Privacy
Security
Mobile Experience
Accessibility
```

Detailed testing strategy belongs to:

```text
TESTING.md
```

---

# 91. Future Parent Features

The architecture should support future capabilities such as:

```text
Parent-Teacher Meetings
Fee Information
Fee Payment
Transport Information
School Events
Digital Consent
Permission Requests
Parent Community
Career Guidance
Scholarship Alerts
Advanced AI Parent Assistant
```

These may become separate modules as the platform expands.

---

# 92. Parent-Teacher Meetings

Future functionality may support:

```text
Meeting Request
Available Time Slots
Appointment
Meeting Reminder
Meeting History
```

---

# 93. Digital Consent

Future school integrations may allow parents to approve:

```text
School Activities
Trips
Events
Digital Permissions
Academic Programs
```

All consent records should be auditable.

---

# 94. Parent Career Support

For older students, parents may receive authorized information related to:

```text
Career Options
University Pathways
Scholarships
Courses
Skills
```

This should remain supportive rather than prescriptive.

---

# 95. Parent Module Integration Map

```text
                         PARENT
                            │
                     AUTHENTICATION
                            │
                     PARENT IDENTITY
                            │
                PARENT-STUDENT RELATION
                            │
              ┌─────────────┼─────────────┐
              ↓             ↓             ↓
           STUDENT       LEARNING      ASSESSMENTS
              │             │             │
              └─────────────┼─────────────┘
                            ↓
                        ANALYTICS
                            ↓
                           AI
                            ↓
                       INSIGHTS
                            ↓
                    PARENT DASHBOARD
```

---

# 96. Complete Parent Data Flow

```text
PARENT
  ↓
AUTHENTICATION
  ↓
AUTHORIZED RELATIONSHIP
  ↓
CHILD SELECTION
  ↓
ACADEMIC CONTEXT
  ↓
LEARNING
  ↓
ASSESSMENTS
  ↓
PROGRESS
  ↓
ANALYTICS
  ↓
INSIGHTS
  ↓
PARENT ACTION
```

---

# 97. Parent Module Boundaries

The Parent Module owns the **parent-facing experience and orchestration**.

It does not own:

```text
Authentication Credentials
Student Master Data
Academic Structure
Question Bank
Assessment Engine
Learning Progress Engine
AI Model Infrastructure
Media Storage
Analytics Engine
School Administration
```

These remain separate domains.

---

# 98. Core Parent Module Components

```text
Parent Identity
Parent Profile
Parent-Student Relationship
Child Selector
Parent Dashboard
Academic Overview
Learning Progress
Assessment Results
Attendance View
Teacher Communication
School Communication
Notifications
Reports
AI Assistant
Parent Settings
```

---

# 99. Final Parent Module Principle

The Aspirian Parent Module must provide:

> **A secure, transparent and easy-to-use environment that enables parents and authorized guardians to understand, monitor and support their children's educational progress while preserving student privacy and clear access boundaries.**

The Parent Module must connect parents to the student's educational journey without duplicating the underlying academic, learning, assessment, AI, media or analytics systems.

---

# 100. Document Status

**File:** `PARENT_MODULE.md`
**Version:** 1.0
**Status:** Final Parent Module Blueprint
**Phase:** D
**Module:** D4 — Parent Module
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Parent Module for the Aspirian Student Platform.
