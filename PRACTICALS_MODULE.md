# Aspirian Student Platform — Practicals Module

**Version:** 1.0
**Status:** Final Practicals Module Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the functional architecture of the Practicals Module for the Aspirian Student Platform.

The Practicals Module is responsible for managing practical, laboratory, hands-on and activity-based learning experiences.

It supports subjects and courses where students need to perform practical activities in addition to theoretical study.

---

# 2. Practicals Module Principle

The Practicals Module connects academic concepts with practical application.

```text
THEORY
   ↓
PRACTICAL ACTIVITY
   ↓
INSTRUCTIONS
   ↓
STUDENT WORK
   ↓
OBSERVATION / SUBMISSION
   ↓
EVALUATION
   ↓
PRACTICAL PROGRESS
```

---

# 3. Module Scope

The Practicals Module owns:

```text
Practical Activities
Laboratory Exercises
Practical Instructions
Practical Assignments
Practical Submissions
Practical Records
Practical Evaluation
Practical Skills
Practical Completion
Practical Progress
```

It does not own:

```text
Student Identity
Question Bank Master Data
Official Written Tests
Official Result Master Data
School Master Data
Teacher Master Data
Media Master Data
```

---

# 4. Practical Learning Types

The system should support:

```text
Laboratory Practical
Computer Practical
Programming Practical
Science Experiment
Mathematics Activity
Project Activity
Field Activity
Workshop Activity
Technical Practical
Art Activity
Research Activity
Simulation-Based Practical
```

---

# 5. Subject Support

The Practicals Module may support practical components for:

```text
Physics
Chemistry
Biology
Computer Science
Information Technology
Mathematics
Technical Subjects
Vocational Subjects
Other Activity-Based Subjects
```

The exact subjects depend on the curriculum.

---

# 6. Practical Activity

A Practical Activity represents a defined hands-on learning task.

It may contain:

```text
Title
Description
Subject
Class
Chapter
Topic
Learning Objectives
Required Materials
Instructions
Safety Instructions
Expected Outcome
Evaluation Criteria
```

---

# 7. Practical Categories

Activities may be categorized as:

```text
Experiment
Exercise
Demonstration
Observation
Project
Assignment
Workshop
Simulation
Field Work
```

---

# 8. Practical Status

Possible activity statuses:

```text
DRAFT
PUBLISHED
ACTIVE
ARCHIVED
```

---

# 9. Student Practical Status

For each student:

```text
NOT_STARTED
IN_PROGRESS
SUBMITTED
UNDER_REVIEW
COMPLETED
REQUIRES_REVISION
```

---

# 10. Practical Assignment

A teacher may assign a practical activity to:

```text
Individual Student
Group
Class
Section
Course
Batch
```

---

# 11. Practical Assignment Data

An assignment may include:

```text
Practical ID
Teacher ID
Student / Group ID
Assigned Date
Due Date
Instructions
Priority
Status
```

---

# 12. Practical Instructions

Instructions should be structured and easy to follow.

Example:

```text
Step 1
Prepare the required materials.

Step 2
Follow the setup instructions.

Step 3
Perform the experiment.

Step 4
Record observations.

Step 5
Submit the practical record.
```

---

# 13. Step-by-Step Practical Guide

Each practical may contain ordered steps.

```text
STEP 1
 ↓
STEP 2
 ↓
STEP 3
 ↓
STEP 4
 ↓
RESULT
```

---

# 14. Required Materials

The system may display:

```text
Equipment
Chemicals
Books
Computer
Software
Internet Resources
Stationery
Other Materials
```

where appropriate.

---

# 15. Safety Instructions

Practical activities involving laboratory equipment or hazardous materials should include safety guidance.

Example:

```text
Wear appropriate protective equipment.
Follow teacher instructions.
Do not handle equipment without supervision.
```

Safety requirements should be configurable by subject and practical.

---

# 16. Safety Acknowledgement

Students may be required to acknowledge safety instructions before beginning certain practicals.

```text
SAFETY INSTRUCTIONS
 ↓
ACKNOWLEDGEMENT
 ↓
START PRACTICAL
```

---

# 17. Teacher Supervision

Some practical activities may require teacher supervision.

Possible requirement:

```text
SUPERVISION_REQUIRED = TRUE
```

The system should prevent or restrict unsupervised execution where configured.

---

# 18. Practical Learning Objectives

Each practical should identify learning objectives.

Example:

