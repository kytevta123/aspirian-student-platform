# Aspirian Student Platform — Reporting System

**Version:** 1.0
**Status:** Final Reporting System Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

The Reporting module provides a centralized reporting and analytics presentation layer for the Aspirian Student Platform.

It converts platform data into useful reports for:

```text
Students
Teachers
Parents
Schools
School Administrators
Platform Administrators
Content Teams
Academic Teams
```

The Reporting System covers:

```text
Academic Reports
Assessment Reports
Student Progress Reports
Teacher Reports
School Reports
Question Reports
Content Reports
AI Reports
Attendance Reports
Usage Reports
Administrative Reports
Security Reports
Platform Reports
```

---

# 2. Vision

The Reporting System should provide accurate, permission-controlled and actionable information.

```text
                         PLATFORM DATA
                              ↓
                     REPORTING ENGINE
                              ↓
              ┌───────────────┼───────────────┐
              ↓               ↓               ↓
           ANALYTICS       REPORTS         DASHBOARDS
              ↓               ↓               ↓
              └───────────────┼───────────────┘
                              ↓
                   DECISION & ACTION
```

---

# 3. Reporting Principles

Reports must be:

```text
Accurate
Relevant
Secure
Permission-Controlled
Understandable
Consistent
Auditable
Exportable
Scalable
```

---

# 4. Reporting Sources

Reports may consume data from:

```text
User Management
Student Module
Teacher Module
School Module
Question Bank
Question Management
Test Engine
Assessment System
Result Engine
Learning Progress
Revision Engine
AI Tutor
AI Question Generator
AI Paper Generator
AI Viva
Audio System
Video System
Gamification
Notification System
Content Management
```

---

# 5. Reporting Architecture

```text
APPLICATION MODULES
        ↓
DATA / EVENTS
        ↓
ANALYTICS LAYER
        ↓
REPORTING ENGINE
        ↓
PERMISSION CHECK
        ↓
REPORT
        ↓
DASHBOARD / EXPORT / PRINT
```

---

# 6. Report Types

The system should support:

```text
Operational Reports
Academic Reports
Performance Reports
Progress Reports
Management Reports
Analytical Reports
Compliance Reports
Usage Reports
Financial Reports Where Applicable
Security Reports
```

---

# 7. Report Categories

Main categories:

```text
Students
Teachers
Schools
Questions
Tests
Exams
Results
Learning
Content
AI
Media
Gamification
Notifications
Users
Security
Platform
```

---

# 8. Student Reports

Student reports may include:

```text
Academic Progress
Test Performance
Exam Performance
Subject Performance
Chapter Performance
Topic Performance
Learning Progress
Revision Progress
Question Accuracy
Time Spent
Weak Areas
Strength Areas
```

---

# 9. Student Performance Report

A student performance report may contain:

```text
Student
Class
Section
Academic Session
Tests Attempted
Average Score
Accuracy
Subject Performance
Recent Results
Strengths
Weak Areas
```

---

# 10. Student Progress Report

Track:

```text
Learning Progress
Course Progress
Chapter Completion
Topic Completion
Practice Activity
Revision Activity
```

---

# 11. Subject Report

Show:

```text
Subject
Tests
Attempts
Average Score
Accuracy
Progress
Weak Topics
Strong Topics
```

---

# 12. Chapter Report

Show:

```text
Chapter
Questions Attempted
Accuracy
Average Score
Revision Status
Completion
```

---

# 13. Topic Report

Show detailed performance at topic level.

---

# 14. Weak Area Report

Identify topics where a student may need additional practice.

Signals may include:

```text
Low Accuracy
Repeated Incorrect Answers
Low Progress
High Time Per Question
```

---

# 15. Strength Report

Identify areas with strong performance.

---

# 16. Revision Report

Show:

```text
Revision Items
Completed
Pending
Repeated Mistakes
Improvement
```

---

# 17. Test Reports

Test reports may include:

```text
Test Name
Class
Subject
Questions
Participants
Attempts
Average Score
Highest Score
Lowest Score
Accuracy
Completion Rate
```

---

# 18. Test Attempt Report

Track:

```text
Student
Attempt
Score
Percentage
Time
Correct
Incorrect
Skipped
```

---

# 19. Exam Reports

Exam reporting should support:

