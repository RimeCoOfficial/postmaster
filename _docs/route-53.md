---
title: Route 53
---

## Hosted Zone `postmaster`

{:.table}
| Domain Name | Type | Record Set Count | Comment | Hosted Zone ID
| ----------- | ---- | ---------------- | ------- | --------------
| postmaster.example.com. | Public | 8 | |

# Record Set

## `A` Alias

{:.table}
| Name | Type | Value
| ---- | ---- | -----
| postmaster.example.com. | A | dualstack.php-lb-XXXXXXXXXX.us-east-1.elb.amazonaws.com. [LB]({{ site.baseurl }}/load-balancer#route-53)


## `NS` Nameserver

{:.table}
| Name | Type | Value
| ---- | ---- | -----
| postmaster.rime.co. | NS | ns-1111.awsdns-11.co.uk. <br> ns-2222.awsdns-22.org. <br> ns-333.awsdns-33.com. <br> ns-444.awsdns-44.net. `Default`

## `SOA` Default

{:.table}
| Name | Type | Value
| ---- | ---- | -----
| postmaster.example.com. | SOA | ns-1111.awsdns-11.co.uk. awsdns-hostmaster.amazon.com. 1 7200 900 1209600 86400 `Default`

## `CNAME` Subdomain

{:.table}
| Name | Type | Value
| ---- | ---- | -----
| dkim_xxxxx-11111._domainkey.example.com. | CNAME | example.com [SES]({{ site.baseurl }}/ses#route-53---records)
| dkim_xxxxx-22222._domainkey.example.com. | CNAME | example.com [SES]({{ site.baseurl }}/ses#route-53---records)
| dkim_xxxxx-33333._domainkey.example.com. | CNAME | example.com [SES]({{ site.baseurl }}/ses#route-53---records)

## `TXT`

{:.table}
| Name | Type | Value
| ---- | ---- | -----
| _amazonses.rime.co | TXT | "ses_key-XXXXXXX" [SES]({{ site.baseurl }}/ses#route-53---records)
| rime.co. | TXT | "v=spf1 a mx include:amazonses.com ~all" [SPF]({{ site.baseurl }}/ses#domain-spf)
