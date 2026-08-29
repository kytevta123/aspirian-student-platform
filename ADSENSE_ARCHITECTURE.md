# Aspirian Student Platform — AdSense Architecture

**Version:** 1.0
**Status:** Final AdSense Architecture Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Website:** `aspirian.pk`
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the Google AdSense monetization architecture for the Aspirian ecosystem.

The architecture separates:

```text
Free Public Educational Content
Premium Student Platform
Subscription Revenue
Advertising Revenue
```

The objective is to generate advertising revenue without compromising:

* Student experience
* Educational quality
* Privacy
* Platform performance
* Premium subscription value
* Ad policy compliance

---

# 2. Aspirian Monetization Architecture

```text
                         ASPIRIAN ECOSYSTEM
                                ↓
                 ┌──────────────┴──────────────┐
                 ↓                             ↓
          ASPIRIAN.PK                    APP.ASPIRIAN.PK
                 ↓                             ↓
       Public Educational Content        Student Platform
                 ↓                             ↓
             AdSense                    Subscriptions
                 ↓                             ↓
        Advertising Revenue          Premium Revenue
```

---

# 3. Primary Monetization Channels

Aspirian may generate revenue through:

```text
AdSense
Subscriptions
Premium Features
School Plans
Educational Partnerships
Future Sponsorships
```

AdSense is only one part of the overall monetization strategy.

---

# 4. Website Role

`aspirian.pk` remains primarily focused on:

```text
Educational Articles
Notes
Study Resources
Free Tools
SEO Content
Downloads
Public Learning Resources
Student Discovery
Organic Traffic
```

These areas are suitable for advertising where ad placement and content comply with applicable policies.

---

# 5. Application Role

`app.aspirian.pk` focuses on:

```text
Student Accounts
Tests
Question Bank
AI Tutor
AI Learning
Revision
Progress
Gamification
Premium Features
Subscriptions
```

The application should prioritize learning experience over advertising.

---

# 6. AdSense vs Premium

The two monetization systems remain independent.

```text
                    ASPIRIAN
                       ↓
             ┌─────────┴─────────┐
             ↓                   ↓
           ADSENSE          SUBSCRIPTIONS
             ↓                   ↓
        Free Content       Premium Access
```

---

# 7. Core Principle

> Advertising should monetize free educational content, while subscriptions should provide additional premium functionality.

---

# 8. Free Content Strategy

Ad-supported areas may include:

```text
Educational Articles
Class Notes
Study Guides
Free Tools
Public Resources
Selected Practice Content
Educational News
```

---

# 9. Premium Content Strategy

Premium areas may include:

```text
AI Tutor
Advanced Tests
AI Question Generator
AI Paper Generator
AI Revision
AI Viva
Advanced Analytics
Premium Learning Content
```

Premium access should not depend on advertisements.

---

# 10. Advertising on Premium Features

Premium features should generally provide a cleaner learning experience.

Advertising must not interfere with:

```text
AI Tutor
Tests
Exam Sessions
Viva Sessions
Focused Revision
Critical Learning Workflows
```

---

# 11. Student Experience Principle

Aspirian should avoid excessive advertising.

The goal is:

```text
Useful Content
      +
Reasonable Advertising
      =
Sustainable Free Education
```

---

# 12. Ad Placement Categories

Potential website placements:

```text
Header / Top Area
In-Content
Between Content Sections
Sidebar
After Content
Footer
```

Actual placements depend on page design and policy compliance.

---

# 13. Header Advertising

Header/top advertising should not:

```text
Push Content Too Far Down
Create Misleading Click Areas
Resemble Navigation
Block Important Information
```

---

# 14. In-Content Advertising

In-content ads may be placed between meaningful sections.

Ads should remain visually distinguishable from educational content.

---

# 15. Sidebar Advertising

Sidebar ads may be used on desktop layouts where appropriate.

---

# 16. Mobile Advertising

Mobile layouts require special care.

Ads must not:

```text
Cover Content
Block Navigation
Cause Accidental Clicks
Create Layout Instability
```

---

# 17. Footer Advertising

Footer advertisements may be used where appropriate but should not overwhelm the page.

---

# 18. Tool Pages

Free tools may contain ads where appropriate.

Examples:

```text
Age Calculator
GPA Calculator
Other Free Educational Tools
```

