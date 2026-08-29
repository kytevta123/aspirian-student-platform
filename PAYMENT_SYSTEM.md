# Aspirian Student Platform — Payment System

**Version:** 1.0
**Status:** Final Payment System Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

The Payment System provides a secure and scalable financial transaction layer for Aspirian.

It manages:

```text
Payments
Orders
Invoices
Subscriptions
Plans
Transactions
Refunds
Coupons
Payment Methods
Payment Gateway Integration
Payment Status
Payment Receipts
Financial Records
```

The system is designed to support both current and future monetization models.

---

# 2. Vision

Aspirian should support free educational access while providing a reliable infrastructure for optional paid services.

```text
                         ASPIRIAN
                            ↓
                    PAYMENT SYSTEM
                            ↓
          ┌─────────────────┼─────────────────┐
          ↓                 ↓                 ↓
       PRODUCTS         SUBSCRIPTIONS      SERVICES
          ↓                 ↓                 ↓
       ORDERS            BILLING          PAYMENTS
          └─────────────────┼─────────────────┘
                            ↓
                    PAYMENT GATEWAYS
                            ↓
                     TRANSACTIONS
                            ↓
                 RECEIPTS / REPORTING
```

---

# 3. Core Principles

The payment architecture must be:

```text
Secure
Reliable
Auditable
Scalable
Gateway-Agnostic
Idempotent
Privacy-Conscious
Transparent
```

---

# 4. Free + Paid Architecture

Aspirian may contain both:

```text
Free Features
Paid Features
Freemium Features
School Plans
Premium Subscriptions
One-Time Purchases
```

Payment infrastructure must never make core free educational resources accidentally inaccessible.

---

# 5. Payment Components

Main components:

```text
Payment Gateway
Payment Service
Order Service
Subscription Service
Invoice Service
Refund Service
Coupon Service
Receipt Service
Webhook Service
Payment Reporting
```

---

# 6. Payment Flow

Standard payment:

```text
User
 ↓
Select Product / Plan
 ↓
Create Order
 ↓
Create Payment
 ↓
Payment Gateway
 ↓
Customer Authentication
 ↓
Gateway Result
 ↓
Webhook / Verification
 ↓
Payment Confirmation
 ↓
Order Completion
 ↓
Entitlement Activation
 ↓
Receipt
```

---

# 7. Order vs Payment

Orders and payments must remain separate concepts.

```text
Order
 ↓
Payment Attempt 1
 ↓
Failed

Payment Attempt 2
 ↓
Successful
```

One order may therefore have multiple payment attempts.

---

# 8. Order

An order represents what the customer intends to purchase.

Possible fields:

```text
Order ID
Customer
Items
Subtotal
Discount
Tax Where Applicable
Total
Currency
Status
Created At
```

---

# 9. Order Status

Recommended:

```text
Draft
Pending Payment
Paid
Partially Refunded
Refunded
Cancelled
Expired
Failed
```

---

# 10. Payment

A payment represents a financial payment attempt or confirmed transaction.

Possible fields:

```text
Payment ID
Order ID
Gateway
Gateway Transaction ID
Amount
Currency
Status
Payment Method
Created At
Completed At
```

---

# 11. Payment Status

Recommended:

```text
Pending
Processing
Authorized
Succeeded
Failed
Cancelled
Refunded
Partially Refunded
```

---

# 12. Payment Attempts

Each payment attempt must receive a unique internal ID.

---

# 13. Idempotency

Payment creation must support idempotency.

If the same request is submitted twice, the system must not accidentally charge the customer twice.

---

# 14. Idempotency Key

Payment requests should use a unique idempotency key where supported.

Example:

```text
IDEMP-2026-000001
```

---

# 15. Currency

The platform should support configurable currencies.

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

# 16. Currency Storage

Money values should not rely on floating-point arithmetic.

Use integer minor units where appropriate.

Example:

```text
PKR 1,500
```

should be represented according to the application's money-storage convention.

---

# 17. Product Catalog

Payment products may include:

```text
Premium Plan
Student Subscription
School Subscription
Exam Package
Premium Test
Digital Course
Certificate
Additional AI Credits
```

Only approved products may be sold.

---

# 18. Product

A product should contain:

```text
Product ID
Name
Description
Type
Price
Currency
Status
Tax Configuration
Availability
```

---

# 19. Product Status

```text
Draft
Active
Paused
Archived
```

