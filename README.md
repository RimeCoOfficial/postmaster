A **light-weight** (*CodeIgniter*, *Twitter Bootstrap*, *SVG*) **email server** (*Campaign*, *Autoresponder* and *Transactional*) which **includes a tweet-bot** and **its free** (*Apache 2.0*, *AWS: SES, OpsWorks t2.micro, SQS, SNS, S3, RDS t2.micro, Route 53*).  
&mdash; From **[Rime](https://rime.co)**

## Features

- [x] List-unsubscribe
  - [x] Autoresponders
  - [x] Campaign
  - [x] Transactional

- [x] API Access
   
```
  - [x] transactional/send
  - [x] list-recipient/subscribe
  - [x] list-recipient/unsubscribe
  - [x] list-recipient/update-metadata
  - [x] message-archive/get-info
```

- [x] Upload attachments to S3 (`YYYYMMDD-HHMMSS_file_name.ext`)
- [x] Admin login
- [x] Auto add [`List-Unsubscribe`](http://www.list-unsubscribe.com/) headers (if body includes `{_unsubscribe_link}`)
- [x] Auto inline CSS
- [x] Minify HTML
- [x] Auto `Plain text` email
- [x] SNS, SQS - handle feedback (bounces, complaints, deliveries)
- [x] Queuing and Multiple emails sending
- [x] Campaign Archive - `open/campaign/{list_id}/{created_hash}`
- [x] Open Subscribe `open/subscribe/{list_id}` and Unsubscribe `open/unsubscribe/{request_id}/{unsubscribe_key}`
- [x] Google Analytics (click and open)
