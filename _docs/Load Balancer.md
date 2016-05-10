---
title: Load Balancer
---

## Step 1: Configuration

Load Balancer name: | PHP-LB
:--- | :---
Create LB Inside: | My Default VPC `Default`

## Step 2: Security Groups
**Assign a security group:** Select an existing security group

Security Group ID | Name | Description
--- | --- | ---
sg-XXXXXXXX | default | AWS-OpsWorks-LB-Server | AWS OpsWorks load balancer - do not change or delete

## Step 3: Security Settings
`Default`

## Step 4: Health Check
Ping Protocol | TCP
:--- | :---
Ping Port | 80

# Route 53
Name: | postmaster.rime.co.  
:--- | :---
Type: | A  - IPv4 address
Alias: |Yes
Alias Target: | -- *Elastic Load Balancers* -- PHP-LB

Name | Type | Value
---- | ---- | -----
postmaster.example.com | A | ALIAS dualstack.php-lb-XXXXXXXXXX.us-east-1.elb.amazonaws.com.
