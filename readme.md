# 代理池

### 获取单个代理
```shell
curl HOST/api/proxies/{quality}
```
```json
{
  "data": {
    "id": 2766,
    "ip": "113.200.214.164",
    "port": "9999",
    "protocol": "https",
    "anonymity": "high_anonymous",
    "quality": "premium",
    "speed": "634",
    "used_times": 1,
    "succeed_times": "69",
    "last_checked_at": "2018-12-14 09:58:04",
    "created_at": "2018-12-13 23:03:50",
    "updated_at": "2018-12-14 10:35:28"
  }
}
```

### 获取代理列表
```shell
curl HOST/api/proxies/{quality}/list
```
```json
{
  "data": [{
    "id": 2766,
    "ip": "113.200.214.164",
    "port": "9999",
    "anonymity": "high_anonymous",
    "protocol": "https",
    "speed": "634",
    "used_times": "0",
    "succeed_times": "69",
    "last_checked_at": "2018-12-14 09:58:04",
    "created_at": "2018-12-13 23:03:50",
    "updated_at": "2018-12-14 09:58:04"
  },
  {
    "id": 2598,
    "ip": "39.137.69.7",
    "port": "8080",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "279",
    "used_times": "0",
    "succeed_times": "139",
    "last_checked_at": "2018-12-14 09:47:03",
    "created_at": "2018-12-13 08:04:08",
    "updated_at": "2018-12-14 09:47:03"
  },
  {
    "id": 1522,
    "ip": "117.191.11.102",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "938",
    "used_times": "115",
    "succeed_times": "564",
    "last_checked_at": "2018-12-14 09:47:02",
    "created_at": "2018-12-11 05:03:36",
    "updated_at": "2018-12-14 09:47:02"
  },
  {
    "id": 2327,
    "ip": "117.191.11.105",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "918",
    "used_times": "23",
    "succeed_times": "253",
    "last_checked_at": "2018-12-14 09:47:01",
    "created_at": "2018-12-12 21:04:20",
    "updated_at": "2018-12-14 09:47:01"
  },
  {
    "id": 215,
    "ip": "58.53.128.83",
    "port": "3128",
    "anonymity": "high_anonymous",
    "protocol": "https",
    "speed": "164",
    "used_times": "116",
    "succeed_times": "1221",
    "last_checked_at": "2018-12-14 09:47:00",
    "created_at": "2018-12-07 00:03:54",
    "updated_at": "2018-12-14 09:47:00"
  },
  {
    "id": 515,
    "ip": "39.137.69.10",
    "port": "8080",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "329",
    "used_times": "116",
    "succeed_times": "1103",
    "last_checked_at": "2018-12-14 09:47:00",
    "created_at": "2018-12-07 07:03:32",
    "updated_at": "2018-12-14 09:47:00"
  },
  {
    "id": 2780,
    "ip": "101.248.64.68",
    "port": "8080",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "478",
    "used_times": "0",
    "succeed_times": "51",
    "last_checked_at": "2018-12-14 09:47:00",
    "created_at": "2018-12-13 21:04:17",
    "updated_at": "2018-12-14 09:47:00"
  },
  {
    "id": 1211,
    "ip": "117.191.11.73",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "1752",
    "used_times": "115",
    "succeed_times": "626",
    "last_checked_at": "2018-12-14 09:46:59",
    "created_at": "2018-12-10 10:04:32",
    "updated_at": "2018-12-14 09:46:59"
  },
  {
    "id": 1208,
    "ip": "223.203.0.14",
    "port": "8000",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "467",
    "used_times": "115",
    "succeed_times": "626",
    "last_checked_at": "2018-12-14 09:46:58",
    "created_at": "2018-12-10 10:04:41",
    "updated_at": "2018-12-14 09:46:58"
  },
  {
    "id": 1203,
    "ip": "117.191.11.75",
    "port": "8080",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "1062",
    "used_times": "115",
    "succeed_times": "626",
    "last_checked_at": "2018-12-14 09:46:57",
    "created_at": "2018-12-10 10:04:26",
    "updated_at": "2018-12-14 09:46:57"
  },
  {
    "id": 2548,
    "ip": "218.60.8.99",
    "port": "3129",
    "anonymity": "anonymous",
    "protocol": "http",
    "speed": "297",
    "used_times": "0",
    "succeed_times": "157",
    "last_checked_at": "2018-12-14 09:46:56",
    "created_at": "2018-12-13 05:04:29",
    "updated_at": "2018-12-14 09:46:56"
  },
  {
    "id": 2806,
    "ip": "52.179.5.76",
    "port": "8080",
    "anonymity": "anonymous",
    "protocol": "http",
    "speed": "1606",
    "used_times": "0",
    "succeed_times": "37",
    "last_checked_at": "2018-12-14 09:46:56",
    "created_at": "2018-12-14 01:03:53",
    "updated_at": "2018-12-14 09:46:56"
  },
  {
    "id": 1756,
    "ip": "117.191.11.104",
    "port": "8080",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "911",
    "used_times": "116",
    "succeed_times": "498",
    "last_checked_at": "2018-12-14 09:46:54",
    "created_at": "2018-12-11 10:04:48",
    "updated_at": "2018-12-14 09:46:54"
  },
  {
    "id": 2802,
    "ip": "138.68.174.31",
    "port": "3128",
    "anonymity": "anonymous",
    "protocol": "http",
    "speed": "1782",
    "used_times": "0",
    "succeed_times": "37",
    "last_checked_at": "2018-12-14 09:46:53",
    "created_at": "2018-12-14 01:03:54",
    "updated_at": "2018-12-14 09:46:53"
  },
  {
    "id": 2799,
    "ip": "46.101.74.238",
    "port": "3128",
    "anonymity": "anonymous",
    "protocol": "http",
    "speed": "1389",
    "used_times": "0",
    "succeed_times": "37",
    "last_checked_at": "2018-12-14 09:45:32",
    "created_at": "2018-12-14 01:03:54",
    "updated_at": "2018-12-14 09:45:32"
  },
  {
    "id": 2797,
    "ip": "77.242.105.88",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "1182",
    "used_times": "0",
    "succeed_times": "37",
    "last_checked_at": "2018-12-14 09:45:30",
    "created_at": "2018-12-14 01:03:55",
    "updated_at": "2018-12-14 09:45:30"
  },
  {
    "id": 2795,
    "ip": "60.212.197.137",
    "port": "8060",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "343",
    "used_times": "0",
    "succeed_times": "37",
    "last_checked_at": "2018-12-14 09:45:29",
    "created_at": "2018-12-14 01:40:20",
    "updated_at": "2018-12-14 09:45:29"
  },
  {
    "id": 2793,
    "ip": "3.0.139.193",
    "port": "3128",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "609",
    "used_times": "0",
    "succeed_times": "37",
    "last_checked_at": "2018-12-14 09:45:29",
    "created_at": "2018-12-14 01:03:56",
    "updated_at": "2018-12-14 09:45:29"
  },
  {
    "id": 2791,
    "ip": "167.99.156.230",
    "port": "3128",
    "anonymity": "high_anonymous",
    "protocol": "https",
    "speed": "1453",
    "used_times": "0",
    "succeed_times": "37",
    "last_checked_at": "2018-12-14 09:45:28",
    "created_at": "2018-12-14 01:03:54",
    "updated_at": "2018-12-14 09:45:28"
  },
  {
    "id": 1600,
    "ip": "39.137.169.69",
    "port": "8080",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "814",
    "used_times": "115",
    "succeed_times": "561",
    "last_checked_at": "2018-12-14 09:45:27",
    "created_at": "2018-12-11 05:03:36",
    "updated_at": "2018-12-14 09:45:27"
  }],
  "links": {
    "first": "http://proxy.vm/api/proxies/stable/list?page=1",
    "last": "http://proxy.vm/api/proxies/stable/list?page=4",
    "prev": null,
    "next": "http://proxy.vm/api/proxies/stable/list?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 4,
    "path": "http://proxy.vm/api/proxies/stable/list",
    "per_page": 20,
    "to": 20,
    "total": 68
  }
}
```