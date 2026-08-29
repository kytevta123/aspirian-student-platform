# Aspirian Student Platform — Web Integration

**Version:** 1.0
**Status:** Final Web Integration Blueprint
**Project:** Aspirian Student Platform
**Public Website:** `aspirian.pk`
**Student Platform:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the integration architecture between the Aspirian public web ecosystem and the Aspirian Student Platform.

The objective is to create one connected educational ecosystem while keeping the public website, application, user data, learning systems, and monetization systems properly separated.

---

# 2. Web Ecosystem

```text
                         ASPIRIAN ECOSYSTEM
                                │
              ┌─────────────────┴─────────────────┐
              │                                   │
              ▼                                   ▼
        aspirian.pk                         app.aspirian.pk
        Public Website                      Student Platform
              │                                   │
              ▼                                   ▼
       Content + SEO                         Learning + AI
              │                                   │
              └─────────────────┬─────────────────┘
                                ▼
                         Shared User Journey
```

---

# 3. Public Website Role

`aspirian.pk` is responsible for:

```text
Educational Articles
Notes
Study Resources
Free Tools
Downloads
SEO
Public Educational Content
News
Career Resources
Job Resources
Student Discovery
Organic Traffic
```

---

# 4. Student Platform Role

`app.aspirian.pk` is responsible for:

```text
Authentication
Student Dashboard
Teacher Dashboard
Parent Dashboard
School Dashboard
Question Bank
Tests
Results
Progress
AI Tutor
AI Question Generator
AI Paper Generator
AI Revision
AI Viva
Audio Learning
Video Learning
Gamification
Notifications
Subscriptions
Payments
Premium Features
```

---

# 5. Integration Principle

The web ecosystem follows:

```text
Public Web
    ↓
Discovery
    ↓
Registration
    ↓
Application
    ↓
Learning
    ↓
Assessment
    ↓
Personalization
    ↓
Premium
```

---

# 6. Web-to-App Journey

```text
Google Search
     ↓
Aspirian Article
     ↓
Related Topic
     ↓
Practice / Test
     ↓
app.aspirian.pk
     ↓
Student Account
     ↓
Learning
```

---

# 7. App-to-Web Journey

```text
Student Platform
       ↓
Study Resource
       ↓
Public Aspirian Content
       ↓
Article / Note / Tool
       ↓
Return to Application
```

---

# 8. Domain Architecture

```text
aspirian.pk
    │
    ├── /articles/
    ├── /notes/
    ├── /classes/
    ├── /subjects/
    ├── /tools/
    ├── /jobs/
    ├── /career/
    └── /resources/

app.aspirian.pk
    │
    ├── /login
    ├── /register
    ├── /dashboard
    ├── /tests
    ├── /questions
    ├── /ai-tutor
    ├── /revision
    ├── /viva
    ├── /progress
    ├── /subscription
    └── /profile
```

---

# 9. URL Ownership

Public educational URLs belong to:

```text
aspirian.pk
```

Application URLs belong to:

```text
app.aspirian.pk
```

---

# 10. URL Stability

Public URLs should remain stable for SEO.

Application routes should be versioned and managed independently.

---

# 11. Public SEO Strategy

Aspirian's public web layer should focus on:

```text
Search Intent
Educational Queries
Class Notes
Subject Notes
Exam Preparation
Free Tools
Career Queries
Jobs
Educational Guides
```

---

# 12. Application SEO Strategy

Application SEO should focus primarily on public-facing product pages.

Private student pages should not be treated as public SEO content.

---

# 13. Public vs Private

```text
PUBLIC
 ↓
Articles
Notes
Tools
Resources
Landing Pages

PRIVATE
 ↓
Dashboard
Results
Progress
Personal Data
Subscriptions
```

---

# 14. Authentication Boundary

The application is the primary authentication authority for application users.

```text
User
 ↓
app.aspirian.pk
 ↓
Authentication
 ↓
Application Session
```

---

# 15. Registration

Public website:

```text
Join Aspirian
      ↓
Register
      ↓
app.aspirian.pk/register
```

---

# 16. Login

```text
aspirian.pk
      ↓
Login
      ↓
app.aspirian.pk/login
```

---

# 17. Logout

Application logout should invalidate the application session.

---

# 18. Session Isolation

Recommended:

```text
WordPress Session
        ≠
Application Session
```

unless a secure SSO system is implemented.

---

