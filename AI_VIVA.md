# Aspirian Student Platform — AI Viva System

**Version:** 1.0
**Status:** Final AI Viva System Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

The AI Viva System provides an intelligent oral assessment and viva-practice environment for Aspirian students.

The system can:

* Generate viva questions
* Ask questions interactively
* Accept text or voice answers
* Analyze student responses
* Provide feedback
* Identify weak concepts
* Adjust question difficulty
* Generate follow-up questions
* Create personalized viva sessions
* Provide performance analytics

---

# 2. Vision

The AI Viva System should simulate a real educational viva while remaining safe, curriculum-aligned and teacher-controlled.

Core workflow:

```text
CURRICULUM
     ↓
TOPIC / PRACTICAL
     ↓
AI VIVA
     ↓
QUESTION
     ↓
STUDENT ANSWER
     ↓
AI ANALYSIS
     ↓
FEEDBACK
     ↓
FOLLOW-UP QUESTION
     ↓
VIVA SCORE / PERFORMANCE
     ↓
LEARNING PROGRESS
```

---

# 3. Core Principle

The system should evaluate **understanding**, not merely exact wording.

A student should receive credit when the answer communicates the correct concept using different valid words.

---

# 4. Module Scope

The AI Viva module owns:

```text
AI Viva Question Generation
Interactive Viva
Voice-Based Viva
Text-Based Viva
Answer Analysis
Follow-Up Questions
Difficulty Adaptation
Concept Detection
Feedback
Viva Scoring Assistance
Viva Reports
Weakness Detection
Viva Practice
```

---

# 5. Non-Goals

The AI Viva System does not replace:

```text
Official Teacher Assessment
Official Examination Result
School Academic Policies
Human Examiner Judgment
```

AI evaluation should be treated as an assistance layer unless explicitly configured otherwise.

---

# 6. Viva Modes

Supported modes:

```text
Practice Viva
AI Mock Viva
Teacher-Assisted Viva
Exam Preparation Viva
Subject Viva
Chapter Viva
Topic Viva
Practical Viva
Coding Viva
Revision Viva
```

---

# 7. Subject Support

Potential subjects:

```text
Computer Science
Physics
Chemistry
Biology
Mathematics
English
Urdu
General Science
Pakistan Studies
Islamiyat
General Knowledge
Other Supported Subjects
```

---

# 8. Academic Scope

The system should support:

```text
Nursery → Class 12
```

with age-appropriate question complexity.

---

# 9. Viva Configuration

A teacher or student may select:

```text
Class
Subject
Chapter
Topic
Viva Type
Difficulty
Question Count
Language
Duration
```

---

# 10. Example Configuration

```text
Class: 9
Subject: Computer Science
Topic: Programming
Viva Type: Practice
Difficulty: Medium
Questions: 10
Language: English
```

---

# 11. Question Generation

AI may generate viva questions using:

```text
Curriculum
Approved Content
Question Bank
Practical Content
Learning Objectives
Previous Student Performance
```

---

# 12. Source-Grounded Questions

Questions should preferably be based on approved Aspirian educational content.

```text
APPROVED CONTENT
      ↓
AI VIVA QUESTION GENERATOR
      ↓
VALIDATED QUESTION
```

---

# 13. Question Types

AI Viva supports:

```text
Definition
Conceptual
Application
Reasoning
Comparison
Problem Solving
Scenario-Based
Practical
Coding
Follow-Up
```

---

# 14. Basic Viva Question

Example:

```text
Question:
What is a variable in programming?
```

---

# 15. Conceptual Viva

Example:

```text
Why do programmers use variables?
```

---

# 16. Application Viva

Example:

```text
If you need to store a student's age, which data type would you choose and why?
```

---

# 17. Reasoning Viva

Example:

```text
Why would using the wrong data type cause a problem?
```

---

# 18. Scenario Viva

Example:

```text
Suppose a program needs to store the names of 50 students. What structure would you use?
```

---

# 19. Practical Viva

Questions may be generated from practical activities.

Example:

```text
What is the purpose of this experiment?
```

---

# 20. Coding Viva

For programming students:

```text
What does this code do?
Why did you use a loop?
What will happen if this condition changes?
```

---

# 21. Follow-Up Questions

AI may ask a follow-up based on the student's answer.

Example:

```text
AI:
What is a variable?

Student:
A variable stores data.

AI:
Can a variable's value change during program execution?
```

---

# 22. Follow-Up Logic

Follow-up questions may be triggered by:

```text
Correct Answer
Partially Correct Answer
Incorrect Answer
Unclear Answer
High Confidence
Low Confidence
```

---

# 23. Adaptive Difficulty

Difficulty may change according to performance.

```text
Strong Answer
   ↓
Difficulty ↑

Weak Answer
   ↓
Difficulty ↓
```

---

# 24. Difficulty Levels

```text
Very Easy
Easy
Medium
Hard
Very Hard
```

---

# 25. Cognitive Levels

AI Viva may classify questions using:

```text
Remember
Understand
Apply
Analyze
Evaluate
Create
```

---

# 26. Student Answer Modes

The system should support:

```text
Text Answer
Voice Answer
```

---

# 27. Voice Viva

Voice workflow:

```text
AI SPEAKS
   ↓
STUDENT LISTENS
   ↓
STUDENT ANSWERS
   ↓
SPEECH-TO-TEXT
   ↓
AI ANALYSIS
   ↓
FEEDBACK
```

---

# 28. Text Viva

Text workflow:

```text
QUESTION
   ↓
STUDENT TYPES ANSWER
   ↓
AI ANALYSIS
   ↓
FEEDBACK
```

---

# 29. Speech Recognition

Voice answers may be converted into text using a speech-recognition service.

The architecture should remain provider-independent.

---

# 30. Speech Recognition Errors

The system should account for:

```text
Accent
Pronunciation
Background Noise
Incomplete Speech
Recognition Errors
```

A speech-to-text mistake should not automatically become an academic mistake.

---

# 31. Answer Analysis

The AI should analyze:

```text
Conceptual Correctness
Relevance
Completeness
Reasoning
Key Concepts
Misconceptions
```

---

# 32. Answer Classification

Potential classifications:

```text
Correct
Mostly Correct
Partially Correct
Incorrect
Irrelevant
Unclear
No Answer
```

---

# 33. Concept Matching

The system should identify whether the student included required concepts even when wording differs.

---

# 34. Semantic Evaluation

Evaluation should focus on meaning rather than exact phrase matching.

Example:

```text
Expected:
A variable stores data.

Student:
A variable is a place where a program keeps a value.
```

This should generally be recognized as conceptually correct.

---

# 35. Partial Credit

For subjective viva answers, the system may provide:

```text
Full Credit
Partial Credit
No Credit
```

according to configured rubrics.

---

# 36. Rubric-Based Evaluation

Teachers may define criteria.

Example:

```text
Definition → 2 marks
Concept → 2 marks
Example → 1 mark
```

---

# 37. Teacher Rubrics

Teachers may create subject-specific viva rubrics.

---

# 38. AI Scoring Assistance

AI may recommend a score, but teachers should retain final authority for official assessment.

---

# 39. Score Range

Possible score representation:

```text
0–100
```

or configured marks.

---

# 40. Feedback

After an answer, AI may provide:

```text
What You Got Right
What You Missed
How to Improve
Suggested Revision
```

---

# 41. Immediate Feedback

Practice mode may provide immediate feedback.

---

# 42. Exam Mode Feedback

In secure exam mode, immediate feedback may be disabled.

---

# 43. Encouraging Feedback

Feedback should be constructive and age-appropriate.

---

# 44. No False Praise

The system should not claim an answer is correct when it is not.

---

# 45. Explain Incorrect Answers

Example:

```text
Your answer is partially correct.

You correctly identified X, but you missed Y.
```

---

# 46. Misconception Detection

The system may identify likely misconceptions.

Example:

```text
Student believes:
RAM permanently stores data.
```

The AI may flag the misconception and recommend revision.

---

# 47. Weak Concept Detection

Repeated weak answers may trigger:

```text
AI REVISION ENGINE
```

---

# 48. Revision Integration

```text
VIVA PERFORMANCE
      ↓
WEAK CONCEPT
      ↓
AI REVISION ENGINE
      ↓
TARGETED REVISION
```

---

# 49. AI Tutor Integration

If a student struggles:

```text
VIVA
 ↓
WEAK ANSWER
 ↓
AI TUTOR
 ↓
EXPLANATION
 ↓
NEW VIVA QUESTION
```

---

# 50. AI Question Generator Integration

The AI Viva system can request additional questions from the AI Question Generator.

---

# 51. Question Bank Integration

Approved viva questions should be stored in or linked to the Question Bank.

---

# 52. Practical Module Integration

Practical viva questions should reference approved practical activities.

---

