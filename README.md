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
 		rewrite ^/(.*) /index.php/$1 last;
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