The tool itself must remain usable.

---

# 19. Tool Ad Placement

Recommended conceptual layout:

```text
Page
 ↓
Tool Introduction
 ↓
Tool
 ↓
Result
 ↓
Educational Explanation
 ↓
Ad
 ↓
Related Content
```

The exact implementation depends on UX and policy requirements.

---

# 20. Educational Articles

Article pages may contain:

```text
Title
Introduction
Educational Content
Images
Examples
Ad Placement
Related Articles
Conclusion
```

Advertising must not replace substantive educational content.

---

# 21. Download Pages

Download pages require special attention.

The interface must clearly distinguish:

```text
Download Button
Advertisement
External Link
Sponsored Content
```

Ads must never be designed to look like download controls.

---

# 22. Download Button Protection

Never place an advertisement directly where users could reasonably mistake it for:

```text
Download
Continue
Next
Start
Play
```

---

# 23. Software Download Portal

If Aspirian provides software downloads:

```text
Software Information
 ↓
Version
 ↓
System Requirements
 ↓
Official / Safe Download
 ↓
Instructions
```

Advertisements should remain secondary.

---

# 24. Search Traffic

AdSense may monetize traffic arriving from:

```text
Google Search
Bing
Social Media
Direct Traffic
Referrals
Educational Communities
```

Traffic quality must remain genuine.

---

# 25. SEO + AdSense

SEO strategy should prioritize:

```text
Useful Content
Original Information
Search Intent
Good UX
Fast Performance
Clear Structure
```

Ad revenue should not become the primary reason for publishing low-value pages.

---

# 26. Content Quality

Aspirian content should aim to provide:

```text
Originality
Accuracy
Educational Value
Clear Explanations
Useful Examples
Good Formatting
```

---

# 27. AI-Generated Content

AI may assist content creation, but published content should provide genuine value and be reviewed for:

```text
Accuracy
Originality
Educational Quality
Errors
Repetition
Policy Compliance
```

---

# 28. Thin Content Protection

Avoid publishing large numbers of pages that provide little independent value merely to increase advertising impressions.

---

# 29. Duplicate Content

Avoid unnecessary duplication of:

```text
Articles
Notes
Question Pages
Tool Pages
AI-Generated Content
```

---

# 30. Ad Density

Advertising density should remain reasonable.

The system should prioritize:

```text
Content First
Ads Second
```

---

# 31. Ad Refresh

Automatic ad refreshing should only be used where permitted and technically appropriate.

The platform should not implement aggressive refresh mechanisms solely to increase impressions.

---

# 32. Invalid Traffic Protection

Aspirian must not encourage:

```text
Ad Clicking
Repeated Self-Clicks
Click Exchanges
Artificial Traffic
Automated Impressions
Bot Traffic
```

---

# 33. Owner / Staff Behavior

Administrators and staff should not interact with ads in a way that generates artificial clicks or impressions.

---

# 34. Student Behavior

Students should never be encouraged to:

```text
Click Ads for Rewards
Click Ads to Unlock Content
Click Ads to Earn Points
```

---

# 35. Gamification + Ads

Ad interaction should not become a gamification mechanic.

```text
Wrong:
Watch / Click Ad → Earn Points

Preferred:
Complete Learning Activity → Earn Points
```

---

# 36. Ads + Tests

Advertising should not interfere with active examination sessions.

Recommended:

```text
Before Test
   ↓
No Intrusive Ad

During Test
   ↓
No Intrusive Ad

After Test
   ↓
Optional Non-Intrusive Ad
```

---

# 37. Ads + AI Tutor

Ads should not interrupt an active AI tutoring conversation unnecessarily.

---

# 38. Ads + Viva

During a Viva session:

```text
Question
 ↓
Student Answer
 ↓
Evaluation
```

Advertising should not interrupt the learning workflow.

---

# 39. Ads + Revision

Revision sessions should remain focused.

---

# 40. Ads + Video

Video pages must clearly distinguish:

```text
Educational Video
Advertisement
Sponsored Content
```

where applicable.

---

# 41. Ads + Audio

Audio learning pages should avoid advertising that interferes with educational audio playback.

---

# 42. Ads + Live Streaming

Live educational streams should maintain a clear distinction between educational stream content and advertising.

---

# 43. Logged-In Users

