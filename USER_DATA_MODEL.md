# Aspirian Student Platform — User Data Model

**Version:** 1.0
**Status:** Final User Data Model Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the user-related data model for the Aspirian Student Platform.

It covers:

* Platform users
* Students
* Teachers
* Parents / Guardians
* School administrators
* Schools
* User roles
* User profiles
* School memberships
* Student enrollments
* Teacher assignments
* Parent-student relationships
* Account status
* User preferences
* Academic context
* Access boundaries
* User data lifecycle

This document defines the **domain-level user data structure**.

Exact database tables, columns, indexes, foreign keys, migrations, and database-specific implementation remain part of `DATABASE.md`.

---

# 2. User Model Philosophy

Aspirian should use a central user identity with role-specific profiles.

```text
                         USER
                           │
          ┌────────────────┼────────────────┐
          │                │                │
       STUDENT          TEACHER          PARENT
          │                │                │
          │                │                │
     Enrollment       School/Classes    Children
          │                │                │
          └────────────────┼────────────────┘
                           │
                      SCHOOL ADMIN
                           │
                         SCHOOL
```

The core identity should remain separate from role-specific academic and institutional information.

---

# 3. Core User Entity

The `User` represents an authenticated account.

Conceptual attributes:

```text
id
name
email
phone
password_hash
status
email_verified_at
phone_verified_at
last_login_at
created_at
updated_at
```

Not every user must provide every optional field.

---

# 4. User Identity

Each user should have a stable internal identifier.

The internal ID should be used for relationships instead of relying on:

* Name
* Email
* Phone number
* Username

Names and contact information may change, but the internal user identity should remain stable.

---

# 5. User Status

Possible account states:

```text
ACTIVE
PENDING
SUSPENDED
LOCKED
DEACTIVATED
DELETED
```

The exact implementation may use a status field or equivalent state model.

---

# 6. User Roles

Initial platform roles:

```text
STUDENT
TEACHER
PARENT
SCHOOL_ADMIN
PLATFORM_ADMIN
```

A user may potentially have more than one role.

Example:

```text
User
 ├── Teacher
 └── Parent
```

The architecture should not assume that one person can only have one role.

---

# 7. Role Separation

Roles should determine authorization.

Profiles should store role-specific information.

Concept:

```text
USER
  │
  ├── ROLE → permissions
  │
  └── PROFILE → role-specific data
```

This prevents the main user record from becoming overloaded with unrelated fields.

---

# 8. Student Profile

A student profile represents a learner.

Conceptual attributes:

```text
id
user_id
date_of_birth
preferred_language
current_class_id
status
created_at
updated_at
```

Sensitive information should only be stored when necessary.

---

# 9. Student Academic Identity

A student may have different academic placements over time.

Therefore, the current class should not be the only academic record.

Example:

```text
Student
 ├── 2025–26 → Class 8
 ├── 2026–27 → Class 9
 └── 2027–28 → Class 10
```

Historical enrollment records preserve this progression.

---

# 10. Student Enrollment

Student enrollment connects a student with an educational institution and academic context.

Concept:

```text
Student
 ↓
School
 ↓
Academic Session
 ↓
Class
 ↓
Section
 ↓
Group / Stream
```

Possible enrollment data:

```text
student_id
school_id
academic_session_id
class_id
section
group_reference
roll_number
start_date
end_date
status
```

---

# 11. Multiple Enrollment Support

The model should allow a student to have multiple historical enrollment records.

Example:

```text
Student
 │
 ├── School A / 2025–26
 │
 ├── School A / 2026–27
 │
 └── School B / 2027–28
```

This supports school transfers without destroying historical data.

---

# 12. Current Academic Placement

The platform may calculate or retrieve a student's current placement from active enrollment.

Concept:

```text
Student
 ↓
Active Enrollment
 ↓
Current School
Current Class
Current Section
Current Session
```

The system should avoid creating conflicting sources of truth.

---

# 13. Student Preferences

Students may have configurable preferences.

Examples:

```text
Preferred Language
Notification Preferences
Learning Preferences
Theme Preference
Accessibility Preferences
```

Preferences should be separate from core identity data where appropriate.

---

