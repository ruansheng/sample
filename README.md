# sample
sample php framework

## Nginx Config
```
server{
	listen 5678;
	server_name 127.0.0.1;
	root /Users/ruansheng/PhpstormProjects/sample;
	location / {
		index index.php index.html index.htm;
 		rewrite ^/(.*) /index_api.php/$1 last;
	}

    location ~* \.(html|htm|gif|jpg|jpeg|bmp|png|ico|txt|js|css)$ {
        root /Users/ruansheng/PhpstormProjects/sample/static;
    }

	location ~ \.php {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            
            fastcgi_split_path_info ^(.+\.php)(.*)$;
            fastcgi_param PATH_INFO $fastcgi_path_info;

            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  SCRIPT_NAME $fastcgi_script_name;
            include        fastcgi_params;
    }
}
```

## Access method
```
php file:
    http://demo.sample.com/test/index/index

static file:
    http://demo.sample.com/css/1.css
```

## support composer package
```
1. define vendor autoload file
   ./vendor/autoload.php 
2. edit ./composer.json file
3. composer install
```

## define self functions
```
Example:
    # vim common/component/functions.php
    function echo helloWorld() {
        echo 'hello world!';
    }
    
Call in other php file:
    helloWorld();    
```

## cron
```
# php index_cron.php
or
# php index_cron.php -h
show:
    Usage: php index_cron.php [options]
          -h                       show help
          -c=<controller name>    route call controller name. example: -c="test/index"
          -m=<method name>        route call method name. example: -m="index"
          -p=<params>             call method params. example: -p="a=1&b=2"

# php index_cron.php -c="test/index" -m="index" -p="a=1&b=2"
show:
    crontab index method
    --------------------------------------------------------------------------
    file: /Users/ruansheng/PhpstormProjects/sample/apps/cron/controllers//test/index_controller.php
    method: index
    memory:  2.00 M
    spend_time: 1.000 S
    host: ruanshengdeMacBook-Pro.local
    --------------------------------------------------------------------------
```