```text
Exam Summary
Subject Results
Student Results
Class Results
Section Results
Top Performers
Performance Distribution
```

---

# 20. Question Performance Report

Track:

```text
Question
Attempts
Correct
Incorrect
Accuracy
Average Time
Difficulty
Reports / Flags
```

---

# 21. Question Quality Report

Show potential issues:

```text
High Error Rate
Very High Accuracy
Duplicate Candidates
Reported Problems
Outdated Content
```

---

# 22. Question Bank Report

Show:

```text
Total Questions
Published
Draft
Pending Review
Archived
AI Generated
Teacher Created
```

---

# 23. Question Distribution Report

Break down questions by:

```text
Class
Subject
Chapter
Topic
Type
Difficulty
Language
Source
```

---

# 24. Teacher Reports

Teacher reports may include:

```text
Classes
Students
Tests Created
Questions Created
Assessments
Student Performance
Assignments
Content Activity
```

---

# 25. Teacher Performance Dashboard

The system may show:

```text
Students Managed
Tests Created
Assessments Conducted
Question Contributions
Student Improvement
```

Metrics should be interpreted carefully and should not be used as the sole basis for personnel decisions.

---

# 26. Teacher Class Report

Show:

```text
Class
Students
Average Score
Completion
Weak Topics
Strong Topics
```

---

# 27. Teacher Assessment Report

Show:

```text
Tests
Participants
Average Score
Question Performance
Result Distribution
```

---

# 28. School Reports

School administrators may access school-level reports.

---

# 29. School Performance Report

Show:

```text
Students
Teachers
Classes
Assessments
Average Performance
Subject Performance
Participation
Learning Progress
```

---

# 30. Class Report

Show:

```text
Class
Students
Average Score
Median Score
Highest Score
Lowest Score
Participation
Subject Performance
```

---

# 31. Section Report

Show section-level performance.

---

# 32. Subject Comparison

Compare performance across subjects.

Example:

```text
Mathematics → 72%
English     → 78%
Computer    → 84%
Science     → 75%
```

---

# 33. Class Comparison

Authorized school administrators may compare classes.

---

# 34. Academic Session Comparison

Compare performance between academic sessions where data definitions are compatible.

---

# 35. Parent Reports

Parents may receive appropriate reports for linked students.

Possible:

```text
Academic Progress
Test Results
Subject Performance
Learning Activity
Revision Progress
```

Parents should only access data for authorized linked students.

---

# 36. Student Report Card

A report card may include:

```text
Student
Class
Academic Session
Subjects
Marks
Percentage
Grade
Teacher Remarks
Progress Summary
```

---

# 37. Report Card Versions

Published report cards should be versioned or snapshotted where historical integrity is required.

---

# 38. Ranking Reports

If enabled, rankings may show:

```text
Class Rank
Section Rank
School Rank
```

Ranking features should respect school policies and student privacy.

---

# 39. Ranking Privacy

Avoid exposing unnecessary student information publicly.

---

# 40. Attendance Reports

If attendance is supported:

```text
Present
Absent
Late
Attendance %
```

---

# 41. Content Reports

Content Management reports may show:

```text
Articles
Notes
Videos
Audio
Learning Resources
Published Content
Draft Content
```

---

# 42. Content Performance

Where analytics are available:

```text
Views
Engagement
Completion
Downloads
```

---

# 43. Video Reports

Track:

```text
Video Views
Watch Time
Completion
Drop-Off
Popular Videos
```

---

# 44. Audio Reports

Track:

```text
Plays
Listening Time
Completion
Popular Audio
```

---

# 45. Radio Reports

Where supported:

```text
Listeners
Sessions
Listening Duration
Peak Usage
```

---

# 46. YouTube Live Reports

Where integrated:

```text
Live Viewers
Peak Viewers
Watch Time
Session Duration
```

---

# 47. AI Reports

AI-related reporting may include:

```text
AI Tutor Sessions
AI Questions Generated
AI Papers Generated
AI Revision Sessions
AI Viva Sessions
AI Audio Notes
AI Video Learning
```

---

# 48. AI Usage Report

Show:

```text
Total Sessions
Active Users
Requests
Successful Responses
Errors
```

---

# 49. AI Cost Reporting

Where applicable, authorized platform administrators may monitor:

```text
AI Requests
Token Usage
Estimated Cost
Provider Usage
```

