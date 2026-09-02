# ASPIRIAN STUDENT PLATFORM — SERVER SETUP

**File:** `SERVER_SETUP.md`

**Version:** 1.0

**Phase:** K — DevOps & Deployment

**Status:** Final Technical Specification

**Project:** Aspirian Student Platform

**Website:** `aspirian.pk`

**Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the server infrastructure and deployment setup required for the Aspirian Student Platform.

The purpose of this document is to provide a standardized server environment for:

- Web application
- Backend API
- Database
- Queue workers
- Scheduled jobs
- File storage
- Media processing
- Notifications
- AI services
- Monitoring
- Backups
- Security

The server architecture should be secure, maintainable, scalable, and suitable for future platform growth.

---

# 2. Server Setup Vision

The Aspirian server architecture should provide a reliable environment where all core platform services can operate together while remaining logically separated.

Recommended architecture:

    User
      ↓
    DNS
      ↓
    HTTPS / SSL
      ↓
    Web Server / Reverse Proxy
      ↓
    Application
      ↓
    API
      ↓
    Database
      ↓
    Cache / Queue
      ↓
    Background Workers

Additional services:

    File Storage
    Media Processing
    Notifications
    AI Services
    Monitoring
    Backups

---

# 3. Server Environment

The production server should provide a stable Linux-based environment.

Recommended operating-system family:

- Ubuntu LTS
- Debian Stable
- Another supported enterprise Linux distribution

The final operating system should be selected according to the hosting provider and deployment architecture.

---

# 4. Server Responsibilities

The production server may host:

- Aspirian web application
- Backend API
- Database services where appropriate
- Queue workers
- Scheduled tasks
- Cache services
- File storage
- Application logs
- Monitoring agents
- Deployment agents

Large media or high-volume storage should be separated when required.

---

# 5. Server Architecture

Recommended logical structure:

    Internet
       ↓
    DNS
       ↓
    Firewall
       ↓
    Reverse Proxy
       ↓
    Web / API Application
       ↓
    Application Services
       ↓
    Database / Cache / Queue
       ↓
    Storage / Backup

This architecture may evolve as the platform scales.

---

# 6. Domain Configuration

The primary website domain is:

`aspirian.pk`

The application may use:

`app.aspirian.pk`

API services may use a dedicated subdomain where appropriate.

Example:

`api.aspirian.pk`

The exact domain structure should remain consistent across development, staging, and production environments.

---

# 7. DNS Configuration

DNS records should be configured through the selected DNS provider.

Typical records may include:

- A record
- AAAA record where IPv6 is supported
- CNAME record
- TXT records
- MX records
- Verification records

DNS changes should be documented before production deployment.

---

# 8. DNS Security

DNS management accounts must use strong authentication.

Recommended controls include:

- Strong password
- Multi-factor authentication
- Restricted access
- DNS change monitoring
- Recovery procedures

DNS credentials must never be committed to Git.

---

# 9. Server Access

Server access should use secure authentication.

SSH should be preferred over insecure remote-access methods.

Recommended approach:

    Developer / Administrator
             ↓
          SSH Key
             ↓
        Server Access

Password-based SSH access should be disabled where practical.

---

# 10. SSH Configuration

SSH should be securely configured.

Recommended controls include:

- SSH key authentication
- Disabled root login
- Disabled password authentication where practical
- Restricted users
- Non-default SSH configuration where appropriate
- Connection monitoring

Any configuration change must be tested before closing the existing administrative session.

---

# 11. Server Users

Separate server users should be used where practical.

Example:

    administrator
    deploy
    application
    database

The exact users depend on the final server architecture.

Applications should not normally run as root.

---

# 12. Root Access

Root access should be restricted.

Routine application deployment should not require direct root access.

Administrative privileges should be granted only when necessary.

The principle of least privilege must be followed.

---

# 13. Firewall

A production firewall must restrict unnecessary network access.