Logged-in users may receive a different advertising experience from anonymous visitors.

---

# 44. Premium Users

A future product decision may provide:

```text
Reduced Ads
```

or:

```text
Ad-Free Premium Experience
```

if commercially appropriate.

This should be controlled independently from core subscription entitlements.

---

# 45. Ad-Free Entitlement

If Aspirian introduces ad-free premium access:

```text
Subscription
 ↓
Entitlement
 ↓
ads_free
 ↓
Ads Disabled
```

This is preferable to hard-coding ad removal based on plan name.

---

# 46. School Users

School accounts may have:

```text
No Ads
Reduced Ads
Standard Ads
```

depending on the purchased plan.

The final business rule should be plan-configurable.

---

# 47. Parent Users

Parent billing/account pages should prioritize financial information and should not be cluttered with advertisements.

---

# 48. Admin Panel

Administrative interfaces should not rely on AdSense monetization.

---

# 49. Teacher Administration

Teacher management interfaces should prioritize teaching workflows.

---

# 50. School Administration

School management dashboards should prioritize:

```text
Students
Teachers
Reports
Licenses
Performance
```

rather than advertising.

---

# 51. Advertising Architecture

```text
                         ASPIRIAN
                            ↓
                     PAGE REQUEST
                            ↓
                    CONTENT TYPE
                            ↓
              ┌─────────────┴─────────────┐
              ↓                           ↓
        PUBLIC CONTENT                APP CONTENT
              ↓                           ↓
           ADSENSE                 PREMIUM / FREE
              ↓                           ↓
       AD ELIGIBILITY              FEATURE ACCESS
              ↓
         AD REQUEST
              ↓
       AD RENDERING
```

---

# 52. Ad Eligibility

Before displaying ads, the application/site may evaluate:

```text
Page Type
User State
Ad Configuration
Consent Requirements
Device
Placement
```

---

# 53. Ad Configuration

Maintain centralized configuration for:

```text
Ad Units
Placements
Page Types
Experiments
Status
```

---

# 54. Ad Unit Registry

Conceptual fields:

```text
Ad Unit ID
Placement
Page Type
Device
Status
Description
Created At
Updated At
```

---

# 55. Placement Registry

Example:

```text
article_top
article_inline
article_sidebar
article_bottom
tool_result
download_content
```

---

# 56. Ad Unit Naming

Use descriptive internal names.

Example:

```text
desktop_article_top
mobile_article_inline
tool_result_bottom
```

---

# 57. Responsive Ads

Where supported, use responsive advertising formats suitable for the available layout.

---

# 58. Mobile vs Desktop

Maintain separate configuration where layout requirements differ.

---

# 59. Ad Experiments

Aspirian may test:

```text
Placement
Density
Format
Position
```

but experiments must not create misleading or disruptive experiences.

---

# 60. A/B Testing

Advertising experiments should be measurable.

Track:

```text
Page Performance
Revenue
UX Metrics
Ad Viewability
Bounce / Engagement
```

---

# 61. Performance

Ads can affect page speed.

Aspirian should monitor:

```text
Core Web Vitals
Page Load
Layout Stability
JavaScript Cost
Network Requests
```

---

# 62. Lazy Loading

Where technically appropriate, ads below the initial viewport may be loaded efficiently to reduce unnecessary performance impact.

---

# 63. Layout Stability

Reserve appropriate space for advertisements where possible to reduce layout shifts.

---

# 64. Caching

Caching strategy must not cause incorrect personalized or consent-related ad behavior.

---

# 65. CDN

CDN and caching architecture should remain compatible with advertising requirements.

---

# 66. Consent

Where legally applicable, Aspirian must implement appropriate user consent mechanisms for advertising and related technologies.

---

# 67. Privacy

Advertising integrations must respect:

```text
Applicable Privacy Laws
Consent Requirements
Platform Policies
User Choices
```

---

# 68. Consent Management

A consent mechanism may manage:

```text
Advertising Consent
Analytics Consent
Personalization Preferences
Cookie / Storage Preferences
```

---

# 69. Regional Behavior

Advertising and consent behavior may differ by user's jurisdiction.

The architecture should support regional configuration.

---

# 70. Privacy-First Design

Do not collect unnecessary personal information merely to improve advertising revenue.

---

# 71. Children's Privacy

