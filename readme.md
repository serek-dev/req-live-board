# Scalo req-task

Thank you for inviting me to this process, here is my solution and steps I'd like to commit
in a normal "dev-day".

## Development

Use provided `Makefile` in order to run this apps (unit tests). `Docker + docker-compose` must be installed
on the host machine. Tested on _Ubuntu v22_:

```bash
$ docker -v
# Docker version 24.0.5, build ced0996

$ docker-compose -v
# docker-compose version 1.29.2, build 5becea4c
```

The following `Makefile` commands are available:

```text
bash                           Runs container in bash mode
start                          Start local env and tests
tests_phpstan                  Runs phpstan analysis
tests_unit                     Runs unit tests
```
