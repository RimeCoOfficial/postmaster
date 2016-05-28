---
title: OpsWorks - Layers and Instances
---

## Add Layer

### OpsWorks

{:.table}
| Layer type | PHP App Server
| :--- | :---
| Elastic Load Balancer | PHP-LB ([Load Balancer]({{ site.baseurl }}/load-balancer))
| Instance Shutdown Behavior | Wait `Default`

### RDS
mydbinstance ([RDS]({{ site.baseurl }}/rds))

{:.table}
| User | awsuser
| :--- | :---
| Password | mypassword

## Recipes

{:.table}
| Repository URL | `https://github.com/RimeOfficial/opsworks-cookbooks`
| :--- | :---
| Setup     | 
| Configure | 
| Deploy    | `composer::install`, `phpenv::php_env_vars`, `cronjobs::default`
| Undeploy  | 
| Shutdown  | 

## Instances

{:.table}
| Hostname | puff-pastry `Default`
| :--- | :---
| Size | t2.micro
| Subnet | `Default`
| Scaling type | 24/7 `Default`

{:.table}
| Hostname | donut `Default`
| :--- | :---
| Size | t2.micro
| Subnet | `Default`
| Scaling type | Load-based
