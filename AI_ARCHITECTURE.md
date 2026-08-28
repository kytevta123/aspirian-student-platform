# Aspirian Student Platform — AI Architecture

**Version:** 1.0
**Status:** Technical Design Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12

---

# 1. Purpose

Aspirian Student Platform will use Artificial Intelligence as a supporting educational layer rather than making AI the entire platform.

The AI architecture will support:

* AI Tutor
* Question Generation
* Question Explanation
* Personalized Learning
* Mistake Analysis
* Revision Recommendations
* Exam Score Forecasting
* Teacher Paper Builder
* Notes Generation
* Formula Sheet Generation
* Cheat-Sheet Generation
* Audio-to-Notes
* Audio Summary
* Video-to-Keynotes
* Video-to-Flashcards
* Video Quiz Generation
* Smart Interactive Video Quiz
* AI Viva
* Writing Assistance
* Coding Assistance
* Learning Analytics

---

# 2. Core AI Philosophy

Aspirian AI must follow this principle:

> **AI should assist learning, not replace learning.**

AI-generated educational material should be:

* Context-aware
* Grade-aware
* Subject-aware
* Board-aware
* Topic-aware
* Explainable where practical
* Reviewable
* Safe
* Age-appropriate

---

# 3. High-Level AI Architecture

```text
                         Student / Teacher
                                │
                                ▼
                         Aspirian App
                                │
                                ▼
                            API Layer
                                │
                                ▼
                         AI Orchestrator
                                │
              ┌─────────────────┼─────────────────┐
              │                 │                 │
              ▼                 ▼                 ▼
        AI Tutor Engine    Generation Engine   Learning Engine
              │                 │                 │
              └─────────────────┼─────────────────┘
                                │
                    ┌───────────┼───────────┐
                    │           │           │
                    ▼           ▼           ▼
                Knowledge     Student     AI Models
                  Layer        Data
                    │
                    ▼
               PostgreSQL
                    │
                    ▼
              Vector Search
```

---

# 4. AI Orchestrator

The AI Orchestrator is the central component responsible for deciding:

* Which AI service should handle a request
* Which educational context should be provided
* Which knowledge sources should be retrieved
* Which model should be used
* Whether human review is required
* Whether the task should be synchronous or asynchronous

Example:

```text
User Question
      ↓
AI Orchestrator
      ↓
Identify Grade
      ↓
Identify Subject
      ↓
Identify Topic
      ↓
Retrieve Relevant Knowledge
      ↓
Select AI Task
      ↓
Generate Response
      ↓
Validate
      ↓
Return Response
```

---

# 5. AI Context System

AI responses should use educational context whenever possible.

Context may include:

```text
Grade
Board
Academic Session
Subject
Book
Chapter
Topic
Learning Objective
Student Mastery
Student Mistakes
Current Test
Previous Attempts
```

Example:

```text
Student:
"Explain this formula."

System Context:
Grade 10
Punjab Board
Physics
Chapter 2
Topic: Motion
```

This should produce a more relevant response than a generic AI prompt.

---

# 6. AI Tutor

## Purpose

The AI Tutor will provide interactive educational assistance.

Capabilities:

* Explain concepts
* Answer questions
* Simplify difficult topics
* Give examples
* Ask follow-up questions
* Generate practice questions
* Explain mistakes
* Recommend revision
* Provide step-by-step guidance

---

# 7. AI Tutor Learning Modes

The tutor should support different modes.

```text
Explain Mode
Practice Mode
Hint Mode
Exam Mode
Revision Mode
Socratic Mode
Quick Answer Mode
Detailed Answer Mode
```

---

# 8. Age-Aware AI Tutor

Because Aspirian starts from Nursery, AI responses must be age/grade appropriate.

Example:

```text
Nursery/KG
↓
Very simple language
Visual concepts
Short responses

Primary
↓
Simple explanations
Examples
Interactive questions

Middle School
↓
Conceptual explanations
Practice

Secondary / Higher Secondary
↓
Detailed concepts
Exam preparation
Board-oriented material
```

The system must not expose unnecessarily advanced or inappropriate content to younger learners.

---

# 9. Knowledge Retrieval

The AI Tutor should retrieve relevant Aspirian educational content before generating answers where appropriate.

```text
Student Question
       ↓
Search Knowledge Base
       ↓
Relevant Content
       ↓
Prompt Context
       ↓
AI Model
       ↓
Answer
```

This is the foundation of a future RAG system.

---

# 10. Retrieval Sources

Possible sources:

* Aspirian Notes
* Question Bank
* Textbook-aligned content
* Definitions
* Formulas
* Practicals
* Activities
* Teacher-created material
* Approved educational resources

Unverified AI-generated material should not automatically become trusted knowledge.

---

# 11. Retrieval-Augmented Generation

Future architecture:

```text
User Query
    ↓
Query Understanding
    ↓
Embedding
    ↓
Vector Search
    ↓
Relevant Knowledge
    ↓
Prompt Construction
    ↓
LLM
    ↓
Answer
```

Vector search may use PostgreSQL-compatible vector infrastructure.

---

# 12. Source Grounding

Where appropriate, AI answers should be connected to the educational source used.

Example:

```text
Answer
↓
Based on:
Class 10 Physics
Chapter 3
Topic: Waves
```

This improves trust and allows students to open the original learning material.

---

# 13. AI Question Generator

The system will generate questions according to:

* Grade
* Subject
* Chapter
* Topic
* Difficulty
* Question type
* Number of questions
* Marks
* Board style

Example:

```text
Class 9
Biology
Chapter 1
MCQs
Medium
10 Questions
```

---

# 14. Question Generation Pipeline

```text
Teacher Request
      ↓
Context Selection
      ↓
Knowledge Retrieval
      ↓
AI Generation
      ↓
Schema Validation
      ↓
Duplicate Detection
      ↓
Quality Checks
      ↓
Teacher Review
      ↓
Question Bank
```

AI-generated questions should not automatically become approved questions.

---

# 15. AI Question Quality Checks

The system should check:

* Correct answer
* Option validity
* Duplicate questions
* Ambiguous wording
* Difficulty
* Topic relevance
* Marks
* Curriculum alignment

---

# 16. Teacher Paper Builder

The AI Paper Builder will allow teachers to generate papers from the Question Bank.

Teacher can specify:

```text
Class
Subject
Board
Chapters
Total Marks
Difficulty
MCQs
Short Questions
Long Questions
Time
```

Architecture:

```text
Teacher Requirements
        ↓
Paper Blueprint
        ↓
Question Bank
        ↓
Question Selection
        ↓
AI Optimization
        ↓
Paper
        ↓
Teacher Review
        ↓
Export
```

---

# 17. Smart Paper Generation

The system should prevent:

* Excessive questions from one topic
* Incorrect marks distribution
* Duplicate questions
* Unbalanced difficulty
* Missing important topics

---

# 18. Formula Sheet Builder

AI will generate structured formula sheets.

Input:

```text
Class
Subject
Chapter
```

Output:

```text
Formula
Meaning
Variables
Units
Example
```

The system should prefer verified educational sources.

---

# 19. Cheat-Sheet Builder

The Cheat-Sheet Builder is intended for legitimate revision.

It may generate:

* Key formulas
* Definitions
* Important points
* Mnemonics
* Quick revision tables
* Common mistakes
* Important concepts

It must not encourage academic cheating during examinations.

---

# 20. Personalized Revision Queue

This is one of Aspirian's most important AI features.

The system will analyze:

```text
Student Performance
+
Mistakes
+
Topic Mastery
+
Revision History
+
Upcoming Exams
```

and produce:

```text
Personalized Revision Queue
```

Example:

```text
Today

1. Revise Newton's Laws
2. Practice 5 weak MCQs
3. Review Photosynthesis
4. Attempt Physics mini-test
```

---

# 21. Mistakes Notebook Intelligence

The AI system can identify patterns.

Example:

```text
Student repeatedly makes mistakes in:

Fractions
↓
Topic mastery decreases
↓
AI identifies weakness
↓
Revision recommendation
↓
Practice
↓
Re-evaluation
```

---

# 22. Spaced Revision

Future revision algorithms may consider:

* Previous performance
* Time since revision
* Mistake frequency
* Confidence
* Difficulty

The exact algorithm will evolve based on real student data.

---

# 23. Predictive Exam Score Forecaster

The platform may estimate future performance.

Inputs:

```text
Previous Tests
Practice Results
Topic Mastery
Revision Activity
Mistakes
Time Remaining
```

Output:

```text
Estimated Score
Possible Range
Confidence
Strong Areas
Weak Areas
Recommended Actions
```

The system must clearly state that this is an estimate and not a guaranteed result.

---

# 24. Student Performance Model

Conceptual model:

```text
Student
   │
   ├── Attempts
   ├── Mistakes
   ├── Mastery
   ├── Revision
   ├── Practice
   └── Activity
          │
          ▼
    Learning Profile
          │
          ▼
       AI Engine
          │
          ▼
 Recommendations
```

---

# 25. Audio-to-Notes

Students and teachers may upload or record audio.

Pipeline:

```text
Audio
 ↓
Speech-to-Text
 ↓
Transcript
 ↓
Topic Detection
 ↓
Key Concepts
 ↓
Structured Notes
 ↓
Summary
```

---

# 26. Audio Exam Summary

The system may generate:

* Quick revision summary
* Important points
* Definitions
* Formulas
* Key questions
* Action items

The output should remain educational rather than replacing the original material.

