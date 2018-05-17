## Preview: [https://Mirkt.lt](https://mirkt.lt/website-info)

## Create SSL Certificate for development

##### Install packages
```
sudo apt-get update && apt-get install openssl libnss3-tools
```

##### Create the Certificate using OpenSSL

```
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout docker/nginx/ssl/localhost.key -out docker/nginx/ssl/localhost.crt -config docker/nginx/ssl/localhost.conf
```

##### Copy the public key to the /etc/ssl/certs directory
```
sudo cp localhost.crt /etc/ssl/certs/localhost.crt
```

##### Copy the private key to the /etc/ssl/private directory
```
sudo cp localhost.key /etc/ssl/private/localhost.key
```
##### Add the certificate to the trusted CA root store
```
certutil -d sql:$HOME/.pki/nssdb -A -t "P,," -n "localhost" -i docker/nginx/ssl/localhost.crt
```