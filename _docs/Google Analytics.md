---
title: Google Analytics
---

### Setup instructions

First, log in to your Google Analytics account and [set up a new property](https://support.google.com/analytics/answer/1042508?hl=en):

* Select "Website", use new "Universal Analytics" tracking
* **Website name:** anything you want (e.g. GitHub projects)
* **WebSite URL: https://ga-beacon.appspot.com/**
* Click "Get Tracking ID", copy the `UA-XXXXX-X` ID on next page

Next, add a tracking image to the pages you want to track:

* _https://ga-beacon.appspot.com/UA-XXXXX-X/your-repo/page-name_
* `UA-XXXXXXXX-X` should be your tracking ID
* `your-repo/page-name` is an arbitrary path. For best results specify the repository name and the page name - e.g. if you have multiple readme's or wiki pages you can use different paths to map them to same repo: `your-repo/readme`, `your-repo/other-page`, and so on!


Replace `"ga=UA-XXXXXXXX-X"` in [blob/master/opsworks/custom.json#L17](../blob/master/opsworks/custom.json#L17)