---

# 20. Pricing

Pricing should support:

```text
One-Time Price
Recurring Price
Introductory Price
Discounted Price
School Price
```

---

# 21. One-Time Purchase

Example:

```text
Premium Exam Package
PKR 500
```

Customer pays once and receives the defined entitlement.

---

# 22. Subscription

Subscriptions may include:

```text
Monthly
Quarterly
Yearly
```

where applicable.

---

# 23. Subscription Lifecycle

```text
Trial
 ↓
Active
 ↓
Renewing
 ↓
Past Due
 ↓
Cancelled / Expired
```

---

# 24. Subscription Status

Recommended:

```text
Trialing
Active
Past Due
Paused
Cancelled
Expired
```

---

# 25. Subscription Renewal

Recurring billing must create a new billing event/payment attempt for each renewal.

---

# 26. Failed Renewal

If renewal fails:

```text
Payment Failed
 ↓
Retry Policy
 ↓
Customer Notification
 ↓
Grace Period
 ↓
Subscription Restriction / Cancellation
```

---

# 27. Grace Period

Paid access may remain available during a configurable grace period after a failed renewal.

---

# 28. Cancellation

Users may cancel eligible subscriptions.

Cancellation rules must clearly define:

```text
Immediate Cancellation
End-of-Period Cancellation
```

---

# 29. Subscription Reactivation

Eligible cancelled subscriptions may be reactivated according to plan rules.

---

# 30. Billing Cycle

Each subscription should store:

```text
Start Date
Current Period Start
Current Period End
Next Billing Date
```

---

# 31. Plan

A plan defines a recurring package.

Example:

```text
Aspirian Premium Student
```

may include:

```text
AI Tutor
Advanced Tests
Revision Features
Premium Content
```

---

# 32. Entitlements

Payment should activate entitlements rather than directly modifying unrelated application tables.

```text
Payment
 ↓
Order
 ↓
Entitlement
 ↓
Feature Access
```

---

# 33. Entitlement Example

```text
Premium AI Tutor
```

may be activated for:

```text
User X
```

until:

```text
2026-09-30
```

---

# 34. Entitlement Types

Possible:

```text
Feature Access
Content Access
Course Access
Exam Access
AI Credits
Download Credits
Certificate Access
```

---

# 35. Entitlement Expiration

Entitlements may be:

```text
Permanent
Time-Limited
Subscription-Based
Usage-Based
```

---

# 36. Usage-Based Credits

Future services may use credit systems.

Example:

```text
AI Credits
Video Generation Credits
Practice Credits
```

---

# 37. Credit Ledger

Credits should be tracked through a ledger rather than only storing a mutable balance.

```text
Credit Added
Credit Used
Credit Refunded
Credit Expired
```

---

# 38. Payment Gateway

The system should use an abstraction layer:

```text
Aspirian Payment Service
          ↓
    Gateway Adapter
          ↓
   Selected Gateway
```

This prevents the application from becoming dependent on one provider.

---

# 39. Gateway Adapter

Each gateway adapter should implement a common interface.

Conceptual operations:

```text
Create Payment
Authorize
Capture
Refund
Verify
Handle Webhook
```

---

# 40. Pakistan Gateway Support

The architecture should allow integration with appropriate Pakistan-supported payment providers.

Examples may include:

```text
Bank / Card Processing
Mobile Wallets
Local Payment Gateways
```

Specific providers should be selected based on current commercial availability, API quality, fees, compliance requirements and business needs.

---

# 41. International Payments

Future international payment gateways may be integrated without changing the core payment model.

---

# 42. Card Payments

Where supported, card payments should use gateway-hosted or tokenized payment flows.

Aspirian should avoid storing raw card numbers.

---

# 43. Card Data

The platform must not store:

```text
Full Card Number
CVV
Sensitive Authentication Data
```

unless explicitly permitted under applicable payment-security requirements and handled by a compliant payment processor.

Prefer gateway tokenization.

---

# 44. Mobile Wallets

Where supported:

```text
Mobile Wallet
 ↓
Gateway
 ↓
Payment
 ↓
Aspirian
```

---

# 45. Bank Transfer

Future support may include manual or automated bank-transfer reconciliation.

Possible status:

```text
Pending Verification
Verified
Rejected
```

---

# 46. Cash Payments

If schools support offline collection, payment records may be manually entered by authorized staff.

