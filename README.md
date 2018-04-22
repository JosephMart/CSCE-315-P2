# CSCE 315 Project 2

## Download Docker
* [Windows 10](https://store.docker.com/editions/community/docker-ce-desktop-windows)
* [MAC](https://store.docker.com/editions/community/docker-ce-desktop-mac)
* [Ubuntu](https://store.docker.com/editions/community/docker-ce-server-ubuntu)
* [Older Windows/MAC](https://docs.docker.com/toolbox/overview/)

## Run Docker image
```bash
docker-compose up
```

## Addresses
* PHPMyAdmin - localhost:8080
* Webserver - localhost

On Windows (?) you can find the ip my typing `docker-machine ip`

## Add proper IP

Find DB address. If TAMU it will be `database.cs.tamu.edu`.
If local dev you can find it as follows

```bash
docker-compose exec mariadb sh # ssh into the container
hostname -I # this will spit out the IP address you will need to added to the common methods file
```

## File Structure
```
.
├── docker-compose.yml
├── docs
├── README.md
├── schema.sql
├── setup.sql
└── src
    ├── app
    ├── arduino
    └── old
```