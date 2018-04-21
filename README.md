# CSCE 315 Project 2

## Download docker
* [Windows](https://store.docker.com/editions/community/docker-ce-desktop-windows)
* [MAC](https://store.docker.com/editions/community/docker-ce-desktop-mac)
* [Ubuntu](https://store.docker.com/editions/community/docker-ce-server-ubuntu)

## Run docker image
```bash
docker-compose up
```

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