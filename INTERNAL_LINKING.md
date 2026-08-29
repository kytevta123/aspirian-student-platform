# Aspirian Student Platform — Internal Linking Architecture

**Version:** 1.0
**Status:** Final Internal Linking Blueprint
**Project:** Aspirian Student Platform
**Primary Website:** `aspirian.pk`
**Student Platform:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the internal linking architecture for the Aspirian ecosystem.

The purpose is to:

* Improve student navigation
* Improve search-engine crawlability
* Build topical authority
* Connect related educational resources
* Reduce orphan pages
* Improve content discovery
* Move students from content to practice
* Connect public content with the Student Platform
* Support organic traffic conversion
* Improve learning journeys

---

# 2. Internal Linking Mission

Aspirian internal linking follows:

```text
DISCOVER
   ↓
UNDERSTAND
   ↓
PRACTICE
   ↓
TEST
   ↓
ANALYZE
   ↓
REVISE
   ↓
MASTER
```

---

# 3. Internal Linking Ecosystem

```text
                         ASPIRIAN
                            │
          ┌─────────────────┼─────────────────┐
          ▼                 ▼                 ▼
       ARTICLES            NOTES             TOOLS
          │                 │                 │
          └─────────────────┼─────────────────┘
                            ▼
                      MCQs / PRACTICE
                            │
                            ▼
                         TESTS
                            │
                            ▼
                         RESULTS
                            │
             ┌──────────────┼──────────────┐
             ▼              ▼              ▼
           REVISION        AI TUTOR        VIVA
             │              │              │
             └──────────────┼──────────────┘
                            ▼
                    STUDENT PLATFORM
```

---

# 4. Primary Principle

Every important public page should be connected to other relevant pages.

Avoid isolated content.

---

# 5. Internal Link Types

Aspirian uses:

```text
Contextual Links
Navigation Links
Breadcrumb Links
Related Content
Category Links
Topic Links
Tool Links
Practice Links
Application CTAs
Footer Links
```

---

# 6. Link Priority

Priority should be:

```text
Contextual
   ↓
Related Resource
   ↓
Practice
   ↓
Application
```

Contextual links should carry the most meaningful user journey.

---

# 7. Academic Hierarchy

```text
Class
 ↓
Subject
 ↓
Chapter
 ↓
Topic
 ↓
Notes
 ↓
Questions
 ↓
Test
 ↓
Revision
```

---

# 8. Example

```text
Class 9
 ↓
Computer Science
 ↓
Chapter 1
 ↓
Computer Fundamentals
 ↓
Computer MCQs
 ↓
Online Test
 ↓
Revision
```

---

# 9. Pillar Pages

Important subjects and academic categories should have pillar pages.

Example:

```text
Class 9 Computer Science
```

The pillar page links to:

```text
Notes
Chapters
MCQs
Past Papers
Tests
Related Resources
```

---

# 10. Supporting Pages

Supporting pages should link back to the appropriate pillar.

```text
Chapter Article
      ↓
Class 9 Computer Science
```

---

# 11. Topic Cluster

Example:

```text
                CLASS 9 COMPUTER SCIENCE
                         │
       ┌─────────────────┼─────────────────┐
       ▼                 ▼                 ▼
     NOTES              MCQs              TESTS
       │                 │                 │
       ▼                 ▼                 ▼
    CHAPTERS           PRACTICE         RESULTS
       │                                   │
       └─────────────────┬─────────────────┘
                         ▼
                      REVISION
                         │
                         ▼
                       AI TUTOR
```

---

# 12. One Topic, Multiple Resources

A single topic should connect relevant resources:

```text
Topic
 ├── Explanation
 ├── Notes
 ├── MCQs
 ├── Important Questions
 ├── Test
 ├── Revision
 ├── Viva
 └── AI Tutor
```

---

# 13. Contextual Linking

Contextual links should appear naturally inside content.

Example:

```text
Students learning computer fundamentals
can also practice Class 9 Computer Science MCQs.
```

---

# 14. Anchor Text

Anchor text should clearly describe the destination.

Good:

```text
Class 9 Computer Science MCQs
```

Avoid vague anchors such as:

```text
Click Here
Read More
Click This
```

when a descriptive anchor is possible.

---

# 15. Keyword Variation

Do not use the exact same keyword as anchor text for every link.

Use natural variations.

Example:

```text
Class 9 Computer Science notes
Computer Science chapter notes
Computer fundamentals notes
Class 9 CS study material
```

---

# 16. Avoid Keyword Stuffing

Internal links should serve users first.

---

# 17. Link Relevance

A link should normally be relevant to the current content.

---

# 18. Link Destination

Before adding a link, verify that the destination:

```text
Exists
Works
Is Relevant
Is Accessible
```

---

# 19. Broken Links

Broken internal links should be identified and fixed quickly.

---

# 20. Orphan Pages

An orphan page is a page with no meaningful internal links pointing to it.

Important public pages should not remain orphaned.

---

# 21. Orphan Prevention

Every new important page should receive links from:

```text
Parent Category
Related Content
Relevant Topic
Navigation
```

where appropriate.

---

# 22. New Content Linking Rule

When publishing a new article:

```text
New Article
 ↓
Link to Older Relevant Content
```

---

# 23. Existing Content Update

When publishing important new content:

```text
New Content
 ↓
Find Relevant Older Pages
 ↓
Add Internal Links
```

---

# 24. Two-Way Linking

Where useful:

```text
Old Page
   ↔
New Page
```

Two-way linking is not mandatory when it creates unnatural repetition.

---

# 25. Hub-and-Spoke Model

Use:

```text
Hub
 ↓
Multiple Related Pages
```

Example:

```text
Class 9 Computer Science
       ↓
 ┌─────┼─────┐
 ▼     ▼     ▼
Ch 1   Ch 2   Ch 3
```

---

# 26. Spoke-to-Hub

Each important supporting page should usually link back to its hub.

---

# 27. Breadcrumb Architecture

Recommended:

```text
Home
 ↓
Class
 ↓
Subject
 ↓
Chapter
 ↓
Topic
```

---

# 28. Breadcrumb Benefits

Breadcrumbs help:

```text
Navigation
Hierarchy
Content Discovery
Crawlability
```

---

# 29. Category Links

Category pages should connect to relevant content.

---

# 30. Subject Pages

Subject pages should connect to:

```text
Notes
Chapters
MCQs
Tests
Past Papers
```

---

# 31. Chapter Pages

Chapter pages should connect to:

```text
Chapter Notes
Questions
MCQs
Test
Revision
```

---

# 32. Topic Pages

Topic pages should connect to:

```text
Explanation
Examples
Questions
Practice
Test
AI Tutor
```

---

# 33. Article Linking

Educational articles should include relevant links to:

```text
Notes
Related Articles
Tools
MCQs
Tests
```

---

# 34. Notes Linking

Notes should include:

```text
Related Topics
MCQs
Practice
Online Test
Revision
```

---

# 35. MCQ Linking

MCQ pages should connect to:

```text
Topic Notes
Chapter Notes
Online Test
Related MCQs
Revision
```

---

# 36. Test Linking

Test landing pages should connect to:

```text
Study Notes
Practice Questions
Topic Resources
Revision
```

---

# 37. Result Linking

After a test, the application may recommend:

```text
Weak Topics
Revision
AI Tutor
Practice Questions
```

---

# 38. Revision Linking

Revision pages should connect to:

```text
Original Notes
Practice Questions
Test
AI Tutor
Viva
```

---

# 39. AI Tutor Linking

AI Tutor entry points can originate from:

```text
Article
Notes
Topic
Question
Test Result
Revision
```

---

# 40. Viva Linking

Viva practice can connect from:

```text
Topic
Subject
Practical
Revision
AI Tutor
```

---

# 41. Tool Linking

Educational pages may link to relevant free tools.

Example:

```text
GPA Guide
 ↓
GPA Calculator
```

---

# 42. Tool-to-Content

Tools should link to explanatory educational content.

```text
GPA Calculator
 ↓
How GPA Works
```

---

# 43. Tool-to-Application

Where relevant:

```text
Free Tool
 ↓
Create Account
 ↓
Student Platform
```

---

# 44. Application CTA

Public pages may include contextual calls to action:

```text
Practice This Topic
Take Online Test
Ask AI Tutor
Start Revision
```

---

# 45. CTA Relevance

Do not place the same CTA everywhere if it is irrelevant to the page.

---

# 46. Free-to-App Funnel

```text
Search
 ↓
Article
 ↓
Useful Resource
 ↓
Practice
 ↓
Application
```

---