# 14. Teacher Profile

A teacher profile represents an educator.

Conceptual attributes:

```text
id
user_id
school_id
status
created_at
updated_at
```

Additional professional information may be added where legitimately required.

---

# 15. Teacher-School Relationship

A teacher may belong to one or more schools over time.

Concept:

```text
Teacher
 ↓
School Membership
 ↓
School
```

Historical memberships should be preserved.

---

# 16. Teacher Assignment

A teacher may teach:

```text
Multiple Classes
Multiple Sections
Multiple Subjects
```

Therefore teacher assignment should be represented independently.

Concept:

```text
Teacher
 ↓
Academic Session
 ↓
School
 ↓
Class / Section
 ↓
Subject
```

---

# 17. Teacher Class Assignment

Conceptual data:

```text
teacher_id
school_id
class_id
subject_id
academic_session_id
section
status
```

This enables:

* Class management
* Test assignment
* Student performance viewing
* Assignment creation
* Question-bank management

---

# 18. Teacher Permissions

Teachers should only access student and class data within their authorization scope.

Example:

```text
Teacher
   ↓
Assigned School
   ↓
Assigned Class
   ↓
Assigned Subject
   ↓
Authorized Students
```

A teacher should not automatically receive access to every student on the platform.

---

# 19. Parent Profile

A parent/guardian profile represents an authorized adult account connected to one or more students.

Conceptual attributes:

```text
id
user_id
status
created_at
updated_at
```

---

# 20. Parent-Student Relationship

Parent access should be represented through a dedicated relationship.

Concept:

```text
Parent
 ↓
Parent-Student Relationship
 ↓
Student
```

Possible relationship types:

```text
PARENT
GUARDIAN
AUTHORIZED_GUARDIAN
OTHER_AUTHORIZED_RELATIONSHIP
```

---

# 21. Multiple Children

A parent may be connected with multiple students.

Example:

```text
Parent
 ├── Student A
 ├── Student B
 └── Student C
```

The model must support this naturally.

---

# 22. Multiple Parents / Guardians

A student may have more than one authorized parent or guardian.

Example:

```text
Student
 ├── Parent A
 ├── Parent B
 └── Authorized Guardian
```

The system should not assume only one parent relationship.

---

# 23. Parent Access Scope

Parent access may include:

```text
Academic Progress
Test Results
Assignments
Attendance-related platform data
Learning Activity
Revision Progress
```

Only data explicitly authorized for parent access should be exposed.

---

# 24. School Entity

A school represents an educational institution using or participating in the platform.

Conceptual attributes:

```text
id
name
code
address
contact_information
status
created_at
updated_at
```

The exact school profile may expand later.

---

# 25. School Administrator

A school administrator manages the school's platform resources.

Concept:

```text
School Admin
 ↓
School
 ├── Teachers
 ├── Students
 ├── Classes
 ├── Sections
 └── Assessments
```

School administrators should only manage resources belonging to their authorized institution.

---

# 26. School Membership

Institutional relationships should be modeled separately from user identity.

Possible membership types:

```text
STUDENT
TEACHER
SCHOOL_ADMIN
```

Concept:

```text
User
 ↓
School Membership
 ↓
School
```

This supports institutional history and multiple memberships.

---

# 27. School Membership Lifecycle

Membership states may include:

```text
INVITED
PENDING
ACTIVE
SUSPENDED
ENDED
```

Example:

```text
Teacher
 ↓
School
 ↓
Active Membership
```

When the teacher leaves the school, the membership can be ended without deleting the teacher account.

---

# 28. School Academic Structure

A school may contain:

```text
School
 ├── Academic Sessions
 │
 ├── Classes
 │    ├── Sections
 │    └── Groups
 │
 ├── Teachers
 │
 └── Students
```

The school-specific structure must remain connected to the global academic model.

---

# 29. School Class

A school class represents an institutional class offering.

Example:

```text
School A
 └── Class 9
      ├── Section A
      ├── Section B
      └── Section C
```

The global `Class` identifies the academic grade.

The school-specific class identifies the school's actual offering.

---

# 30. School Section

Sections are institution-specific.

Example:

```text
Class 9
 ├── A
 ├── B
 └── C
```

