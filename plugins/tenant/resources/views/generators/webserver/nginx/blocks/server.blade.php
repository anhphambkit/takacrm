server {

    listen {{ array_get($config, 'ports.http', 80) }};
    listen {{ array_get($config, 'ports.https', 443) }} ssl;
    # ssl on;
    ssl_certificate {{ array_get($config, 'ssl_certificate', storage_path('app/ssl/takacrm.bi.pem')) }};
    ssl_certificate_key {{ array_get($config, 'ssl_certificate_key', storage_path('app/ssl/takacrm.bi-key.pem')) }};

    # server hostnames
    server_name {{ $hostname->fqdn }};

    # allow cross origin access
    add_header Access-Control-Allow-Origin *;
    add_header Access-Control-Request-Method GET;

    # root path of website; serve files from here
    root {{ public_path() }};
    index index.php index.html index.htm index.nginx-debian.html;

    # logging
    access_log {{ storage_path('logs/')  }}{{ $hostname->fqdn }}.access.log;
    error_log {{ storage_path('logs/')  }}{{ $hostname->fqdn }}.error.log notice;

    @if($media)
    location ~* ^/media/(.+)$ {
        alias {{ $media }}/$1;
    }
    @endif

    location / {
        try_files $uri $uri/ /index.php?$query_string;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }

    # pass the PHP scripts to FastCGI server from upstream phpfcgi
    location ~ \.php(/|$) {
        try_files        $uri =404;
        fastcgi_pass {{ array_get($config, 'php-sock') }};
        include fastcgi_params;

        fastcgi_split_path_info ^(.+\.php)(/.*)$;

        fastcgi_param    SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    client_max_body_size 200M;
}

