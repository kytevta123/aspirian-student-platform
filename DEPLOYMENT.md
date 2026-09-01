# Aspirian Student Platform — Deployment Architecture

**Version:** 1.0
**Status:** Technical Design Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12

---

# 1. Purpose

This document defines the deployment and infrastructure strategy for the Aspirian Student Platform.

The platform will be developed separately from the existing WordPress website and deployed as an independent application.

---

# 2. Production Architecture

The initial production architecture is:

```text
                    INTERNET
                        │
              ┌─────────┴─────────┐
              │                   │
        aspirian.pk        app.aspirian.pk
              │                   │
       WordPress Website    Student Platform
                                  │
                                  ▼
                           api.aspirian.pk
                                  │
                     ┌────────────┼────────────┐
                     │            │            │
                 Backend      Database      Cache
                     │
             ┌───────┼────────┐
             │       │        │
            AI     Queue    Storage
             │
       AI Providers
```

---

# 3. Existing WordPress Website

The existing:

```text
https://aspirian.pk
```

will continue to operate as the public content platform.

Primary responsibilities:

* Educational Articles
* Notes
* Tutorials
* Free Online Tools
* Job & Career Hub
* Downloads
* SEO
* Organic Traffic
* Public Educational Content
* Student Discovery

The application deployment must not unnecessarily interfere with the existing WordPress installation.

---

# 4. Application Domain

The main application will use:

```text
app.aspirian.pk
```

This will be the primary student-facing application.

Examples:

```text
app.aspirian.pk/login
app.aspirian.pk/dashboard
app.aspirian.pk/tests
app.aspirian.pk/subjects
app.aspirian.pk/revision
```

---

# 5. API Domain

The backend API will use:

```text
api.aspirian.pk
```

Example:

```text
app.aspirian.pk
        │
        ▼
api.aspirian.pk
        │
        ▼
Backend
```

The API should not expose unnecessary internal services directly to the public internet.

---

# 6. Development Environment

Development will initially happen on the developer's local computer.

Conceptually:

```text
Developer Computer
        │
        ├── Frontend
        ├── Backend
        ├── Database
        ├── Cache
        └── Local Services
```

---

# 7. Development Configuration

Development environment should use:

```text
APP_ENV=local
```

and separate credentials from staging and production.

---

# 8. Environment Separation

The project should maintain separate environments:

```text
Development
     ↓
Testing
     ↓
Staging
     ↓
Production
```

Each environment should have separate:

* Database
* Credentials
* API keys
* Storage
* Configuration
* Logs

---

# 9. Staging Environment

Before production deployment, a staging environment should be used for major releases.

Possible structure:

```text
staging.app.aspirian.pk
staging-api.aspirian.pk
```

Exact subdomains can be finalized later.

---

# 10. Production Environment

Production will host:

```text
app.aspirian.pk
api.aspirian.pk
```

Production infrastructure must be isolated from development credentials and test data.

---

# 11. Infrastructure Philosophy

The initial infrastructure should be:

* Cost-effective
* Secure
* Maintainable
* Scalable
* Easy to monitor
* Easy to back up
* Easy to migrate

Avoid unnecessary infrastructure complexity during the initial launch.

---

# 12. Server Strategy

The application can initially run on a VPS/cloud server.

The exact provider can be selected based on:

* Price
* CPU
* RAM
* Storage
* Network
* Location
* Backup options
* Scalability

The architecture must avoid unnecessary vendor lock-in.

---

# 13. Containerization

Docker/containerization may be introduced where beneficial.

Possible services:

```text
Frontend
Backend
Database
Redis
Queue Worker
Web Server
```

The final production setup will be selected after the application stack is finalized.

---

# 14. Reverse Proxy

A reverse proxy/web server will sit in front of application services.

Conceptually:

```text
Internet
   │
   ▼
Reverse Proxy
   │
   ├── app.aspirian.pk
   └── api.aspirian.pk
```

---

# 15. HTTPS

All production application traffic must use HTTPS.

Required:

```text
https://app.aspirian.pk
https://api.aspirian.pk
```

HTTP requests should redirect to HTTPS where appropriate.

---

# 16. SSL/TLS

Production SSL certificates should be automatically renewed where practical.

Certificates must never be allowed to expire unexpectedly.

---

# 17. DNS

DNS will route the application domains to the production infrastructure.

Conceptually:

```text
app.aspirian.pk
        ↓
Production Server

api.aspirian.pk
        ↓
Production Server
```

DNS provider and exact records will be configured during deployment.

---

# 18. Frontend Deployment

