# Aspirian Student Platform — Subscription System

**Version:** 1.0
**Status:** Final Subscription System Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

The Subscription System manages recurring paid access across the Aspirian Student Platform.

It provides infrastructure for:

```text
Subscription Plans
Recurring Billing
Trials
Plan Upgrades
Plan Downgrades
Renewals
Cancellations
Grace Periods
Failed Payments
Entitlements
School Subscriptions
Student Subscriptions
Parent-Paid Subscriptions
Subscription History
Subscription Reporting
```

---

# 2. Vision

The Subscription System must provide flexible recurring access while keeping the platform's free educational resources available.

```text
                         ASPIRIAN
                            ↓
                    SUBSCRIPTION SYSTEM
                            ↓
          ┌─────────────────┼─────────────────┐
          ↓                 ↓                 ↓
        PLANS             BILLING         ENTITLEMENTS
          ↓                 ↓                 ↓
       CUSTOMER         PAYMENTS          ACCESS
          └─────────────────┼─────────────────┘
                            ↓
                     PREMIUM FEATURES
```

---

# 3. Core Principles

The subscription architecture must be:

```text
Secure
Reliable
Transparent
Flexible
Auditable
Scalable
Gateway-Independent
Permission-Controlled
```

---

# 4. Subscription Models

Aspirian may support:

```text
Individual Student Subscription
Parent-Paid Student Subscription
Teacher Subscription
School Subscription
Organization Subscription
```

Only applicable models should be enabled for each product.

---

# 5. Billing Models

Supported billing models may include:

```text
Monthly
Quarterly
Yearly
Custom Recurring Period
```

---

# 6. Subscription Lifecycle

```text
Trial
 ↓
Active
 ↓
Renewal
 ↓
Active
 ↓
Cancellation Requested
 ↓
Period Ends
 ↓
Expired
```

Alternative failure path:

```text
Active
 ↓
Renewal Payment Failed
 ↓
Past Due
 ↓
Grace Period
 ↓
Recovered
       OR
 ↓
Expired
```

---

# 7. Subscription Plan

A plan defines the recurring commercial package.

Example:

```text
Aspirian Premium Student
```

A plan may include:

```text
AI Tutor
Advanced Tests
Advanced Revision
Premium Learning Content
Premium Practice
```

---

# 8. Plan Fields

Conceptually:

```text
Plan ID
Name
Description
Billing Interval
Price
Currency
Trial Duration
Status
Features
Eligibility
Created At
Updated At
```

---

# 9. Plan Status

Recommended:

```text
Draft
Active
Paused
Archived
```

---

# 10. Plan Versioning

Plans should support versioning or immutable pricing references where required.

Changing a price should not silently alter an already-created historical billing record.

---

# 11. Subscription Record

A subscription should contain:

```text
Subscription ID
Customer ID
Beneficiary ID
Plan ID
Status
Currency
Price
Billing Interval
Start Date
Current Period Start
Current Period End
Next Billing Date
Cancellation Date
Created At
Updated At
```

---

# 12. Customer

The subscription customer may be:

```text
Student
Parent
Teacher
School
Organization
```

---

# 13. Beneficiary

The beneficiary is the user receiving the subscription entitlement.

This is important when:

```text
Parent → Student
School → Student
School → Teacher
```

---

# 14. Subscription Ownership

The system must distinguish:

```text
Purchaser
Subscription Owner
Beneficiary
Organization
```

where these are different entities.

---

# 15. Individual Student Subscription

Example:

```text
Student
 ↓
Select Premium
 ↓
Payment
 ↓
Subscription
 ↓
Premium Entitlement
```

---

# 16. Parent-Paid Subscription

Example:

```text
Parent
 ↓
Select Child
 ↓
Select Plan
 ↓
Payment
 ↓
Subscription
 ↓
Child Entitlement
```

The parent must be authorized to purchase access for the linked student.

---

# 17. School Subscription

Example:

```text
School
 ↓
Select School Plan
 ↓
Payment
 ↓
Subscription
 ↓
License Pool
 ↓
Students / Teachers
```

---

# 18. School License Subscription

A school plan may contain:

```text
100 Student Licenses
20 Teacher Licenses
```

The subscription controls the available license pool.