Actual billing data should come from the relevant provider/infrastructure source.

---

# 50. AI Safety Report

Track:

```text
Safety Flags
Blocked Requests
Review Cases
Reported AI Responses
```

Access should be restricted.

---

# 51. Gamification Reports

Show:

```text
Points
Badges
Achievements
Challenges
Leaderboard Participation
```

---

# 52. Notification Reports

Track:

```text
Notifications Sent
Delivered
Failed
Opened Where Supported
```

---

# 53. User Reports

Show:

```text
Total Users
Students
Teachers
Parents
School Admins
Staff
Active Users
Suspended Users
```

---

# 54. User Activity Report

May include:

```text
Login Activity
Learning Activity
Assessment Activity
Content Activity
```

subject to permissions and privacy rules.

---

# 55. Platform Usage Report

Platform administrators may view:

```text
Daily Active Users
Monthly Active Users
Sessions
Tests
Questions
Content Usage
AI Usage
```

---

# 56. Engagement Report

Possible metrics:

```text
DAU
WAU
MAU
Session Count
Average Session Duration
Returning Users
```

---

# 57. Retention Report

Measure user return patterns.

Example:

```text
Day 1
Day 7
Day 30
```

---

# 58. Feature Usage Report

Track adoption of:

```text
Tests
Flashcards
Revision
AI Tutor
Video
Audio
Coding Lab
Viva
```

---

# 59. Dashboard

The Reporting System should provide role-specific dashboards.

---

# 60. Student Dashboard

Student reporting may show:

```text
My Progress
My Results
My Strengths
My Weak Areas
My Revision
My Achievements
```

---

# 61. Teacher Dashboard

Teacher reporting may show:

```text
Class Performance
Student Progress
Assessment Results
Question Performance
```

---

# 62. Parent Dashboard

Parent reporting may show:

```text
Child Progress
Recent Results
Subject Performance
Revision Activity
```

---

# 63. School Dashboard

School dashboard:

```text
Students
Teachers
Classes
Assessments
Academic Performance
Engagement
```

---

# 64. Platform Admin Dashboard

Platform dashboard:

```text
Users
Schools
Questions
Assessments
Content
AI
System Usage
Security
```

---

# 65. Report Filters

Reports should support filters such as:

```text
Date Range
Academic Session
School
Class
Section
Subject
Chapter
Topic
Teacher
Student
Question Type
Difficulty
```

---

# 66. Date Filters

Common ranges:

```text
Today
Yesterday
Last 7 Days
Last 30 Days
This Month
This Term
This Session
Custom Range
```

---

# 67. Report Comparison

Reports may support comparisons:

```text
Previous Period
Previous Session
Class vs Class
Subject vs Subject
```

---

# 68. Report Drill-Down

Users may move from:

```text
School
 ↓
Class
 ↓
Section
 ↓
Student
 ↓
Subject
 ↓
Topic
 ↓
Question
```

only where permissions allow.

---

# 69. Aggregation

Reports should support:

```text
Count
Sum
Average
Median
Minimum
Maximum
Percentage
Rate
Distribution
```

---

# 70. Data Accuracy

Reporting data must use clearly defined calculation rules.

---

# 71. Metric Definitions

Every important metric should have a consistent definition.

Example:

```text
Accuracy =
Correct Answers / Attempted Questions × 100
```

---

# 72. Score Definition

Reports must distinguish between:

```text
Raw Marks
Maximum Marks
Percentage
Grade
Normalized Score
```

---

# 73. Attempt Definition

The system must clearly distinguish:

```text
Started
Completed
Submitted
Auto-Submitted
Abandoned
```

---

# 74. Completion Rate

Example:

```text
Completed Attempts / Started Attempts × 100
```

The exact business rule must remain consistent across reports.

---

# 75. Report Snapshots

Official reports may be snapshotted to preserve historical values.

---

# 76. Real-Time Reports

Some operational reports may use near-real-time data.

---

# 77. Cached Reports

Heavy reports may use cached or precomputed results.

---

# 78. Background Report Generation

Large reports should be generated asynchronously.

```text
Request
 ↓
Queue
 ↓
Generate
 ↓
Store
 ↓
Notify
 ↓
Download / View
```

---

# 79. Report Export

Supported formats may include:

```text
PDF
Excel
CSV
JSON
```

