---
title: RDS
---

## EC2 Security Group

{:.table}
| Security group name | rds
| :--- | :---
| Description | rds
| VPC | * denotes default VPC `Default`

#### Inbound

{:.table}
| Type | Protocol |Port Range | Source
| --- | --- | --- | --- | ---
| MYSQL/Aurora | TCP | 3306 | sg-XXXXXXXX (AWS-OpsWorks-PHP-App-Server)
| MYSQL/Aurora | TCP | 3306 | sg-XXXXXXXX (AWS-OpsWorks-nodejs-App-Server)

#### Outbound `Default`

{:.table}
| Type | Protocol |Port Range | Source
| --- | --- | --- | --- | ---
| All traffic | All | All | 0.0.0.0/0

---

## Parameter Group

{:.table}
| Parameter Group Family | mysql5.7  
| :--- | :---
| Name | basic-pg
| Description | basic pg

### Parameters Comparison

{:.table}
| Parameter | basic-pg | default
| :--- | :--- | :---
| slow_query_log | 1 | &lt;engine-default&gt;
| innodb_autoinc_lock_mode | 0 | &lt;engine-default&gt;

---

## Instance

### DB Details

#### Instance Specifications

{:.table}
| DB Engine | mysql
| :--- | :---
| License Model | General Public License
| DB Engine Version | 5.7.10
| DB Instance Class | db.t2.micro
| Multi-AZ Deployment | No
| Storage Type | General Purpose (SSD) `Default`
| Allocated Storage* | 10 GB

#### Settings

{:.table}
| DB Instance Identifier* | mydbinstance
| :--- | :---
| Master Username* | awsuser
| Master Password* | mypassword

### Advanced Settings

#### Network & Security

{:.table}
| VPC* | Default VPC `Default`
| :--- | :---
| Subnet Group | default `Default`
| Publicly Accessible | Yes `Default`
| Availability Zone | No Preference `Default`
| VPC Security Group(s) | RDS

#### Database Options

{:.table}
| Database Name | ci_postmaster
| :--- | :---
| Database Port | 3306 `Default`
| DB Parameter Group | basic-pg
| Option Group | default.mysql5.7 `Default`

#### Backup
`Default`

#### Maintenance
`Default`

---

## Config
Update `db_hostname` in [blob/master/opsworks/custom.json#L9](https://github.com/{{ site.github.username }}{{ site.baseurl }}/blob/master/opsworks/custom.json#L9)

---

{:.table}
| DB Engine | mysql
| :--- | :---
| DB Instance Class | db.t2.micro