# 19. Future SSO

Future architecture may introduce:

```text
Identity Provider
       ↓
WordPress
       ↓
Application
```

with secure token-based authentication.

---

# 20. User Data Ownership

Application owns:

```text
Student Profile
Teacher Profile
Parent Profile
School Profile
Learning Progress
Results
Subscriptions
AI Usage
```

---

# 21. Public Content Ownership

Public website owns:

```text
Articles
Notes
Categories
Tags
Public Resources
Public Media
SEO Metadata
```

---

# 22. Content Integration

The application may reference public web content using stable identifiers.

Example:

```text
wordpress_post_id
content_slug
content_url
```

---

# 23. Content Reference Model

```text
Application Topic
       ↓
Public WordPress Content
       ↓
Article / Note
```

---

# 24. Avoid Content Duplication

The same article should not normally be stored independently in both systems.

Recommended:

```text
WordPress = Public Source
Application = Learning Experience
```

---

# 25. Topic Integration

A topic may connect:

```text
Article
Notes
Questions
Test
AI Tutor
Revision
Viva
```

---

# 26. Topic Journey

```text
Topic
 ↓
Read Notes
 ↓
Practice Questions
 ↓
Take Test
 ↓
View Result
 ↓
Revision
 ↓
AI Tutor
 ↓
Viva
```

---

# 27. Class Integration

The same academic hierarchy should be respected across both systems.

```text
Nursery
KG
Class 1
...
Class 12
```

---

# 28. Subject Integration

Subjects should use consistent identifiers.

Example:

```text
Mathematics
English
Physics
Chemistry
Computer Science
Biology
```

---

# 29. Content Taxonomy

Public WordPress taxonomy should map to application taxonomy where required.

Conceptual:

```text
Class
 ↓
Subject
 ↓
Chapter
 ↓
Topic
```

---

# 30. Taxonomy Mapping

Maintain a controlled mapping table:

```text
wordpress_term_id
application_class_id
application_subject_id
application_topic_id
```

---

# 31. Mapping Ownership

Application identifiers should remain independent from WordPress IDs.

---

# 32. Free Tools Integration

Aspirian's free tools remain important acquisition channels.

Examples:

```text
Age Calculator
GPA Calculator
Educational Calculators
Other Student Tools
```

---

# 33. Tool Journey

```text
Google
 ↓
Aspirian Tool
 ↓
Use Tool
 ↓
Educational Recommendation
 ↓
Register
 ↓
Application
```

---

# 34. Tool-to-App Conversion

Tools may include appropriate calls to action:

```text
Create Student Account
Practice More
Take a Test
Track Progress
Try AI Tutor
```

---

# 35. Tools Should Remain Useful

The free tool should provide meaningful functionality without requiring a premium subscription unless the feature is explicitly premium.

---

# 36. Notes Integration

Public notes can link to interactive learning features.

Example:

```text
Class 9 Biology Note
        ↓
Practice Questions
        ↓
Application
```

---

# 37. Article Integration

Educational articles may include:

```text
Practice This Topic
Take a Quiz
Ask AI Tutor
Revise This Topic
```

---

# 38. Question Integration

Public educational questions may link to the application question bank.

---

# 39. Test Integration

Public pages can link to application tests.

```text
Free Test
 ↓
Start Test
 ↓
Application Test Engine
```

---

# 40. Test Authentication

If a test requires saved progress/results:

```text
Login
 ↓
Application
 ↓
Test
```

---

# 41. Public Practice

Selected practice experiences may be available without an account.

---

# 42. Account Conversion

After useful free interaction:

```text
Practice
 ↓
Save Result
 ↓
Create Account
```

---

# 43. Result Saving

Personal results should be stored by the application.

---

# 44. Progress Tracking

Progress is application-owned.

---

# 45. AI Tutor Integration

Public website can introduce AI Tutor functionality.

```text
Article
 ↓
Ask AI Tutor
 ↓
Application
 ↓
AI Tutor
```

---

# 46. AI Context

Where appropriate, the article/topic identifier can be passed so the application understands the student's selected topic.

---

# 47. Sensitive Context

Never place:

```text
Student Password
Private Result
Personal Notes
Private Profile Data
```

inside public URLs.

---

# 48. AI Question Generator

Public content can promote AI question generation.

Actual generation occurs in the application/backend.

---

# 49. AI Paper Generator

Public web pages may link to the paper generator.