Typical allowed services may include:

- SSH
- HTTP
- HTTPS

Database, cache, and internal service ports should not normally be exposed directly to the public Internet.

---

# 14. Network Architecture

Recommended network flow:

    Internet
       ↓
    Firewall
       ↓
    Web Server
       ↓
    Application
       ↓
    Internal Services

Internal services should communicate through private interfaces wherever possible.

---

# 15. HTTP and HTTPS

HTTP should redirect to HTTPS.

Production application traffic should use encrypted HTTPS connections.

The application should not expose sensitive information over unencrypted HTTP.

---

# 16. SSL / TLS

A valid SSL/TLS certificate must be configured for production domains.

Certificates should be:

- Valid
- Automatically renewed where possible
- Monitored for expiration
- Properly configured

Certificate private keys must remain protected.

---

# 17. Web Server

The server may use a production-grade web server or reverse proxy.

Possible technologies include:

- Nginx
- Apache
- Caddy

The final selection should match the application architecture and hosting environment.

---

# 18. Reverse Proxy

A reverse proxy may handle:

- HTTPS termination
- Request routing
- Static files
- Compression
- Rate limiting
- Security headers
- Proxying requests to the application

Example:

    HTTPS Request
          ↓
    Reverse Proxy
          ↓
    Application Server

---

# 19. Application Server

The application server should run the Aspirian backend and related services.

The application runtime should match the selected development framework.

For example, if Laravel is used, the server should provide the required PHP version and extensions.

---

# 20. PHP Environment

If Laravel/PHP is used, the server should provide:

- Supported PHP version
- Required PHP extensions
- Composer
- PHP-FPM where applicable

The exact PHP version must be defined according to the application's supported Laravel version.

---

# 21. Composer

Composer should be installed for PHP dependency management.

Production installation should use:

    composer install --no-dev --optimize-autoloader

The exact deployment command may be adjusted according to the final application.

---

# 22. Node.js Environment

If frontend assets require Node.js, the production or build environment should use a supported Node.js version.

Dependency installation should use the project's lock file.

Example:

    npm ci

Production builds should be generated through the CI/CD pipeline where practical.

---

# 23. Application Directory

The application should use a controlled server directory.

Example:

    /var/www/aspirian

The actual directory may vary according to the hosting environment.

The web server should point to the application's public directory where required.

---

# 24. Laravel Public Directory

If Laravel is used, the web server should point to:

    /var/www/aspirian/public

The application root itself should not be directly exposed to the public web.

---

# 25. Application Permissions

Application files should use appropriate ownership and permissions.

The web server should have access only to directories that require write permissions.

Writable directories should be limited.

---

# 26. Storage Directory

If Laravel is used, application storage may include:

- Logs
- Cache
- Temporary files
- Generated files
- User uploads

Write permissions should be granted only where necessary.

---

# 27. Public Storage

If user-uploaded files need public access, the application should use a controlled public-storage mechanism.

For Laravel:

    php artisan storage:link

Only intended public files should be exposed.

---

# 28. Environment Configuration

Production configuration should be stored outside source-controlled code.

For Laravel this commonly includes:

    .env

The production `.env` file must never be committed to Git.

---

# 29. Production Environment Variables

Important configuration may include:

- Application URL
- Database credentials
- Cache configuration
- Queue configuration
- Mail configuration
- Payment configuration
- AI provider configuration
- Notification configuration
- Storage configuration

Actual secrets must remain protected.

---

# 30. Application Key

If Laravel is used, the application encryption key must be securely generated and stored.

Production application keys must not be exposed publicly.

Changing an existing production encryption key without understanding its impact can invalidate encrypted data and sessions.

---

# 31. Database Server

The platform requires a reliable relational database.

The current approved database technology is:

- MariaDB 10.6.5

The database server must be configured and maintained according to the requirements of the Laravel 12 application.

---

The final database engine must match the approved application architecture.