# 53. Coding Lab Integration

Coding viva may reference:

```text
Programs
Assignments
Code Exercises
Debugging Tasks
```

---

# 54. Student Performance Integration

The system may use previous:

```text
Viva Performance
Test Results
Revision Performance
Learning Progress
```

to personalize questions.

---

# 55. Personalized Viva

Example:

```text
Student Weakness:
Loops

AI Viva:
Ask 5 questions focused on loops.
```

---

# 56. Viva Session Structure

A standard session:

```text
1. Introduction
2. Easy Question
3. Concept Question
4. Application Question
5. Follow-Up
6. Difficult Question
7. Final Feedback
```

---

# 57. Warm-Up Questions

The system may start with easier questions to establish context.

---

# 58. Progressive Difficulty

Difficulty may increase as understanding becomes evident.

---

# 59. Adaptive Viva

The system may dynamically choose the next question.

```text
ANSWER
  ↓
ANALYZE
  ↓
SELECT NEXT QUESTION
  ↓
ASK
```

---

# 60. Viva Session Length

Configurable:

```text
5 Questions
10 Questions
15 Questions
20 Questions
```

or duration-based.

---

# 61. Time-Based Viva

Teacher may define:

```text
5 Minutes
10 Minutes
15 Minutes
20 Minutes
```

---

# 62. Question Timeout

If a student does not answer within the configured period:

```text
No Answer
```

may be recorded.

---

# 63. Skip Question

Practice mode may allow students to skip.

---

# 64. Retry

Practice mode may allow:

```text
Try Again
```

where appropriate.

---

# 65. Exam Mode

Exam mode may disable:

```text
Retry
Answer Reveals
Immediate Feedback
Unlimited Skips
```

according to exam settings.

---

# 66. Viva Session States

Potential states:

```text
READY
IN_PROGRESS
PAUSED
COMPLETED
CANCELLED
EXPIRED
```

---

# 67. Question States

```text
ASKED
ANSWERED
SKIPPED
TIMEOUT
REVIEWED
```

---

# 68. Viva Session Metadata

Conceptual fields:

```text
Viva Session ID
Student ID
Class
Subject
Topic
Mode
Language
Difficulty
Question Count
Duration
Start Time
End Time
Score
Status
```

---

# 69. Answer Metadata

```text
Answer ID
Question ID
Answer Text
Voice Recording Reference
Speech-to-Text Result
Answer Classification
AI Score
Teacher Score
Feedback
```

---

# 70. AI Metadata

Track:

```text
AI Provider
Model
Model Version
Prompt Version
Generation Time
Evaluation Time
```

---

# 71. Audit Trail

Important events should be recorded:

```text
Session Started
Question Generated
Question Asked
Answer Submitted
Answer Evaluated
Teacher Reviewed
Session Completed
```

---

# 72. Teacher Review

Teachers may review:

```text
Questions
Student Answers
AI Evaluation
Scores
Feedback
```

---

# 73. Teacher Override

Teachers may override:

```text
AI Classification
AI Score
AI Feedback
```

for official assessments.

---

# 74. Teacher Notes

Teachers may add private evaluation notes.

---

# 75. Student Report

After practice, students may receive:

```text
Total Questions
Correct Answers
Partial Answers
Incorrect Answers
Score
Strong Topics
Weak Topics
Recommended Revision
```

---

# 76. Teacher Report

Teachers may receive:

```text
Student Performance
Question-Level Results
Weak Concepts
Repeated Mistakes
Viva Score
```

---

# 77. School Analytics

Schools may view aggregated:

```text
Subject Performance
Class Performance
Topic Weaknesses
Viva Completion
```

---

# 78. Parent Summary

Parents may receive appropriate high-level summaries.

---

# 79. Privacy

Voice recordings and student answers are educational data and should be handled securely.

---

# 80. Voice Recording Retention

The platform should define configurable retention policies.

For example:

```text
Practice Voice:
Temporary / Optional

Official Viva:
Retained According to School Policy
```

---

# 81. Student Data Minimization

Only necessary information should be sent to AI providers.

---

# 82. Tenant Isolation

School-specific viva sessions and recordings must remain isolated.

---

# 83. Security

Implement:

```text
Authentication
Authorization
Role-Based Access
Tenant Isolation
Encryption
Audit Logging
Rate Limiting
Input Validation
Output Validation
```

---

# 84. AI Safety

AI should not provide:

```text
Dangerous Instructions
Illegal Instructions
Age-Inappropriate Content
Harmful Content
```