Such payments require strong audit trails.

---

# 47. Manual Payment

Manual payments should record:

```text
Payment Method
Amount
Reference
Collected By
Date
Verification Status
```

---

# 48. Payment Verification

Offline/manual payments must not activate paid entitlements until authorized verification is completed.

---

# 49. Webhooks

Payment gateways commonly notify Aspirian through webhooks.

```text
Gateway
 ↓
Webhook
 ↓
Webhook Verification
 ↓
Payment Service
 ↓
Order / Subscription Update
```

---

# 50. Webhook Security

Webhooks must be:

```text
Authenticated
Verified
Idempotent
Logged
Replay-Protected Where Possible
```

---

# 51. Webhook Events

Possible events:

```text
payment.created
payment.processing
payment.succeeded
payment.failed
payment.refunded
subscription.created
subscription.renewed
subscription.cancelled
```

Actual event names depend on the gateway.

---

# 52. Webhook Replay

Repeated webhook delivery must not create duplicate orders, payments or entitlements.

---

# 53. Payment Verification

Never rely solely on frontend success messages.

The server must verify the payment using:

```text
Gateway Response
Webhook
Gateway API Verification
```

as appropriate.

---

# 54. Frontend Payment Flow

```text
User
 ↓
Checkout
 ↓
Gateway Checkout
 ↓
Payment
 ↓
Return to Aspirian
 ↓
Server Verification
 ↓
Final Status
```

---

# 55. Checkout

Checkout should display:

```text
Product
Quantity
Subtotal
Discount
Tax Where Applicable
Total
Currency
Payment Method
Terms
```

---

# 56. Price Integrity

The backend must calculate the final amount.

Never trust the price submitted by the browser.

---

# 57. Checkout Security

Checkout must validate:

```text
Product
Price
Currency
Availability
Discount
Customer
Order
```

---

# 58. Order Expiration

Unpaid orders may expire after a configurable period.

---

# 59. Duplicate Orders

The system should prevent accidental duplicate order creation where possible.

---

# 60. Coupons

The system may support promotional coupons.

---

# 61. Coupon Fields

```text
Coupon Code
Discount Type
Discount Value
Start Date
End Date
Usage Limit
Per User Limit
Product Scope
Plan Scope
Status
```

---

# 62. Discount Types

```text
Percentage
Fixed Amount
```

---

# 63. Coupon Validation

Validate:

```text
Expiration
Usage Limit
User Eligibility
Product Eligibility
Minimum Purchase
```

---

# 64. Coupon Abuse Protection

Prevent:

```text
Repeated Unlimited Use
Self-Generated Codes
Unauthorized Discounts
```

---

# 65. Refunds

Authorized staff may issue refunds according to business rules and gateway capabilities.

---

# 66. Refund Types

```text
Full Refund
Partial Refund
```

---

# 67. Refund Flow

```text
Refund Request
 ↓
Permission Check
 ↓
Eligibility Check
 ↓
Gateway Refund
 ↓
Verification
 ↓
Order Update
 ↓
Entitlement Update
 ↓
Receipt / Notification
```

---

# 68. Refund Status

```text
Requested
Processing
Succeeded
Failed
Rejected
```

---

# 69. Partial Refund

Partial refunds must store:

```text
Original Amount
Refunded Amount
Remaining Amount
```

---

# 70. Refund Entitlements

If a refund invalidates paid access, the corresponding entitlement must be updated according to product policy.

---

# 71. Refund Audit

Every refund must be auditable.

---

# 72. Invoice

The system may generate invoices for eligible transactions.

Invoice fields:

```text
Invoice ID
Invoice Number
Customer
Items
Subtotal
Discount
Tax
Total
Currency
Payment Status
Issue Date
Due Date Where Applicable
```

---

# 73. Invoice Number

Invoice numbers should be unique.

Example:

```text
INV-2026-000001
```

---

# 74. Receipt

Successful payments may generate receipts.

Receipt should contain:

```text
Receipt Number
Order Number
Payment Reference
Customer
Items
Amount
Currency
Payment Date
Status
```

---

# 75. Downloadable Receipt

Authorized customers should be able to access their own receipts.

---

# 76. Invoice PDF

Where required, invoices may be generated as PDF documents.

---

# 77. Tax

The payment system should support configurable tax rules.

Tax implementation must follow the applicable legal and business requirements.

---

# 78. Tax Calculation