# 47. Application-to-Web

The application may link back to public educational resources.

```text
Student Topic
 ↓
Read Detailed Notes
 ↓
Aspirian.pk
```

---

# 48. Deep Links

Application links should open the relevant destination directly where possible.

Example:

```text
app.aspirian.pk/test/...
```

rather than sending the student to a generic homepage.

---

# 49. Public-to-App Deep Links

Public content may link directly to:

```text
Practice
Test
AI Tutor
Revision
Viva
```

---

# 50. Deep-Link Validation

Application links must be checked after major route changes.

---

# 51. Cross-Domain Linking

The relationship:

```text
aspirian.pk
      ↕
app.aspirian.pk
```

should be intentional and clear.

---

# 52. Cross-Domain Link Purpose

Cross-domain links should generally serve:

```text
Learning
Practice
Registration
Authentication
Premium
```

---

# 53. Navigation Separation

Public website navigation should focus on:

```text
Articles
Notes
Classes
Subjects
Tools
Jobs
Career
Resources
```

---

# 54. Application Navigation

Application navigation should focus on:

```text
Dashboard
Tests
Questions
Learning
AI
Revision
Progress
Profile
Subscription
```

---

# 55. Footer Linking

Footer links should include important utility and trust pages.

Examples:

```text
About
Contact
Privacy Policy
Terms
Disclaimer
Sitemap
```

---

# 56. Footer SEO

Do not turn the footer into a keyword list.

---

# 57. Header Navigation

Header navigation should prioritize important user destinations.

---

# 58. Mega Menu

A mega menu may be used for large academic structures.

Example:

```text
Classes
 ├── Class 1
 ├── Class 2
 ├── ...
 └── Class 12
```

---

# 59. Mega Menu Principle

Do not expose thousands of links unnecessarily.

Prioritize useful navigation.

---

# 60. Related Content

Related content should be algorithmically or editorially relevant.

---

# 61. Related Article Logic

Possible factors:

```text
Same Class
Same Subject
Same Chapter
Same Topic
Related Keywords
```

---

# 62. Related Notes Logic

Possible relationship:

```text
Same Class
+
Same Subject
+
Same Chapter
```

---

# 63. Related Questions

Questions should be connected by:

```text
Topic
Chapter
Subject
Difficulty
Exam Type
```

where relevant.

---

# 64. Related Tests

Tests can be connected by:

```text
Subject
Chapter
Topic
Class
Difficulty
```

---

# 65. Link Modules

Reusable components may include:

```text
Related Articles
Related Notes
Practice This Topic
Take a Test
Recommended Resources
```

---

# 66. Automated Linking

Automated internal linking may be used carefully.

---

# 67. Automated Linking Rules

Automation must consider:

```text
Relevance
Destination Quality
Anchor Quality
Frequency
Context
```

---

# 68. Avoid Over-Linking

Too many links can reduce usability.

---

# 69. Link Density

There is no universal ideal number of internal links.

Use the number required to help users navigate the topic naturally.

---

# 70. Above-the-Fold Links

Important next-step links may be placed early where useful.

---

# 71. Deep Content Links

Long educational pages should use links throughout the content where relevant.

---

# 72. End-of-Page Links

At the end of important content:

```text
Related Notes
Practice Questions
Take Test
```

may be presented.

---

# 73. Learning Journey Links

The ideal student flow:

```text
Learn
 ↓
Practice
 ↓
Test
 ↓
Result
 ↓
Revision
 ↓
AI Help
```

---

# 74. Weak Topic Loop

Application:

```text
Test Result
 ↓
Weak Topic
 ↓
Notes
 ↓
Practice
 ↓
Revision
 ↓
Retest
```

---

# 75. Strong Topic Loop

```text
Test
 ↓
High Score
 ↓
Advanced Questions
 ↓
Next Topic
```

---

# 76. Cross-Content Learning Loop

```text
Article
 ↓
Notes
 ↓
MCQs
 ↓
Test
 ↓
Revision
```

---

# 77. Content-to-Conversion Loop

```text
Article
 ↓
Tool / Practice
 ↓
Student Account
 ↓
Application
```

---

# 78. Topic Navigation

Each major topic should expose relevant next actions.

Example:

```text
Read Topic
 | 
 ├── Practice MCQs
 ├── Take Test
 ├── Revise
 └── Ask AI Tutor
```