---

# 19. License Allocation

School administrators may assign eligible licenses to authorized users.

---

# 20. License Reassignment

Unused or eligible licenses may be reassigned according to school policy.

---

# 21. Subscription Entitlements

Subscription access should be represented through entitlements.

```text
Subscription
 ↓
Entitlement
 ↓
Feature Access
```

---

# 22. Entitlement Examples

```text
Premium AI Tutor
Advanced Question Bank
Premium Tests
Premium Revision
Premium Content
```

---

# 23. Entitlement Duration

Subscription entitlements normally remain valid for the active subscription period.

---

# 24. Subscription Period

Each subscription period should clearly define:

```text
Period Start
Period End
```

---

# 25. Billing Cycle

Example:

```text
Monthly Subscription
Start: 1 September
Next Billing: 1 October
Period End: 30 September
```

Actual date calculation rules must be deterministic.

---

# 26. Calendar Billing

For monthly/yearly billing, handle months with different numbers of days safely.

---

# 27. Renewal

Normal renewal:

```text
Current Period Ends
 ↓
Create Renewal Billing Event
 ↓
Payment Attempt
 ↓
Successful
 ↓
New Period
 ↓
Entitlement Continues
```

---

# 28. Renewal Payment

Renewal payments are handled through the Payment System.

Reference:

```text
PAYMENT_SYSTEM.md
```

---

# 29. Failed Renewal

```text
Renewal Due
 ↓
Payment Failed
 ↓
Subscription → Past Due
 ↓
Retry Policy
 ↓
Payment Recovered
```

---

# 30. Grace Period

A configurable grace period may allow temporary continued access after a failed renewal.

Example:

```text
Payment Failed
 ↓
Grace Period: 3 Days
 ↓
Retry
```

The actual duration should be configurable.

---

# 31. Grace Period Rules

During grace period:

```text
Subscription = Past Due
Entitlement = Temporarily Active
```

where business policy allows.

---

# 32. Expiration

If payment is not recovered:

```text
Past Due
 ↓
Grace Period Ends
 ↓
Subscription → Expired
 ↓
Entitlement → Expired
```

---

# 33. Free Access After Expiration

Expiration of a premium subscription must not delete the user's account.

Free platform functionality remains available.

---

# 34. Trial

Plans may optionally provide a free trial.

---

# 35. Trial Fields

```text
Trial Duration
Trial Start
Trial End
Trial Eligibility
Payment Requirement
```

---

# 36. Trial Lifecycle

```text
Trial
 ↓
Trial Ending
 ↓
Payment
 ↓
Active
```

or:

```text
Trial
 ↓
Cancelled
 ↓
Expired
```

---

# 37. Trial Eligibility

The system may restrict multiple trials for the same customer or beneficiary.

---

# 38. Trial Abuse Protection

Possible controls:

```text
Account Eligibility
Previous Trial History
Previous Subscription History
Verified Parent / School Relationship
```

---

# 39. Trial Conversion

If payment is required:

```text
Trial Ending
 ↓
Payment Attempt
 ↓
Successful
 ↓
Active Subscription
```

---

# 40. Subscription Cancellation

Users may cancel eligible subscriptions.

---

# 41. Cancellation Types

```text
Immediate
End of Current Billing Period
```

---

# 42. End-of-Period Cancellation

Recommended default for recurring plans:

```text
Cancel Requested
 ↓
Subscription remains Active
 ↓
Current Period Ends
 ↓
Subscription Expired
```

---

# 43. Immediate Cancellation

If enabled:

```text
Cancel
 ↓
Subscription Ends
 ↓
Entitlement Updated
```

Refund rules must be separately defined.

---

# 44. Cancellation Reason

Optional cancellation reasons may include:

```text
Too Expensive
Not Using
Technical Issues
No Longer Needed
Other
```

---

# 45. Cancellation History

Store:

```text
Requested At
Requested By
Effective Date
Reason
```

where appropriate.

---

# 46. Reactivation

A cancelled subscription may be reactivated if:

```text
Current Period Has Not Ended
Plan Still Available
Customer Eligible
```

---

# 47. Upgrade

Users may upgrade to a higher plan.

```text
Basic
 ↓
Premium
```