Aspirian serves students from Nursery through Class 12.

Therefore advertising and personalization for younger users require especially careful policy and privacy handling.

The platform should not assume that all student accounts are equivalent to adult users.

---

# 72. Age-Aware Advertising

Where required, advertising behavior should support age-appropriate and legally compliant configurations.

---

# 73. Personalized Advertising

Personalized advertising should only be enabled where appropriate and where required consent/eligibility conditions are satisfied.

---

# 74. Non-Personalized Advertising

Where personalized advertising is not appropriate, the platform should support non-personalized/contextual advertising configurations where available.

---

# 75. Student Safety

Ads must not promote content that is inappropriate for the platform's educational audience.

Ad platform controls should be configured as appropriate for the site's audience.

---

# 76. Sensitive Content

Aspirian should carefully consider advertising behavior on pages discussing sensitive educational or personal topics.

---

# 77. Ad Review

Advertising configuration should be periodically reviewed.

---

# 78. AdSense Account

The AdSense account should be managed separately from the application's core subscription infrastructure.

---

# 79. AdSense Code

AdSense integration code should be maintained in a controlled deployment configuration.

Avoid scattering ad code throughout business logic.

---

# 80. Environment Configuration

Use appropriate environment/configuration management for:

```text
AdSense Publisher Identifier
Ad Unit Configuration
Consent Configuration
Feature Flags
```

---

# 81. Secrets

Sensitive credentials or private configuration must not be committed to GitHub.

---

# 82. Git Security

Never commit:

```text
Private API Keys
Secret Tokens
Credentials
Private Payment Information
```

---

# 83. WordPress Integration

For `aspirian.pk`, AdSense may be integrated through controlled WordPress configuration.

Potential approaches:

```text
Ad Management Plugin
Theme Integration
Custom Code
Google-Provided Integration
```

The final implementation should prioritize maintainability and policy compliance.

---

# 84. WordPress Ad Placement

Ad placements should be centrally manageable rather than manually inserted into hundreds of articles wherever possible.

---

# 85. Elementor Compatibility

If Elementor is used for page layouts, advertisements should be placed without creating misleading UI or excessive layout complexity.

---

# 86. Article Template

Recommended:

```text
Header
 ↓
Article Title
 ↓
Introduction
 ↓
Content
 ↓
Ad Placement
 ↓
Content
 ↓
Related Articles
 ↓
Optional Ad
 ↓
Conclusion
```

---

# 87. Tool Template

Recommended:

```text
Tool Title
 ↓
Description
 ↓
Tool Interface
 ↓
Result
 ↓
Explanation
 ↓
Related Educational Content
 ↓
Optional Ad
```

---

# 88. Download Template

Recommended:

```text
Resource Information
 ↓
Version / Details
 ↓
Instructions
 ↓
Download Button
 ↓
Related Information
 ↓
Optional Ad
```

---

# 89. Ads Must Not Mimic UI

Advertisements must remain distinguishable from:

```text
Navigation
Download Buttons
Form Controls
Questions
Answers
System Messages
```

---

# 90. Error Pages

Advertising on error pages should not be prioritized over helping the user recover.

---

# 91. Login Pages

Login and registration pages should prioritize authentication.

Advertising should generally be avoided where it could distract or confuse.

---

# 92. Checkout Pages

Subscription checkout pages should prioritize:

```text
Plan
Price
Billing
Payment
Terms
Confirmation
```

Advertising should not distract from financial transactions.

---

# 93. Payment Pages

Payment interfaces should remain focused and trustworthy.

---

# 94. Subscription Management

Subscription management pages should generally avoid unnecessary advertising.

---

# 95. Premium Upgrade Pages

Premium upgrade pages should prioritize:

```text
Features
Pricing
Benefits
Terms
Checkout
```

rather than third-party advertising.

---

# 96. Advertising Revenue

Revenue may be generated from:

```text
Ad Impressions
Ad Clicks
Other Eligible Ad Interactions
```

according to the applicable advertising program.

---

# 97. Revenue Reporting

Advertising reporting should remain separate from subscription revenue.

```text
Total Revenue
 ├── Advertising Revenue
 └── Subscription Revenue
```

---

# 98. Revenue Analytics

Possible metrics:

```text
Page Views
Ad Impressions
Estimated Revenue
RPM
CTR
Viewability
```