```text
Understand the concept
Perform the procedure
Record observations
Analyze results
Draw conclusion
```

---

# 19. Practical Skills

The module may track skills such as:

```text
Observation
Measurement
Calculation
Experiment Setup
Data Recording
Analysis
Problem Solving
Programming
Technical Operation
Report Writing
```

---

# 20. Practical Skill Progress

A student's practical skill development may be tracked separately from theoretical marks.

```text
SKILL
 ↓
PRACTICAL ATTEMPTS
 ↓
EVALUATION
 ↓
SKILL PROGRESS
```

---

# 21. Practical Session

A Practical Session represents the student's execution of a practical activity.

Possible status:

```text
NOT_STARTED
IN_PROGRESS
PAUSED
COMPLETED
ABANDONED
```

---

# 22. Practical Session Data

A session may contain:

```text
Student
Practical
Start Time
End Time
Duration
Status
Attempt Number
```

---

# 23. Practical Attempts

A practical may allow multiple attempts.

```text
ATTEMPT 1
 ↓
FEEDBACK
 ↓
ATTEMPT 2
 ↓
IMPROVEMENT
```

The number of allowed attempts should be configurable.

---

# 24. Practical Record

Students may maintain a digital practical record.

Possible sections:

```text
Title
Objective
Apparatus / Materials
Procedure
Observations
Calculations
Results
Conclusion
Precautions
```

---

# 25. Digital Lab Notebook

The platform may provide a digital laboratory notebook.

```text
LAB NOTEBOOK
 ├── Practical 1
 ├── Practical 2
 ├── Practical 3
 └── Practical 4
```

---

# 26. Observation Recording

Students may record:

```text
Text
Numbers
Measurements
Tables
Images
Diagrams
```

---

# 27. Measurement Data

Practical activities may require numerical observations.

Example:

```text
Reading 1
Reading 2
Reading 3
Average
Unit
```

---

# 28. Calculation Support

The system may provide calculation tools where appropriate.

Examples:

```text
Average
Percentage
Formula Calculation
Unit Conversion
Graph Calculation
```

Official assessment results should remain controlled by the Result Engine.

---

# 29. Practical Tables

Students may enter observations in structured tables.

```text
Observation | Value | Unit
------------|-------|-----
1           | 10    | cm
2           | 12    | cm
3           | 14    | cm
```

---

# 30. Graphs and Charts

Where useful, students may create graphs from practical data.

Possible graphs:

```text
Line Graph
Bar Graph
Scatter Plot
```

---

# 31. Practical Diagrams

Students may submit or create:

```text
Scientific Diagram
Circuit Diagram
Flowchart
Technical Diagram
Labeled Figure
```

---

# 32. File Submission

Practical submissions may include:

```text
PDF
DOCX
Image
Spreadsheet
Presentation
Code File
ZIP
```

Allowed file types should be configurable.

---

# 33. Image Submission

Students may submit photographs of:

```text
Experiment Setup
Handwritten Record
Lab Work
Project Work
Diagram
Model
```

Image uploads should follow platform storage and privacy policies.

---

# 34. Video Submission

Where configured, students may submit a video demonstrating practical work.

Examples:

```text
Experiment
Programming Demonstration
Technical Procedure
Project Demonstration
```

---

# 35. Audio Submission

Some activities may accept audio submissions.

Example:

```text
Language Practical
Oral Presentation
Speaking Activity
```

---

# 36. Programming Practical

The module should support programming-based practical work.

Examples:

```text
Write a Program
Debug Code
Build a Small Application
Solve a Programming Problem
Database Exercise
Web Development Exercise
```

---

# 37. Code Submission

Programming practicals may accept:

```text
Source Code
Repository Link
Project Archive
Online Editor Submission
```

---

# 38. Code Execution

Future implementations may provide controlled code execution.

```text
CODE
 ↓
SANDBOX
 ↓
EXECUTION
 ↓
TEST CASES
 ↓
RESULT
```

Untrusted code must run in an isolated environment.

---

# 39. Practical Simulation

Where physical equipment is unavailable, the platform may support simulations.

```text
SIMULATION
 ↓
STUDENT INTERACTION
 ↓
OBSERVATION
 ↓
RESULT
```

---

# 40. Virtual Laboratory

Future versions may provide virtual laboratory experiences for selected subjects.

Potential areas:

```text
Physics
Chemistry
Biology
Computer Science
```

---

# 41. Interactive Practical

Interactive activities may allow students to:

```text
Change Variables
Perform Steps
Observe Results
Record Data
Draw Conclusions
```

---

# 42. Practical Submission

A student may submit the completed practical record.

```text
STUDENT
 ↓
COMPLETE PRACTICAL
 ↓
SUBMIT
 ↓
TEACHER
 ↓
REVIEW
```

---

# 43. Submission Status

Possible values:

```text
DRAFT
SUBMITTED
RETURNED
RESUBMITTED
ACCEPTED
REJECTED
```

---

# 44. Teacher Review

Teachers may review submissions based on:

```text
Procedure
Accuracy
Observation
Calculations
Result
Presentation
Safety
Understanding
```

---

# 45. Practical Rubric

Teachers may evaluate practical work using rubrics.

Example:

```text
Procedure           20%
Observation         20%
Calculation         20%
Result              20%
Presentation        10%
Safety              10%
```

The exact weighting should be configurable.

---

# 46. Practical Evaluation Criteria

Possible criteria:

```text
Excellent
Good
Satisfactory
Needs Improvement
Incomplete
```

---

# 47. Practical Feedback

Teachers may provide:

```text
General Feedback
Step Feedback
Correction
Suggestions
Improvement Instructions
```

---

# 48. Student Feedback View

Students should be able to see authorized feedback.

```text
YOUR SUBMISSION
 ↓
TEACHER FEEDBACK
 ↓
IMPROVEMENT
```

---

# 49. Resubmission

If configured:

```text
SUBMITTED
 ↓
REVIEW
 ↓
REQUIRES REVISION
 ↓
STUDENT CORRECTS
 ↓
RESUBMIT
```

---

# 50. Practical Completion

A practical may be considered complete when:

```text
Required Steps Completed
+
Required Record Completed
+
Submission Accepted
```

The exact completion criteria should be configurable.

---

# 51. Completion vs Marks

Completion and marks are separate concepts.

```text
COMPLETED
≠
HIGH SCORE
```

---

# 52. Practical Marks

Where practical marks are part of an assessment structure, the Result Engine should own official result calculation.

The Practicals Module supplies practical evaluation data.

```text
PRACTICAL EVALUATION
 ↓
RESULT ENGINE
 ↓
OFFICIAL RESULT
```

---

# 53. Assessment Integration

Practical activities may contribute to assessments.

```text
PRACTICAL
 ↓
EVALUATION
 ↓
ASSESSMENT COMPONENT
 ↓
RESULT
```

---

# 54. Test Engine Integration

The Test Engine may be used for theoretical questions related to practical work.

Example:

```text
PRACTICAL
 ↓
THEORY QUIZ
 ↓
TEST ENGINE
```

---

# 55. Question Bank Integration

Practical-related MCQs and questions may be stored in the Question Bank.

The Practicals Module should reference them rather than duplicate question data.

---

# 56. Learning Progress Integration

Practical completion and performance may contribute to learning progress signals.

```text
PRACTICAL PERFORMANCE
 ↓
LEARNING PROGRESS
```

---

# 57. Revision Integration

Practical mistakes may generate revision recommendations.

```text
PRACTICAL MISTAKE
 ↓
WEAK SKILL / TOPIC
 ↓
REVISION ENGINE
 ↓
PRACTICE
```

---

# 58. AI Tutor Integration

The AI Tutor may help students understand practical concepts.

Possible assistance:

```text
Explain Procedure
Explain Concept
Provide Hint
Explain Observation
Help Interpret Results
Generate Practice
```

The AI should not replace required teacher supervision.

---

# 59. AI Practical Assistant

Future AI features may include:

```text
Practical Guidance
Report Structure Assistance
Observation Explanation
Error Detection
Code Debugging
Diagram Explanation
```

---

# 60. Media Integration

Practical activities may include:

```text
Instructional Video
Audio Explanation
Images
Animations
Interactive Media
```

Media should be provided through the platform's Media system.

---

# 61. Practical Resources

Each practical may have supporting resources:

```text
Notes
PDF
Video
Diagram
Reference Material
Safety Guide
```

---

# 62. Teacher Practical Creation

Teachers may create practical activities.

Workflow:

```text
CREATE
 ↓
ADD OBJECTIVES
 ↓
ADD MATERIALS
 ↓
ADD STEPS
 ↓
ADD SAFETY
 ↓
ADD EVALUATION
 ↓
PUBLISH
```

---

# 63. Teacher Practical Templates