---

# 48. Upgrade Flow

```text
Current Plan
 ↓
Select New Plan
 ↓
Calculate Price Difference
 ↓
Payment / Proration
 ↓
New Plan
 ↓
New Entitlements
```

---

# 49. Downgrade

Users may downgrade according to plan rules.

```text
Premium
 ↓
Basic
```

---

# 50. Downgrade Timing

A downgrade may take effect:

```text
Immediately
```

or preferably:

```text
At End of Current Billing Period
```

depending on the business policy.

---

# 51. Proration

Subscription changes may support proration.

Proration must have clearly defined rules.

---

# 52. Proration Example

If a user upgrades halfway through a billing period:

```text
Unused Basic Value
+
Remaining Premium Cost
=
Prorated Adjustment
```

The exact calculation must be handled server-side.

---

# 53. Price Changes

Future plan price changes should not silently alter existing billing periods.

---

# 54. Existing Subscribers

A price increase may require:

```text
Advance Notice
Customer Consent Where Required
Next-Cycle Price Update
```

depending on applicable law and business policy.

---

# 55. Currency

Subscriptions should store their billing currency.

Initial deployment may use:

```text
PKR
```

Future support may include:

```text
USD
GBP
EUR
AED
SAR
```

---

# 56. Subscription Price

The price must be stored with the subscription or immutable price reference so historical billing remains accurate.

---

# 57. Payment Method

Recurring payments may use a gateway-supported tokenized payment method.

Aspirian should not store raw card credentials.

---

# 58. Default Payment Method

Customers may have a default tokenized payment method for recurring billing where supported.

---

# 59. Payment Failure

When renewal fails:

```text
Subscription
    ↓
Past Due
```

The system must not immediately assume permanent cancellation.

---

# 60. Retry Strategy

A configurable retry policy may include:

```text
Retry 1
Retry 2
Retry 3
```

Actual timing depends on the gateway and business policy.

---

# 61. Smart Retry

Future versions may adjust retry timing based on gateway recommendations or payment history.

---

# 62. Payment Recovery

If payment succeeds during the retry period:

```text
Past Due
 ↓
Payment Successful
 ↓
Active
 ↓
Billing Period Updated
```

---

# 63. Payment Verification

Subscription activation and renewal must rely on server-side payment verification.

Frontend success messages alone are insufficient.

---

# 64. Webhooks

Gateway webhooks may update subscription billing state.

Possible events:

```text
Payment Succeeded
Payment Failed
Subscription Renewed
Subscription Cancelled
Refund Completed
```

Actual event names depend on the gateway.

---

# 65. Webhook Idempotency

Duplicate webhook delivery must not create:

```text
Duplicate Billing
Duplicate Renewal
Duplicate Entitlement
```

---

# 66. Subscription Event Log

Important lifecycle events should be recorded.

Examples:

```text
Subscription Created
Trial Started
Trial Converted
Renewal Started
Renewal Succeeded
Renewal Failed
Plan Changed
Cancellation Requested
Cancellation Completed
Subscription Expired
```

---

# 67. Subscription History

Users and authorized administrators should be able to view appropriate subscription history.

---

# 68. Subscription Timeline

Example:

```text
01 Sep → Subscription Created
01 Sep → Trial Started
08 Sep → Trial Converted
08 Oct → Renewed
08 Nov → Renewed
20 Nov → Cancellation Requested
08 Dec → Subscription Expired
```

---

# 69. Subscription Status

Recommended statuses:

```text
Trialing
Active
Past Due
Paused
Cancellation Pending
Cancelled
Expired
```

---

# 70. Status Transitions

```text
Trialing → Active
Trialing → Cancelled
Trialing → Expired

Active → Past Due
Active → Cancellation Pending
Active → Cancelled
Active → Expired

Past Due → Active
Past Due → Expired

Cancellation Pending → Active
Cancellation Pending → Expired
```

Invalid transitions must be rejected.

---

# 71. Paused Subscription

Future plans may support pausing.

Pause rules must define:

```text
Maximum Pause Duration
Billing Behavior
Entitlement Behavior
Resume Date
```

---

# 72. Resume

A paused subscription may resume according to its configured rules.

---