depending on report type.

---

# 80. PDF Reports

PDF should support:

```text
Title
Logo
Date
Filters
Tables
Charts
Summary
Footer
```

---

# 81. Excel Reports

Excel exports should use structured columns and readable headings.

---

# 82. CSV Reports

CSV exports should be machine-readable and suitable for further analysis.

---

# 83. JSON Reports

JSON may be used for APIs and integrations.

---

# 84. Report Printing

Reports should have print-friendly layouts.

---

# 85. Report Scheduling

Authorized users may schedule recurring reports.

Examples:

```text
Daily
Weekly
Monthly
Termly
```

---

# 86. Scheduled Delivery

Reports may be delivered through:

```text
Dashboard
Email
Download Center
```

subject to permissions.

---

# 87. Report Subscriptions

Authorized users may subscribe to selected reports.

---

# 88. Report Alerts

The system may support threshold alerts.

Example:

```text
Class Average < 50%
```

triggering an authorized notification.

---

# 89. Academic Alerts

Possible alerts:

```text
Low Performance
Low Participation
Repeated Failure
Significant Improvement
```

These should be treated as indicators requiring human interpretation.

---

# 90. Student Privacy

Reports must follow least-privilege access.

---

# 91. Parent Privacy

Parents only receive reports for linked students.

---

# 92. Teacher Privacy

Teachers should only access reports within their authorized scope.

---

# 93. School Privacy

Schools must not access another school's private reports.

---

# 94. Platform Privacy

Platform-wide reports should use aggregated information where individual-level detail is unnecessary.

---

# 95. Sensitive Reports

Some reports should have restricted permissions:

```text
Security Reports
AI Safety Reports
Administrative Reports
User Audit Reports
```

---

# 96. Report Permissions

Recommended permissions:

```text
reports.view
reports.create
reports.export
reports.schedule
reports.share
reports.delete
reports.admin
```

---

# 97. Scope Permissions

Reports can be scoped to:

```text
Own Data
Class
Section
Subject
School
Platform
```

---

# 98. Report Sharing

Reports may be shared only with authorized recipients.

---

# 99. Share Expiration

Sensitive report links should optionally expire.

---

# 100. Export Audit

Export actions should be logged for sensitive reports.

---

# 101. Report Audit Log

Track:

```text
Report Generated
Viewed
Exported
Shared
Scheduled
Deleted
```

---

# 102. Report Templates

Reusable templates may include:

```text
Student Report Card
Test Report
Class Report
School Report
Question Report
Teacher Report
Progress Report
```

---

# 103. Custom Reports

Authorized administrators may create custom reports using approved data fields.

---

# 104. Custom Report Builder

Possible flow:

```text
Select Data
 ↓
Select Fields
 ↓
Apply Filters
 ↓
Choose Grouping
 ↓
Choose Metrics
 ↓
Preview
 ↓
Save
```

---

# 105. Report Builder Security

The report builder must only expose fields permitted to the current user.

---

# 106. Report Columns

Users may choose visible columns where supported.

---

# 107. Sorting

Reports should support sorting by relevant metrics.

---

# 108. Grouping

Group by:

```text
School
Class
Section
Subject
Teacher
Date
```

where appropriate.

---

# 109. Charts

Reports may use:

```text
Bar Charts
Line Charts
Pie / Donut Charts
Progress Charts
Distribution Charts
```

Charts should supplement—not replace—underlying data tables.

---

# 110. Accessibility

Charts must have accessible alternatives such as tables or textual summaries.

---

# 111. Color Accessibility

Charts must not rely only on color to communicate meaning.

---

# 112. Mobile Reporting

Reports should be usable on:

```text
Desktop
Tablet
Mobile
```

---

# 113. Pagination

Large tables should use pagination or efficient virtualized loading.

---

# 114. Search

Report tables should support search where useful.

---

# 115. Data Refresh

Reports should show data freshness when information is not real-time.

Example:

```text
Last Updated: 10:30 AM
```

---

# 116. Report Errors

If data generation fails:

```text
Show Clear Error
Allow Retry
Log Failure
Do Not Produce Misleading Partial Results
```

---

# 117. Missing Data

Reports should clearly distinguish:

```text
Zero
Unknown
Not Available
Not Applicable
```

---

# 118. Data Validation

Reporting pipelines should validate data before producing official reports.

