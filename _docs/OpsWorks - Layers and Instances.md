---
title: OpsWorks - Layers and Instances
---

## Add Layer
#### OpsWorks
Layer type | PHP App Server
:--- | :---
Elastic Load Balancer | PHP-LB ([[Load Balancer]])
Instance Shutdown Behavior | Wait `Default`

#### RDS
mydbinstance ([[RDS]])

User | awsuser
:--- | :---
Password | mypassword

## Recipes
Repository URL | `https://github.com/RimeOfficial/opsworks-cookbooks`
:--- | :---
Setup     | 
Configure | 
Deploy    | `composer::install`, `phpenv::php_env_vars`, `cronjobs::default`
Undeploy  | 
Shutdown  | 

## Instances
Hostname | puff-pastry `Default`
:--- | :---
Size | t2.micro
Subnet | `Default`
Scaling type | 24/7 `Default`

Hostname | donut `Default`
:--- | :---
Size | t2.micro
Subnet | `Default`
Scaling type | Load-based