---

# 85. Child Safety

Since Aspirian serves school-age students, AI viva interactions must use strong age-appropriate safety controls.

---

# 86. Bias Control

The system should evaluate academic content rather than:

```text
Accent
Gender
Background
Personality
```

when these are irrelevant to the assessment.

---

# 87. Accent Fairness

Accent or pronunciation should not reduce academic scoring unless pronunciation itself is the learning objective.

---

# 88. Language Support

The system should support:

```text
English
Urdu
Roman Urdu
```

where supported by the speech and AI infrastructure.

---

# 89. Bilingual Viva

Possible future mode:

```text
Question: English
Explanation: Urdu
```

or:

```text
Question: Urdu
Answer: English
```

according to configuration.

---

# 90. AI Model Gateway

The AI Viva system should use a provider-independent gateway.

```text
AI VIVA SERVICE
       ↓
MODEL GATEWAY
   ├── Provider A
   ├── Provider B
   └── Future Provider
```

---

# 91. Speech Provider Gateway

Speech recognition should also use an abstraction layer.

```text
VOICE INPUT
     ↓
SPEECH GATEWAY
   ├── Provider A
   ├── Provider B
   └── Future Provider
```

---

# 92. Model Fallback

If the primary AI model fails:

```text
PRIMARY
 ↓
FAILURE
 ↓
FALLBACK
```

---

# 93. Prompt Versioning

Viva prompts must be version controlled.

Example:

```text
AI Viva Prompt v1
AI Viva Prompt v2
```

---

# 94. Prompt Context

Possible context:

```text
Class
Subject
Topic
Learning Objective
Approved Content
Viva Mode
Difficulty
Previous Answers
```

---

# 95. Source Grounding

The AI should preferably generate questions from approved content.

---

# 96. Hallucination Prevention

Unsupported facts should not become viva questions.

---

# 97. Structured Output

AI evaluation should return structured information.

Conceptually:

```text
Answer Classification
Score
Correct Concepts
Missing Concepts
Misconceptions
Feedback
Next Question Recommendation
```

---

# 98. Validation

AI output must be validated before being stored as official assessment data.

---

# 99. Error Handling

Potential errors:

```text
VIVA_GENERATION_FAILED
SPEECH_RECOGNITION_FAILED
AI_EVALUATION_FAILED
MODEL_UNAVAILABLE
TIMEOUT
INVALID_CONTEXT
RATE_LIMITED
UNAUTHORIZED
```

---

# 100. Graceful Failure

If AI evaluation fails, the session should not lose the student's submitted answer.

The answer should be stored and marked:

```text
PENDING_REVIEW
```

where appropriate.

---

# 101. Offline / Fallback Mode

Where possible, text-based viva should remain available even if voice services are unavailable.

---

# 102. Rate Limiting

Viva generation and AI evaluation should be rate-limited to control:

```text
Abuse
System Load
AI Costs
```

---

# 103. Usage Tracking

Track:

```text
Viva Sessions
Questions Generated
Answers Evaluated
Voice Minutes
AI Tokens
Estimated Cost
```

---

# 104. Cost Management

Use:

```text
Caching
Question Bank Reuse
Efficient Prompts
Model Routing
Batch Processing
```

where appropriate.

---

# 105. Performance

Question generation and answer evaluation should be optimized for interactive response times.

---

# 106. Scalability

The architecture should support:

```text
1,000 Students
10,000 Students
100,000+ Students
```

without fundamental redesign.

---

# 107. Observability

Monitor:

```text
Session Count
Generation Latency
Evaluation Latency
Speech Recognition Success
Failure Rate
AI Cost
```

---

# 108. Quality Evaluation

Evaluate the system using:

```text
Question Quality
Answer Evaluation Accuracy
Teacher Agreement
Student Feedback
Topic Alignment
```

---

# 109. Teacher Agreement

Compare AI scoring with teacher scoring to measure evaluation reliability.

---

# 110. Human Evaluation

Teachers should periodically review AI-evaluated viva samples.

---

# 111. Regression Testing

Changes to:

```text
AI Model
Prompt
Speech System
Question Generator
Curriculum
Evaluation Rules
```

should trigger regression testing.

---

# 112. Revision Trigger

Repeated weak viva performance should trigger revision recommendations.

```text
VIVA
 ↓
WEAK CONCEPT
 ↓
AI REVISION ENGINE
```

---

# 113. Mastery Trigger