---

# 79. Class Navigation

Class pages should link to:

```text
Subjects
Notes
MCQs
Tests
Past Papers
```

---

# 80. Subject Navigation

Subject pages should link to:

```text
Chapters
Notes
Questions
Tests
Resources
```

---

# 81. Chapter Navigation

Chapter pages should link to:

```text
Topics
Notes
MCQs
Test
Revision
```

---

# 82. Topic Navigation

Topic pages should link to:

```text
Explanation
Examples
Practice
Test
Revision
AI Tutor
```

---

# 83. Career Content Linking

Career pages may connect:

```text
Career Guide
 ↓
Required Skills
 ↓
Learning Resources
 ↓
Courses
 ↓
Jobs
```

---

# 84. Jobs Content Linking

Job-related pages may connect to:

```text
Job
 ↓
Required Skills
 ↓
Relevant Courses
 ↓
Learning Resources
```

---

# 85. Programming Content Linking

Programming topics can form clusters:

```text
Python
 ↓
Basics
 ↓
Variables
 ↓
Data Types
 ↓
Conditions
 ↓
Loops
 ↓
Functions
```

---

# 86. AI Education Linking

AI content may connect:

```text
AI Basics
 ↓
AI Tools
 ↓
AI Tutor
 ↓
AI Question Generator
 ↓
AI Revision
```

---

# 87. Free Resource Linking

Free resources should connect to related premium learning functionality where appropriate.

---

# 88. Premium Linking

Premium CTAs should be contextual.

Example:

```text
Free Revision Guide
 ↓
Advanced AI Revision
```

---

# 89. No Aggressive Linking

Do not interrupt educational content with excessive commercial links.

---

# 90. Link Attributes

Internal links normally should remain standard crawlable links unless a specific technical reason requires otherwise.

---

# 91. Avoid Unnecessary NoFollow

Do not add `nofollow` to ordinary internal links without a valid reason.

---

# 92. JavaScript Links

Important internal navigation should remain accessible to search engines and users.

---

# 93. Crawlable Links

Prefer normal semantic links for important destinations.

---

# 94. Link Consistency

Use consistent URL formats.

Avoid linking sometimes to:

```text
https://aspirian.pk/page
```

and elsewhere to unnecessary alternate variants.

---

# 95. HTTPS Consistency

Use HTTPS everywhere in production.

---

# 96. Trailing Slash Policy

Choose a consistent URL convention and maintain it.

---

# 97. Redirect-Free Internal Links

Internal links should ideally point directly to the final canonical URL.

---

# 98. Avoid Redirect Chains

Do not intentionally create:

```text
Page A
 ↓
Redirect
 ↓
Redirect
 ↓
Page B
```

---

# 99. Link Audit

Regular internal-link audits should identify:

```text
Broken Links
Redirect Links
Orphan Pages
Poor Anchors
Irrelevant Links
Important Pages with Few Links
```

---

# 100. Internal Link Score

A future internal system may calculate an internal linking score based on:

```text
Inbound Links
Outbound Links
Page Importance
Topic Relevance
Click Depth
```

---

# 101. Important Page Identification

High-value pages may include:

```text
Pillar Pages
High-Traffic Pages
High-Converting Pages
Core Tools
Major Class Pages
Major Subject Pages
```

---

# 102. Link Equity Strategy

Important pages should receive strong contextual links from relevant pages.

---

# 103. Do Not Manipulate

Internal linking should improve information architecture, not attempt to manipulate rankings artificially.

---

# 104. Content Update Linking

Whenever an article is updated:

```text
Review Existing Links
 ↓
Add Newly Relevant Resources
 ↓
Remove Broken/Irrelevant Links
```

---

# 105. New Feature Linking

When a new learning feature launches:

```text
Existing Relevant Content
        ↓
New Feature
```

should be linked where useful.

---

# 106. New Tool Launch

When a new tool launches:

```text
Tool Landing Page
        ↓
Relevant Articles
        ↓
Relevant Notes
```

should be connected.

---

# 107. New Subject Launch

When a new subject is added:

```text
Class Page
 ↓
Subject Page
 ↓
Chapter Pages
 ↓
Topic Pages
```

must be connected.

---

# 108. New Class Launch

New class content should connect to:

```text
Class Hub
Subject Hubs
Notes
MCQs
Tests
```

---

# 109. Internal Linking Database