A section should not be treated as a global academic class.

---

# 31. Student-School Relationship

A student may belong to a school through an enrollment or membership record.

Concept:

```text
Student
 ↓
School Enrollment
 ↓
School
```

The relationship should include academic session information where necessary.

---

# 32. Student-Teacher Relationship

Students and teachers should not generally be connected through a single permanent direct relationship.

Instead:

```text
Student
 ↓
Enrollment / Class
 ↓
Teacher Assignment
 ↓
Teacher
```

This reflects real academic structures more accurately.

---

# 33. Teacher-Subject Relationship

Teachers may teach multiple subjects.

Example:

```text
Teacher
 ├── Mathematics
 ├── Computer Science
 └── Physics
```

Assignments should therefore support multiple subject relationships.

---

# 34. Student-Subject Relationship

Students may study different subjects depending on:

```text
Board
Class
Group
School
Academic Session
```

The platform should derive or explicitly record the applicable subject enrollment where required.

---

# 35. User Academic Context

The application should be able to determine a student's active academic context:

```text
Student
 ↓
Active Enrollment
 ↓
School
 ↓
Academic Session
 ↓
Board / Curriculum
 ↓
Class
 ↓
Group / Stream
 ↓
Subjects
```

This context can drive:

* Dashboard
* Learning content
* Tests
* AI tutor
* Revision
* Recommendations

---

# 36. User Dashboard Context

The student's dashboard may display:

```text
Current Class
Current Subjects
Learning Progress
Upcoming Tests
Recent Results
Revision Items
AI Recommendations
```

Dashboard data should be generated from the user's actual academic context.

---

# 37. User Language

The platform may support:

```text
English
Urdu
Roman Urdu
```

Language preference should not change the user's academic identity.

For example:

```text
Class 9 Biology
```

can be presented in different interface/content languages.

---

# 38. Account Verification

The system may support:

```text
Email Verification
Phone Verification
```

Verification state should be tracked separately from account status.

---

# 39. Authentication vs Profile Data

Authentication data should be separated conceptually from educational profile data.

```text
Authentication
 ├── Credentials
 ├── Verification
 └── Sessions

Profile
 ├── Student
 ├── Teacher
 └── Parent
```

This separation improves security and maintainability.

---

# 40. User Sessions

Authenticated sessions may be associated with a user.

Conceptual information:

```text
user_id
session_reference
device_reference
created_at
expires_at
revoked_at
```

Sensitive session credentials must be securely handled.

---

# 41. User Devices

Future applications may support multiple devices.

Example:

```text
Student
 ├── Web Browser
 ├── Android Device
 └── Future iOS Device
```

Device information should only be collected when necessary.

---

# 42. Notifications

Notifications belong to users rather than roles.

Examples:

```text
Student → Test Result
Teacher → New Submission
Parent → Child Progress Update
School Admin → School Activity
```

---

# 43. User Saved Content

Users may save:

```text
Notes
Questions
Lessons
Videos
Audio
Topics
```

Saved content should reference the original content rather than duplicating it.

---

# 44. User Learning Data

Student-specific learning data may include:

```text
Progress
Attempts
Answers
Results
Mistakes
Revision
Flashcards
Study Plans
```

These records should be connected to the student profile through stable identifiers.

---

# 45. User AI Data

AI learning sessions should be linked to the authenticated user and, where applicable, the student profile.

Concept:

```text
User
 ↓
Student
 ↓
AI Session
 ↓
AI Messages
```

AI usage data may also be connected to subscription entitlements.

---

# 46. User Subscription

A user may have:

```text
Free Access
Premium Subscription
Teacher Plan
Family Plan
```

Subscription status should be separate from the user role.

For example:

```text
User
 ├── Role: STUDENT
 └── Plan: STUDENT_PREMIUM
```

---

# 47. User Entitlements

Feature access should be determined through entitlements.

Example:

```text
User
 ↓
Subscription / Role
 ↓
Entitlements
 ↓
Feature Access
```

This prevents feature permissions from being hard-coded directly into the user record.

---

# 48. Account Lifecycle

A typical user lifecycle:

```text
Registration
     ↓
Verification
     ↓
Active Account
     ↓
Platform Usage
     ↓
Possible Role / School Membership
     ↓
Possible Subscription
     ↓
Account Deactivation
```

Historical records should remain intact where required.

---

# 49. Registration Types

The platform may eventually support:

```text
Student Registration
Teacher Registration
Parent Registration
School Invitation
School Administrator Invitation
```

The exact onboarding process may differ by role.

---

# 50. Student Registration

Potential flow:

```text
Create Account
 ↓
Verify Account
 ↓
Student Profile
 ↓
Select Academic Context
 ↓
Start Learning
```

School enrollment may be added separately.

---

# 51. Teacher Registration

Potential flow:

```text
Create Account
 ↓
Verify Account
 ↓
Teacher Profile
 ↓
School Invitation / Association
 ↓
Teacher Assignment
 ↓
Teacher Dashboard
```

Teacher authority should not automatically be granted simply by selecting a school.

---

# 52. Parent Registration

Potential flow:

```text
Create Account
 ↓
Verify Account
 ↓
Parent Profile
 ↓
Connect / Authorize Student
 ↓
Parent Dashboard
```

Student connections should use a secure authorization mechanism.

---

# 53. School Onboarding

Potential flow:

```text
School Registration
 ↓
Verification
 ↓
School Profile
 ↓
School Administrator
 ↓
Academic Setup
 ↓
Teachers
 ↓
Students
 ↓
Classes / Sections
```

---

# 54. School Verification

Where institutional accounts are enabled, school verification may be required.

Potential verification methods may include:

```text
Institutional Email
Official Documentation
Administrative Approval
Other Verification Method
```

The final process will be defined by product and compliance requirements.

---

# 55. Role Change

A user's role may change over time.

Example:

```text
Student
   ↓
Teacher
```

or:

```text
Teacher
   ↓
Teacher + Parent
```

Historical role records may be required for auditing.

---

# 56. User Deactivation

When an account is deactivated:

```text
Authentication Access
        ↓
Disabled
```

Historical academic and financial records should not automatically be deleted.

---

# 57. Account Deletion

Account deletion must distinguish between:

```text
Account Deactivation
```

and:

```text
Permanent Data Deletion
```

Some records may need to be retained for legal, security, academic, or financial reasons.

---

# 58. Privacy Principle

Only necessary user information should be collected.

Avoid collecting unnecessary:

```text
Personal Details
Location Data
Device Data
Contact Information
Sensitive Information
```

The platform should follow data minimization principles.

---

# 59. Student Data Protection

Student-related data should receive strong access controls.

Examples:

```text
Personal Information
Academic Progress
Test Results
Learning Activity
AI Conversations
```

Access should be limited to authorized users and services.

---

# 60. Teacher Data Protection

Teacher information should also be protected.

Examples:

```text
Contact Information
School Membership
Class Assignments
Question Banks
Created Assessments
```

---

# 61. Parent Data Protection

Parent accounts should only expose authorized child information.

```text
Parent
 ↓
Authorized Relationship
 ↓
Specific Student
 ↓
Permitted Data
```

---

# 62. School Data Isolation

School administrators should operate within their institution.

```text
School A Admin
      ↓
School A Data

School B Admin
      ↓
School B Data
```

Cross-school access must require explicit authorization.

---

# 63. Platform Administrator

Platform administrators operate at the platform level.

Potential responsibilities:

```text
User Management
Content Management
Academic Structure
Security
Moderation
Platform Configuration
```

Administrative access must be strongly protected and audited.

---

# 64. User Auditability

Important account and authorization actions should be auditable.

Examples:

```text
Role Changed
School Membership Added
School Membership Removed
Permission Changed
Account Suspended
Account Reactivated
```

---

# 65. Core User Relationships

```text
USER
 │
 ├── STUDENT PROFILE
 │      │
 │      ├── ENROLLMENTS
 │      ├── PROGRESS
 │      ├── ATTEMPTS
 │      ├── RESULTS
 │      ├── REVISION
 │      └── AI SESSIONS
 │
 ├── TEACHER PROFILE
 │      │
 │      ├── SCHOOL MEMBERSHIPS
 │      ├── TEACHER ASSIGNMENTS
 │      ├── QUESTION BANKS
 │      └── TESTS
 │
 └── PARENT PROFILE
        │
        └── PARENT-STUDENT RELATIONSHIPS
```

