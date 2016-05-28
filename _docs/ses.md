---
title: SES
---

## Domains

### Verify a New Domain
**Domain:** example.com  

- [x] Generate DKIM Settings

#### Route 53 - Records

{:.table .table-responsive}
| Name | Type | Value
| ---- | ---- | -----
| example.com | MX | 10 inbound-smtp.us-east-1.amazonaws.com
| _amazonses.example.com. | TXT | "XXXXX"
| XXXXX._domainkey.example.com. | CNAME | XXXXX.dkim.amazonses.com
| XXXXX._domainkey.example.com. | CNAME | XXXXX.dkim.amazonses.com
| XXXXX._domainkey.example.com. | CNAME | XXXXX.dkim.amazonses.com

## Email Addresses

### Verify a new Email Address
**Email Address:** postmaster@example.com

### Notifications
- SNS Topic Configuration: notifications [SNS, SQS]({{ site.baseurl }}/sns-sqs)
- Email Feedback Forwarding: Disable

#### DKIM
Enable

## Domain SPF

{:.table}
| Name | Type | Value
| ---- | ---- | -----
| example.com. | TXT | "<Value>v=spf1 a mx include:amazonses.com ~all</Value>"
