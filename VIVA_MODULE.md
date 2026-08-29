# Aspirian Student Platform — Viva Module

**Version:** 1.0
**Status:** Final Viva Module Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the functional architecture of the Viva Module for the Aspirian Student Platform.

The Viva Module provides a structured environment for oral examination, verbal questioning, speaking practice, concept explanation and communication assessment.

It supports:

```text
Oral Questions
Viva Sessions
Speaking Practice
Concept Explanation
Teacher-Led Viva
AI-Assisted Viva
Automated Evaluation
Feedback
Progress Tracking
Assessment Integration
```

---

# 2. Viva Principle

```text
QUESTION
 ↓
STUDENT THINKS
 ↓
STUDENT ANSWERS
 ↓
ANSWER CAPTURED
 ↓
EVALUATION
 ↓
FEEDBACK
 ↓
NEXT QUESTION
 ↓
FINAL PERFORMANCE
```

The module is designed to evaluate not only whether a student knows an answer, but also how effectively the student can explain and communicate that knowledge.

---

# 3. Module Scope

The Viva Module owns:

```text
Viva Sessions
Viva Questions
Question Sequences
Student Responses
Audio Responses
Video Responses
Evaluation
Viva Rubrics
Teacher Feedback
AI Feedback
Viva Progress
Viva History
Viva Reports
```

It does not own:

```text
Student Identity
Teacher Identity
School Master Data
Question Bank Master Data
Official Assessment Results
General Learning Progress
General AI Tutor Logic
```

---

# 4. Primary Users

The module supports:

```text
Students
Teachers
Schools
Authorized Content Creators
Administrators
```

---

# 5. Viva Types

The system should support:

```text
Practice Viva
Teacher Viva
Exam Viva
Subject Viva
Chapter Viva
Topic Viva
Practical Viva
AI Viva
Mock Viva
Interview Practice
Oral Assessment
```

---

# 6. Academic Range

Viva activities may support:

```text
Nursery
Prep / KG
Class 1 → Class 12
```

The architecture should remain extensible for higher education and professional learning.

---

# 7. Subject Support

Viva sessions may be created for:

```text
English
Urdu
Mathematics
Physics
Chemistry
Biology
Computer Science
General Science
Pakistan Studies
Social Studies
Other Supported Subjects
```

---

# 8. Viva Question

A Viva Question may contain:

```text
Question ID
Question Text
Subject
Class
Chapter
Topic
Difficulty
Expected Answer
Key Concepts
Follow-Up Questions
Time Limit
Language
Media
Status
Created By
```

---

# 9. Question Types

Possible question types:

```text
Direct Question
Conceptual Question
Definition
Explanation
Why Question
How Question
Compare Question
Problem Solving
Scenario-Based
Application-Based
Opinion-Based
Follow-Up Question
Practical Question
```

---

# 10. Example

```text
Question:
What is photosynthesis?

Expected Knowledge:
Plants prepare food using light energy.
```

The system should evaluate understanding rather than requiring an identical sentence.

---

# 11. Follow-Up Questions

A Viva session may dynamically continue based on the student's response.

Example:

```text
Q1:
What is photosynthesis?

 ↓

Q2:
Why is sunlight important?

 ↓

Q3:
Where does photosynthesis occur?
```

---

# 12. Question Difficulty

Possible levels:

```text
BEGINNER
EASY
MEDIUM
HARD
ADVANCED
```

---

# 13. Viva Session

A Viva Session represents one oral practice or assessment attempt.

It may contain:

```text
Session ID
Student ID
Teacher ID
School ID
Subject
Class
Topic
Question Set
Session Type
Start Time
End Time
Status
Score
Feedback
```

---

# 14. Viva Session States

Possible states:

```text
SCHEDULED
READY
IN_PROGRESS
PAUSED
COMPLETED
CANCELLED
EXPIRED
```

---

# 15. Student Viva Flow

```text
LOGIN
 ↓
SELECT VIVA
 ↓
START SESSION
 ↓
QUESTION APPEARS
 ↓
THINK
 ↓
ANSWER
 ↓
ANSWER CAPTURED
 ↓
EVALUATION
 ↓
NEXT QUESTION
 ↓
SESSION COMPLETE
 ↓
FEEDBACK
```

---

# 16. Question Presentation

Questions may be presented as:

```text
Text
Audio
Image
Diagram
Video
```

---

# 17. Answer Methods

Students may answer using:

```text
Microphone
Camera
Text Input
```

depending on session configuration.

---

# 18. Audio Answer

Audio Viva allows students to answer verbally using a microphone.

Workflow:

```text
QUESTION
 ↓
RECORD
 ↓
STOP
 ↓
SUBMIT
 ↓
ANALYZE
```

---

# 19. Video Viva

Video Viva may capture:

```text
Student Voice
Student Video
Answer Duration
```

Video should be optional and controlled by session settings.

---

# 20. Text-Based Viva

A text mode may be used for accessibility or low-bandwidth environments.

```text
QUESTION
 ↓
TYPE ANSWER
 ↓
SUBMIT
```

---

# 21. Speech-to-Text

Future versions may convert audio responses into text.

```text
AUDIO
 ↓
SPEECH-TO-TEXT
 ↓
TRANSCRIPT
 ↓
ANALYSIS
```

---

# 22. Speech Recognition

The architecture may support future speech analysis such as:

```text
Pronunciation
Speech Clarity
Speaking Pace
Pauses
```

These should be treated as assistive indicators rather than absolute measures.

---

# 23. Answer Recording

The system should record metadata such as:

```text
Response ID
Session ID
Question ID
Student ID
Start Time
End Time
Duration
Audio Reference
Video Reference
Transcript
```

---

# 24. Recording Controls

Students should see clear controls:

```text
Start Recording
Pause
Resume
Stop
Replay
Submit
Retry
```

Retry availability should depend on session configuration.

---

# 25. Answer Time

Each question may have:

```text
Preparation Time
Answer Time
Total Time
```

---

# 26. Question Timer

The teacher may configure a time limit.

Example:

```text
Preparation:
15 seconds

Answer:
60 seconds
```

---

# 27. Viva Question Bank Integration

Viva questions may be sourced from the Question Bank.

```text
QUESTION BANK
 ↓
VIVA QUESTION
 ↓
VIVA SESSION
```

The Question Bank remains the source of truth for reusable question content.

---

# 28. Viva Question Selection

Questions may be selected by:

```text
Subject
Class
Chapter
Topic
Difficulty
Question Type
Tags
```

---

# 29. Random Question Selection

The system may randomly select questions from an authorized question pool.

---

# 30. Fixed Question Sequence

Teachers may also create a fixed sequence.

```text
Q1
 ↓
Q2
 ↓
Q3
 ↓
Q4
```

---

# 31. Adaptive Question Selection

Future versions may adjust question difficulty based on student performance.

Conceptually:

```text
Strong Answer
 ↓
Harder Question

Weak Answer
 ↓
Simpler / Clarifying Question
```

---

# 32. AI Viva

AI may act as a virtual viva examiner for practice purposes.

```text
AI EXAMINER
 ↓
ASK QUESTION
 ↓
LISTEN
 ↓
ANALYZE
 ↓
FOLLOW-UP
 ↓
FEEDBACK
```

---

# 33. AI Viva Principle

AI Viva should primarily be considered a **practice and learning feature**.

For high-stakes examinations, teacher or institution-controlled evaluation should remain available.

---

# 34. AI Question Generation

AI may generate practice questions from:

```text
Chapter
Topic
Notes
Question Bank
Learning Objectives
```

Generated questions should be validated before being treated as official assessment content.

---

# 35. AI Follow-Up Questions

AI may ask follow-up questions based on the student's answer.

Example:

```text
Student:
Photosynthesis makes food.

AI:
What is the source of energy used in this process?
```

---

# 36. AI Feedback

AI may provide feedback on:

```text
Accuracy
Completeness
Clarity
Concept Understanding
Vocabulary
Explanation Quality
```

---

# 37. AI Hallucination Protection

AI evaluation should not invent requirements that are absent from the configured rubric or expected knowledge.

For academic assessment, evaluation should preferably be grounded in:

```text
Question
Expected Answer
Key Concepts
Rubric
Curriculum
Teacher Configuration
```

---

# 38. AI Confidence

AI-generated evaluation may include an internal confidence indicator.

Low-confidence evaluations should be treated cautiously and may be escalated for teacher review.

---

# 39. Teacher-Led Viva

Teachers may conduct live or recorded viva sessions.

Workflow:

```text
TEACHER
 ↓
SELECT STUDENT
 ↓
START VIVA
 ↓
ASK QUESTIONS
 ↓
STUDENT ANSWERS
 ↓
TEACHER EVALUATES
 ↓
FEEDBACK
```

---

# 40. Live Viva

A live viva may use:

```text
Audio
Video
Text
```

with real-time interaction.

---

# 41. Recorded Viva

Students may submit recorded answers.

Teachers can review responses later.

---

# 42. Teacher Question Controls

Teachers may:

```text
Select Question
Skip Question
Repeat Question
Add Follow-Up
Change Question
End Session
```

---

# 43. Teacher Evaluation

Teachers may evaluate:

```text
Correctness
Understanding
Confidence
Clarity
Communication
Completeness
```

according to configured rubrics.

---

# 44. Viva Rubrics

A rubric may contain:

```text
Criterion
Description
Maximum Marks
Performance Levels
Weight
```

---

# 45. Example Rubric

```text
Concept Understanding     10
Correctness                5
Explanation                5
Communication              5
Total                     25
```

---

# 46. Performance Levels

Possible levels:

```text
Excellent
Good
Satisfactory
Needs Improvement
Poor
```

---

# 47. Teacher Comments

Teachers may provide:

```text
Overall Comment
Question-Level Comment
Improvement Suggestion
Strength
Weakness
```

---

# 48. Student Feedback

After completion, students may receive:

```text
Score
Strengths
Weak Areas
Teacher Feedback
AI Feedback
Recommended Practice
```

---

# 49. Answer Review

Students may be allowed to replay their own responses.

This setting should be configurable.

---

# 50. Transcript

For recorded audio/video sessions, a transcript may be generated.

The transcript may be used for:

```text
Review
Search
Feedback
AI Analysis
Accessibility
```

---

# 51. Transcript Accuracy

Speech-to-text transcripts may contain errors.

The system should treat transcripts as derived data rather than replacing the original recording.

---

# 52. Pronunciation Practice

For language learning, the module may support pronunciation practice.

Possible areas:

```text
Word Pronunciation
Sentence Pronunciation
Reading Aloud
Conversation Practice
```

---

# 53. English Speaking Practice

The module may provide:

```text
Vocabulary Questions
Grammar Questions
Conversation Prompts
Picture Description
Reading Practice
Interview Questions
```

---

# 54. Urdu Speaking Practice

The architecture may support Urdu oral practice.

---

# 55. Interview Practice

Students may practice interview-style questions.

Examples:

```text
Introduce yourself.
Why do you want to study this subject?
What are your strengths?
Explain a project you completed.
```

---

# 56. Practical Viva

The Viva Module may integrate with the Practicals Module.

```text
PRACTICAL
 ↓
PRACTICAL TASK
 ↓
VIVA QUESTION
 ↓
STUDENT ANSWER
 ↓
EVALUATION
```

---

# 57. Coding Viva

The Coding Lab may generate viva questions about:

```text
Code
Logic
Variables
Functions
Algorithms
Errors
Output
```

---

# 58. Paper-Based Exam Viva

For examination preparation, the module may generate oral questions from relevant paper topics.

---

# 59. Mock Viva

Mock Viva simulates an examination environment.

Possible configuration:

```text
Number of Questions
Time Limit
Difficulty
Subject
Topic
Evaluation Method
```

---

# 60. Exam Mode

Exam Mode may restrict:

```text
Question Changes
External Assistance
AI Assistance
Retries
```

according to configuration.

---

# 61. AI Assistance Control

Possible settings:

```text
OFF
HINTS
PRACTICE ASSISTANCE
FULL PRACTICE MODE
```

AI assistance should generally be disabled for restricted assessments.

---

# 62. Viva Assignment

Teachers may assign Viva sessions to:

```text
Class
Section
Group
Individual Student
```

---

# 63. Assignment Configuration

A Viva assignment may define:

```text
Viva
Start Date
Due Date
Number of Attempts
Time Limit
AI Assistance
Recording
Evaluation Method
```

---

# 64. Attempts

Students may have multiple practice attempts.

Formal assessment attempts should follow assessment rules.

---

# 65. Practice History

Students may see:

```text
Previous Sessions
Scores
Topics
Feedback
Improvement
```

---

# 66. Viva Progress

Progress may track:

```text
Sessions Completed
Questions Answered
Correct Answers
Average Score
Average Response Time
Topic Mastery
```

---

# 67. Topic Progress

The system may identify topics where students struggle.

```text
WEAK TOPIC
 ↓
VIVA PRACTICE
 ↓
FEEDBACK
 ↓
REVISION
```

---

# 68. Communication Progress

For language and speaking practice, the system may track configurable indicators such as:

```text
Response Completeness
Speaking Practice Frequency
Answer Duration
Vocabulary Usage
Pronunciation Practice
```

These should not be treated as definitive measures of intelligence or ability.

---

# 69. Revision Engine Integration

Weak viva performance may trigger revision recommendations.

```text
VIVA PERFORMANCE
 ↓
WEAK CONCEPT
 ↓
REVISION ENGINE
 ↓
STUDY MATERIAL
 ↓
RETRY VIVA
```

