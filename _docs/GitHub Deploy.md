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
App | [[OpsWorks: app]] **OpsWorks ID**
:--- | :--- 
Stack | [[OpsWorks: stack]] **OpsWorks ID**
Branch name | master
GitHub api url | |
Aws access key | XXXXXXXXXXXXXXXXXXXX
Aws secret access key | ∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗
GitHub token | |

- [x] Active