代理池
======
[![](https://img.shields.io/badge/Powered%20by-GallopYD-green.svg)](http://357.im/)
[![GitHub contributors](https://img.shields.io/github/contributors/GallopYD/proxy-pool.svg)](https://github.com/GallopYD/proxy-pool/graphs/contributors)
[![](https://img.shields.io/badge/language-PHP-blue.svg)](https://github.com/GallopYD/proxy-pool)

    ______                        ______             _
    | ___ \_                      | ___ \           | |
    | |_/ / \__ __   __  _ __   _ | |_/ /___   ___  | |
    |  __/|  _// _ \ \ \/ /| | | ||  __// _ \ / _ \ | |
    | |   | | | (_) | >  < \ |_| || |  | (_) | (_) || |___
    \_|   |_|  \___/ /_/\_\ \__  |\_|   \___/ \___/ \_____\
                           __ / /
                          /___ /
## 警告
代理IP采集于网络，请勿用于非法途径，违者后果自负！
## 安装使用
### 环境要求
- PHP >= 7.0
- PHP redis 拓展

### 安装
* 下载源码
```
git clone https://github.com/GallopYD/proxy-pool.git
```
* 项目初始化
```
composer install
php artisan migrate
```


### 使用
* 代理质量

| 质量 | 检测次数 | 连续失败次数 | 描述|
| ----| ---- | ---- | ----|
| common | checked_times < 30 | fail_times < 1 | 普通代理，检测成功次数小于30|
| stable | 30 <= checked_times < 100 | fail_times <= 3 | 稳定代理，检测成功次数大于30小于100|
| premium | checked_times >= 100 | fail_times <= 3 | 优质代理，检测成功次数大于100|


* WEB

| web | method | Description | arg|
| ----| ---- | ---- | ----|
| /{quality} | GET | 代理列表| quality=common/stable/premium|


* API

| api | method | Description | arg|
| ----| ---- | ---- | ----|
| /api/proxies/{quality} | GET | 获取单个代理 | quality=common/stable/premium|
| /api/proxies/{quality}/list | GET | 获取代理列表 | quality=common/stable/premium|