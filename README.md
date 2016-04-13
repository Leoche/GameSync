<p align="center">
	<img src="//leoche.org/gsdemo/template/imgs/logo.png" alt="GameSync Logo"><br/>
	<h1>GameSync</h1>
</p>

GameSync is a multiplateform deployment tool that provide a secured syncronisation between client/server with a JSON end-point.

## Installation
---
* Unzip master folder to your webserver (ex: domain.com/gamesync/).
* Be sure that a config folder is present at root and **check that apache/nginx have write permissions** into it.
* Browse into domain.com/gamesync/ and provide an email and password.

## Use
---
Once connected to GameSync you can manage ur whitelist and upload or remove mods from mods folder, you also can activate of disable maintenance of the service.

Your license id is in the bottom of the about page

#### Request /api/retrieve
---
For this request you must add a "GameSync-Id" headers that match the license id which is in your about page.

This request returns:
* State of the service
* The Whitelist
* List of all files in the gamefiles folder with their informations (names, md5s and sizes)
* Execution time of the request
##### Request
```http
GET /api/retrieve HTTP/1.1
host: domain.net
GameSync-Id: XXXXX-XXXXX-XXXXX-XXXXX-XXXXX
```
##### Response
```json
{
   "online":true,
   "whitelist":[
      "launcher.settings",
      "hats\/*",
      "logs\/*",
      "resourcepacks\/*",
      "saves\/*"
   ],
   "infos":[
      {
         "name":"game.jar",
         "size":0,
         "md5":"d41d8cd98f00b204e9800998ecf8427e"
      },
      {
         "name":"mods\/resource.zip",
         "size":1303763,
         "md5":"cd7736872df8af0fb2625be67d1968be"
      }
   ],
   "exec_time":0.037817
}
```
## Contact
[Leoche](https://leoche.org)