The frontend should be built for production before deployment.

Conceptually:

```text
Source Code
    ↓
Install Dependencies
    ↓
Build
    ↓
Production Assets
    ↓
Deploy
```

---

# 19. Backend Deployment

Backend deployment should follow:

```text
Pull Release
 ↓
Install Dependencies
 ↓
Configure Environment
 ↓
Run Safe Migrations
 ↓
Clear/Build Caches
 ↓
Restart Workers
 ↓
Health Check
```

---

# 20. Database

Production must use a dedicated production database.

The database should not be publicly exposed unnecessarily.

Preferred architecture:

```text
Internet
   X
   │
Database
   │
Backend Only
```

---

# 21. Database Security

Database access should use:

* Strong credentials
* Restricted network access
* Least-privilege accounts
* Encrypted connections where appropriate
* Regular backups

---

# 22. Database Migrations

Database schema changes must be managed through version-controlled migrations.

Never rely on manually changing production tables.

---

# 23. Migration Deployment

Preferred workflow:

```text
Backup
 ↓
Deploy Code
 ↓
Run Migration
 ↓
Verify
 ↓
Health Check
```

Destructive migrations require additional planning.

---

# 24. Redis / Cache

Redis or an equivalent caching system may be used for:

* Cache
* Sessions
* Queues
* Rate limiting
* Temporary data

The exact usage will be defined during implementation.

---

# 25. Queue Workers

Long-running operations should use background workers.

Examples:

```text
AI Generation
Audio Transcription
Video Processing
Email
Notifications
Reports
Large Imports
```

Architecture:

```text
Application
    │
    ▼
Queue
    │
    ▼
Worker
    │
    ▼
Task
```

---

# 26. Scheduled Jobs

Scheduled tasks may include:

```text
Daily Revision Generation
Notifications
Content Processing
Cleanup Jobs
Reports
Analytics Aggregation
Backup Tasks
```

---

# 27. AI Infrastructure

AI requests should normally pass through backend services.

Preferred:

```text
Student
  ↓
Frontend
  ↓
Backend
  ↓
AI Service
  ↓
AI Provider
```

Do not expose private AI provider API keys in frontend code.

---

# 28. AI Cost Protection

AI features must include controls such as:

* Rate limiting
* Usage limits
* Request validation
* Token limits
* Monitoring
* Abuse prevention

---

# 29. File Storage

Large files should not unnecessarily be stored directly on the application server.

Potential storage:

```text
Object Storage
CDN
Media Provider
```

Examples of files:

* PDFs
* Images
* Audio
* Video
* Student uploads
* Generated documents

The final provider will be selected during implementation.

---

# 30. Media Architecture

The platform may use multiple media services.

```text
Educational Video
       ↓
YouTube / Media Platform

Audio
       ↓
Object Storage / Streaming

PDF
       ↓
Object Storage

Application
       ↓
Metadata + Access Control
```

---

# 31. Internet Radio

The Aspirian Internet Radio system will be treated as an independent streaming service.

Conceptually:

```text
Audio Source
     ↓
Streaming Server
     ↓
Public Stream
     ↓
Aspirian Application
```

The application will display:

* Current program
* Radio status
* Player
* Schedule
* Program information

---

# 32. YouTube Live

Educational live broadcasts may use YouTube Live.

Architecture:

```text
Live Production
       ↓
YouTube Live
       ↓
Aspirian Application
       ↓
Student
```

The application may show:

* Live player
* Live status
* Schedule
* Program details
* Upcoming stream information

---

# 33. YouTube API Credentials

Private YouTube API credentials must remain server-side.

They must never be committed to GitHub.

---

# 34. CDN

A CDN may be introduced for:

* Static assets
* Images
* Public files
* Media
* Global performance

CDN usage can be expanded as traffic grows.

---

# 35. Email Infrastructure

The platform may require email for:

* Registration
* Verification
* Password reset
* Notifications
* Teacher communication
* System alerts

Production email should use a reliable transactional email service.

---

# 36. Notifications

Notification infrastructure may support:

```text
In-App
Email
Push Notifications
```

Future mobile applications can reuse the same notification backend.

---

# 37. Monitoring

Production should be monitored for:

```text
Server Health
CPU
RAM
Disk
Database
API
Queue
AI Services
Errors
Response Time
```

---

# 38. Application Health Checks

The application should expose health information where appropriate.

Conceptually:

```text
/api/health
```

Health checks may verify:

```text
Application
Database
Cache
Queue
Storage
```

Sensitive infrastructure information must not be exposed publicly.

---

# 39. Error Monitoring

