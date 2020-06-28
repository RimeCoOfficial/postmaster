# Postmaster

![](./images/paris_france.jpg)

A **light-weight** (*CodeIgniter*, *Twitter Bootstrap*, *SVG*) **email server** (*Campaign*, *Autoresponder* and *Transactional*) and **its free** (*Apache 2.0*, *AWS: SES, OpsWorks t2.micro, SQS, SNS, S3, RDS t2.micro, Route 53*).

## Features

- List-unsubscribe
  - Autoresponders
  - Campaign
  - Transactional

- API Access

```
  - request/transactional/{message_id}
  - recipient/subscribe/{list}
  - recipient/unsubscribe/{list}
  - recipient/update-metadata/{list}
  - archive/get-info/{request_id}/{unsubscribe_key}
```

- Upload attachments to S3 (`YYYYMMDD-HHMMSS_file_name.ext`)
- Admin login
- Auto add [`List-Unsubscribe`](http://www.list-unsubscribe.com/) headers (if body includes `{_unsubscribe_link}`)
- Auto inline CSS
- Minify HTML
- Auto `Plain text` email
- SNS, SQS - handle feedback (bounces, complaints, deliveries)
- Queuing and Multiple emails sending
- Campaign Archive - `open/campaign/{list}/{created_hash}`
- Open Subscribe `open/subscribe/{list}` and Unsubscribe `open/unsubscribe/{request_id}/{unsubscribe_key}`
- Google Analytics (click and open)

---

[![](images/Fi5YIvH.gif)](//imgur.com/Fi5YIvH)

> J (Will Smith) has to bring back Kevin Brown a. k. a. K (Tommy Lee Jones) to the MIB. Funny Scene.  
> &mdash; [Men In Black II - Post Office Scene](//youtu.be/4HgUh5bOgbM?t=195)