---

# 70. Learning Progress Integration

Viva performance may contribute to learning progress.

```text
VIVA RESULT
 ↓
SKILL PERFORMANCE
 ↓
LEARNING PROGRESS
```

---

# 71. Flashcards Integration

Important viva concepts may be converted into flashcards.

```text
VIVA WEAK AREA
 ↓
FLASHCARDS
 ↓
RECALL PRACTICE
```

---

# 72. Writing Practice Integration

Viva and writing activities may reinforce communication skills.

```text
VIVA
 ↓
ORAL EXPLANATION
 ↓
WRITING PRACTICE
 ↓
STRUCTURED EXPLANATION
```

---

# 73. AI Tutor Integration

Students may ask the AI Tutor to explain a question they could not answer.

```text
VIVA QUESTION
 ↓
AI TUTOR
 ↓
EXPLANATION
 ↓
PRACTICE
 ↓
RETRY
```

---

# 74. Analytics Integration

Viva events may be sent to Analytics.

Examples:

```text
Viva Started
Question Asked
Answer Submitted
Question Skipped
Session Completed
Feedback Viewed
```

---

# 75. Notification Integration

Notifications may include:

```text
Viva Assigned
Viva Due
Viva Reminder
Feedback Available
Practice Recommended
```

---

# 76. Media Integration

The module may use:

```text
Audio
Video
Images
Diagrams
Screen Capture
```

where supported.

---

# 77. Accessibility

The module should support:

```text
Keyboard Navigation
Screen Readers
Text Mode
Captions
Transcripts
Readable Interface
Alternative Input
```

---

# 78. Low-Bandwidth Mode

A lightweight mode may provide:

```text
Text Questions
Text Answers
Compressed Audio
Optional Video
```

---

# 79. Mobile Support

The Viva Module should be optimized for:

```text
Mobile
Tablet
Desktop
```

---

# 80. Recording Privacy

Recording should only occur when enabled and properly disclosed.

Students should know when audio/video is being recorded.

---

# 81. Data Retention

Institutions should be able to configure retention rules for:

```text
Audio
Video
Transcripts
Viva Attempts
Feedback
```

---

# 82. Privacy

Viva recordings may contain biometric-like personal characteristics such as voice and appearance.

The system must therefore apply appropriate privacy, access and retention controls.

---

# 83. Access Control

Conceptually:

```text
AUTHENTICATION
 ↓
ROLE
 ↓
SESSION ACCESS
 ↓
RECORDING ACCESS
 ↓
ALLOW / DENY
```

---

# 84. Student Permissions

Students may:

```text
View Assigned Viva
Start Practice Viva
Submit Answers
View Own Recordings
View Feedback
Retry Practice
View Progress
```

---

# 85. Teacher Permissions

Teachers may:

```text
Create Viva
Edit Viva
Assign Viva
Conduct Viva
Evaluate Responses
Provide Feedback
View Student Progress
```

within authorized scope.

---

# 86. Administrator Permissions

Authorized administrators may manage:

```text
Viva Content
Official Question Sets
Rubrics
Moderation
System Settings
Analytics
```

---

# 87. Security

The system should protect:

```text
Audio
Video
Transcripts
Student Responses
Teacher Feedback
Assessment Data
AI Analysis
```

---

# 88. Academic Integrity

Restricted assessments should provide configurable controls against unauthorized assistance.

Possible controls:

```text
AI Disabled
Question Locking
Attempt Limits
Time Limits
Recording
Teacher Review
```

---

# 89. Anti-Cheating Considerations

Future versions may support configurable indicators such as:

```text
Unexpected Session Changes
Multiple Device Activity
Unusual Timing
Recording Interruptions
```

These indicators should not automatically be treated as proof of misconduct.

---

# 90. Audit Logging

Important events may include:

```text
VIVA_CREATED
VIVA_UPDATED
VIVA_PUBLISHED
VIVA_ASSIGNED
SESSION_STARTED
QUESTION_PRESENTED
ANSWER_STARTED
ANSWER_SUBMITTED
ANSWER_SKIPPED
RECORDING_STARTED
RECORDING_STOPPED
AI_ANALYSIS_REQUESTED
FEEDBACK_CREATED
SESSION_COMPLETED
SESSION_CANCELLED
```

---

# 91. API Boundary

Conceptual services:

```text
Create Viva
Get Viva
Update Viva
Delete Viva
Create Viva Question
Get Question
Start Session
Get Session
Present Question
Submit Answer
Upload Recording
Generate Transcript
Evaluate Answer
Submit Teacher Feedback
Generate AI Feedback
Complete Session
Get Viva Result
Get Viva Progress
Assign Viva
```