# 73. Multiple Subscriptions

The platform must define whether one beneficiary may have:

```text
One Active Subscription
```

or:

```text
Multiple Concurrent Subscriptions
```

Recommended default:

> One active subscription per subscription family/entitlement category.

---

# 74. Subscription Conflicts

If two plans grant overlapping entitlements, the system must have deterministic rules.

---

# 75. Entitlement Priority

Possible hierarchy:

```text
School License
      ↓
Individual Subscription
      ↓
Free Access
```

The exact business priority must be configurable.

---

# 76. School + Individual Subscription

If a student receives premium access through a school and also purchases an individual subscription, the system should avoid unnecessary duplicate entitlement conflicts.

---

# 77. School Subscription Expiration

When a school subscription expires:

```text
School Entitlements
 ↓
Expire / Restrict
 ↓
Student Free Access Continues
```

An individual's separate subscription, if any, should remain unaffected.

---

# 78. Parent Subscription Expiration

If a parent-paid student subscription expires:

```text
Premium Access → Expired
Student Account → Remains Active
Free Features → Remain Available
```

---

# 79. Subscription Access Check

Application services should check entitlement status rather than directly checking payment records.

```text
Feature Request
 ↓
Authorization
 ↓
Entitlement Check
 ↓
Allow / Deny
```

---

# 80. Feature Gating

Premium features may be protected through feature entitlements.

Example:

```text
AI Tutor
 ↓
premium_ai_tutor
 ↓
Entitlement Check
```

---

# 81. Subscription Limits

Plans may define usage limits.

Example:

```text
AI Requests / Month
Practice Tests / Month
Video Access
Storage
```

---

# 82. Usage Tracking

Usage-based limits should be tracked separately from subscription status.

---

# 83. Usage Reset

Monthly usage limits may reset at the start of each billing period.

---

# 84. Usage Carryover

If enabled, unused credits may carry over.

This must be explicitly defined per plan.

---

# 85. Subscription Benefits

Each plan should clearly define:

```text
Features
Limits
Duration
Price
Renewal
Cancellation
```

---

# 86. Plan Comparison

Users should be able to compare plans.

Example:

```text
                    Free    Basic    Premium
AI Tutor             —       ✓         ✓
Advanced Tests       —       ✓         ✓
AI Revision          —       —         ✓
Premium Content      —       —         ✓
```

---

# 87. Plan Eligibility

Plans may be restricted by:

```text
User Type
Country
School
Age / Account Type
Academic Level
Organization
```

Only implement restrictions that are necessary and appropriate.

---

# 88. Student Age Considerations

Aspirian serves minors.

Subscription purchases should therefore support parent/guardian or authorized school purchasing flows where required.

---

# 89. Student Purchase Protection

A student account should not automatically be treated as authorized to make purchases.

---

# 90. Parent Authorization

Parent-paid subscription flow:

```text
Parent
 ↓
Linked Student
 ↓
Plan
 ↓
Checkout
 ↓
Payment
 ↓
Subscription
 ↓
Student Entitlement
```

---

# 91. School Authorization

School subscriptions should require authorized school personnel.

---

# 92. Organization Subscription

Future organizations may purchase subscriptions for groups of users.

---

# 93. Seat-Based Subscription

School/organization plans may use:

```text
Purchased Seats
Assigned Seats
Available Seats
```

---

# 94. Seat Limits

A subscription must not allow assignment beyond purchased capacity.

---

# 95. Seat Release

When a user is removed from a school license:

```text
Assigned Seat
 ↓
Released
 ↓
Available Seat
```

---

# 96. Seat Audit

Assignment and release events should be logged.

---

# 97. Subscription Billing Portal

A customer billing portal may provide:

```text
Current Plan
Billing Cycle
Next Billing Date
Payment Method
Invoices
Receipts
Subscription History
Cancel
Upgrade
Downgrade
```

---

# 98. Parent Billing Portal

Parents should be able to manage subscriptions they purchased for linked students.

---

# 99. School Billing Portal

School administrators may manage:

```text
School Plan
Seats
Renewal
Invoices
Payments
Licenses
```

---

# 100. Subscription Notifications

Important events should trigger appropriate notifications.