Production errors should be captured by an error-monitoring system.

Important information:

* Error type
* Timestamp
* Request context
* Application version
* Environment

Sensitive data must be excluded.

---

# 40. Logging

Logs should be centralized or retained sufficiently for troubleshooting.

Never log:

* Passwords
* API secrets
* Tokens
* Payment credentials
* Sensitive student information

---

# 41. Backups

Production backups should cover:

```text
Database
Important Files
Configuration
Application Recovery Information
```

---

# 42. Backup Strategy

Recommended conceptual strategy:

```text
Daily Backup
+
Periodic Full Backup
+
Off-Site Backup
```

Exact retention policy will be finalized according to storage cost and business requirements.

---

# 43. Backup Verification

A backup is not considered reliable until restoration has been tested.

Periodic restore testing should be performed.

---

# 44. Disaster Recovery

The platform should have a recovery plan.

Possible scenario:

```text
Server Failure
     ↓
Provision Replacement
     ↓
Restore Database
     ↓
Restore Storage
     ↓
Deploy Application
     ↓
Configure DNS
     ↓
Health Check
```

---

# 45. Deployment Strategy

Initial deployment may use a controlled manual process.

As the project grows, CI/CD should automate deployment.

---

# 46. CI/CD

Future CI/CD pipeline:

```text
Git Push
   ↓
Automated Tests
   ↓
Security Checks
   ↓
Build
   ↓
Staging
   ↓
Approval
   ↓
Production
```

---

# 47. GitHub Integration

GitHub will remain the primary source repository.

Production should deploy from a controlled branch/release rather than from random local files.

---

# 48. Branch Strategy

Conceptually:

```text
main
 │
 ├── feature/*
 ├── fix/*
 └── release/*
```

Only stable code should reach production.

---

# 49. Release Versioning

Releases should use identifiable versions.

Example:

```text
v0.1.0
v0.2.0
v1.0.0
```

Major release conventions can be refined later.

---

# 50. Zero/Low Downtime Goal

As the platform grows, deployments should aim for minimal disruption.

Possible future techniques:

* Rolling deployments
* Blue/green deployment
* Health checks
* Graceful worker restart

These are not required for the first prototype.

---

# 51. Rollback Strategy

Every production deployment should have a rollback plan.

Conceptually:

```text
New Release
    ↓
Problem?
   / \
 NO  YES
 │     │
Done  Rollback
```

---

# 52. Environment Secrets

Secrets must be stored outside source code.

Examples:

```text
Database Password
AI API Key
Email API Key
Storage Credentials
OAuth Secrets
JWT/Session Secrets
```

---

# 53. GitHub Secret Protection

Never commit:

```text
.env
API Keys
Private Keys
Passwords
Production Credentials
```

Use:

```text
.env.example
```

for documentation.

---

# 54. Server Access

Production server access should follow least privilege.

Avoid sharing the root account unnecessarily.

---

# 55. SSH Security

Production SSH should use secure authentication practices.

Where practical:

* SSH keys
* Disabled password login
* Limited users
* Firewall rules
* Monitoring

---

# 56. Firewall

Only required ports/services should be exposed publicly.

Typical public services:

```text
HTTP
HTTPS
```

Database and internal services should not normally be publicly accessible.

---

# 57. Security Updates

Server operating system and dependencies should be updated regularly.

Security updates should be tested before production where practical.

---

# 58. Storage Management

Monitor disk usage.

Important because the platform may eventually store:

* PDFs
* Images
* Audio
* Student files
* Generated documents
* Logs

Large media should preferably use dedicated storage.

---

# 59. Scaling Strategy

The platform should be able to evolve from:

```text
Single Server
      ↓
Optimized Server
      ↓
Separate Services
      ↓
Multiple Application Servers
      ↓
Load Balancer
```

Scaling should happen based on real traffic and bottlenecks.

---

# 60. Database Scaling

Future database scaling may include:

```text
Indexes
Query Optimization
Caching
Read Replicas
Database Scaling
```

Do not introduce database clustering before it is necessary.

---

# 61. Queue Scaling

AI and media processing may require multiple workers.

```text
Queue
 ├── Worker 1
 ├── Worker 2
 └── Worker 3
```

Workers can scale independently from web requests.

---

# 62. AI Scaling

AI workloads should be isolated where possible.

```text
Web Requests
     │
     X
AI Queue
     │
     ▼
AI Workers
```

This prevents long AI requests from blocking normal student activity.

---

# 63. Code Execution Infrastructure

The coding lab will require isolated execution infrastructure.

