---
title: API
---

```shell
curl -X POST -i http://postmaster.example.com/api/message/request-transactional -d \
"key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
&message_id=1\
&to_name=nemo\
&to_email=nemo@example.com\
&pseudo_vars[foo]=bar"
```

```shell
curl -X POST -i http://postmaster.example.com/api/list-unsubscribe/subscribe/test -d \
  "key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
  &to_name=nemo\
  &to_email=nemo@example.com\
  &custom_id=\
  &metadata[username]=nemo\
  &metadata[location]=IN\
  &unsubscribed=1000-00-00 00:00:00\
  &subscribed=20XX-XX-XX XX-XX-XX\
  &updated=20XX-XX-XX XX-XX-XX"
```