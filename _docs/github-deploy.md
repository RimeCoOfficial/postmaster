---
title: GitHub Deploy
---

## IAM
**User:** `GitHub.postmaster`

### Inline Policies
**Name:** `OpsWorks.CreateDeployment`  
**Document:**

```json
{
  "Statement": [
    {
      "Effect": "Allow",
      "Action": "opsworks:CreateDeployment",
      "Resource": "*"
    },
    {
      "Effect": "Allow",
      "Action": "opsworks:UpdateApp",
      "Resource": "*"
    }
  ]
}
```

## GitHub - repo/settings/hooks `AWS OpsWorks`

{:.table}
| App | [OpsWorks - App]({{ site.baseurl }}/opsworks-app) **OpsWorks ID**
| :--- | :--- 
| Stack | [OpsWorks - stack]({{ site.baseurl }}/opsworks-stack) **OpsWorks ID**
| Branch name | master
| GitHub api url | |
| Aws access key | XXXXXXXXXXXXXXXXXXXX
| Aws secret access key | ∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗
| GitHub token | |

- [x] Active