Consistent strong viva performance may contribute to mastery evidence.

The Learning Progress module remains the source of truth.

---

# 114. Gamification Integration

Completed practice viva sessions may contribute to:

```text
XP
Badges
Achievements
Streaks
```

according to Gamification rules.

---

# 115. Notification Integration

The Notification System may remind students about:

```text
Scheduled Viva
Viva Practice
Pending Revision
Exam Preparation
```

---

# 116. AI Viva Workflow — Practice

```text
STUDENT
  ↓
SELECT SUBJECT
  ↓
SELECT TOPIC
  ↓
START AI VIVA
  ↓
AI ASKS QUESTION
  ↓
STUDENT ANSWERS
  ↓
AI ANALYZES
  ↓
FEEDBACK
  ↓
FOLLOW-UP
  ↓
NEXT QUESTION
  ↓
FINAL REPORT
```

---

# 117. AI Viva Workflow — Voice

```text
AI QUESTION
     ↓
TEXT-TO-SPEECH
     ↓
STUDENT LISTENS
     ↓
VOICE ANSWER
     ↓
SPEECH-TO-TEXT
     ↓
AI EVALUATION
     ↓
FEEDBACK
```

---

# 118. AI Viva Workflow — Teacher

```text
TEACHER
  ↓
SELECT CLASS
  ↓
SELECT SUBJECT
  ↓
SELECT TOPIC
  ↓
CONFIGURE VIVA
  ↓
GENERATE
  ↓
REVIEW
  ↓
ASSIGN / START
  ↓
RESULTS
```

---

# 119. AI Viva Workflow — Practical

```text
PRACTICAL
   ↓
EXPERIMENT / TASK
   ↓
AI VIVA
   ↓
CONCEPT QUESTIONS
   ↓
PROCEDURE QUESTIONS
   ↓
RESULT QUESTIONS
   ↓
PERFORMANCE REPORT
```

---

# 120. AI Viva Workflow — Adaptive

```text
QUESTION
   ↓
ANSWER
   ↓
ANALYSIS
   ↓
STRONG / WEAK
   ↓
SELECT NEXT DIFFICULTY
   ↓
FOLLOW-UP QUESTION
```

---

# 121. Complete Aspirian AI Viva Loop

```text
              CURRICULUM
                   ↓
            APPROVED CONTENT
                   ↓
            AI VIVA SYSTEM
                   ↓
              QUESTION
                   ↓
            STUDENT ANSWER
                   ↓
             AI ANALYSIS
                   ↓
        ┌──────────┴──────────┐
        ↓                     ↓
   CORRECT                 WEAK
        ↓                     ↓
 NEXT QUESTION        AI REVISION ENGINE
                              ↓
                         AI TUTOR
                              ↓
                        NEW PRACTICE
```

---

# 122. Future Features

The architecture should support:

```text
AI Video Viva
AI Avatar Examiner
Real-Time Voice Conversation
Multilingual Voice Viva
AI Pronunciation Practice
AI Presentation Viva
AI Interview Practice
AI Job Interview Simulation
AI Medical / Engineering Viva Practice
AI Practical Demonstration Evaluation
```

---

# 123. AI Avatar Examiner

Future versions may provide an animated AI examiner.

The avatar should remain an interface layer, not the academic authority.

---

# 124. Real-Time Conversation

Future versions may support natural conversational viva:

```text
AI Question
 ↓
Student Answer
 ↓
AI Follow-Up
 ↓
Student Explanation
 ↓
AI Counter Question
```

---

# 125. Presentation Viva

Students may upload or present a project and answer AI-generated questions about it.

---

# 126. Project Viva

Possible workflow:

```text
PROJECT
 ↓
AI ANALYSIS
 ↓
QUESTION GENERATION
 ↓
VIVA
 ↓
FEEDBACK
```

---

# 127. Final Design Principle

The Aspirian AI Viva System must be:

```text
Interactive
Curriculum-Aware
Adaptive
Voice-Capable
Text-Capable
Semantic
Fair
Explainable
Teacher-Controlled
Privacy-Aware
Scalable
```

The most important rule is:

> **AI Viva should evaluate demonstrated understanding rather than memorized wording, while human teachers retain authority over official assessment decisions.**

---

# 128. Document Status

**File:** `AI_VIVA.md`
**Version:** 1.0
**Status:** Final AI Viva System Blueprint
**Phase:** F
**Module:** F5 — AI Viva
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official AI Viva System for the Aspirian Student Platform.