```text
Trial Ending
Renewal Upcoming
Payment Successful
Payment Failed
Subscription Past Due
Subscription Expiring
Subscription Cancelled
Subscription Expired
```

---

# 101. Notification Timing

Examples:

```text
7 Days Before Renewal
3 Days Before Renewal
Payment Failure
Before Grace Period Ends
```

Actual timing should be configurable.

---

# 102. Email

Transactional subscription emails may include:

```text
Welcome
Trial Started
Trial Ending
Renewal Confirmation
Payment Failure
Cancellation Confirmation
Expiration
```

---

# 103. In-App Notifications

Important subscription events may also appear inside the application.

---

# 104. Notification Privacy

Notifications must not expose sensitive billing details to unauthorized users.

---

# 105. Subscription Reporting

Authorized reports may include:

```text
Active Subscriptions
New Subscriptions
Cancelled Subscriptions
Expired Subscriptions
Trial Users
Renewals
Failed Renewals
```

---

# 106. Subscription Analytics

Track:

```text
New Subscribers
Active Subscribers
Renewal Rate
Cancellation Rate
Churn
Trial Conversion
```

---

# 107. Monthly Recurring Revenue

Where applicable:

```text
MRR
```

may be calculated from active recurring subscriptions using a documented methodology.

---

# 108. Annual Recurring Revenue

Where applicable:

```text
ARR
```

may be calculated from recurring subscription commitments.

---

# 109. Revenue Definitions

Subscription analytics should distinguish:

```text
Gross Billing
Discounts
Refunds
Taxes
Net Revenue
```

---

# 110. Churn Definition

The system must document exactly how churn is calculated.

---

# 111. Trial Conversion

Example:

```text
Trials Converted to Paid
------------------------- × 100
Eligible Completed Trials
```

---

# 112. Renewal Rate

Example:

```text
Successful Renewals
-------------------- × 100
Renewal Opportunities
```

The exact business definition must remain consistent.

---

# 113. Failed Renewal Report

Show:

```text
Subscription
Customer
Plan
Failure Date
Gateway
Recovery Status
```

Access should be permission-controlled.

---

# 114. Cancellation Report

Show:

```text
Plan
Customer Type
Cancellation Date
Reason Where Available
Subscription Duration
```

---

# 115. Subscription Cohorts

Future analytics may compare cohorts based on:

```text
Signup Month
Plan
School
Acquisition Source
```

---

# 116. Subscription Data Model

Core entities:

```text
Customer
Beneficiary
Plan
Price
Subscription
SubscriptionItem
BillingPeriod
SubscriptionEvent
Entitlement
UsageRecord
Payment
Invoice
Refund
```

---

# 117. Relationships

```text
Customer
   ↓
Subscription
   ↓
Plan
   ↓
Billing Period
   ↓
Payment
   ↓
Entitlement
```

---

# 118. Parent Relationship

```text
Parent
   ↓
Subscription
   ↓
Student
   ↓
Entitlement
```

---

# 119. School Relationship

```text
School
   ↓
Subscription
   ↓
License Pool
   ↓
Students / Teachers
```

---

# 120. Database Requirements

Use appropriate:

```text
Foreign Keys
Unique Constraints
Indexes
Transactions
Status Constraints
```

---

# 121. Unique Subscription Rules

Prevent duplicate active subscriptions where business rules require only one active subscription.

---

# 122. Subscription Transactions

Critical lifecycle changes should use database transactions.

Example:

```text
Renewal Payment Verified
 ↓
Billing Period Updated
 ↓
Subscription Updated
 ↓
Entitlement Extended
 ↓
Event Recorded
```

---

# 123. Concurrency

Concurrent renewal workers must not extend the same subscription twice.

---

# 124. Idempotency

Subscription lifecycle operations must be idempotent where possible.

---

# 125. Webhook Deduplication

Store gateway event IDs and reject duplicate processing.

---

# 126. Payment Integration

Subscription billing must use:

```text
PAYMENT_SYSTEM.md
```

rather than implementing separate payment logic.

---

# 127. Payment Failure Integration

Subscription status should react to verified payment events.

---

# 128. Refund Integration

Refunds may change subscription or entitlement status according to defined refund policy.

---

# 129. Coupon Integration