---

# 32. Database Isolation

The database should not be publicly accessible.

Recommended:

    Application Server
          ↓
    Private Database Connection
          ↓
    Database Server

Only authorized application services should be able to connect.

---

# 33. Database Credentials

Database credentials should be stored securely.

Credentials should not appear in:

- Source code
- Git history
- Public documentation
- CI logs
- Screenshots
- Error messages

---

# 34. Database Backups

Production databases must be backed up regularly.

Backup strategy should include:

- Automated backups
- Retention policy
- Off-server copies
- Backup monitoring
- Restore testing

---

# 35. Database Restore

A database restoration procedure must be documented.

Recommended process:

    Backup
       ↓
    Restore to Isolated Environment
       ↓
    Verify
       ↓
    Approve
       ↓
    Production Recovery

Restore procedures should be tested periodically.

---

# 36. Redis / Cache

Redis or another cache system may be used for:

- Application cache
- Sessions
- Queues
- Rate limiting
- Temporary data

Cache services should remain protected from public access.

---

# 37. Queue System

The Aspirian platform may use queues for background processing.

Possible jobs include:

- Email
- Notifications
- AI processing
- Report generation
- Media processing
- Analytics
- Data processing

---

# 38. Queue Worker

Queue workers should run continuously where required.

If Laravel is used, a process manager such as Supervisor or an appropriate service manager may be used.

Example architecture:

    Queue
      ↓
    Worker
      ↓
    Job Processing
      ↓
    Result

---

# 39. Process Management

Long-running processes should be managed by a reliable process manager.

Possible technologies include:

- systemd
- Supervisor
- Container orchestration

The final implementation depends on the deployment environment.

---

# 40. Scheduled Tasks

The platform may require scheduled tasks for:

- Notifications
- Subscription checks
- Cleanup
- Analytics
- Reports
- Backups
- Maintenance

The scheduler must run reliably.

---

# 41. Laravel Scheduler

If Laravel is used, the scheduler should be configured according to the application's scheduling architecture.

Example:

    php artisan schedule:run

The scheduling mechanism should be executed at the required interval.

---

# 42. Cron Jobs

Cron may be used for scheduled application tasks.

Cron configuration should be version-documented where practical.

Production cron jobs must be monitored to detect failures.

---

# 43. Mail Server

The application should use a reliable transactional email provider rather than depending on a basic local mail server where appropriate.

Email services may handle:

- Account verification
- Password reset
- Notifications
- Reports
- Subscription messages

SMTP credentials must remain secure.

---

# 44. File Storage

Application files should be stored using an appropriate storage architecture.

Possible options include:

- Local server storage
- Object storage
- Cloud storage
- CDN-backed storage

Large files should preferably be separated from the primary application server as the platform grows.

---

# 45. Media Storage

Aspirian may eventually store:

- Images
- PDFs
- Audio
- Video
- Student files
- Teacher resources
- Educational content

Media storage should be designed independently from application code.

---

# 46. CDN

A CDN may be introduced for high-volume static and media content.

Potential CDN content includes:

- Images
- CSS
- JavaScript
- Videos
- Audio
- Public educational resources

CDN adoption should be based on traffic and performance requirements.

---

# 47. Upload Limits

The server should define appropriate upload limits.

Limits may apply to:

- Images
- PDFs
- Audio
- Video
- Documents

Upload limits should be aligned with application requirements.

---

# 48. File Upload Security

Uploaded files must be validated.

Validation should include:

- File type
- MIME type
- File size
- File extension
- Filename handling
- Malware scanning where required

Uploaded files must never be trusted automatically.

---

# 49. Server Logs

The server should maintain logs for:

- Web requests
- Application errors
- Authentication events
- Deployment events
- System events
- Security events

Logs should be rotated and retained according to operational requirements.

---

# 50. Application Logs

The application should use structured and useful logs.

Important events may include:

- Authentication failures
- API errors
- Payment failures
- Queue failures
- AI service failures
- Database errors
- Critical exceptions

Sensitive information must not be written to logs.

---

# 51. Log Rotation

Logs should be rotated automatically.

The server must not allow logs to consume all available disk space.

Monitoring should alert administrators when disk usage becomes abnormal.

---

# 52. Monitoring

Production monitoring should cover:

- CPU
- RAM
- Disk
- Network
- Application health
- Database health
- Queue health
- API response time
- Error rate

---

# 53. Server Health Monitoring

The server should provide health information.

Important metrics include:

    CPU Usage
    Memory Usage
    Disk Usage
    Load Average
    Network Traffic
    Process Health

---

# 54. Application Health Monitoring

Application monitoring should verify:

- Homepage availability
- API availability
- Login
- Database connectivity
- Queue processing
- Critical application services

---

# 55. Uptime Monitoring

Production endpoints should be monitored from outside the server.

External monitoring can detect:

- Server downtime
- DNS problems
- SSL problems
- HTTP failures
- Slow responses

---

# 56. Error Monitoring

An application error-monitoring system may be integrated.

It should help identify:

- Exceptions
- Stack traces
- Failed requests
- Performance problems
- Repeated errors

Sensitive information must be protected.

---

# 57. Security Updates

The production operating system and server packages should be updated regularly.

Security updates should follow a controlled process.

    Security Update
          ↓
    Test / Review
          ↓
    Apply
          ↓
    Verify
          ↓
    Monitor

---

# 58. Automatic Security Updates

Automatic security updates may be enabled where appropriate.

However, critical application dependencies should still be tested through CI/CD before major changes.

---

# 59. Malware Protection

Where appropriate, production servers should use malware and file-integrity monitoring.

Uploaded files should receive additional validation and scanning when required.

---

# 60. Brute-Force Protection

Administrative endpoints should be protected against brute-force attacks.

Possible controls include:

- Rate limiting
- Login throttling
- MFA
- IP restrictions
- Fail2ban
- Security monitoring

---

# 61. Rate Limiting

Application and API endpoints should use rate limiting where necessary.

Rate limiting may apply to:

- Login
- Registration
- Password reset
- Public APIs
- AI requests
- File uploads
- Test submission

---

# 62. Server Security Headers

The web server and application should use appropriate security headers.

Possible headers include:

- HSTS
- Content Security Policy
- X-Content-Type-Options
- Referrer-Policy
- Frame protection

The final configuration should be tested for compatibility before production rollout.

---

# 63. Server Time

The production server should use correct time synchronization.

Accurate server time is important for:

- Authentication tokens
- Logs
- Scheduled jobs
- Payments
- Notifications
- Database records

---

# 64. Time Zone

The application should use a clearly defined time-zone strategy.

The application should avoid inconsistent time handling between:

- Server
- Database
- Backend
- Web application
- Mobile applications

UTC is recommended for internal timestamps where practical.

---

# 65. Deployment User

Production deployment should use a dedicated deployment identity where possible.

Example:

    Git / CI
       ↓
    Deploy User
       ↓
    Application Deployment

Deployment permissions should remain restricted.

---

# 66. CI/CD Integration

The server must integrate with the CI/CD architecture defined in `CI_CD.md`.

Recommended process:

    Git Push
       ↓
    CI Pipeline
       ↓
    Tests
       ↓
    Security
       ↓
    Build
       ↓
    Deployment
       ↓
    Server
       ↓
    Health Check

---

# 67. Deployment Directory Strategy

A release-based deployment structure may be used.

Example:

    /var/www/aspirian/
        releases/
            2026-01/
            2026-02/
            2026-03/
        current/
        shared/

This allows controlled releases and easier rollback.

---

# 68. Shared Files

Files that must survive deployments should be stored separately.

Examples:

- Environment configuration
- User uploads
- Application storage
- Persistent files

