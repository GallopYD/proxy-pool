# 代理池

### 获取稳定代理
```shell
curl HOST/api/proxies/stable
```
```json
{
  "data": {
    "id": 2766,
    "ip": "113.200.214.164",
    "port": "9999",
    "anonymity": "high_anonymous",
    "protocol": "https",
    "speed": "634",
    "used_times": 1,
    "checked_times": "69",
    "last_checked_at": "2018-12-14 09:58:04",
    "created_at": "2018-12-13 23:03:50",
    "updated_at": "2018-12-14 10:35:28"
  }
}
```

### 获取优质代理
```shell
curl HOST/api/proxies/premium
```
```json
{
  "data": {
    "id": 14,
    "ip": "39.137.77.66",
    "port": "8080",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "556",
    "used_times": 118,
    "checked_times": "645",
    "last_checked_at": "2018-12-14 09:58:53",
    "created_at": "2018-12-10 10:05:05",
    "updated_at": "2018-12-14 10:35:45"
  }
}
```

### 获取稳定代理列表
```shell
curl HOST/api/proxies/stable/list
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
    "checked_times": "69",
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
    "checked_times": "139",
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
    "checked_times": "564",
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
    "checked_times": "253",
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
    "checked_times": "1221",
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
    "checked_times": "1103",
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
    "checked_times": "51",
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
    "checked_times": "626",
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
    "checked_times": "626",
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
    "checked_times": "626",
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
    "checked_times": "157",
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
    "checked_times": "37",
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
    "checked_times": "498",
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
    "checked_times": "37",
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
    "checked_times": "37",
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
    "checked_times": "37",
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
    "checked_times": "37",
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
    "checked_times": "37",
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
    "checked_times": "37",
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
    "checked_times": "561",
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

### 获取优质代理列表
```shell
curl HOST/api/proxies/premium/list
```
```json
{
  "data": [{
    "id": 15,
    "ip": "218.60.8.83",
    "port": "3129",
    "anonymity": "anonymous",
    "protocol": "http",
    "speed": "750",
    "used_times": "118",
    "checked_times": "641",
    "last_checked_at": "2018-12-14 09:58:54",
    "created_at": "2018-12-10 10:04:11",
    "updated_at": "2018-12-14 10:19:51"
  },
  {
    "id": 14,
    "ip": "39.137.77.66",
    "port": "8080",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "556",
    "used_times": "117",
    "checked_times": "645",
    "last_checked_at": "2018-12-14 09:58:53",
    "created_at": "2018-12-10 10:05:05",
    "updated_at": "2018-12-14 09:58:53"
  },
  {
    "id": 13,
    "ip": "59.34.2.92",
    "port": "3128",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "214",
    "used_times": "0",
    "checked_times": "137",
    "last_checked_at": "2018-12-14 09:58:53",
    "created_at": "2018-12-13 14:03:46",
    "updated_at": "2018-12-14 09:58:53"
  },
  {
    "id": 12,
    "ip": "119.180.182.104",
    "port": "8060",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "307",
    "used_times": "0",
    "checked_times": "137",
    "last_checked_at": "2018-12-14 09:58:53",
    "created_at": "2018-12-13 14:50:22",
    "updated_at": "2018-12-14 09:58:53"
  },
  {
    "id": 11,
    "ip": "39.137.107.98",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "419",
    "used_times": "7",
    "checked_times": "221",
    "last_checked_at": "2018-12-14 09:58:52",
    "created_at": "2018-12-12 21:04:25",
    "updated_at": "2018-12-14 09:58:52"
  },
  {
    "id": 10,
    "ip": "218.60.8.99",
    "port": "3129",
    "anonymity": "high_anonymous",
    "protocol": "https",
    "speed": "371",
    "used_times": "0",
    "checked_times": "137",
    "last_checked_at": "2018-12-14 09:58:52",
    "created_at": "2018-12-13 16:02:56",
    "updated_at": "2018-12-14 09:58:52"
  },
  {
    "id": 7,
    "ip": "117.191.11.101",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "1070",
    "used_times": "115",
    "checked_times": "459",
    "last_checked_at": "2018-12-14 09:58:51",
    "created_at": "2018-12-11 16:03:41",
    "updated_at": "2018-12-14 09:58:51"
  },
  {
    "id": 8,
    "ip": "39.137.69.7",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "333",
    "used_times": "7",
    "checked_times": "235",
    "last_checked_at": "2018-12-14 09:58:51",
    "created_at": "2018-12-12 22:03:46",
    "updated_at": "2018-12-14 09:58:51"
  },
  {
    "id": 9,
    "ip": "219.141.153.44",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "84",
    "used_times": "0",
    "checked_times": "137",
    "last_checked_at": "2018-12-14 09:58:51",
    "created_at": "2018-12-13 16:02:56",
    "updated_at": "2018-12-14 09:58:51"
  },
  {
    "id": 6,
    "ip": "117.191.11.72",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "905",
    "used_times": "0",
    "checked_times": "138",
    "last_checked_at": "2018-12-14 09:58:50",
    "created_at": "2018-12-13 15:03:40",
    "updated_at": "2018-12-14 09:58:50"
  },
  {
    "id": 5,
    "ip": "39.137.69.10",
    "port": "80",
    "anonymity": "high_anonymous",
    "protocol": "http",
    "speed": "410",
    "used_times": "115",
    "checked_times": "461",
    "last_checked_at": "2018-12-14 09:58:49",
    "created_at": "2018-12-11 15:03:21",
    "updated_at": "2018-12-14 09:58:49"
  },
  {
    "id": 4,
    "ip": "112.115.57.20",
    "port": "3128",
    "anonymity": "transparent",
    "protocol": "http",
    "speed": "601",
    "used_times": "0",
    "checked_times": "142",
    "last_checked_at": "2018-12-14 09:58:49",
    "created_at": "2018-12-13 13:02:27",
    "updated_at": "2018-12-14 09:58:49"
  },
  {
    "id": 2,
    "ip": "58.53.128.83",
    "port": "3128",
    "anonymity": "anonymous",
    "protocol": "http",
    "speed": "177",
    "used_times": "117",
    "checked_times": "2636",
    "last_checked_at": "2018-12-14 09:58:46",
    "created_at": "2018-12-03 14:47:08",
    "updated_at": "2018-12-14 09:58:46"
  },
  {
    "id": 1,
    "ip": "218.60.8.98",
    "port": "3129",
    "anonymity": "high_anonymous",
    "protocol": "https",
    "speed": "372",
    "used_times": "117",
    "checked_times": "320",
    "last_checked_at": "2018-12-14 09:58:46",
    "created_at": "2018-12-12 05:04:06",
    "updated_at": "2018-12-14 09:58:46"
  },
  {
    "id": 3,
    "ip": "14.207.34.230",
    "port": "3128",
    "anonymity": "high_anonymous",
    "protocol": "https",
    "speed": "732",
    "used_times": "0",
    "checked_times": "137",
    "last_checked_at": "2018-12-14 09:57:57",
    "created_at": "2018-12-13 11:08:34",
    "updated_at": "2018-12-14 09:58:48"
  }],
  "links": {
    "first": "http://proxy.vm/api/proxies/premium/list?page=1",
    "last": "http://proxy.vm/api/proxies/premium/list?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://proxy.vm/api/proxies/premium/list",
    "per_page": 20,
    "to": 15,
    "total": 15
  }
}
```