Application controls:

```text
Generation
Configuration
Usage Limits
Premium Entitlement
```

---

# 50. AI Revision

```text
Public Topic
 ↓
Revise This Topic
 ↓
Application Revision Engine
```

---

# 51. AI Viva

```text
Topic
 ↓
Practice Viva
 ↓
Application
 ↓
Viva Engine
```

---

# 52. Audio Learning

Public pages may link to audio learning.

Application may track:

```text
Playback
Progress
Completion
Favorites
```

---

# 53. Video Learning

Public pages may link to video learning.

Application may track:

```text
Watch Progress
Completion
History
Recommendations
```

---

# 54. Gamification

Gamification remains application-owned.

Public website may promote achievements but should not store the authoritative achievement state.

---

# 55. Notifications

Public website may publish announcements.

Personal notifications remain application-owned.

---

# 56. Jobs Hub

Aspirian's public Jobs section may remain on the public website.

Application may provide personalized career features in the future.

---

# 57. Career Hub

Public career content may include:

```text
Career Guides
Courses
Skills
Career Paths
Jobs
Admissions
```

---

# 58. Career Personalization

Future application features may provide:

```text
Student Interests
Career Recommendations
Skill Tracking
Career Roadmaps
```

---

# 59. Downloads

Public downloads remain primarily on WordPress.

Application may track student-specific learning resources.

---

# 60. Download Tracking

If tracking is required, use privacy-conscious aggregate or consented analytics.

---

# 61. Media Integration

Public media may remain WordPress-managed.

Application-specific generated media may use application storage.

---

# 62. API Architecture

```text
                    WEB ECOSYSTEM
                         │
             ┌───────────┴───────────┐
             ▼                       ▼
         WordPress API          Application API
             │                       │
             ▼                       ▼
       Public Content          Private Learning
```

---

# 63. WordPress API

Potential resources:

```text
Posts
Pages
Categories
Tags
Media
Public Resources
```

---

# 64. Application API

Potential resources:

```text
Users
Questions
Tests
Results
Progress
AI
Subscriptions
Payments
Notifications
Gamification
```

---

# 65. API Authentication

Application API endpoints must use appropriate authentication and authorization.

---

# 66. Public API

Public content endpoints may be accessible without authentication when intentionally exposed.

---

# 67. Private API

Student data endpoints must require authentication.

---

# 68. Authorization

Authentication alone is not sufficient.

The application must verify:

```text
User
Role
Resource Ownership
Permission
```

---

# 69. Role-Based Access

Roles may include:

```text
Student
Teacher
Parent
School Admin
Teacher Admin
Platform Admin
```

---

# 70. Cross-Origin Requests

Cross-origin requests should be explicitly controlled.

```text
aspirian.pk
        ↓
Allowed Application/API Origin
```

Avoid unrestricted wildcard policies for authenticated APIs.

---

# 71. HTTPS

All production communication must use HTTPS.

---

# 72. Secure Redirects

Redirects between WordPress and application must use trusted destinations.

---

# 73. Open Redirect Protection

Do not allow arbitrary user-controlled redirect URLs.

---

# 74. Deep Linking

Supported deep links may include:

```text
/article/topic
/practice/topic
/test/test-id
/ai-tutor/topic
/revision/topic
```

Application routes should validate referenced resources.

---

# 75. Campaign Tracking

Public web campaigns may use:

```text
utm_source
utm_medium
utm_campaign
```

---

# 76. Attribution

Application registration may optionally retain campaign attribution.

---

# 77. Privacy

Campaign parameters must not contain sensitive student information.

---

# 78. Analytics Separation

Public web analytics:

```text
Traffic
Page Views
Search
Content Engagement
Tool Usage
```

Application analytics:

```text
Learning Activity
Test Performance
Progress
AI Usage
Subscriptions
```

---

# 79. Conversion Events

Track useful conversion events:

```text
Application Click
Registration Start
Registration Complete
First Test
Premium Page View
Subscription
```

---

# 80. Event Ownership

The application should be the source of truth for:

```text
Registration
Subscription
Payment
Learning Progress
```

---

# 81. Web Performance

Public pages should remain fast even when application services are unavailable.

---

# 82. Graceful Degradation

If application APIs fail:

```text
WordPress Content
       ↓
Continues Working
```

---

# 83. API Failure Handling

The website should not display broken application widgets indefinitely.