Tax should be calculated server-side.

---

# 79. Tax Records

Where required, store:

```text
Tax Rate
Tax Amount
Tax Type
Tax Jurisdiction
```

---

# 80. Billing Address

If required for invoicing, collect:

```text
Name
Address
City
Country
```

Only collect information necessary for the transaction.

---

# 81. Customer

A customer may be:

```text
Student
Parent
Teacher
School
Organization
```

depending on the product.

---

# 82. Parent-Paid Student Subscription

A parent may purchase access for a linked student.

```text
Parent
 ↓
Purchase
 ↓
Student Entitlement
```

Authorization must verify the relationship.

---

# 83. School Purchase

Schools may purchase subscriptions or packages for students/teachers.

```text
School
 ↓
Order
 ↓
Payment
 ↓
School Entitlements
 ↓
Users
```

---

# 84. Bulk School Purchase

Future support may include bulk licensing.

Example:

```text
500 Student Licenses
```

---

# 85. License Assignment

Purchased licenses may be assigned to authorized school users.

---

# 86. License Pool

A school may have:

```text
Purchased Licenses
Assigned Licenses
Available Licenses
Expired Licenses
```

---

# 87. License Reassignment

Authorized school administrators may reassign eligible licenses.

---

# 88. Subscription Ownership

Subscriptions should clearly identify:

```text
Purchaser
Beneficiary
Organization
```

where these differ.

---

# 89. Payment Reporting

Payment reports may include:

```text
Total Revenue
Successful Payments
Failed Payments
Refunds
Subscriptions
Orders
Average Order Value
```

---

# 90. Financial Dashboard

Authorized administrators may see:

```text
Revenue
Transactions
Refunds
Active Subscriptions
Failed Payments
Pending Payments
```

---

# 91. Revenue Definition

Revenue metrics must clearly distinguish:

```text
Gross Payments
Discounts
Refunds
Taxes
Net Amount
```

---

# 92. Transaction Report

Transaction reports may contain:

```text
Transaction ID
Order ID
Customer
Amount
Currency
Gateway
Status
Date
```

---

# 93. Payment Gateway Report

Compare:

```text
Gateway
Transactions
Success Rate
Failed Payments
Refunds
Processing Fees Where Available
```

---

# 94. Payment Failure Report

Track:

```text
Failed Payments
Failure Category
Gateway
Date
Retry Result
```

Avoid exposing sensitive gateway data unnecessarily.

---

# 95. Subscription Report

Show:

```text
Active
Trialing
Past Due
Cancelled
Expired
```

---

# 96. Churn

Subscription analytics may calculate churn according to a documented business definition.

---

# 97. Payment Success Rate

Example:

```text
Successful Payment Attempts
-------------------------------- × 100
Total Payment Attempts
```

---

# 98. Financial Reconciliation

The platform should support reconciliation between:

```text
Aspirian Transactions
        ↕
Gateway Transactions
        ↕
Bank / Settlement Records
```

---

# 99. Reconciliation Status

```text
Matched
Unmatched
Partial
Pending
Exception
```

---

# 100. Reconciliation Exceptions

Possible reasons:

```text
Missing Transaction
Amount Mismatch
Duplicate Transaction
Refund Mismatch
Settlement Delay
```

---

# 101. Settlement

Gateway settlement records may be imported or synchronized where supported.

---

# 102. Gateway Fees

If gateway fee data is available, store separately from customer payment amount.

```text
Customer Payment
Gateway Fee
Net Settlement
```

---

# 103. Financial Ledger

A future accounting integration may maintain a proper double-entry ledger.

The payment system should remain compatible with that architecture.

---

# 104. Accounting Integration

Potential integration:

```text
Payment
 ↓
Financial Transaction
 ↓
Accounting System
```

---

# 105. Payment Data Model

Core entities:

```text
User
Customer
Product
Plan
Price
Order
OrderItem
Payment
PaymentAttempt
Subscription
Invoice
Refund
Coupon
Entitlement
WebhookEvent
Gateway
```

---

# 106. Relationships

```text
Customer
   ↓
Order
   ↓
Order Items
   ↓
Payment Attempts
   ↓
Payment
   ↓
Entitlement
```

---

# 107. Subscription Relationships

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

# 108. Payment Security

Payment operations must follow strong security practices.

---

# 109. PCI Considerations