Teachers may use templates for:

```text
Science Experiment
Computer Practical
Programming Exercise
Lab Report
Project
Field Activity
```

---

# 64. Practical Template Structure

```text
Template
 ├── Objective
 ├── Materials
 ├── Procedure
 ├── Observation
 ├── Result
 ├── Conclusion
 └── Evaluation
```

---

# 65. Practical Assignment Scheduling

Teachers may specify:

```text
Start Date
Due Date
Available Time
Attempt Limit
Late Submission Policy
```

---

# 66. Late Submission

The system may support configurable policies:

```text
Allow
Allow With Penalty
Require Approval
Block
```

---

# 67. Group Practicals

The platform may support group activities.

```text
GROUP
 ├── Student A
 ├── Student B
 ├── Student C
 └── Student D
```

---

# 68. Group Roles

Students may have roles such as:

```text
Leader
Recorder
Observer
Operator
Presenter
```

Roles are optional and configurable.

---

# 69. Individual Contribution

For group practicals, teachers may record individual contributions where required.

---

# 70. Practical Attendance

Where relevant, a practical session may require attendance.

Attendance should integrate with the appropriate attendance system rather than becoming duplicated master data.

---

# 71. Lab Schedule

Future versions may support:

```text
Laboratory
Date
Time
Class
Teacher
Practical
Capacity
```

---

# 72. Equipment Tracking

Equipment inventory should remain under an appropriate inventory or school-management module.

The Practicals Module may reference required equipment.

```text
PRACTICAL
 ↓
REQUIRED EQUIPMENT
 ↓
INVENTORY SYSTEM
```

---

# 73. Laboratory Availability

Future integration may check:

```text
Lab Availability
Equipment Availability
Teacher Availability
Student Group
```

---

# 74. Practical Booking

Future versions may support practical/lab booking.

```text
Teacher
 ↓
Select Lab
 ↓
Select Time
 ↓
Select Practical
 ↓
Book
```

---

# 75. Practical Calendar

Students and teachers may see:

```text
Upcoming Practicals
Due Practicals
Completed Practicals
Lab Sessions
```

---

# 76. Practical Notifications

The system may notify students about:

```text
New Practical
Upcoming Practical
Due Date
Teacher Feedback
Resubmission Required
Practical Session
```

---

# 77. Practical Dashboard — Student

Student dashboard may contain:

```text
Today's Practicals
Upcoming Practicals
Pending Submissions
Feedback
Completed Practicals
Practical Skills
```

---

# 78. Practical Dashboard — Teacher

Teacher dashboard may contain:

```text
Assigned Practicals
Pending Reviews
Late Submissions
Completion Rate
Class Performance
Skill Progress
```

---

# 79. Practical Dashboard — School

Authorized school users may view:

```text
Practical Completion
Subject Performance
Lab Usage
Class Performance
Teacher Activity
```

according to permissions.

---

# 80. Practical Analytics

The system may track:

```text
Completion Rate
Submission Rate
Average Practical Score
Late Submission Rate
Resubmission Rate
Skill Performance
Subject Performance
```

---

# 81. Practical Performance

Possible performance metrics:

```text
Accuracy
Procedure Quality
Completion
Time
Attempt Count
Evaluation Score
```

---

# 82. Practical Improvement

The system may compare practical performance over time.

```text
FIRST ATTEMPT
 ↓
FEEDBACK
 ↓
SECOND ATTEMPT
 ↓
IMPROVEMENT
```

---

# 83. Practical Skill Analytics

The system may identify skills requiring additional practice.

Example:

```text
Observation = Strong
Measurement = Medium
Data Analysis = Weak
```

---

# 84. Practical Revision

A practical topic may be added to revision when:

```text
Low Practical Score
Repeated Mistakes
Incomplete Procedure
Weak Skill
```

---

# 85. Practical Learning Path

A practical learning path may be:

```text
CONCEPT
 ↓
DEMONSTRATION
 ↓
GUIDED PRACTICAL
 ↓
INDEPENDENT PRACTICAL
 ↓
EVALUATION
 ↓
MASTERy
```

---

# 86. Practical Mastery

Practical mastery should be based on configured evidence such as:

```text
Repeated Successful Performance
Required Skills Achieved
Evaluation Criteria Met
```

Completion alone does not necessarily indicate mastery.

---

# 87. Practical Evidence

Evidence may include:

```text
Submission
Observation
Teacher Evaluation
Photo
Video
Code
Report
Quiz
```