Use:

```text
Timeout
Fallback
Retry
Friendly Error
```

where appropriate.

---

# 84. Caching

Public content should use appropriate caching.

---

# 85. API Caching

Public WordPress content can be cached.

Private student responses must not be cached publicly.

---

# 86. CDN

CDN may be used for:

```text
Images
CSS
JavaScript
Public Media
Static Assets
```

---

# 87. Mobile Integration

The public website must be responsive.

Application must also provide a responsive student experience.

---

# 88. Mobile Deep Links

Future mobile applications may open:

```text
Aspirian Article
Test
Revision
AI Tutor
```

through supported deep-link mechanisms.

---

# 89. Future Android App

Potential architecture:

```text
Android App
      ↓
Application API
      ↓
Student Platform
```

Public WordPress content may be accessed through controlled APIs.

---

# 90. Future iOS App

Same core architecture:

```text
iOS App
   ↓
Application API
```

---

# 91. PWA

If a Progressive Web App is used:

```text
Web
 ↓
PWA
 ↓
Application
```

---

# 92. Web Push

Application web push notifications may be used for:

```text
Test Reminders
Learning Reminders
Announcements
Subscription Events
```

subject to consent.

---

# 93. Email Integration

Public website email:

```text
Contact
Newsletter
Content Notifications
```

Application email:

```text
Account
Security
Tests
Subscriptions
Payments
Learning Notifications
```

---

# 94. Email Separation

Transactional application emails should not depend on WordPress newsletter plugins.

---

# 95. Subscription Integration

Public website can promote premium plans.

```text
Premium Feature
 ↓
Pricing
 ↓
app.aspirian.pk
 ↓
Subscription
```

---

# 96. Premium Access

Application determines whether a user has:

```text
Premium
Free
Trial
Expired
Cancelled
```

---

# 97. Entitlements

Premium functionality should use entitlement checks.

Example:

```text
ai_tutor
ai_question_generator
ai_paper_generator
ai_revision
ai_viva
advanced_analytics
ads_free
```

---

# 98. Payment Boundary

Payment processing belongs to the application/payment architecture.

---

# 99. Public Pricing Page

WordPress may publish pricing information, but the authoritative active plan configuration should be maintained by the application.

---

# 100. Pricing Synchronization

If pricing is displayed on both systems:

```text
Application Pricing Source
        ↓
Controlled Web Presentation
```

Avoid manually maintaining conflicting prices.

---

# 101. AdSense

Public website advertising remains part of the monetization architecture.

```text
Public Traffic
      ↓
Eligible Content
      ↓
AdSense
      ↓
Advertising Revenue
```

---

# 102. Premium Advertising

Premium application experiences should follow the established advertising rules.

---

# 103. No Ad Dependency

Application functionality must not depend on advertising.

---

# 104. Security Boundary

```text
Public Website
       ≠
Private Student Platform
```

---

# 105. Data Minimization

Only required data should cross the integration boundary.

---

# 106. Personal Data

Avoid passing unnecessary:

```text
Email
Phone
Address
Student Records
Academic Results
```

through public website requests.

---

# 107. Student Privacy

Personal learning data must remain private.

---

# 108. Parent Privacy

Parent account and billing data must remain private.

---

# 109. School Privacy

School reports and institutional analytics must remain application-controlled.

---

# 110. API Logging

Logs should contain useful technical information without unnecessarily storing sensitive user data.

---

# 111. Monitoring

Monitor:

```text
Website Uptime
Application Uptime
API Uptime
API Latency
Authentication
Conversion
Broken Links
```

---

# 112. Error Monitoring

Monitor:

```text
404
403
401
500
API Timeout
Authentication Failure
Payment Redirect Failure
```

---

# 113. Broken Link Monitoring

Regularly verify:

```text
WordPress → Application
Application → WordPress
Article → Practice
Topic → Test
Pricing → Subscription
```

---

# 114. SEO Monitoring

Monitor:

```text
Indexing
Sitemap
Canonical URLs
404 Errors
Redirects
Search Rankings
Organic Traffic
```

---

# 115. Search Console

The public website should be monitored through appropriate search-engine webmaster tools.

---

# 116. Structured Data

Public educational content may use appropriate structured data where valid.

---

# 117. Canonicalization

Avoid duplicate versions of the same public content.

---

# 118. Robots

Private application pages should not be unintentionally exposed for indexing.