A future mapping system may maintain:

```text
internal_links

id
source_content_id
target_content_id
link_type
anchor_text
status
created_at
updated_at
```

---

# 110. Link Types

Potential values:

```text
CONTEXTUAL
RELATED
BREADCRUMB
NAVIGATION
CTA
PRACTICE
TEST
TOOL
AI
REVISION
RESOURCE
```

---

# 111. Link Status

Recommended:

```text
ACTIVE
BROKEN
REDIRECT
REMOVED
```

---

# 112. Automated Link Audit

The system may periodically check:

```text
HTTP Status
Canonical URL
Redirect
Availability
```

---

# 113. Broken Link Workflow

```text
Broken Link
 ↓
Identify Source
 ↓
Identify Correct Destination
 ↓
Replace Link
 ↓
Verify
```

---

# 114. Removed Content

If content is permanently removed:

```text
Source Page
 ↓
Relevant Replacement
```

or an appropriate 404/410 strategy should be used.

---

# 115. Internal Search

Site search can improve discovery of content that is not prominent in navigation.

---

# 116. Search Results

Internal search results should help users find:

```text
Articles
Notes
Topics
Tools
Resources
```

---

# 117. Search-to-Learning

```text
Search
 ↓
Topic
 ↓
Notes
 ↓
Practice
```

---

# 118. Recommendation Engine

Future recommendations may use:

```text
Current Topic
Class
Subject
Learning History
Test Results
Weak Areas
```

---

# 119. Personalized Linking

Application can provide personalized links such as:

```text
Continue Learning
Revise Weak Topic
Practice Recommended Questions
```

---

# 120. Privacy Boundary

Personalized links must not expose private student information publicly.

---

# 121. Public Recommendation

Public website recommendations should be based on content relevance, not private student data.

---

# 122. SEO + UX

Internal linking serves both:

```text
Search Engine
+
Student
```

but student usefulness is the primary principle.

---

# 123. Mobile Internal Linking

Links and CTA buttons must remain easy to tap on mobile devices.

---

# 124. Accessibility

Internal links should have:

```text
Meaningful Text
Keyboard Accessibility
Clear Focus
Readable Labels
```

---

# 125. Visual Link Hierarchy

Important links should be visually distinguishable without making every link look like an advertisement.

---

# 126. Analytics

Monitor important internal-link interactions.

Possible events:

```text
Article → Notes
Article → Test
Article → Tool
Article → App
Notes → Practice
Test → Revision
```

---

# 127. Internal Link CTR

Measure click-through rates for important contextual links and CTAs.

---

# 128. Conversion Analysis

Determine which internal paths produce:

```text
Registrations
Tests
AI Usage
Subscriptions
```

---

# 129. SEO Reporting

Internal linking reports may include:

```text
Top Linked Pages
Orphan Pages
Pages with Few Internal Links
Broken Links
Redirect Links
High-Value Link Paths
```

---

# 130. Internal Linking Dashboard

Future admin dashboard:

```text
Internal Links
────────────────────
Total Links
Broken Links
Redirect Links
Orphan Pages
Top Linked Pages
Low Linked Pages
Recent Link Changes
```

---

# 131. Content Editor Workflow

When creating content:

```text
Create Draft
 ↓
Select Class
 ↓
Select Subject
 ↓
Select Chapter
 ↓
Select Topic
 ↓
Add Relevant Internal Links
 ↓
SEO Review
 ↓
Publish
```

---

# 132. Editorial Checklist

Before publishing:

```text
□ Correct category
□ Correct class
□ Correct subject
□ Correct chapter
□ Relevant internal links
□ Related resources
□ Practice CTA
□ Correct URLs
□ No broken links
□ No unnecessary links
```

---

# 133. Content Update Checklist

```text
□ Review old links
□ Add new relevant resources
□ Remove broken links
□ Verify destination URLs
□ Review anchor text
□ Check CTA
```

---

# 134. Internal Linking Automation

Future CMS integration may automatically suggest:

```text
Related Articles
Related Notes
Related Questions
Related Tests
Relevant Tools
```

---

# 135. AI Link Suggestions

AI may suggest potential internal links, but editorial validation should remain available.

---

# 136. AI Linking Safety

AI-generated links must not be published blindly.

Verify:

```text
Destination
Relevance
URL
Context
```

---