Conceptually:

```text
Student Code
     ↓
Secure Sandbox
     ↓
Resource Limits
     ↓
Execution
     ↓
Result
```

Code execution must never run directly with unrestricted application-server privileges.

---

# 64. Video Processing

Video processing should use background workers.

```text
Upload
 ↓
Storage
 ↓
Queue
 ↓
Worker
 ↓
Processing
 ↓
Output
```

---

# 65. Audio Processing

Audio-to-notes functionality:

```text
Audio
 ↓
Storage
 ↓
Transcription
 ↓
AI Processing
 ↓
Notes
```

This should not block the normal web request.

---

# 66. Teacher Paper Builder

Paper generation may require:

```text
Question Selection
 ↓
Blueprint Validation
 ↓
Paper Generation
 ↓
Formatting
 ↓
PDF Generation
 ↓
Storage
```

Large PDF generation should use background processing when required.

---

# 67. Student Revision Queue

Revision generation may run through scheduled jobs:

```text
Performance
 ↓
Mistake Analysis
 ↓
Revision Engine
 ↓
Personalized Queue
```

---

# 68. Analytics

Analytics processing should avoid slowing down student-facing requests.

Future architecture may use:

```text
Application Events
 ↓
Queue
 ↓
Analytics Processing
 ↓
Reports
```

---

# 69. Production Data Rules

Production student data must never be casually copied into development environments.

If anonymized data is required for testing, it must be properly sanitized.

---

# 70. Privacy

The application should follow privacy-by-design principles.

Collect only information required for the intended functionality.

---

# 71. Domain Architecture Summary

```text
aspirian.pk
     │
     └── WordPress
         │
         ├── Articles
         ├── Notes
         ├── Tutorials
         ├── Free Tools
         ├── Job & Career Hub
         └── Downloads


app.aspirian.pk
     │
     └── Student Platform
             │
             ▼
       api.aspirian.pk
             │
       ┌─────┼───────────┐
       │     │           │
    Database Cache      Queue
       │                 │
       │            AI/Media
       │
       └──── Storage
```

---

# 72. Deployment Lifecycle

```text
Development
     ↓
Git Commit
     ↓
GitHub
     ↓
CI Tests
     ↓
Staging
     ↓
UAT
     ↓
Release
     ↓
Production
     ↓
Monitoring
```

---

# 73. Production Checklist

Before production release:

```text
[ ] Domain configured
[ ] DNS configured
[ ] HTTPS active
[ ] Environment variables configured
[ ] Database configured
[ ] Migrations completed
[ ] Storage configured
[ ] Queue configured
[ ] AI configuration verified
[ ] Email configured
[ ] Backups configured
[ ] Monitoring configured
[ ] Error tracking configured
[ ] Security checks passed
[ ] Tests passed
[ ] Rollback plan available
```

---

# 74. Deployment Checklist After Release

```text
[ ] Application opens
[ ] Login works
[ ] Registration works
[ ] API works
[ ] Database works
[ ] Tests can start
[ ] Tests can submit
[ ] Results calculate correctly
[ ] AI features respond
[ ] Media works
[ ] Radio works
[ ] YouTube Live integration works
[ ] Notifications work
[ ] No critical errors
```

---

# 75. First Production Version

The first production version should remain intentionally simple.

Priority:

```text
Stable
Secure
Tested
Monitorable
Recoverable
```

Advanced infrastructure should only be introduced when justified by actual requirements.

---

# 76. Future Infrastructure Evolution

As Aspirian grows:

```text
Phase 1
Single VPS
   ↓
Phase 2
Separate Database / Storage
   ↓
Phase 3
Queue + Multiple Workers
   ↓
Phase 4
CDN + Load Balancer
   ↓
Phase 5
Horizontally Scaled Services
```

The actual infrastructure will depend on traffic and business requirements.

---

# 77. Deployment Documentation

Infrastructure changes must be documented.

Update this document when there are significant changes to:

* Servers
* Domains
* DNS
* Database
* Storage
* Queues
* AI infrastructure
* CI/CD
* Monitoring
* Backup strategy

---

# 78. Final Deployment Principle

> **Production should be boring: predictable deployments, protected data, tested releases, reliable backups, clear monitoring, and a known recovery path.**

---

# 79. Document Status

**File:** `DEPLOYMENT.md`
**Phase:** B
**Module:** B7 — Deployment Architecture

**Version:** 1.0
**Status:** Technical Design Blueprint

This document defines the initial deployment architecture for the Aspirian Student Platform.

Infrastructure details will be finalized during implementation and deployment.
