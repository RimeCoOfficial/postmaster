A **light-weight** (*CodeIgniter*, *Twitter Bootstrap*, *SVG*) **email server** (*Campaign*, *Autoresponder* and *Transactional*) and **its free** (*Apache 2.0*, *AWS: SES, OpsWorks t2.micro, SQS, SNS, S3, RDS t2.micro, Route 53*).  
&mdash; From **[Rime](https://rime.co)**

> [![Men In Black II - Post Office Scene](https://i.imgur.com/Fi5YIvH.gif)](http://www.youtube.com/watch?v=4HgUh5bOgbM)
> 
> **Men In Black II - Post Office Scene**
> J (Will Smith) has to bring back Kevin Brown a. k. a K (Tommy Lee Jones) to the MIB. Funny Scene.
> https://youtu.be/4HgUh5bOgbM&t=3m15s

## Features

- [x] List-unsubscribe
  - [x] Autoresponders
  - [x] Campaign
  - [x] Transactional

- [x] API Access
   
```
  - [x] request/transactional/{message_id}
  - [x] recipient/subscribe/{list}
  - [x] recipient/unsubscribe/{list}
  - [x] recipient/update-metadata/{list}
  - [x] archive/get-info/{request_id}/{unsubscribe_key}
```

- [x] Upload attachments to S3 (`YYYYMMDD-HHMMSS_file_name.ext`)
- [x] Admin login
- [x] Auto add [`List-Unsubscribe`](http://www.list-unsubscribe.com/) headers (if body includes `{_unsubscribe_link}`)
- [x] Auto inline CSS
- [x] Minify HTML
- [x] Auto `Plain text` email
- [x] SNS, SQS - handle feedback (bounces, complaints, deliveries)
- [x] Queuing and Multiple emails sending
- [x] Campaign Archive - `open/campaign/{list}/{created_hash}`
- [x] Open Subscribe `open/subscribe/{list}` and Unsubscribe `open/unsubscribe/{request_id}/{unsubscribe_key}`
- [x] Google Analytics (click and open)