---

# 119. Analytics Integration

Reporting consumes analytics data from:

```text
ANALYTICS_DATA_MODEL.md
```

and other module data sources.

---

# 120. Result Integration

Reports consume assessment data from:

```text
RESULT_ENGINE.md
```

---

# 121. Learning Integration

Reports consume progress data from:

```text
LEARNING_PROGRESS_MODEL.md
```

---

# 122. Question Integration

Reports consume question information from:

```text
QUESTION_MANAGEMENT.md
```

---

# 123. User Integration

Reports consume identity and organizational scope from:

```text
USER_MANAGEMENT.md
```

---

# 124. Content Integration

Reports consume content information from:

```text
CONTENT_MANAGEMENT.md
```

---

# 125. AI Integration

Reports consume AI activity from:

```text
AI_TUTOR.md
AI_QUESTION_GENERATOR.md
AI_PAPER_GENERATOR.md
AI_REVISION_ENGINE.md
AI_VIVA.md
AI_AUDIO_NOTES.md
AI_VIDEO_LEARNING.md
```

---

# 126. Reporting API

Conceptual endpoints:

```text
/api/v1/reports
/api/v1/reports/{id}
/api/v1/reports/{id}/export
/api/v1/reports/{id}/schedule
/api/v1/dashboards
```

---

# 127. API Authorization

Every report API request must validate:

```text
Authentication
Role
Permission
Organization
Scope
```

---

# 128. API Pagination

Large report datasets should support pagination.

---

# 129. API Filtering

Filtering should be validated server-side.

---

# 130. API Rate Limiting

Heavy report-generation endpoints should have appropriate rate limits.

---

# 131. Report Data Layer

Recommended architecture:

```text
DATABASE
   ↓
DATA ACCESS
   ↓
ANALYTICS / AGGREGATION
   ↓
REPORT SERVICE
   ↓
AUTHORIZATION
   ↓
REPORT OUTPUT
```

---

# 132. Data Warehouse

A future analytics warehouse may be used for large-scale reporting.

This is an optional scalability layer.

---

# 133. Materialized Metrics

Frequently used metrics may be precomputed.

---

# 134. Event-Based Analytics

Important platform events may feed analytics pipelines.

---

# 135. Event Examples

```text
User Registered
Test Started
Question Answered
Test Submitted
Result Generated
Content Viewed
Video Watched
AI Session Started
Badge Earned
```

---

# 136. Reporting Consistency

The same metric must produce consistent results across:

```text
Dashboard
Report
API
Export
```

---

# 137. Report Versioning

Important report definitions should be versioned when calculation rules change.

---

# 138. Historical Reports

Past official reports should remain reproducible where required.

---

# 139. Report Retention

Define retention policies for generated reports.

---

# 140. Temporary Reports

Temporary exports may have shorter retention periods.

---

# 141. Storage

Large generated reports should be stored securely with access controls.

---

# 142. Download Security

Generated files must not be publicly accessible by default.

---

# 143. Report File Expiration

Temporary report download links may expire automatically.

---

# 144. Security

Reporting must protect against:

```text
Unauthorized Data Access
Data Leakage
Cross-School Exposure
Privilege Escalation
Unsafe Exports
```

---

# 145. Tenant Isolation

All school reports must enforce tenant boundaries.

---

# 146. SQL / Query Security

Custom report builders must never permit unsafe arbitrary database queries from users.

---

# 147. Data Masking

Sensitive fields may be masked when full information is unnecessary.

---

# 148. Auditability

Every sensitive report action should be auditable.

---

# 149. Performance

Reporting must remain performant as the platform grows.

Use:

```text
Indexes
Caching
Aggregation
Pagination
Queues
Precomputation
Analytics Storage
```

where appropriate.

---

# 150. Scalability

The reporting architecture should support growth in:

```text
Schools
Users
Students
Questions
Tests
Results
Content
AI Activity
```

---

# 151. Report Generation Queue

Large reports should not block normal web requests.

---

# 152. Notification Integration

When a scheduled report is ready:

```text
Report Generated
 ↓
Notification Service
 ↓
Authorized Recipient
```

---

# 153. Report Dashboard Navigation

Recommended:

