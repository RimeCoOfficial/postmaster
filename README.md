# Postmaster

AWS email server

## Features

- [x] List-unsubscribe
  - [x] Autoresponders
  - [x] Campaign
  - [x] Transcational

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
- [ ] Campaign Archive - `open/campaign/{list_id}`
- [x] Google Analytics (click and open)