Subscriptions may support:

```text
Discount Codes
Promotional Pricing
Introductory Offers
```

through the Payment System.

---

# 130. Tax Integration

Subscription invoices should support applicable tax calculations.

---

# 131. Security

Subscription APIs must enforce:

```text
Authentication
Authorization
Tenant Isolation
Input Validation
Rate Limiting
Audit Logging
```

---

# 132. Subscription Permissions

Recommended permissions:

```text
subscriptions.view
subscriptions.create
subscriptions.update
subscriptions.cancel
subscriptions.pause
subscriptions.resume
subscriptions.export
subscriptions.admin
```

---

# 133. School Permissions

Recommended:

```text
school_subscriptions.view
school_subscriptions.manage
school_licenses.assign
school_licenses.revoke
school_billing.view
```

---

# 134. Customer Permissions

Customers may:

```text
View Own Subscription
Cancel Own Subscription
View Own Billing
```

subject to product rules.

---

# 135. Parent Permissions

Parents may manage subscriptions they own for linked students.

---

# 136. Student Permissions

Students may view their own resulting entitlement/subscription status but should not automatically access a parent's private billing information.

---

# 137. Audit Logs

Track:

```text
Subscription Created
Plan Changed
Renewal Processed
Payment Failed
Cancellation Requested
Cancellation Completed
Subscription Paused
Subscription Resumed
Seat Assigned
Seat Released
```

---

# 138. Administrative Audit

Admin actions affecting subscriptions must identify:

```text
Actor
Action
Target
Timestamp
Reason Where Required
```

---

# 139. Subscription Security

Never expose:

```text
Payment Secrets
Gateway Credentials
Raw Card Data
Private Customer Billing Data
```

---

# 140. Data Privacy

Only collect and expose information required for subscription management.

---

# 141. Data Retention

Define retention policies for:

```text
Subscriptions
Billing Events
Invoices
Payments
Cancellation Records
Audit Logs
```

---

# 142. Historical Integrity

Historical subscription periods must remain reproducible.

---

# 143. Subscription Snapshot

At billing time, retain the applicable:

```text
Plan
Price
Currency
Billing Interval
Discount
Tax
```

so historical invoices remain accurate.

---

# 144. Timezone

Subscription billing calculations should use a clearly defined system timezone strategy.

---

# 145. Date Handling

Store timestamps consistently, preferably in UTC internally, while presenting dates in the user's relevant timezone.

---

# 146. Leap Year / Month-End Handling

Annual and monthly subscriptions must safely handle:

```text
February
Leap Years
Month-End Dates
Timezone Transitions
```

---

# 147. Subscription API

Conceptual endpoints:

```text
/api/v1/plans
/api/v1/plans/{id}
/api/v1/subscriptions
/api/v1/subscriptions/{id}
/api/v1/subscriptions/{id}/cancel
/api/v1/subscriptions/{id}/resume
/api/v1/subscriptions/{id}/upgrade
/api/v1/subscriptions/{id}/downgrade
/api/v1/subscriptions/{id}/billing
/api/v1/subscriptions/{id}/events
```

---

# 148. API Authorization

Every request must verify:

```text
Authentication
Role
Permission
Customer Ownership
Organization Scope
```

---

# 149. API Validation

Validate:

```text
Plan
Price
Currency
Eligibility
Status
Billing Period
```

on the server.

---

# 150. Subscription API Rate Limits

Subscription-management endpoints should have appropriate rate limits to prevent abuse.

---

# 151. Background Jobs

Recurring billing should be handled through reliable background workers.

```text
Billing Scheduler
 ↓
Find Due Subscriptions
 ↓
Create Payment Attempt
 ↓
Gateway
 ↓
Process Result
 ↓
Update Subscription
```

---

# 152. Billing Scheduler

The scheduler must safely handle:

```text
Due Subscriptions
Overdue Subscriptions
Retry Attempts
Trial Expiration
Cancellation Expiration
```

---

# 153. Job Idempotency

If a billing job runs twice, it must not create duplicate charges.

---

# 154. Monitoring

Monitor:

```text
Renewal Success
Renewal Failure
Billing Queue
Webhook Processing
Subscription Expiration
Entitlement Sync
```

