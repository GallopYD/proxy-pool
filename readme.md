# 代理池

### 获取单个代理IP
```shell
curl HOST/api/proxies/one
```
```
111.219.117.11:9000
```

### 获取代理IP列表
```shell
curl HOST/api/proxies
```
```json
{
  "data": [
    {
      "id": 1223,
      "ip": "119.131.88.187",
      "port": "9797",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "93",
      "checked_at": "2018-11-29 09:03:51",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:51"
    },
    {
      "id": 1224,
      "ip": "112.95.204.30",
      "port": "8888",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "93",
      "checked_at": "2018-11-29 09:03:51",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:51"
    },
    {
      "id": 1228,
      "ip": "125.123.122.197",
      "port": "9000",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "100",
      "checked_at": "2018-11-29 09:03:51",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:51"
    },
    {
      "id": 1226,
      "ip": "116.232.39.16",
      "port": "8118",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "102",
      "checked_at": "2018-11-29 09:03:51",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:51"
    },
    {
      "id": 1227,
      "ip": "113.251.172.98",
      "port": "8123",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "109",
      "checked_at": "2018-11-29 09:03:51",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:51"
    },
    {
      "id": 1225,
      "ip": "116.30.197.93",
      "port": "9797",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "121",
      "checked_at": "2018-11-29 09:03:51",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:51"
    },
    {
      "id": 1222,
      "ip": "112.95.205.127",
      "port": "8888",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "124",
      "checked_at": "2018-11-29 09:03:51",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:51"
    },
    {
      "id": 1215,
      "ip": "112.95.26.9",
      "port": "8088",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "86",
      "checked_at": "2018-11-29 09:03:50",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:50"
    },
    {
      "id": 1216,
      "ip": "163.125.31.43",
      "port": "8118",
      "anonymity": "transparent",
      "protocol": "http",
      "speed": "104",
      "checked_at": "2018-11-29 09:03:50",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:50"
    },
    {
      "id": 1214,
      "ip": "113.78.67.170",
      "port": "9797",
      "anonymity": "transparent",
      "protocol": "https",
      "speed": "107",
      "checked_at": "2018-11-29 09:03:50",
      "created_at": "2018-11-29 08:51:01",
      "updated_at": "2018-11-29 09:03:50"
    }
  ],
  "links": {
    "first": "http://proxy.vm/api/proxies?page=1",
    "last": "http://proxy.vm/api/proxies?page=86",
    "prev": null,
    "next": "http://proxy.vm/api/proxies?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 86,
    "path": "http://proxy.vm/api/proxies",
    "per_page": "10",
    "to": 10,
    "total": 859
  }
}
```