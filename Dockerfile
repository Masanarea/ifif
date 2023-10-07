### DockerhubからUbuntuイメージをpull ###
FROM ubuntu:20.04

### 環境設定を指定 ###
ENV DEBIAN_FRONTEND=noninteractive

### composerイメージをインストール ###
COPY --from=composer:2.0.9 /usr/bin/composer /usr/local/bin/composer

### Laravelに必要なソフトウェアをインストール ###
RUN apt-get update && \
   apt-get -y upgrade && \
   apt-get -y install software-properties-common && \
   LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php && \
   apt-get -y install tzdata && \
   apt-get -y install php8.0 php8.0-dom php8.0-mbstring php8.0-curl php8.0-mysql php8.0-fpm php8.0-redis php8.0-zip php8.0-gd && \
   apt-get -y install git zip unzip mysql-client && \
   apt-get -y remove apache2 && \
   apt-get -y install nginx

### Laravelプロジェクトのコピー ###
WORKDIR /var/www/html
COPY . /var/www/html

### 依存関係のインストール ###
RUN composer install

### ディレクトリ権限の設定 ###
RUN chmod -R 775 storage bootstrap/cache

### Nginxの設定をコピー ###
COPY laravel.conf /etc/nginx/sites-available/laravel.conf

### 実行スクリプトをコピー ###
COPY run.sh /root/run.sh

### 実行スクリプトを実行 ###
RUN chmod +x /root/run.sh
CMD ["/root/run.sh"]