Where card payments are offered, the architecture should minimize Aspirian's handling of cardholder data by using compliant payment processors and hosted/tokenized payment flows.

---

# 110. Secret Management

Gateway secrets must never be stored in source code.

Use:

```text
Environment Variables
Secret Manager
Encrypted Configuration
```

---

# 111. API Security

Payment APIs require:

```text
Authentication
Authorization
Validation
Rate Limiting
Audit Logging
```

---

# 112. Admin Payment Permissions

Recommended permissions:

```text
payments.view
payments.create
payments.refund
payments.verify
payments.reconcile
payments.export
subscriptions.view
subscriptions.manage
```

---

# 113. Financial Data Access

Financial reports must only be available to authorized roles.

---

# 114. School Financial Isolation

School administrators should only access their organization's financial records.

---

# 115. Platform Financial Access

Platform financial data should remain restricted to authorized platform roles.

---

# 116. Student Payment Privacy

Students should not automatically see private payment information belonging to parents or schools.

---

# 117. Parent Payment Privacy

Parents should only see transactions they are authorized to view.

---

# 118. Audit Logs

Record:

```text
Order Created
Payment Created
Payment Verified
Payment Failed
Refund Created
Refund Completed
Subscription Changed
Coupon Applied
Manual Payment Verified
```

---

# 119. Payment Event Log

Store important gateway events for troubleshooting and reconciliation.

---

# 120. Retry Policy

Network or gateway failures may trigger controlled retries.

Never retry blindly when doing so could create duplicate charges.

---

# 121. Timeout Handling

Payment requests must have safe timeout behavior.

A timeout does not automatically mean the payment failed.

---

# 122. Unknown Payment State

If the payment result is uncertain:

```text
Payment → Pending Verification
```

Then verify through the gateway.

---

# 123. Double-Charge Protection

Use:

```text
Idempotency
Unique Transaction References
Webhook Deduplication
Server Verification
```

---

# 124. Fraud Monitoring

Future payment security may monitor:

```text
Unusual Transaction Frequency
Repeated Failed Payments
Suspicious Accounts
Abnormal Refund Patterns
```

---

# 125. Risk Controls

High-risk transactions may require additional verification.

---

# 126. Account Restrictions

Payment abuse may result in temporary transaction restrictions without necessarily deleting the user's educational account.

---

# 127. Notifications

Payment events may trigger:

```text
Payment Successful
Payment Failed
Subscription Renewed
Subscription Expiring
Refund Completed
Invoice Generated
```

---

# 128. Email Notifications

Transactional payment emails may include:

```text
Receipt
Invoice
Payment Confirmation
Refund Confirmation
Subscription Reminder
```

---

# 129. User Payment History

Users may access their authorized payment history.

```text
Orders
Payments
Invoices
Receipts
Subscriptions
Refunds
```

---

# 130. Billing Portal

A future billing portal may provide:

```text
Current Plan
Payment History
Invoices
Receipts
Payment Methods
Subscription Management
```

---

# 131. Payment Method Management

Where gateway-supported, customers may manage tokenized payment methods.

Aspirian should not store raw card credentials.

---

# 132. Default Payment Method

A customer may have a default tokenized payment method for recurring billing where supported.

---

# 133. Failed Payment Recovery

The system may notify users to update payment methods after failures.

---

# 134. Subscription Expiration

Before expiration:

```text
Reminder
 ↓
Renewal Attempt
 ↓
Success / Failure
```

---

# 135. Expired Subscription

When subscription access ends:

```text
Subscription → Expired
Entitlement → Expired
Premium Features → Restricted
```

Core free features remain available.

---

# 136. Upgrade

Users may upgrade eligible plans.

---

# 137. Downgrade

Users may downgrade according to billing rules.

---

# 138. Proration

Future subscription plans may support prorated billing.

If enabled, proration rules must be clearly defined.

---

# 139. Trial

Plans may optionally offer trials.

Trial rules must define:

```text
Duration
Eligible Users
Payment Requirement
Conversion
Cancellation
```

---

# 140. Trial Abuse Protection

The system may restrict repeated trials for the same customer where appropriate.

---

# 141. Promotional Campaigns

Payment system may support campaigns such as:

```text
Back to School
Annual Discount
New Student Offer
School Partnership
```

---

# 142. Coupon Audit

Discount creation and usage should be auditable.

---

# 143. Product Availability

Products may be restricted by:

```text
Country
School
Class
User Type
Subscription
```

where business rules require.

---

# 144. Age Considerations

Because Aspirian serves minors, paid services involving students must use age-appropriate account and payment flows.

Where required, purchases should be handled by a parent/guardian or authorized school/organization.

---

# 145. Child Account Protection

The payment system should not assume that a student account is automatically authorized to make purchases.

---

# 146. Parent Authorization

Where applicable:

```text
Student
 ↓
Purchase Request
 ↓
Parent / Authorized Adult
 ↓
Payment
 ↓
Entitlement
```

---

# 147. School Authorization

School purchases may require an authorized school administrator.

---

# 148. Payment UI

Checkout should be:

```text
Simple
Clear
Accessible
Mobile-Friendly
Transparent
```

---

# 149. Price Transparency

Before payment, clearly show:

```text
Product
Price
Discount
Tax
Total
Currency
Billing Frequency
```

---

# 150. Terms

Customers should see relevant:

```text
Terms
Refund Policy
Subscription Conditions
```

before completing payment.

---

# 151. Failed Checkout

The system should provide clear next steps without exposing sensitive gateway information.

---

# 152. Payment Success

After successful verification:

```text
Payment Successful
Order Confirmed
Entitlement Activated
Receipt Available
```

---

# 153. Payment Pending

Show:

```text
Payment is being verified.
```

Do not immediately grant irreversible access until verification is complete.

---

# 154. Payment Failure

Show:

```text
Payment could not be completed.
```

Offer safe retry options.

---

# 155. Payment Receipt

Receipt should be accessible from:

```text
Account
 ↓
Billing
 ↓
Orders
 ↓
Receipt
```

---

# 156. Admin Payment Dashboard

Recommended navigation:

```text
Payments

├── Overview
├── Orders
├── Transactions
├── Subscriptions
├── Refunds
├── Invoices
├── Coupons
├── Entitlements
├── Gateways
├── Reconciliation
├── Reports
└── Audit Logs
```

---

# 157. Customer Billing Navigation

```text
Billing

├── My Orders
├── Payments
├── Subscriptions
├── Invoices
├── Receipts
└── Payment Methods
```

---

# 158. School Billing Navigation

```text
School Billing

├── Plans
├── Licenses
├── Orders
├── Payments
├── Invoices
├── Renewals
└── Reports
```

---

# 159. Payment API

Conceptual endpoints:

```text
/api/v1/products
/api/v1/plans
/api/v1/orders
/api/v1/orders/{id}
/api/v1/payments
/api/v1/payments/{id}
/api/v1/subscriptions
/api/v1/refunds
/api/v1/invoices
/api/v1/coupons
/api/v1/entitlements
/api/v1/webhooks/{gateway}
```

---

# 160. API Rules

All payment APIs must:

```text
Validate Input
Authorize User
Validate Price
Use Idempotency
Log Important Events
Protect Sensitive Data
```

---

# 161. Webhook API

Webhook endpoints should:

```text
Verify Signature
Validate Payload
Check Event ID
Process Idempotently
Record Event
Return Appropriate Response
```

---

# 162. Database Integrity

Payment records should use:

```text
Foreign Keys
Unique Constraints
Indexes
Transactions
Status Validation
```

where appropriate.

---

# 163. Database Transactions

Critical operations should use database transactions.

Example:

```text
Payment Verified
 ↓
Order Updated
 ↓
Entitlement Created
 ↓
Audit Recorded
```

These related changes should be handled atomically where practical.

---

# 164. Concurrency Protection

Prevent multiple workers from activating the same entitlement or processing the same payment event twice.

---

# 165. Payment Monitoring

Monitor:

```text
Payment Success Rate
Gateway Errors
Webhook Failures
Refund Failures
Reconciliation Exceptions
```

---

# 166. Operational Alerts

Administrators may receive alerts for:

```text
Gateway Outage
High Payment Failure Rate
Webhook Failure
Settlement Mismatch
```

---

# 167. Gateway Failover

Future architecture may support multiple gateways.

```text
Primary Gateway
      ↓
Failure
      ↓
Secondary Gateway
```

Failover rules must avoid duplicate charging.

---

# 168. Gateway Configuration

Each gateway should have configurable:

```text
Name
Currency Support
Country Support
Credentials
Webhook Configuration
Status
```

Secrets must remain securely stored.

---

# 169. Sandbox Mode