---

# 27. Video-to-Keynotes

Pipeline:

```text
Video
 ↓
Transcript
 ↓
Topic Segmentation
 ↓
Key Concepts
 ↓
Keynotes
```

---

# 28. Video-to-Flashcards

Pipeline:

```text
Video
 ↓
Transcript
 ↓
Important Concepts
 ↓
Question/Answer Pairs
 ↓
Flashcards
 ↓
Student Review
```

---

# 29. Video Quiz Generator

The AI may generate questions from educational videos.

```text
Video
 ↓
Transcript
 ↓
Concept Extraction
 ↓
Question Generation
 ↓
Timestamp Mapping
 ↓
Video Quiz
```

---

# 30. Smart Interactive Video Quiz

During a video:

```text
Video Playing
      ↓
Timestamp Reached
      ↓
Question Appears
      ↓
Student Answers
      ↓
Immediate Feedback
      ↓
Continue Video
```

Results can contribute to the student's learning profile.

---

# 31. AI Viva

AI Viva can simulate oral questioning.

Possible flow:

```text
Topic
 ↓
AI asks question
 ↓
Student answers by text/voice
 ↓
Speech-to-text
 ↓
Answer evaluation
 ↓
Feedback
 ↓
Next question
```

Possible evaluation areas:

* Concept understanding
* Accuracy
* Completeness
* Confidence
* Missing concepts

---

# 32. Writing AI

Supported areas:

* Essay
* Letter
* Application
* Story
* Dialogue
* Paragraph
* Summary
* Report
* Notice
* Speech

AI should primarily provide:

* Guidance
* Structure
* Feedback
* Corrections
* Improvement suggestions

The system should avoid encouraging students to submit AI-generated work dishonestly.

---

# 33. Coding AI

For Python and other supported educational programming:

```text
Student Code
 ↓
Syntax Analysis
 ↓
Test Execution
 ↓
Error Detection
 ↓
Explanation
 ↓
Hint
```

The AI should preferably provide hints before directly giving complete solutions for learning exercises.

---

# 34. Secure Code Execution

Student code must run in an isolated sandbox.

```text
Student
 ↓
API
 ↓
Code Sandbox
 ↓
Resource Limits
 ↓
Execution
 ↓
Result
```

Limits may include:

* CPU
* Memory
* Runtime
* Network access
* File access

---

# 35. AI Image/OCR Support

Future AI services may process:

* Handwritten questions
* Printed questions
* Diagrams
* Mathematical expressions
* Science diagrams
* Uploaded homework

Pipeline:

```text
Image
 ↓
OCR / Vision
 ↓
Content Understanding
 ↓
Question / Topic Detection
 ↓
AI Assistance
```

---

# 36. AI Diagram Assistance

For subjects such as:

* Biology
* Physics
* Chemistry
* Computer Science

AI may help explain or identify diagram components.

Verified educational diagrams should remain preferred over unrestricted AI-generated diagrams where accuracy is critical.

---

# 37. AI Model Abstraction

The application should not tightly couple business logic to one AI provider.

Architecture:

```text
AI Service Interface
       │
 ┌─────┼─────┐
 │     │     │
Model A Model B Model C
```

This allows future model changes without rewriting the entire application.

---

# 38. Model Selection

Different tasks may use different models.

Example:

```text
Simple classification
↓
Low-cost model

Complex educational reasoning
↓
Advanced model

Speech recognition
↓
Speech model

Image understanding
↓
Vision model
```

The exact providers/models will be selected during implementation based on:

* Accuracy
* Cost
* Speed
* Availability
* Privacy
* Reliability

---

# 39. AI Cost Management

AI usage can become expensive.

The platform should implement:

* Token limits
* Request limits
* Caching
* Model routing
* Background processing
* Usage monitoring
* User quotas

---

# 40. AI Usage Tracking

The system should track:

```text
User
Request
Feature
Model
Input Tokens
Output Tokens
Cost Estimate
Duration
Status
```

This is important for future monetization and operational control.

---

# 41. Prompt Management

Prompts should not be scattered throughout application code.

Future architecture:

```text
Prompt Templates
       ↓
Version Control
       ↓
AI Orchestrator
       ↓
Model
```

Prompt versions should be identifiable.

---

# 42. AI Output Validation

AI output should be validated before being stored or shown where necessary.

Validation may include:

* JSON schema
* Required fields
* Content type
* Educational context
* Safety checks
* Duplicate checks

---

# 43. Human-in-the-Loop

High-impact educational content should allow human review.

```text
AI
 ↓
Draft
 ↓
Teacher/Editor Review
 ↓
Approved
 ↓
Published
```

Especially important for:

* Question Bank
* Exam Papers
* Educational Notes
* Formula Sheets
* Curriculum content

---

# 44. AI Hallucination Protection