---

# 119. Sitemap Separation

Recommended:

```text
Public Sitemap
      ↓
WordPress

Application Public Sitemap
      ↓
Application
```

---

# 120. Deployment Architecture

```text
Developer
   ↓
Git
   ↓
Testing
   ↓
Staging
   ↓
Integration Testing
   ↓
Production
```

---

# 121. Independent Deployment

```text
WordPress Deployment
        ≠
Application Deployment
```

---

# 122. Integration Release

Changes affecting both systems should use coordinated release notes.

---

# 123. Backward Compatibility

Application API changes should not unexpectedly break the public website.

---

# 124. API Versioning

Recommended:

```text
/api/v1/
```

Future breaking changes:

```text
/api/v2/
```

---

# 125. Deprecation

Deprecated APIs should have a documented migration period.

---

# 126. Staging

Use separate staging environments for integration testing where practical.

Example:

```text
staging.aspirian.pk
staging-app.aspirian.pk
```

---

# 127. Test Accounts

Use dedicated test accounts for:

```text
Student
Teacher
Parent
School Admin
Premium User
```

---

# 128. Test Data

Production student data must not be used for normal development testing.

---

# 129. Backup

Maintain backups for:

```text
WordPress Database
WordPress Files
Application Database
Application Files
Media
Configuration
```

---

# 130. Disaster Recovery

If public website fails:

```text
Restore WordPress
```

If application fails:

```text
Restore Application
```

Both systems should remain independently recoverable.

---

# 131. Integration Failure

If integration fails:

```text
Public Content → Remains Available
```

where technically independent.

---

# 132. Security Updates

Keep:

```text
WordPress
Themes
Plugins
Application Dependencies
Server Software
```

updated according to a controlled maintenance process.

---

# 133. WordPress Custom Code

Custom integration should preferably live in:

```text
Custom Plugin
```

rather than being scattered across theme files.

---

# 134. Application Integration Code

Application-side WordPress integration should be isolated into dedicated services/modules.

---

# 135. Integration Service

Conceptual:

```text
WordPressIntegrationService
```

Responsibilities:

```text
Content Mapping
Public Content Retrieval
Deep Links
Metadata Synchronization
```

---

# 136. Content Mapping Service

Potential mappings:

```text
Class
Subject
Chapter
Topic
WordPress Post
Application Topic
```

---

# 137. Web Integration Database

If required, maintain a mapping table such as:

```text
content_integrations

id
wordpress_post_id
application_content_id
content_type
status
created_at
updated_at
```

---

# 138. Integration Status

Possible values:

```text
ACTIVE
INACTIVE
PENDING
ERROR
```

---

# 139. Synchronization

If content metadata must be synchronized:

```text
WordPress Update
       ↓
Integration Process
       ↓
Application Metadata
```

---

# 140. Synchronization Direction

Default:

```text
WordPress
    ↓
Public Content Metadata
    ↓
Application
```

Application should not overwrite authoritative WordPress article content without an explicit architecture decision.

---

# 141. Webhooks

Future webhooks may notify the application when important WordPress content changes.

---

# 142. Webhook Security

Webhooks must use appropriate:

```text
Authentication
Signature Verification
Replay Protection
Rate Limiting
```

---

# 143. API Retry

Temporary API failures may use controlled retries.

Avoid infinite retry loops.

---

# 144. Timeout

Cross-system requests should have reasonable timeouts.

---

# 145. Circuit Breaker

At larger scale, a circuit-breaker approach may prevent an unavailable service from slowing down the entire website.

---

# 146. Feature Flags

Integration features can be controlled using feature flags.

Examples:

```text
show_app_cta
enable_practice_links
enable_ai_links
enable_premium_links
```

---

# 147. Emergency Disable

Administrators should be able to disable broken integrations without deploying a complete application release.

---

# 148. Accessibility

Both systems should support accessible:

```text
Navigation
Buttons
Forms
Links
Headings
Images
Interactive Elements
```

---

# 149. UX Consistency

Maintain consistent:

```text
Branding
Terminology
Navigation Language
Class Naming
Subject Naming
```

across both platforms.

---

# 150. Language Support

The ecosystem may support:

```text
English
Urdu
Roman Urdu
```

where product requirements define support.

---

# 151. Localization

Content and application interfaces should use localization-ready architecture.

---

# 152. Timezone

User-facing timestamps should use the appropriate configured timezone.

