---
title: OpsWorks - Stack
---

## Settings
**Name** | Postmaster
| :--- | :--- |
**Region** | US East (N. Virginia)
**Default operating system** | Ubuntu 14.04 LTS
**Default root device type** | EBS backed
**Default SSH key** | No default key

## Configuration management
**Chef version** | 11.10
| :--- | :--- |
**Use custom Chef cookbooks** | Yes
Repository type | Git
Repository URL | https://github.com/RimeOfficial/opsworks-cookbooks
Repository SSH key | –
Branch/Revision | master
**Manage Berkshelf** | No


## Advanced options
**Default root device type** | EBS backed `Default`
:--- | :---
**IAM role** | aws-opsworks-service-role `Default`
**IAM instance profile** | aws-opsworks-ec2-role `Default`
**Hostname theme** | Greek Deities
**OpsWorks Agent version** | *Auto-update* Use latest version `Default`
**Custom JSON** | [blob/master/opsworks/custom.json](../blob/master/opsworks/custom.json)

> #### IAM
> **User:** `OpsWorks.postmaster`  
> **Permissions:** `AmazonS3FullAccess`, `AmazonSESFullAccess`, `AmazonSQSFullAccess`
>
> Replace `aws_account_id`, `aws_access_key`, `aws_secret_key`
> [blob/master/opsworks/custom.json#L12-L14](../blob/master/opsworks/custom.json#L12-L14)

## Security

**Use OpsWorks security groups** | Yes
| :--- | :--- |