---

# 155. Operational Alerts

Possible alerts:

```text
High Renewal Failure Rate
Billing Queue Failure
Webhook Processing Failure
Unexpected Subscription State
Entitlement Mismatch
```

---

# 156. Reconciliation

Subscription records should be reconcilable against:

```text
Payment Records
Gateway Records
Invoices
Entitlements
```

---

# 157. Subscription Reconciliation

Detect mismatches such as:

```text
Paid but Subscription Inactive
Active Subscription but Missing Payment
Active Subscription but Missing Entitlement
Duplicate Renewal
```

---

# 158. Recovery

Authorized administrators may repair inconsistent states through controlled tools.

All repairs must be audited.

---

# 159. Testing

Subscription tests must cover:

```text
Trial Start
Trial Conversion
Successful Renewal
Failed Renewal
Retry
Grace Period
Expiration
Cancellation
Reactivation
Upgrade
Downgrade
Proration
Coupon
Refund
School License
Parent Subscription
Duplicate Webhook
Duplicate Billing Job
```

---

# 160. Sandbox Testing

Use gateway sandbox/test environments where available.

Never use real customer payment information in automated tests.

---

# 161. Disaster Recovery

Subscription and billing data must be backed up appropriately.

---

# 162. Backup Integrity

Regularly verify that subscription data can be restored.

---

# 163. Subscription Dashboard

Recommended customer dashboard:

```text
My Subscription

Plan
Status
Billing Cycle
Current Period
Next Billing Date
Features
Payment Method
Invoices
Manage Subscription
```

---

# 164. Student Dashboard

Students may see:

```text
Premium Status
Available Features
Subscription Expiry
```

without exposing another person's private payment details.

---

# 165. Parent Dashboard

Parents may see:

```text
Child
Plan
Status
Renewal
Billing
Invoices
```

for subscriptions they own.

---

# 166. School Dashboard

Schools may see:

```text
School Plan
Seats
Assigned Users
Available Seats
Renewal
Billing
```

---

# 167. Admin Dashboard

Platform administrators may see:

```text
Subscriptions
Plans
Renewals
Cancellations
Trials
Failed Payments
Revenue
```

according to role permissions.

---

# 168. Plan Management

Admins may:

```text
Create Plan
Edit Plan
Pause Plan
Archive Plan
Create Price
```

Historical billing records must remain unchanged.

---

# 169. Plan Deactivation

When a plan is archived:

```text
New Subscriptions → Disabled
Existing Subscriptions → Continue
```

unless business policy explicitly says otherwise.

---

# 170. Subscription Migration

Future migrations may move users from:

```text
Old Plan
 ↓
New Plan
```

with controlled entitlement and billing changes.

---

# 171. Migration Audit

All subscription migrations must be logged.

---

# 172. Subscription Import

Authorized administrators may import school subscriptions/licenses where required.

Imported records must be validated and audited.

---

# 173. Manual Subscription

Admins may create manual subscriptions only when business rules require it.

Manual subscriptions must record:

```text
Created By
Reason
Start Date
End Date
Plan
Beneficiary
```

---

# 174. Manual Subscription Security

Manual subscription creation must require elevated permission.

---

# 175. Complimentary Subscription

The platform may issue complimentary access.

Example:

```text
Scholarship
Partnership
Promotional Access
Teacher / Staff Benefit
```

Such subscriptions must be clearly marked.

---

# 176. Complimentary Subscription Audit

Record:

```text
Issued By
Reason
Duration
Beneficiary
```

---

# 177. Scholarship Access

Future scholarship programs may provide premium access without direct payment.

The subscription model should support this through controlled entitlements rather than fake payment transactions.

---

# 178. Subscription Source

Track source such as:

```text
Paid
Trial
School
Parent
Promotion
Scholarship
Admin
```

---

# 179. Subscription Analytics Dimensions

Reports may segment by:

```text
Plan
User Type
School
Country
Billing Cycle
Acquisition Source
Subscription Source
```

subject to privacy rules.

---

# 180. Business Metrics

Possible metrics:

```text
Active Subscribers
New Subscribers
Renewals
Churn
Trial Conversion
Average Subscription Duration
MRR
ARR
```

---