---

# 153. Accessibility + Student UX

The public website should remain easy to use for students on:

```text
Desktop
Tablet
Mobile
```

---

# 154. Performance Budget

Each integration should be evaluated against:

```text
Page Load
JavaScript
API Requests
Images
Third-Party Scripts
```

---

# 155. Third-Party Scripts

Avoid adding unnecessary third-party scripts to public pages.

---

# 156. Web Security Headers

Where applicable, configure:

```text
Content Security Policy
X-Content-Type-Options
Referrer-Policy
Permissions Policy
```

and other appropriate security controls.

---

# 157. Content Security

External scripts and resources should be reviewed before being allowed.

---

# 158. Rate Limiting

Public integration endpoints should have appropriate rate limits.

---

# 159. Bot Protection

High-volume automated traffic should be monitored and controlled.

---

# 160. Final Web Architecture

```text
                           INTERNET
                              │
                    ┌─────────┴─────────┐
                    │                   │
                    ▼                   ▼
               ASPIRIAN.PK        APP.ASPIRIAN.PK
                    │                   │
                    ▼                   ▼
                WORDPRESS          APPLICATION
                    │                   │
          ┌─────────┼─────────┐   ┌─────┼──────────┐
          ▼         ▼         ▼   ▼     ▼          ▼
        SEO       NOTES      TOOLS USERS  TESTS      AI
          │         │         │   │     │          │
          └─────────┴────┬────┘   └─────┴──────────┘
                         │
                         ▼
                  STUDENT JOURNEY
                         │
                         ▼
                  LEARNING + DATA
                         │
                         ▼
                    PREMIUM VALUE
                         │
                         ▼
                     REVENUE
```

---

# 161. Final Web Growth Flow

```text
Google Search
      ↓
Aspirian Public Content
      ↓
Free Tool / Note / Article
      ↓
Practice CTA
      ↓
Student Platform
      ↓
Account
      ↓
Learning
      ↓
AI / Tests / Revision
      ↓
Premium
      ↓
Subscription
      ↓
Retention
```

---

# 162. Final Integration Principles

```text
1. aspirian.pk remains the public web and SEO platform.
2. app.aspirian.pk remains the student application.
3. Public content and private learning data remain separated.
4. WordPress remains the public CMS.
5. Application remains the learning-system source of truth.
6. Application authentication remains application-owned unless secure SSO is introduced.
7. WordPress and application databases remain independent.
8. Cross-system communication uses controlled APIs and links.
9. Private student information must never be exposed through public URLs.
10. CORS must be explicitly restricted.
11. HTTPS is mandatory.
12. Application APIs require authentication and authorization where applicable.
13. Public APIs should expose only intentionally public content.
14. Premium access is controlled through application entitlements.
15. Payment processing remains application-owned.
16. Public website advertising remains part of the AdSense architecture.
17. Advertising must not interfere with learning workflows.
18. Public SEO content should not be unnecessarily duplicated in the application.
19. Content taxonomy should remain consistent across both systems.
20. WordPress should drive student discovery and acquisition.
21. The application should drive learning, personalization, and retention.
22. Both systems should be independently deployable.
23. Both systems should be independently recoverable.
24. Integration failures should degrade gracefully.
25. Future mobile apps should use the application API.
26. Future SSO should be introduced without destroying the existing architecture.
27. Integration must prioritize security, privacy, accessibility, performance, and student experience.
```

---

# 163. Document Status

**File:** `ASPIRIAN_WEB_INTEGRATION.md`
**Version:** 1.0
**Status:** Final Web Integration Blueprint
**Phase:** I
**Module:** I2 — Aspirian Web Integration
**Public Website:** `aspirian.pk`
**Student Platform:** `app.aspirian.pk`

This document integrates with:

* `WORDPRESS_INTEGRATION.md`
* `ARCHITECTURE.md`
* `PROJECT_SPEC.md`
* `EDUCATION_STRUCTURE.md`
* `CONTENT_MANAGEMENT.md`
* `USER_MANAGEMENT.md`
* `QUESTION_MANAGEMENT.md`
* `REPORTING.md`
* `PAYMENT_SYSTEM.md`
* `SUBSCRIPTIONS.md`
* `PREMIUM_FEATURES.md`
* `ADSENSE_ARCHITECTURE.md`
* `REVENUE_MODEL.md`
* `AI_SAFETY.md`