---

# 88. Practical Portfolio

Future versions may provide students with a practical portfolio.

```text
MY PRACTICAL PORTFOLIO
 ├── Experiments
 ├── Projects
 ├── Reports
 ├── Code
 ├── Certificates
 └── Achievements
```

---

# 89. Portfolio Privacy

Students should control appropriate portfolio visibility.

Possible visibility:

```text
Private
Teacher
School
Public
```

Public sharing should require explicit permission.

---

# 90. Practical Certificates

Future versions may support certificates for completed practical programs.

Official certificate generation should remain under the appropriate certification module.

---

# 91. Practical Search

Users may search by:

```text
Class
Subject
Chapter
Topic
Practical Type
Difficulty
Status
```

---

# 92. Practical Filtering

Students may filter:

```text
Pending
Completed
Overdue
Needs Revision
Teacher Feedback
```

---

# 93. Practical Difficulty

Activities may be categorized:

```text
Beginner
Intermediate
Advanced
```

---

# 94. Practical Accessibility

The module should support:

```text
Keyboard Navigation
Screen Readers
Readable Instructions
Accessible Forms
Captions
Alternative Text
Accessible Media
```

---

# 95. Mobile Support

Practical records and submissions should work on:

```text
Mobile
Tablet
Laptop
Desktop
```

---

# 96. Offline Support

Future versions may support offline practical recording.

Example:

```text
OFFLINE
 ↓
RECORD OBSERVATIONS
 ↓
SAVE LOCALLY
 ↓
ONLINE
 ↓
SYNC
```

Synchronization must handle conflicts safely.

---

# 97. Data Security

The module must protect:

```text
Student Submissions
Images
Videos
Reports
Teacher Feedback
Practical Records
Performance Data
```

---

# 98. Authorization

Access should follow:

```text
AUTHENTICATION
 ↓
ROLE
 ↓
ACADEMIC SCOPE
 ↓
PRACTICAL PERMISSION
 ↓
ALLOW / DENY
```

---

# 99. Student Access

Students can access their own:

```text
Practicals
Sessions
Records
Submissions
Feedback
Progress
```

---

# 100. Teacher Access

Teachers can access practicals within their authorized teaching scope.

---

# 101. Parent Access

Parents may see appropriate practical progress for linked students.

Example:

```text
Practical Completion
General Performance
Pending Work
```

---

# 102. School Access

School administrators may access authorized school-level practical information.

---

# 103. Audit Logging

Important actions may be logged:

```text
PRACTICAL_CREATED
PRACTICAL_UPDATED
PRACTICAL_PUBLISHED
PRACTICAL_ASSIGNED
SESSION_STARTED
SUBMISSION_CREATED
SUBMISSION_UPDATED
SUBMISSION_SUBMITTED
SUBMISSION_REVIEWED
FEEDBACK_ADDED
RESUBMISSION_REQUESTED
PRACTICAL_COMPLETED
```

---

# 104. Practical API Boundary

Conceptual services:

```text
Get Practicals
Get Practical
Create Practical
Update Practical
Publish Practical
Assign Practical
Start Practical Session
Save Practical Record
Submit Practical
Review Practical
Add Feedback
Request Resubmission
Complete Practical
Get Practical Progress
```

Exact API endpoint naming belongs to the API architecture.

---

# 105. Practical Components

Core components:

```text
Practical Catalog
Practical Activity Manager
Practical Assignment Manager
Practical Session Manager
Practical Record Manager
Submission Manager
Evaluation Manager
Rubric Manager
Skill Tracker
Practical Progress Manager
Schedule Adapter
Media Adapter
Analytics Adapter
Notification Adapter
```

---

# 106. Complete Practicals Architecture

```text
                         TEACHER
                            │
                            ↓
                  PRACTICAL CREATION
                            │
                            ↓
                    PRACTICAL CATALOG
                            │
                            ↓
                     ASSIGNMENT
                            │
                            ↓
                         STUDENT
                            │
                            ↓
                  PRACTICAL SESSION
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
        INSTRUCTIONS    RESOURCES      MATERIALS
             │              │              │
             └──────────────┼──────────────┘
                            ↓
                      STUDENT WORK
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
        OBSERVATIONS      REPORT         MEDIA
             │              │              │
             └──────────────┼──────────────┘
                            ↓
                        SUBMISSION
                            ↓
                         TEACHER
                            ↓
                       EVALUATION
                            ↓
                  ┌─────────┴─────────┐
                  ↓                   ↓
             FEEDBACK             SCORE
                  │                   │
                  └─────────┬─────────┘
                            ↓
                  PRACTICAL PROGRESS
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
       LEARNING         REVISION        ANALYTICS
       PROGRESS         ENGINE
```