The exact structure depends on the deployment mechanism.

---

# 69. Deployment Rollback

The server should support rollback to a previous stable release.

Example:

    Current Release
         ↓
    Problem Detected
         ↓
    Previous Release
         ↓
    Health Check
         ↓
    Restore Service

---

# 70. Zero-Downtime Deployment

Where infrastructure permits, deployments should minimize downtime.

The deployment process should:

- Prepare new release
- Validate release
- Switch traffic
- Verify application
- Retain previous release for rollback

---

# 71. Server Capacity

The initial server should be sized according to expected workload.

Capacity planning should consider:

- Number of students
- Concurrent users
- API requests
- Database load
- File uploads
- Video traffic
- AI requests
- Background jobs

---

# 72. Scalability

The server architecture should support future scaling.

Possible scaling path:

    Single Server
         ↓
    Optimized Server
         ↓
    Separate Database
         ↓
    Separate Storage
         ↓
    Multiple Application Servers
         ↓
    Load Balancer
         ↓
    Distributed Architecture

Scaling should be introduced according to actual demand.

---

# 73. Load Balancer

A load balancer may be introduced when multiple application servers are required.

Example:

    Internet
       ↓
    Load Balancer
       ↓
    ┌───────────────┐
    ↓               ↓
    App Server 1    App Server 2
    ↓               ↓
    └───────┬───────┘
            ↓
        Database

---

# 74. Database Scaling

Database scaling may eventually include:

- Vertical scaling
- Read replicas
- Query optimization
- Index optimization
- Connection pooling
- Database partitioning where necessary

Database architecture should evolve according to measured workload.

---

# 75. Cache Scaling

Cache services may be separated from the application server as traffic grows.

Caching should reduce unnecessary database load without compromising data correctness.

---

# 76. Queue Scaling

Background workers may be scaled independently.

Example:

    Queue
      ↓
    Worker 1
    Worker 2
    Worker 3

This allows heavy background workloads to scale separately from web traffic.

---

# 77. AI Workload

AI-related operations may generate significant background processing.

AI requests should be isolated and controlled through:

- Queue processing
- Rate limiting
- Usage limits
- Monitoring
- Cost controls

AI provider credentials must remain secure.

---

# 78. Media Processing

Video and audio processing should preferably be handled asynchronously.

Example:

    Upload
      ↓
    Queue
      ↓
    Media Worker
      ↓
    Processing
      ↓
    Storage
      ↓
    CDN / Application

---

# 79. Server Backup

Critical server configuration should be backed up.

Backup targets may include:

- Application configuration
- Database
- Deployment configuration
- Important storage
- Infrastructure configuration

Source code remains protected by Git.

---

# 80. Backup Retention

A backup-retention policy should define:

- Daily backups
- Weekly backups
- Monthly backups
- Retention period
- Off-site storage

The exact retention policy should depend on business requirements.

---

# 81. Disaster Recovery

The server architecture should support recovery from:

- Hardware failure
- Disk failure
- Server failure
- Database corruption
- Deployment failure
- Security incident

Recovery procedures must be documented and tested.

---

# 82. Disaster Recovery Workflow

    Incident
       ↓
    Assess
       ↓
    Isolate
       ↓
    Restore Infrastructure
       ↓
    Restore Database
       ↓
    Deploy Application
       ↓
    Verify
       ↓
    Monitor

---

# 83. Server Migration

The architecture should allow migration to another hosting provider if necessary.

Migration should preserve:

- Application
- Database
- Storage
- DNS
- SSL
- Environment configuration
- Deployment process

Avoid unnecessary provider-specific dependencies.

---

# 84. Hosting Provider Independence

Where practical, the platform should avoid being permanently dependent on a single hosting provider.

Application code, database structure, deployment configuration, and documentation should remain portable.

---

# 85. Server Documentation

The following should be documented:

- Server IP
- Operating system
- Installed services
- Domain configuration
- SSL configuration
- Database configuration
- Deployment procedure
- Backup procedure
- Recovery procedure

Sensitive credentials must not be documented in plain text.

---

# 86. Server Inventory

A server inventory should identify:

    Server
      ↓
    Operating System
      ↓
    Application Runtime
      ↓
    Database
      ↓
    Cache
      ↓
    Queue
      ↓
    Web Server
      ↓
    Monitoring
      ↓
    Backup

The inventory should be updated whenever infrastructure changes.

---

# 87. Resource Monitoring Thresholds

Alerts should be configured for abnormal resource usage.

Potential warning conditions:

- High CPU
- High memory usage
- Low disk space
- High database load
- Queue backlog
- Increased API latency

Thresholds should be tuned according to actual production behavior.

---

# 88. Disk Management

Disk usage must be monitored continuously.

Large files should not accumulate indefinitely.

Cleanup policies should cover:

- Old logs
- Temporary files
- Old releases
- Cache files
- Failed uploads

---

# 89. Temporary Files

Temporary files should be cleaned automatically where appropriate.

Temporary data should never become a permanent source of uncontrolled disk growth.

---

# 90. Production Maintenance

Maintenance tasks should be planned and documented.

Examples:

- Security updates
- Runtime updates
- Database maintenance
- Log cleanup
- Backup verification
- Certificate renewal
- Infrastructure upgrades

---

# 91. Maintenance Window

Major infrastructure changes may require a maintenance window.

Users should be informed when planned maintenance may affect availability.

---

# 92. Server Testing

Before production deployment, server configuration should be tested in staging where possible.

Testing should verify:

- Application startup
- Database connection
- API
- Authentication
- Queue workers
- Scheduled jobs
- File uploads
- SSL
- Monitoring

---

# 93. Staging Server

The staging environment should reproduce the production architecture as closely as practical.

Example:

    Staging
       ↓
    Web Server
       ↓
    Application
       ↓
    Database
       ↓
    Queue
       ↓
    Storage

---

# 94. Production Parity

Staging and production should use compatible:

- Operating systems
- Runtime versions
- Database engines
- Application configuration
- Deployment process

This reduces deployment surprises.

---

# 95. Server Performance

Performance should be measured before making optimization decisions.

Important metrics include:

- Page response time
- API response time
- Database query time
- CPU usage
- Memory usage
- Queue processing time
- File-transfer performance

---

# 96. Performance Optimization

Optimization may include:

- Database indexing
- Query optimization
- Caching
- HTTP compression
- CDN
- PHP OPcache
- Asset optimization
- Queue processing
- Server tuning

Optimization should be based on actual measurements.

---

# 97. PHP OPcache

If PHP is used, OPcache should be considered for production.

It can improve PHP application performance by caching compiled PHP code.

Configuration should be tuned according to the application environment.

---

# 98. Database Indexing

Database indexes should be created for frequently queried fields.

Important areas may include:

- User identifiers
- Question identifiers
- Subject identifiers
- Test identifiers
- Result identifiers
- Subscription identifiers

Indexes should be based on actual query patterns.

---

# 99. Server Security Audit

The production server should periodically undergo a security review.

The review should cover:

- Open ports
- SSH configuration
- Firewall
- User accounts
- File permissions
- Installed packages
- SSL/TLS
- Logs
- Secrets
- Backup security

---

# 100. Access Audit

Administrative access should be reviewed periodically.

Remove unused:

- User accounts
- SSH keys
- API credentials
- Deployment credentials
- Cloud permissions

---

# 101. Server Incident Response

For a server security or availability incident:

    Detect
       ↓
    Investigate
       ↓
    Isolate
       ↓
    Recover
       ↓
    Verify
       ↓
    Monitor
       ↓
    Document

Incident response should prioritize user safety, data integrity, and service restoration.

---

# 102. Data Protection

