# Postmaster

AWS email server

## Features

- [ ] List-unsubscribe
  - [ ] Autoresponders
  - [ ] Campaign
  - [x] Transcational

- [x] API Access  
 
```
  - [x] message/transactional
  - [x] list-unsubscribe/subscribe
  - [x] list-unsubscribe/unsubscribe
  - [x] list-unsubscribe/update-metadata
```

- [x] Upload attachments to S3 (`YYYYMMDD-HHMMSS_file_name.ext`)
- [x] Admin login
- [x] Auto add [`List-Unsubscribe`](http://www.list-unsubscribe.com/) headers (if body includes `{_unsubscribe_link}`)
- [x] Auto inline CSS
- [x] Minify HTML
- [x] Auto `Plain text` email
- [x] SNS, SQS - handle feedback (bounces, complaints, deliveries)
- [x] Queuing and Multiple emails sending
- [ ] Campaign Archive - `web/campaign/{message_id}`
- [x] Google Analytics (click and open)