The platform should reduce hallucinations by:

* Retrieval from trusted sources
* Structured prompts
* Source grounding
* Output validation
* Human review
* Clear uncertainty handling

The system should not pretend certainty when the underlying information is uncertain.

---

# 45. AI Safety for Students

The AI system should include:

* Age-appropriate behavior
* Content safety
* Abuse prevention
* Privacy protection
* Prompt injection defenses
* Rate limiting
* Moderation

---

# 46. Student Privacy

AI requests should use the minimum required personal information.

The AI system should not unnecessarily receive:

* Passwords
* Authentication secrets
* Private account credentials
* Unrelated personal information

---

# 47. AI Prompt Injection Defense

Educational content may contain malicious or misleading instructions.

Retrieved content must be treated as data, not as system instructions.

Conceptually:

```text
System Instructions
      ↓
Developer Rules
      ↓
User Request
      ↓
Retrieved Educational Data
```

Retrieved documents must not override system policies.

---

# 48. AI Background Jobs

Long tasks should run asynchronously.

Examples:

* Video transcription
* Audio processing
* Flashcard generation
* Large question generation
* Document processing
* Score analysis

Architecture:

```text
Request
 ↓
Job Queue
 ↓
Worker
 ↓
AI Service
 ↓
Database
```

---

# 49. AI Caching

Repeated requests may be cached where safe.

Examples:

* Common explanations
* Public educational summaries
* Formula references
* Static generated resources

Private student-specific responses should not be shared between users.

---

# 50. AI Analytics

The platform should analyze:

* Most requested topics
* Common student mistakes
* Popular AI features
* AI response quality
* Generation success rate
* Cost
* Latency

These analytics can improve the platform.

---

# 51. AI Feature Roadmap

## Phase 1

```text
AI Tutor
AI Explanations
Question Generation
Basic Summaries
```

## Phase 2

```text
Personalized Revision
Mistake Analysis
Flashcards
Formula Builder
Paper Builder
```

## Phase 3

```text
Audio-to-Notes
Video-to-Keynotes
Video-to-Flashcards
Video Quiz
AI Viva
```

## Phase 4

```text
Predictive Score Forecasting
Advanced Personalization
Vision/OCR
Adaptive Learning
```

---

# 52. AI Architecture and Existing Aspirian Website

The existing WordPress website:

```text
aspirian.pk
```

will remain primarily responsible for:

* Public educational content
* Articles
* SEO
* Notes
* Tutorials
* Free online tools
* Job & Career Hub
* Organic traffic
* Student acquisition

The AI learning platform will operate separately:

```text
app.aspirian.pk
```

This separation protects the existing WordPress site's stability while allowing the application to evolve independently.

---

# 53. AI + WordPress Relationship

Conceptual architecture:

```text
                    aspirian.pk
                         │
              Public Educational Layer
                         │
                         │
                         ▼
                 Student Discovery
                         │
                         ▼
                  app.aspirian.pk
                         │
                         ▼
                    API Layer
                         │
                         ▼
                     AI Layer
```

WordPress content may be integrated into the application through controlled APIs or content synchronization where appropriate.

---

# 54. AI + YouTube

The platform may use YouTube for:

* Educational videos
* Live classes
* Student broadcasts
* Educational programs
* Live events

The application can embed or reference approved YouTube content rather than storing every video locally.

---

# 55. AI + Aspirian Internet Radio

The future Aspirian Internet Radio system may provide:

* Educational audio
* Study sessions
* Exam preparation programs
* Student discussions
* Career guidance
* Live educational broadcasts

AI may later assist with:

* Program summaries
* Transcripts
* Keynotes
* Searchable audio archives

---

# 56. AI Governance

Every AI feature should have:

```text
Purpose
Owner
Input
Output
Validation
Safety Rules
Cost Model
Logging
Fallback
```

No AI feature should be introduced without defining these components.

---

# 57. AI Failure Handling

If an AI service fails:

```text
AI Request
 ↓
AI Service
 ↓
Failure
 ↓
Retry / Fallback
 ↓
User-Friendly Message
```

The application must not crash because an AI provider is temporarily unavailable.

---

# 58. AI Provider Independence

The platform must avoid architectural dependence on one provider.

AI integrations should be implemented behind internal service interfaces.

This allows:

* Provider switching
* Model upgrades
* Cost optimization
* Regional availability changes
* Multi-model strategies

---

# 59. AI Architecture Status

**Version:** 1.0
**Status:** Technical Design Blueprint

This document defines the conceptual AI architecture.

Specific AI providers, models, prompt templates, vector database implementation, pricing strategy, and production infrastructure will be finalized during implementation.

---

# Final AI Principle

> **Aspirian AI should know the student's educational context, use trusted learning material, understand the student's weaknesses, and help the student learn better — not simply generate answers.**