---

# 107. Complete Student Practical Flow

```text
LOGIN
 ↓
PRACTICAL DASHBOARD
 ↓
SELECT PRACTICAL
 ↓
READ OBJECTIVES
 ↓
READ SAFETY
 ↓
VIEW MATERIALS
 ↓
FOLLOW PROCEDURE
 ↓
RECORD OBSERVATIONS
 ↓
COMPLETE REPORT
 ↓
ATTACH EVIDENCE
 ↓
SUBMIT
 ↓
TEACHER REVIEW
 ↓
FEEDBACK
 ↓
RESUBMIT IF REQUIRED
 ↓
COMPLETE
```

---

# 108. Science Practical Flow

```text
CONCEPT
 ↓
EXPERIMENT
 ↓
OBSERVATION
 ↓
MEASUREMENT
 ↓
CALCULATION
 ↓
RESULT
 ↓
CONCLUSION
 ↓
EVALUATION
```

---

# 109. Programming Practical Flow

```text
PROBLEM
 ↓
WRITE CODE
 ↓
RUN / TEST
 ↓
DEBUG
 ↓
SUBMIT
 ↓
TEACHER / AUTOMATED REVIEW
 ↓
FEEDBACK
 ↓
IMPROVEMENT
```

---

# 110. Practical Assessment Flow

```text
PRACTICAL
 ↓
STUDENT PERFORMANCE
 ↓
RUBRIC
 ↓
TEACHER EVALUATION
 ↓
PRACTICAL SCORE
 ↓
RESULT ENGINE
 ↓
OFFICIAL RESULT
```

---

# 111. AI-Assisted Practical Flow

```text
STUDENT
 ↓
PRACTICAL QUESTION
 ↓
AI TUTOR
 ↓
EXPLANATION / HINT
 ↓
STUDENT CONTINUES PRACTICAL
```

AI assistance must follow configured academic and safety policies.

---

# 112. Practical + Revision Flow

```text
PRACTICAL RESULT
 ↓
WEAK SKILL / TOPIC
 ↓
REVISION ENGINE
 ↓
TARGETED PRACTICE
 ↓
REASSESSMENT
```

---

# 113. Practical + Learning Progress

```text
PRACTICAL ACTIVITY
 ↓
PERFORMANCE
 ↓
SKILL PROGRESS
 ↓
LEARNING PROGRESS
```

---

# 114. Practical + Analytics

```text
PRACTICAL EVENTS
 ↓
ANALYTICS
 ↓
REPORTING
```

---

# 115. Future Features

The architecture should support:

```text
Virtual Labs
AR/VR Practicals
AI Practical Coach
AI Report Assistant
Computer Vision Evaluation
Automated Code Evaluation
Interactive Simulations
Digital Lab Notebook
Practical Portfolio
Lab Scheduling
Equipment Integration
Offline Practical Mode
Collaborative Projects
```

---

# 116. Testing Requirements

The Practicals Module should be tested for:

```text
Practical Creation
Practical Publishing
Practical Assignment
Session Creation
Session Resume
Instruction Display
Safety Acknowledgement
Observation Recording
Table Input
Calculation Support
File Upload
Image Upload
Video Upload
Code Submission
Simulation
Submission
Teacher Review
Rubric Evaluation
Feedback
Resubmission
Completion
Marks Integration
Learning Integration
Revision Integration
Analytics
Notifications
Group Practicals
Authorization
Privacy
Security
Accessibility
Mobile Support
Offline Sync
Concurrency
Failure Recovery
```

---

# 117. Final Practicals Module Principle

The Aspirian Practicals Module must provide:

> **A structured digital environment where students can perform, document, submit and improve practical learning activities while teachers can assign, supervise, evaluate and provide feedback, with practical performance integrated into learning progress, revision, assessment and analytics without duplicating the responsibilities of other platform modules.**

---

# 118. Document Status

**File:** `PRACTICALS_MODULE.md`
**Version:** 1.0
**Status:** Final Practicals Module Blueprint
**Phase:** D
**Module:** D11 — Practicals Module
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Practicals Module for the Aspirian Student Platform.