---

# 66. Institutional Relationships

```text
SCHOOL
 │
 ├── SCHOOL ADMINS
 │
 ├── TEACHERS
 │
 ├── STUDENTS
 │
 ├── CLASSES
 │
 └── SECTIONS
```

---

# 67. Academic User Relationships

```text
STUDENT
   ↓
ENROLLMENT
   ↓
ACADEMIC SESSION
   ↓
CLASS
   ↓
GROUP / STREAM
   ↓
SUBJECT
```

Teacher relationship:

```text
TEACHER
   ↓
ASSIGNMENT
   ↓
CLASS / SECTION
   ↓
SUBJECT
```

---

# 68. Parent Relationship

```text
PARENT
   ↓
PARENT-STUDENT RELATIONSHIP
   ↓
STUDENT
   ↓
ACADEMIC DATA
```

The parent does not become the owner of the student's account.

---

# 69. Example — Student

```text
User
 └── Student Profile
      └── Enrollment
           ├── School
           ├── Session 2026–27
           ├── Class 9
           ├── Section A
           ├── Board / Curriculum
           └── Subjects
```

---

# 70. Example — Teacher

```text
User
 └── Teacher Profile
      └── School Membership
           └── Teacher Assignment
                ├── Class 9
                ├── Section A
                └── Biology
```

---

# 71. Example — Parent

```text
User
 └── Parent Profile
      ├── Student A
      ├── Student B
      └── Student C
```

Each relationship can have its own authorization scope.

---

# 72. Example — School

```text
School
 │
 ├── Administrator
 │
 ├── Teachers
 │    ├── Teacher A
 │    └── Teacher B
 │
 ├── Students
 │    ├── Student A
 │    └── Student B
 │
 └── Classes
      ├── Class 9
      └── Class 10
```

---

# 73. Multi-School Support

The platform must support multiple institutions.

```text
Aspirian Platform
 │
 ├── School A
 │
 ├── School B
 │
 ├── School C
 │
 └── Future Schools
```

Institutional data must remain logically isolated.

---

# 74. Multi-Role Support

The platform should support users with multiple roles where appropriate.

Example:

```text
User
 ├── Teacher
 └── Parent
```

Role-specific profiles should remain separate.

---

# 75. API Consideration

The user data model must support:

```text
Web
Android
Future iOS
Future Other Clients
```

All clients should use the same authoritative user/account system.

---

# 76. Data Model Boundary

This document defines:

```text
User
Student
Teacher
Parent
School
Roles
Memberships
Enrollments
Assignments
Relationships
User Lifecycle
```

The following remain outside the detailed scope of this file:

```text
Exact SQL Tables
Column Types
Indexes
Foreign Keys
Migrations
Database Engine Configuration
```

These belong in `DATABASE.md`.

---

# 77. Final User Model

The complete user architecture is:

```text
                         USER
                           │
             ┌─────────────┼─────────────┐
             │             │             │
          STUDENT       TEACHER        PARENT
             │             │             │
        ENROLLMENT     ASSIGNMENTS   CHILD LINKS
             │             │             │
             └─────────────┼─────────────┘
                           │
                         SCHOOL
                           │
             ┌─────────────┼─────────────┐
             │             │             │
          CLASSES       TEACHERS      STUDENTS
             │
          SECTIONS
             │
          SUBJECTS
```

---

# 78. Final Principle

The Aspirian user data model must be:

> **Role-aware, student-centered, institution-aware, historically accurate, privacy-conscious, and scalable from individual learners to large school networks.**

The core identity remains independent from academic placement, school membership, subscriptions, and learning activity.

---

# 79. Document Status

**File:** `USER_DATA_MODEL.md`
**Phase:** C
**Module:** C2 — User Data Model

**File:** `USER_DATA_MODEL.md`
**Version:** 1.0
**Status:** Final User Data Model Blueprint
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official user, student, teacher, parent, and school data model for the Aspirian Student Platform.