# 181. Final Subscription Architecture

```text
                         CUSTOMER
                            ↓
                         PLAN
                            ↓
                       CHECKOUT
                            ↓
                          ORDER
                            ↓
                         PAYMENT
                            ↓
                      SUBSCRIPTION
                            ↓
                    BILLING PERIOD
                            ↓
                       ENTITLEMENT
                            ↓
                     PREMIUM ACCESS
                            ↓
                 RENEWAL / CANCELLATION
                            ↓
                    REPORTING / AUDIT
```

---

# 182. School Subscription Architecture

```text
                         SCHOOL
                            ↓
                          PLAN
                            ↓
                        PAYMENT
                            ↓
                     SUBSCRIPTION
                            ↓
                      LICENSE POOL
                            ↓
               ┌────────────┴────────────┐
               ↓                         ↓
            STUDENTS                  TEACHERS
               ↓                         ↓
          ENTITLEMENTS              ENTITLEMENTS
```

---

# 183. Parent Subscription Architecture

```text
                         PARENT
                            ↓
                     LINKED STUDENT
                            ↓
                           PLAN
                            ↓
                         PAYMENT
                            ↓
                      SUBSCRIPTION
                            ↓
                       ENTITLEMENT
                            ↓
                     STUDENT ACCESS
```

---

# 184. Renewal Architecture

```text
                    BILLING SCHEDULER
                            ↓
                    DUE SUBSCRIPTION
                            ↓
                     PAYMENT ATTEMPT
                            ↓
                  ┌─────────┴─────────┐
                  ↓                   ↓
              SUCCESS               FAILURE
                  ↓                   ↓
              RENEWED              PAST DUE
                  ↓                   ↓
            NEW PERIOD             RETRY
                                      ↓
                             ┌────────┴────────┐
                             ↓                 ↓
                         RECOVERED          EXPIRED
                             ↓                 ↓
                          ACTIVE          ENTITLEMENT ENDS
```

---

# 185. Final Subscription Ecosystem

```text
                    ASPIRIAN PLATFORM
                           ↓
                  SUBSCRIPTION SYSTEM
                           ↓
       ┌───────────┬───────┼───────┬───────────┐
       ↓           ↓       ↓       ↓           ↓
      Plans      Trials  Billing  Seats     Entitlements
       ↓           ↓       ↓       ↓           ↓
       └───────────┴───────┼───────┴───────────┘
                           ↓
                     PAYMENT SYSTEM
                           ↓
                      GATEWAYS
                           ↓
                     TRANSACTIONS
                           ↓
              ┌────────────┼────────────┐
              ↓            ↓            ↓
           Renewals    Refunds      Invoices
              ↓            ↓            ↓
              └────────────┼────────────┘
                           ↓
                    REPORTING / AUDIT
```

---

# 186. Future Expansion

Future versions may include:

```text
Family Plans
Gift Subscriptions
Student Bundles
School Enterprise Plans
Regional Pricing
Multi-Currency Billing
Usage-Based Subscriptions
AI Credit Subscriptions
Annual Contracts
Seat-Based Enterprise Billing
Advanced Proration
Automated Dunning
Revenue Recognition
Advanced Subscription Analytics
```

These are future extensions and do not change the current core architecture.

---

# 187. Final Design Principles

```text
1. Subscription Separate From Payment
2. Subscription Separate From Entitlement
3. Server-Side Billing
4. Idempotent Renewals
5. Reliable Webhooks
6. Clear Cancellation Rules
7. Safe Failed-Payment Handling
8. Parent / School Authorization
9. Historical Billing Integrity
10. Strong Auditability
11. Free Access Must Remain Available
12. Scalable Multi-Tenant Architecture
```

---

# 188. Final Rule

> **The Aspirian Subscription System must provide a secure, transparent and scalable recurring-access framework that connects plans, billing, payments and entitlements while supporting students, parents, schools and organizations without compromising free educational access, payment integrity, privacy or auditability.**

---

# 189. Document Status

**File:** `SUBSCRIPTIONS.md`
**Version:** 1.0
**Status:** Final Subscription System Blueprint
**Phase:** H
**Module:** H2 — Subscriptions
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Subscription System architecture for the Aspirian Student Platform.
