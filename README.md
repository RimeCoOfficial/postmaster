# Postmaster

AWS email server - A <abbr title="CodeIgniter, Twitter Bootstrap, SVG">light-weight</abbr> <abbr title="Campaign, Autoresponder and Transactional">email server</abbr> which includes a tweet-bot and its <abbr title="Apache 2.0, AWS (SES, OpsWorks, SQS, SNS, S3)">free</abbr>. &mdash; From [Rime](https://rime.co)

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
- [x] Auto add [`List-Unsubscribe`][1] headers (if body includes `{_unsubscribe_link}`)
- [x] Auto inline CSS
- [x] Minify HTML
- [x] Auto `Plain text` email
- [x] SNS, SQS - handle feedback (bounces, complaints, deliveries)
- [x] Queuing and Multiple emails sending
- [ ] Campaign Archive - `open/campaign/{list_id}`
- [x] Google Analytics (click and open)

[1]:	http://www.list-unsubscribe.com/