Server architecture must protect sensitive platform data.

Potential sensitive data includes:

- User information
- Authentication data
- Student records
- Teacher records
- School records
- Payment-related information
- Private uploaded files

Only authorized services and users should access protected data.

---

# 103. Database Encryption

Encryption at rest should be considered according to the selected hosting and database infrastructure.

Sensitive data should also be protected during transmission using HTTPS and secure database connections where applicable.

---

# 104. File Encryption

Highly sensitive files may require encryption at rest.

The final implementation should be based on the sensitivity of the stored data and applicable requirements.

---

# 105. Server Secrets

Production secrets may include:

- Application keys
- Database passwords
- API keys
- Payment credentials
- Email credentials
- AI credentials
- Storage credentials
- Deployment credentials

Secrets must be stored securely.

---

# 106. No Hardcoded Secrets

The following must never be hardcoded into application source code:

- Passwords
- API keys
- Tokens
- Private keys
- Database credentials

Use environment variables or a secure secret-management system.

---

# 107. Production Error Handling

Production applications should not expose detailed internal errors to users.

Users should receive safe error messages.

Detailed technical information should remain in protected server logs.

---

# 108. Maintenance Mode

The application should support controlled maintenance mode where required.

Maintenance mode should provide users with a clear message rather than exposing server errors.

---

# 109. Deployment Checklist

Before production deployment:

- CI passed
- Tests passed
- Security checks passed
- Database migration reviewed
- Backup verified
- Environment configuration verified
- SSL verified
- Storage verified
- Queue workers verified
- Scheduler verified
- Monitoring verified
- Rollback plan ready

---

# 110. Post-Deployment Checklist

After deployment:

- Application opens
- HTTPS works
- Login works
- Dashboard works
- API works
- Database works
- Queue works
- Notifications work
- File uploads work
- Critical workflows work
- Monitoring is healthy
- Error logs are checked

---

# 111. Emergency Rollback Checklist

If a production deployment fails:

- Stop further deployment
- Assess the problem
- Check application logs
- Check server health
- Check database health
- Roll back if necessary
- Verify previous release
- Monitor system
- Document the incident

---

# 112. Server Setup and CI/CD

`SERVER_SETUP.md` works together with `CI_CD.md`.

    Git Repository
          ↓
    CI/CD Pipeline
          ↓
    Build
          ↓
    Security
          ↓
    Tests
          ↓
    Deployment
          ↓
    Server
          ↓
    Application
          ↓
    Monitoring

---

# 113. Server Setup and Mobile Applications

The server must support the mobile architecture defined in:

- `MOBILE_APP.md`
- `ANDROID_APP.md`
- `IOS_APP.md`
- `PUSH_NOTIFICATIONS.md`
- `MOBILE_API.md`

Mobile applications communicate with the backend through secure APIs.

---

# 114. API Server

The API server should provide secure endpoints for:

- Authentication
- Student services
- Teacher services
- School services
- Question Bank
- Test Engine
- Results
- Revision
- AI services
- Notifications
- Subscriptions

---

# 115. Mobile API Security

Mobile API communication must use HTTPS.

API security should include:

- Authentication
- Authorization
- Rate limiting
- Input validation
- Secure tokens
- API monitoring

---

# 116. Push Notification Server

The backend may communicate with push-notification providers.

The server should securely manage:

- Device tokens
- Notification jobs
- Provider credentials
- Notification queues
- Delivery status

---

# 117. Payment Server Security

Payment-related services require additional security.

The server must:

- Protect payment credentials
- Validate payment callbacks
- Log important payment events safely
- Prevent unauthorized payment manipulation

Payment information must not be unnecessarily stored on the application server.

---

# 118. AI Service Security

AI integrations must be handled through secure server-side services.

AI provider credentials must never be exposed to browsers or mobile applications.

Recommended:

    Mobile / Web
        ↓
    Aspirian API
        ↓
    AI Service
        ↓
    Aspirian Response