Exact endpoint naming belongs to the API architecture.

---

# 92. Core Components

```text
Viva Manager
Question Manager
Session Manager
Question Sequencer
Recording Manager
Speech-to-Text Adapter
Transcript Manager
Evaluation Engine
Rubric Engine
AI Viva Engine
Feedback Manager
Progress Tracker
Assignment Manager
Analytics Adapter
Notification Adapter
```

---

# 93. Complete Viva Architecture

```text
                         STUDENT
                            │
                            ↓
                       VIVA DASHBOARD
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
          PRACTICE       ASSIGNED        MOCK
             │              │              │
             └──────────────┼──────────────┘
                            ↓
                       START SESSION
                            │
                            ↓
                      PRESENT QUESTION
                            │
                            ↓
                     STUDENT ANSWERS
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
           AUDIO          VIDEO           TEXT
             │              │              │
             └──────────────┼──────────────┘
                            ↓
                       TRANSCRIPT
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
          TEACHER         AI           RULE-BASED
         EVALUATION     ANALYSIS        EVALUATION
             │              │              │
             └──────────────┼──────────────┘
                            ↓
                         FEEDBACK
                            │
                            ↓
                       PROGRESS DATA
                            │
             ┌──────────────┼──────────────┐
             ↓              ↓              ↓
          REVISION       FLASHCARDS      ANALYTICS
```

---

# 94. Teacher Viva Workflow

```text
LOGIN
 ↓
CREATE VIVA
 ↓
SELECT QUESTIONS
 ↓
CONFIGURE RUBRIC
 ↓
ASSIGN STUDENTS
 ↓
CONDUCT / REVIEW
 ↓
EVALUATE
 ↓
FEEDBACK
 ↓
PROGRESS
```

---

# 95. AI Viva Workflow

```text
STUDENT
 ↓
START AI VIVA
 ↓
AI ASKS QUESTION
 ↓
STUDENT ANSWERS
 ↓
SPEECH-TO-TEXT
 ↓
AI ANALYSIS
 ↓
FOLLOW-UP
 ↓
FINAL FEEDBACK
```

---

# 96. Practical Viva Workflow

```text
PRACTICAL TASK
 ↓
STUDENT COMPLETES TASK
 ↓
VIVA QUESTION
 ↓
ORAL ANSWER
 ↓
EVALUATION
 ↓
PRACTICAL PROGRESS
```

---

# 97. Viva Improvement Loop

```text
ANSWER
 ↓
FEEDBACK
 ↓
IDENTIFY WEAKNESS
 ↓
STUDY
 ↓
PRACTICE
 ↓
RETRY
 ↓
IMPROVEMENT
```

---

# 98. Future Features

The architecture should support:

```text
Real-Time AI Examiner
Voice-Based AI Conversation
Multilingual Viva
Advanced Pronunciation Practice
Adaptive Viva Difficulty
AI Interview Coach
Video-Based Practical Viva
Handwriting + Viva Integration
Virtual Lab Viva
Speaking Competitions
Peer Viva Practice
Teacher Live Classroom Viva
```

---

# 99. Testing Requirements

The Viva Module should be tested for:

```text
Viva Creation
Question Creation
Question Selection
Question Randomization
Session Creation
Session Start
Question Presentation
Audio Recording
Video Recording
Text Answers
Timer
Answer Submission
Retry
Skip
Follow-Up Questions
Speech-to-Text
Transcript
Teacher Evaluation
AI Evaluation
Rubrics
Feedback
Progress
Assignments
Notifications
Question Bank Integration
Practical Integration
Coding Lab Integration
Learning Progress
Revision Engine
Flashcards
Analytics
Permissions
Privacy
Recording Security
Data Retention
Accessibility
Mobile
Low Bandwidth
Concurrency
Performance
Failure Recovery
```

---

# 100. Final Viva Principle

The Aspirian Viva Module must provide:

> **A structured oral-learning and assessment environment where students practice explaining concepts, answering questions verbally, improving communication skills, receiving meaningful feedback and strengthening subject knowledge through repeated viva practice.**

The module should support teacher-led, recorded and AI-assisted viva experiences while maintaining clear boundaries between practice, formal assessment, official results, learning progress and AI assistance.

---

# 101. Document Status

**File:** `VIVA_MODULE.md`
**Version:** 1.0
**Status:** Final Viva Module Blueprint
**Phase:** D
**Module:** D16 — Viva Module
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Viva Module for the Aspirian Student Platform.