Metrics should be interpreted using the relevant reporting definitions.

---

# 99. Revenue Dashboard

Admin dashboard may show:

```text
Ad Revenue
Subscription Revenue
Total Revenue
Revenue Trend
Top Pages
Top Content Categories
```

---

# 100. Ad Performance by Page

Track eligible aggregated metrics such as:

```text
Article
Tool
Category
Device
```

while respecting privacy.

---

# 101. Top Monetized Content

Reports may identify pages generating strong advertising revenue.

---

# 102. Content Optimization

Revenue data may help improve:

```text
Content Quality
SEO
Page UX
Ad Placement
```

but should not encourage low-value content production.

---

# 103. Traffic Quality

Monitor unusual traffic patterns.

Examples:

```text
Sudden Traffic Spikes
Unusual Click Activity
Bot-Like Sessions
Abnormal Geographic Patterns
```

---

# 104. Invalid Traffic Monitoring

Potential suspicious behavior should be investigated rather than monetized.

---

# 105. Ad Blocking

Some users may use ad blockers.

Aspirian may choose to:

```text
Allow Access
Show a Respectful Message
Offer Premium / Ad-Free Option
```

according to product policy.

---

# 106. Ad-Free Experience

If offered, premium ad-free access should be controlled through an entitlement:

```text
ads_free
```

rather than hard-coded user roles.

---

# 107. Subscription Integration

```text
Subscription
      ↓
Entitlement
      ↓
ads_free
      ↓
Ad Rendering Disabled
```

---

# 108. Entitlement Expiration

If ad-free access expires:

```text
Entitlement Expires
 ↓
Standard Advertising Rules Resume
```

where applicable.

---

# 109. School Ad-Free

School subscriptions may optionally include:

```text
ads_free
```

for covered users.

---

# 110. Parent-Paid Ad-Free

A parent-paid premium subscription may optionally grant ad-free access to the linked student.

---

# 111. Premium Feature + Ads

Premium functionality and ad-free functionality should remain separate concepts.

Example:

```text
premium_ai_tutor
```

and:

```text
ads_free
```

are independent entitlements.

---

# 112. Ad Configuration Service

Future architecture may use:

```text
Ad Configuration Service
 ↓
Page Type
 ↓
User Eligibility
 ↓
Consent
 ↓
Placement
 ↓
Ad Request
```

---

# 113. Feature Flag Integration

Advertising can be controlled through feature flags for:

```text
New Placement
New Format
A/B Test
Temporary Disable
```

---

# 114. Emergency Ad Disable

Administrators should be able to disable advertising quickly if:

```text
Policy Issue
Technical Issue
Bad Ad Experience
Performance Problem
Security Problem
```

is detected.

---

# 115. Ad Incident Management

If an advertising problem occurs:

```text
Detect
 ↓
Disable
 ↓
Investigate
 ↓
Correct
 ↓
Re-enable
```

---

# 116. Monitoring

Monitor:

```text
Ad Requests
Ad Rendering Errors
Page Performance
Revenue Changes
Policy Notifications
Traffic Quality
```

---

# 117. Alerts

Possible alerts:

```text
Sudden Revenue Drop
Ad Rendering Failure
Traffic Anomaly
Performance Degradation
Policy Warning
```

---

# 118. Disaster Recovery

Advertising configuration should be backed up as part of the application/site configuration strategy.

---

# 119. Testing

Before production deployment, test:

```text
Desktop
Mobile
Tablet
Article Pages
Tool Pages
Download Pages
Logged-In Users
Anonymous Users
Premium Users
School Users
Parent Users
```

---

# 120. Ad Placement Testing

Verify:

```text
No UI Confusion
No Broken Layout
No Excessive Density
No Critical Workflow Interruption
```

---

# 121. Privacy Testing

Verify:

```text
Consent State
Regional Behavior
Personalized / Non-Personalized Configuration
Cookie / Storage Behavior
```

where applicable.

---

# 122. Performance Testing

Measure:

```text
Page Load
Core Web Vitals
Layout Shift
JavaScript
Network Requests
```

before and after advertising integration.

---

# 123. Compliance Review

The advertising architecture should periodically be reviewed against the then-current requirements of:

```text
Google AdSense
Google Publisher Policies
Google Consent Requirements
Applicable Privacy Laws
Applicable Children's Privacy Requirements
```