---

# 119. AI Cost Control

AI requests should be monitored and controlled.

Controls may include:

- Rate limits
- User quotas
- Request validation
- Usage tracking
- Queue processing
- Cost monitoring

---

# 120. Final Server Architecture

    ┌──────────────────────────────┐
    │           USERS              │
    │   Web / Android / iOS        │
    └──────────────┬───────────────┘
                   │
                   ▼
    ┌──────────────────────────────┐
    │        DNS / HTTPS           │
    └──────────────┬───────────────┘
                   │
                   ▼
    ┌──────────────────────────────┐
    │     FIREWALL / REVERSE       │
    │          PROXY               │
    └──────────────┬───────────────┘
                   │
                   ▼
    ┌──────────────────────────────┐
    │      ASPIRIAN APP / API      │
    └───────┬─────────┬────────────┘
            │         │
            ▼         ▼
      ┌──────────┐  ┌──────────┐
      │ DATABASE │  │  CACHE   │
      └──────────┘  └──────────┘
            │
            ▼
      ┌──────────┐
      │  QUEUE   │
      └────┬─────┘
           │
           ▼
      ┌──────────┐
      │ WORKERS  │
      └────┬─────┘
           │
     ┌─────┼───────────┐
     ▼     ▼           ▼
   EMAIL  AI       NOTIFICATIONS

           │
           ▼
      ┌──────────┐
      │ STORAGE  │
      └────┬─────┘
           │
           ▼
         CDN

           │
           ▼
      ┌──────────┐
      │ BACKUPS  │
      └──────────┘

---

# 121. Final Server Setup Principles

1. Production servers must use secure and supported operating systems.

2. Server access must be restricted to authorized personnel.

3. SSH key authentication should be preferred.

4. Root access should be restricted.

5. Firewall rules must block unnecessary public access.

6. Production traffic must use HTTPS.

7. SSL/TLS certificates must be monitored and renewed.

8. Application source code must remain separate from sensitive configuration.

9. Production secrets must never be committed to Git.

10. Database services must not be publicly exposed.

11. Application permissions must follow least privilege.

12. Production databases must be backed up regularly.

13. Backups must be tested for restoration.

14. Queue workers must be monitored.

15. Scheduled tasks must be monitored.

16. Application logs must be protected and rotated.

17. Server resources must be monitored.

18. Security updates must be applied through a controlled process.

19. Production deployments must use CI/CD where practical.

20. Production releases must support rollback.

21. Staging should closely resemble production.

22. Large media files should use dedicated storage as the platform grows.

23. CDN should be introduced when traffic requires it.

24. Server architecture should support future horizontal scaling.

25. AI services must remain server-side and protected.

26. Mobile API traffic must use secure HTTPS connections.

27. Payment-related services require additional security controls.

28. Server configuration must remain documented.

29. Administrative access should be audited periodically.

30. Disaster recovery procedures must be documented and tested.

31. The infrastructure should remain portable where practical.

32. Server optimization should be based on actual monitoring data.

33. Production errors must not expose internal system details.

34. Sensitive user and educational data must be properly protected.

35. Server architecture must remain aligned with the overall Aspirian platform architecture.

---

# 122. Final Status

**File:** `SERVER_SETUP.md`

**Phase:** K — DevOps & Deployment

**Status:** COMPLETE

**Version:** 1.0

The server architecture is now defined for:

- Production Server
- DNS
- HTTPS / SSL
- Firewall
- SSH
- Web Server
- Reverse Proxy
- Application Server
- Database
- Cache
- Queue
- Workers
- Scheduler
- Storage
- CDN
- Monitoring
- Logging
- Backups
- Disaster Recovery
- Security
- CI/CD Integration
- Mobile API
- Push Notifications
- AI Services
- Payment Services
- Future Scalability

**Server setup architecture is complete and ready for implementation.**