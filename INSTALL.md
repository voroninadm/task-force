#Установка проекта:

- Создание БД.  В консоли выполнить: <br>
  > "CREATE DATABASE IF NOT EXISTS taskforce <br>
  >  DEFAULT CHARACTER SET utf8 <br>
  >  DEFAULT COLLATE utf8mb4_general_ci;"
  
- Склонировать репозиторий в каталог taskforce
  > git clone git@github.com:voroninadm/taskforce.git taskforce
  
- Зайти в созданный каталог через консоль
  > cd taskforce
  
- Установить менеджер пакетов Composer <br>
  (если ранее не устанавливался. Проверить можно командой 'composer' из консоли')
    > composer install
  
- Выполнить миграции БД
   > php yii migrate
  
- Выполнить миграции yii для rbac
  > yii migrate --migrationPath=@yii/rbac/migrations
  
- Инициализировать rbac 
  > yii rbac/init