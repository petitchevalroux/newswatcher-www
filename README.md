# newswatcher-www
Newswacher website

##Utility##

Start docker

```
bin/docker-start
```

##Start all twitter indexer##
```bash
docker exec newswatcher-www /usr/bin/php /data/http/bin/startTwitterIndexer.php
```

##Environnement##

set to test environment to cli:

```bash
export NEWSWATCHER_ENV='test';
```