---

# 124. Policy Change Strategy

Advertising policies can change.

Therefore:

```text
Policy
 ↓
Review
 ↓
Configuration Update
 ↓
Testing
 ↓
Deployment
```

should be part of operational practice.

---

# 125. AdSense Independence

If Aspirian changes advertising providers in the future:

```text
AdSense
   ↓
Replaceable Ad Provider Layer
```

The content platform should not require major architectural changes.

---

# 126. Advertising Abstraction

Future architecture:

```text
Page
 ↓
Advertising Interface
 ↓
Provider Adapter
 ↓
Ad Network
```

This keeps the application flexible.

---

# 127. Provider Adapter

Potential future providers could be integrated without changing page/business logic.

---

# 128. No Revenue Dependency

Core educational functionality must not depend on AdSense being available.

---

# 129. AdSense Account Suspension

If advertising is temporarily unavailable:

```text
Educational Content → Continues
Tools → Continue
Student Platform → Continues
Subscriptions → Continue
```

---

# 130. Subscription Independence

Subscription billing must continue independently of advertising status.

---

# 131. Final Monetization Architecture

```text
                         ASPIRIAN
                            ↓
              ┌─────────────┴─────────────┐
              ↓                           ↓
         PUBLIC WEBSITE              STUDENT APP
              ↓                           ↓
       FREE EDUCATIONAL             FREE + PREMIUM
           CONTENT                      ACCESS
              ↓                           ↓
          ADSENSE                   SUBSCRIPTIONS
              ↓                           ↓
       ADVERTISING                 PREMIUM REVENUE
          REVENUE                       ↓
              └─────────────┬─────────────┘
                            ↓
                    TOTAL PLATFORM
                       REVENUE
```

---

# 132. Final Ad Placement Philosophy

```text
Content First
Learning First
User Experience First
Privacy First
Safety First
Revenue Second
```

---

# 133. Final Rules

```text
1. AdSense monetizes eligible public content.
2. Premium subscriptions remain independent from AdSense.
3. Ads must never be disguised as educational UI.
4. Ads must not imitate download buttons.
5. Ads must not encourage accidental clicks.
6. Users must never be rewarded for clicking ads.
7. Advertising must not interfere with tests or focused learning.
8. Premium checkout and payment pages should remain distraction-free.
9. Student privacy and safety are higher priority than ad revenue.
10. Age-sensitive advertising requirements must be respected.
11. Consent requirements must be supported where applicable.
12. Invalid traffic must never be encouraged.
13. Advertising configuration must be centrally manageable.
14. Advertising must be monitored for performance and policy issues.
15. AdSense must remain independent from subscription billing.
16. Core educational functionality must continue if advertising is unavailable.
17. Future ad providers should be replaceable without redesigning the platform.
18. Current Google policies must always be verified before production configuration.
```

---

# 134. Final Ecosystem

```text
                     ASPIRIAN.PK
                          │
              ┌───────────┴───────────┐
              │                       │
       PUBLIC CONTENT             FREE TOOLS
              │                       │
              └───────────┬───────────┘
                          │
                       ADSENSE
                          │
                   ADVERTISING
                     REVENUE


                    APP.ASPIRIAN.PK
                          │
              ┌───────────┴───────────┐
              │                       │
             FREE                  PREMIUM
              │                       │
              │                 SUBSCRIPTIONS
              │                       │
              │                  ENTITLEMENTS
              │                       │
              └───────────┬───────────┘
                          │
                    STUDENT AI
                    PLATFORM
```

---

# 135. Document Status

**File:** `ADSENSE_ARCHITECTURE.md`
**Version:** 1.0
**Status:** Final AdSense Architecture Blueprint
**Phase:** H
**Module:** H4 — AdSense Architecture
**Academic Range:** Nursery → Class 12
**Primary Website:** `aspirian.pk`
**Primary Application:** `app.aspirian.pk`

This document defines the official advertising architecture for the Aspirian ecosystem and integrates with:

* `PAYMENT_SYSTEM.md`
* `SUBSCRIPTIONS.md`
* `PREMIUM_FEATURES.md`
* `AI_SAFETY.md`
* `REPORTING.md`
* `CONTENT_MANAGEMENT.md`
* `USER_MANAGEMENT.md`
