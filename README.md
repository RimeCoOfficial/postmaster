# Postmaster

AWS email server

## Features

- [ ] List-unsubscribe
  - [ ] Autoresponders
  - [ ] Campaign
  - [x] Transcational

- [ ] API Access  
 
```
  - [x] message/transactional
  - [x] list-unsubscribe/subscribe
  - [x] list-unsubscribe/unsubscribe
  - [ ] list-unsubscribe/update
  - [ ] list-unsubscribe/delete
```

- [x] Upload attachments to S3 (`YYYYMMDD-HHMMSS_file_name.ext`)
- [x] Admin login
- [x] Auto add [`List-Unsubscribe`](http://www.list-unsubscribe.com/) headers
- [x] Auto inline CSS
- [x] Minify HTML
- [x] Auto `Plain text` email
- [x] SNS, SQS - handle feedback (bounces, complaints, deliveries)
- [x] Queuing and Multiple emails sending
- [ ] Campaign Archive - `web/campaign/{message_id}`
- [x] Google Analytics (click and open)