```text
Reports

├── Student Reports
├── Teacher Reports
├── School Reports
├── Class Reports
├── Subject Reports
├── Assessment Reports
├── Question Reports
├── Learning Reports
├── Content Reports
├── AI Reports
├── Usage Reports
├── Security Reports
└── Custom Reports
```

---

# 154. Student Report Navigation

```text
My Reports
├── Progress
├── Tests
├── Exams
├── Subjects
├── Revision
└── Achievements
```

---

# 155. School Report Navigation

```text
School Reports
├── Overview
├── Students
├── Teachers
├── Classes
├── Subjects
├── Assessments
├── Questions
├── Learning
└── Usage
```

---

# 156. Platform Report Navigation

```text
Platform Reports
├── Users
├── Schools
├── Assessments
├── Questions
├── Content
├── AI
├── Engagement
├── Security
└── System Usage
```

---

# 157. Report Quality Principles

Reports should:

```text
Use Verified Data
Show Clear Definitions
Respect Permissions
Avoid Misleading Comparisons
Show Time Period
Show Data Freshness
Preserve Historical Integrity
```

---

# 158. Academic Interpretation

Analytics should support educators rather than replace professional judgment.

---

# 159. AI-Generated Insights

AI may summarize reports, for example:

```text
"The class performed strongly in Topic A but needs additional practice in Topic B."
```

AI-generated insights must clearly be treated as recommendations or summaries rather than unquestionable conclusions.

---

# 160. AI Report Safety

AI must not expose information outside the user's authorized scope.

---

# 161. Report Localization

Reports should support:

```text
English
Urdu
Roman Urdu
```

where localization is implemented.

---

# 162. Date and Time

Reports should clearly identify:

```text
Date
Time
Timezone
Academic Session
```

---

# 163. Academic Calendar

Reports should respect configured academic sessions and terms.

---

# 164. Report Branding

School-generated reports may support authorized school branding.

Platform reports may use Aspirian branding.

---

# 165. Report Footer

Official reports may include:

```text
Generated Date
Report Version
Organization
Confidentiality Notice Where Required
```

---

# 166. Report Verification

Official reports may include a verification mechanism such as:

```text
Report ID
Verification Code
QR Code
```

if implemented.

---

# 167. Report Integrity

Official reports should be protected from unauthorized modification.

---

# 168. Final Reporting Ecosystem

```text
                         DATA SOURCES
                              ↓
                    ANALYTICS / DATA LAYER
                              ↓
                       REPORTING ENGINE
                              ↓
             ┌────────────────┼────────────────┐
             ↓                ↓                ↓
         DASHBOARDS        REPORTS          ALERTS
             ↓                ↓                ↓
          STUDENT          PDF/Excel       NOTIFICATIONS
          TEACHER          CSV/JSON
          SCHOOL
          ADMIN
             └────────────────┼────────────────┘
                              ↓
                      DECISION SUPPORT
```

---

# 169. Complete Reporting Flow

```text
USER / ADMIN
     ↓
SELECT REPORT
     ↓
SELECT FILTERS
     ↓
PERMISSION CHECK
     ↓
DATA RETRIEVAL
     ↓
VALIDATION
     ↓
CALCULATION
     ↓
REPORT GENERATION
     ↓
VIEW / EXPORT / SCHEDULE
     ↓
AUDIT
```

---

# 170. Future Expansion

Future versions may include:

```text
Advanced BI Dashboards
Predictive Analytics
Learning Risk Prediction
Advanced Cohort Analysis
Automated Academic Insights
Benchmarking
Board-Level Analytics
Data Warehouse
Real-Time Streaming Analytics
Advanced Data Visualization
```

These are future extensions and do not alter the current core architecture.

---

# 171. Final Design Principles

```text
1. Accurate Data
2. Clear Metrics
3. Permission-Based Access
4. Student Privacy
5. Multi-Tenant Isolation
6. Historical Integrity
7. Exportability
8. Scalability
9. Accessibility
10. Actionable Insights
```

---

# 172. Final Rule

> **Reporting must transform Aspirian's educational and operational data into secure, accurate, understandable and actionable reports while preserving privacy, tenant isolation, historical integrity and role-based access.**

---

# 173. Document Status

**File:** `REPORTING.md`
**Version:** 1.0
**Status:** Final Reporting System Blueprint
**Phase:** G
**Module:** G7 — Reporting
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Reporting architecture for the Aspirian Student Platform.
