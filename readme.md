# 代理池

[![](https://img.shields.io/badge/Powered%20by-GallopYD-green.svg)](https://357.im/)
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
## 声明
本项目所有代理IP均采集于网络，请勿用于非法途径，违者后果自负！

## 环境

- PHP >= 7.1
- MySQL >= 5.7
- Laravel 5.7

## 安装

> $ git clone https://github.com/GallopYD/proxy-pool.git

> $ composer install

> $ php artisan migrate

## 配置

* crontab定时任务

> $ vim /etc/crontab

```
* * * * * root php /www/proxy-pool/artisan schedule:run >> /dev/null 2>&1
```

## 使用

* 代理质量
    * 普通[common]：检测成功次数大于1小于20
    * 稳定[stable]：检测成功次数大于20小于50
    * 优质[premium]：检测成功次数大于50

* API

| api | method | desc | args|
| :--| :-- | :-- | :--|
| /api/proxies/{quality} | GET | 获取单个代理 | quality : common/stable/premium <br>protocol : http/https<br> anonymity : transparent/anonymous/distorting/high_anonymous|
| /api/proxies/{quality}/list | GET | 获取代理列表 | 同上|