# 137. Link Recommendation Engine

Future architecture:

```text
Content
 ↓
Topic Extraction
 ↓
Related Content Search
 ↓
Relevance Score
 ↓
Suggested Links
 ↓
Editor Approval
```

---

# 138. Relevance Score

Possible factors:

```text
Class Match
Subject Match
Chapter Match
Topic Match
Semantic Similarity
Content Type
Student Journey
```

---

# 139. Smart Learning Links

Application can dynamically recommend:

```text
Next Lesson
Practice
Revision
Test
AI Help
```

---

# 140. Learning Sequence

```text
LESSON
  ↓
PRACTICE
  ↓
TEST
  ↓
RESULT
  ↓
REVISION
  ↓
RETEST
```

---

# 141. Master Internal Linking Architecture

```text
                           ASPIRIAN.PK
                               │
                    ┌──────────┼──────────┐
                    ▼          ▼          ▼
                 CLASSES    SUBJECTS     TOOLS
                    │          │          │
                    └────┬─────┴──────────┘
                         ▼
                      CHAPTERS
                         │
                         ▼
                       TOPICS
                         │
          ┌──────────────┼──────────────┐
          ▼              ▼              ▼
        NOTES           MCQs          ARTICLES
          │              │              │
          └──────────────┼──────────────┘
                         ▼
                      PRACTICE
                         │
                         ▼
                        TEST
                         │
                         ▼
                       RESULT
                         │
             ┌───────────┼───────────┐
             ▼           ▼           ▼
          REVISION    AI TUTOR      VIVA
             │           │           │
             └───────────┼───────────┘
                         ▼
                  APP.ASPIRIAN.PK
                         │
                         ▼
                  STUDENT JOURNEY
                         │
                         ▼
                    PREMIUM VALUE
```

---

# 142. Golden Rules

```text
1. Every important page should be connected.
2. Link relevant pages, not random pages.
3. Use descriptive anchor text.
4. Avoid generic "click here" anchors where possible.
5. Build strong pillar-and-cluster structures.
6. Link supporting content back to its hub.
7. Connect related content naturally.
8. Connect notes to practice.
9. Connect practice to tests.
10. Connect results to revision.
11. Connect revision to AI assistance where relevant.
12. Use breadcrumbs for hierarchical content.
13. Keep public and private linking boundaries clear.
14. Use direct canonical URLs.
15. Avoid unnecessary redirects.
16. Fix broken internal links.
17. Prevent important pages from becoming orphaned.
18. Avoid excessive link density.
19. Do not keyword-stuff anchor text.
20. Keep internal links useful for students.
21. Use tools as discovery and learning entry points.
22. Connect public content to the Student Platform through meaningful CTAs.
23. Use personalized linking only inside authenticated experiences.
24. Never expose private student information through links.
25. Audit internal links regularly.
26. Use analytics to improve important user journeys.
27. Use automation carefully and review AI-generated link suggestions.
28. Keep internal linking aligned with the SEO architecture.
29. Keep internal linking aligned with the education hierarchy.
30. Treat internal linking as both an SEO system and a learning-navigation system.
```

---

# 143. Final Objective

The ultimate internal-linking objective is:

```text
SEARCH DISCOVERY
       ↓
CONTENT DISCOVERY
       ↓
LEARNING
       ↓
PRACTICE
       ↓
ASSESSMENT
       ↓
REVISION
       ↓
MASTERY
       ↓
STUDENT RETENTION
```

---

# 144. Document Status

**File:** `INTERNAL_LINKING.md`
**Version:** 1.0
**Status:** Final Internal Linking Blueprint
**Phase:** I
**Module:** I4 — Internal Linking
**Primary Website:** `aspirian.pk`
**Student Platform:** `app.aspirian.pk`

This document integrates with:

* `SEO_ARCHITECTURE.md`
* `ASPIRIAN_WEB_INTEGRATION.md`
* `WORDPRESS_INTEGRATION.md`
* `CONTENT_MANAGEMENT.md`
* `QUESTION_MANAGEMENT.md`
* `USER_MANAGEMENT.md`
* `REPORTING.md`
* `AI_TUTOR.md`
* `AI_REVISION_ENGINE.md`
* `AI_VIVA.md`
* `PAYMENT_SYSTEM.md`
* `SUBSCRIPTIONS.md`
* `PREMIUM_FEATURES.md`
