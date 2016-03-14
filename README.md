A **light-weight** (*CodeIgniter*, *Twitter Bootstrap*, *SVG*) **email server** (*Campaign*, *Autoresponder* and *Transactional*) and **its free** (*Apache 2.0*, *AWS: SES, OpsWorks t2.micro, SQS, SNS, S3, RDS t2.micro, Route 53*).  
&mdash; From **[Rime](https://rime.co)**

<blockquote class="imgur-embed-pub" lang="en" data-id="Fi5YIvH"><a href="//imgur.com/Fi5YIvH">J (Will Smith) has to bring back Kevin Brown a. k. a K (Tommy Lee Jones) to the MIB. Funny Scene.&lt;a class=&quot;youtube-link-no-embed&quot; target=&quot;_blank&quot; href=&quot;https://www.youtube.com/watch?v=4HgUh5bOgbM&amp;amp;t=3m15s&quot;&gt;https://www.youtube.com/watch?v=4HgUh5bOgbM&amp;amp;t=3m15s&lt;/a&gt;</a></blockquote>
<script async src="//s.imgur.com/min/embed.js" charset="utf-8"></script>

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
