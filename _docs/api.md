---
title: API
---

```shell
curl -X POST -i http://example.email/api/request/transactional -d \
"key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
&message_id=1\
&to_name=nemo\
&to_email=nemo@example.com\
&pseudo_vars[foo]=bar"
```

```shell
curl -X POST -i http://example.email/api/recipient/subscribe/test -d \
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

```
request/transactional/{message_id}
recipient/subscribe/{list}
recipient/unsubscribe/{list}
recipient/update-metadata/{list}
archive/get-info/{request_id}/{unsubscribe_key}
```