Payment integrations must support sandbox/test environments where provided by the gateway.

---

# 170. Production Mode

Production credentials must be isolated from development and testing credentials.

---

# 171. Environment Separation

```text
Development
 ↓
Testing / Staging
 ↓
Production
```

Payment data and credentials must remain appropriately separated.

---

# 172. Testing

Payment tests should cover:

```text
Successful Payment
Failed Payment
Timeout
Duplicate Request
Duplicate Webhook
Refund
Partial Refund
Subscription Renewal
Failed Renewal
Cancellation
Coupon
Tax
```

---

# 173. Test Payments

Never use real customer payment data in automated tests.

---

# 174. Recovery Testing

Test:

```text
Gateway Failure
Database Failure
Webhook Delay
Duplicate Webhook
Network Timeout
```

---

# 175. Disaster Recovery

Payment records must be backed up according to financial-data retention requirements.

---

# 176. Financial Integrity

Payment records should never be silently overwritten.

Corrections should be represented as new events or adjustment records where appropriate.

---

# 177. Immutable Transaction History

Important financial transaction records should be treated as append-oriented historical records.

---

# 178. Data Retention

Define retention rules for:

```text
Orders
Payments
Invoices
Refunds
Webhooks
Audit Logs
```

according to legal, accounting and business requirements.

---

# 179. Data Export

Authorized financial administrators may export payment reports.

---

# 180. Data Privacy

Payment reporting should expose only necessary personal information.

---

# 181. Final Payment Architecture

```text
                           CUSTOMER
                              ↓
                           CHECKOUT
                              ↓
                            ORDER
                              ↓
                       PAYMENT SERVICE
                              ↓
                       GATEWAY ADAPTER
                              ↓
                       PAYMENT GATEWAY
                              ↓
                    WEBHOOK / VERIFICATION
                              ↓
                         TRANSACTION
                              ↓
                ┌─────────────┴─────────────┐
                ↓                           ↓
             ORDER                      PAYMENT
                ↓                           ↓
                └─────────────┬─────────────┘
                              ↓
                         ENTITLEMENT
                              ↓
                       PREMIUM ACCESS
                              ↓
                 RECEIPT / NOTIFICATION
                              ↓
                       REPORTING / AUDIT
```

---

# 182. Complete Payment Ecosystem

```text
                     ASPIRIAN PLATFORM
                            ↓
                     PAYMENT SYSTEM
                            ↓
       ┌───────────┬────────┼────────┬───────────┐
       ↓           ↓        ↓        ↓           ↓
    Products    Orders   Payments  Billing   Subscriptions
       ↓           ↓        ↓        ↓           ↓
       └───────────┴────────┼────────┴───────────┘
                            ↓
                     PAYMENT GATEWAYS
                            ↓
                       TRANSACTIONS
                            ↓
              ┌─────────────┼─────────────┐
              ↓             ↓             ↓
           Receipts      Refunds       Entitlements
              ↓             ↓             ↓
              └─────────────┼─────────────┘
                            ↓
                       REPORTING
                            ↓
                         AUDIT
```

---

# 183. Future Expansion

Future versions may include:

```text
Multiple Payment Gateways
International Billing
School Licensing
Enterprise Billing
Usage-Based Billing
AI Credit Marketplace
Gift Cards
Wallet System
Advanced Fraud Detection
Automated Reconciliation
Accounting Integration
Revenue Recognition
Advanced Tax Engine
```

These are future extensions and do not alter the current core architecture.

---

# 184. Final Design Principles

```text
1. Secure Payments
2. No Duplicate Charges
3. Server-Side Verification
4. Gateway Independence
5. Clear Billing
6. Strong Auditability
7. Privacy Protection
8. Parent / School Authorization
9. Reliable Entitlement Management
10. Scalable Financial Architecture
```

---

# 185. Final Rule

> **The Aspirian Payment System must provide a secure, reliable, auditable and gateway-independent financial infrastructure that supports one-time purchases, subscriptions, school licensing and future monetization while protecting users, preventing duplicate charges and maintaining clear separation between payments, orders, entitlements and educational access.**

---

# 186. Document Status

**File:** `PAYMENT_SYSTEM.md`
**Version:** 1.0
**Status:** Final Payment System Blueprint
**Phase:** H
**Module:** H1 — Payment System
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Payment System architecture for the Aspirian Student Platform.
