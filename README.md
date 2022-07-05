# Сервис для системы продажи железнодорожных билетов

Поставленная задача стоит следующим образом:
```
Спроектировать базу данных для системы продажи железнодорожных билетов
```

## Содержание
* [Предисловие](#intro)
* [Описание идеи](#models)
* [Описание моделей](#models)
* [SQL запросы](#sql)



<a name="intro"><h3>Предисловие</h3></a>


В данном репозитории находится результат выполнения тестового задания.


Ориентировался на базу данных PostgresQL.\
Поэтому названия таблиц включают в себя схемы.


Для генерации SQL-кода создания таблиц я использовал свой пет-проект, пакеты:
```
https://github.com/epicoon/lx-core
https://github.com/epicoon/lx-model
```
Поэтому констрейнты и расшивочные таблицы имеют длинные подробные имена.\
Схемы описывал в виде yaml-конфигураций, которые ради интереса оставил в репозитории в директории `schemas/models`.\
Так же в репозитории можно найти автосгенерированный PHP-код моделей и yaml-код миграций, но вряд ли они дадут больше информации, чем yaml-схемы, на основании которых они генерировались.\
Но все же надеюсь, что информация, необходимая для понимания направления моих мыслей, находится в этом README.



<a name="models"><h3>Описание идеи</h3></a>

Система будет состоять из элементов:
* логистических - представление железнодорожной сети и шаблонов для построения маршрутов
* финансовых - для осущетствления оплаты за поездки
* действующих - пользователи, билеты и реальные рейсы


Железнодорожная сеть представлена набором станций, соединенных перегонами.\
Станция может иметь несколько железнодорожных платформ.\
Перегон между станциями имеет известную длину и базовый тариф за перемещение от станции к станции.\
Перегон из станции А в станцию Б и перегон из станции Б в станцию А - два разных перегона, т.к. нет гарантии, 
что железнодорожная колея в одном направлении всегда сопровождается идущей рядом колеёй в обратном направлении.\
Логистика организуется с помощью маршрутов, которые представляют собой шаблоны для создания рейсов.\
Маршрут включает список стоянок на станциях. Стоянки, следующие в списке друг за другом должны быть на соседних станциях, связанных перегонами.\
Маршрут планируется согласно дням недели, реже раза в неделю маршрутов нет. Такое ограничение выбрано, чтобы упростить задачу. 
В такой парадигме просто решается задача проектирования нового маршрута с учетом уже существующих маршрутов, 
чтобы избежать коллизий в вопросе занятости платформ в определенные часы.\
Сутки разбиты на слоты времени, в течение которых поезда могут занимать платформы на станциях.\
Стоянки хранят информацию о слотах времени прибытия и отправления - для проектирования непересекающихся маршрутов.\
Стоянки хранят информацию о продолжительности нахождения в пути на предшествовашем перегоне, благодаря чему, зная длину перегона,
можно рассчитывать среднюю скорость движения поезда на данном перегоне, чтобы он приезжал на станцию к установленному слоту времени.


Финансовая система представлена балансами пользователей (пассажиров и администратора системы).\
Оплата осуществляется с помощью платежей, состоящих из транзакций.


Рейсы создаются планировщиком согласно спроектированным маршрутам.\
Рейс содержит информацию о состоянии перегонов в данном рейсе.
Для перегонов в рейсе можно переопределить базовую стоимость перемещения от станции к станции.\
Так же перегон в рейсе хранит количество занятых мест, которое может меняться при преодолении каждой очередной станции.
Это позволит более гибко бронировать места.\



<a name="models"><h3>Описание моделей</h3></a>


- сущности логистические
  - справочник дней недели (ref_day_of_week)
    - поле {string} name
    - связь (многие-ко-многим) с маршрутами
  - справочник слотов времени пребывания поезда на платформе (ref_time_slot) - все станции в нашей системе стандартизованы
    - поле {time} startTime
    - поле {time} endTime
  - станция (station) - пункты назначения, где поезда могут загружаться/разгружаться. Для упрощения считаем, что пока не важна страна, координаты и т.п.
    - поле {string} name
  - платформа (platform) - прощадка, принадлежащая станции, для остановки одного поезда
    - поле {int} number - порядковый номер платформы
    - связь (многие-к-одному) со станцией
  - поезд (train) - для упрощения игнорируем существование вагонов
    - поле {string} code - регистрационный номер транспортного средства
    - поле {int} seats_count - количество посадочных мест
  - перегон (stage) - участок пути, связывающий соседние станции
    - поле {int} distance - расстояние в км
    - поле {decimal} cost - стоимость преодоления данного участка для пассажира
    - связь (многие-к-одному) со станцией отправления
    - связь (многие-к-одному) со станцией прибытия
  - стоянка (parking) -период пребывания поезда на платформе станции в контексте маршрута
    - поле {int} sequence_order - порядок следования стоянки в маршруте
    - поле {timeInterval} wayDuration - продолжительность нахождения в пути до данной стоянки
    - поле {timeInterval} stayDuration - продолжительность стоянки
    - связь (многие-к-одному) со станцией
    - связь (многие-к-одному) с платформой
    - связь (многие-к-одному) с маршрутом
    - связь (многие-к-одному) со слотом времени прибытия
    - связь (многие-к-одному) со слотом времени отправления
  - маршрут (route) - информация о перемещении поезда из пункта А в пункт Б с учетом стоянок
    - поле {string} name
    - поле {bool} active - флаг активности, на случай если нужно отключать определенные направления
    - связь (один-ко-многим) со стоянками
    - связь (многие-ко-многим) со справочником дней недели - маршрут может быть запланирован на несколько дней недели


- сущности финансовые (целеообразно использовать внешний сервис. Для упрощения задачи, но сохранения полноты картины, можно реализовать в текущей системе)
  - справочник статусов платежей (ref_payment_status) - ожидает подтверждения, подтвержден, отменен
    - поле {string} name
  - справочник типов транзакций (ref_transaction_type) - оплата, отмена
    - поле {string} name
  - баланс пользователя (balance)
    - поле {decimal} balance
    - связь (один-к-одному) с пользователем системы
  - платеж (payment)
    - поле {timestamp} created_at
    - связь (один-ко-многим) с транзакциями
    - связь (многие-к-одному) со справочником статусов платежей
  - транзакция (transaction)
    - поле {decimal} amount
    - поле {timestamp} created_at
    - связь (многие-к-одному) с платежом
    - связь (многие-к-одному) со справочником типов транзакций
    - связь (один-к-одному) баланс списания
    - связь (один-к-одному) баланс зачисления


- сущности действующие
  - справочник статусов брони (ref_booking_status) н-р создана, подтверждена, отменена
    - поле {string} name
  - пользователь системы (users) - администратор системы, пассажир. Целесообразно использовать внешний сервис для аутентификации и авторизации, для упрощения будем хранить роль в модели
    - поле {string} login
    - поле {string} role
  - рейс (trip) - конкретный рейс на основе маршрута
    - поле {string} name
    - поле {date} departure_date
    - поле {date} arrival_date
    - поле {int} total_seats_count - общее число мест
    - поле {bool} approved - флаг подтверждения рейса, когда он полностью создан и готов к бронированию
    - связь (многие-к-одному) с маршрутом
    - связь (многие-к-одному) с поездом - один поезд может обслуживать много рейсов (если они не пересекаются во времени)
  - перегон в рейсе (stage_in_trip)
    - поле {decimal} cost
    - поле {int} reserved_seats_count - число занятых мест
    - связь (многие-к-одному) с рейсом
    - связь (многие-к-одному) с перегоном
  - бронь (booking) - связь рейса и пассажира
    - поле {string} ticket - уникальный номер билета
    - связь (многие-к-одному) с рейсом
    - связь (многие-к-одному) со справочником статусов брони
    - связь (многие-к-одному) с пользователем - один пассажир может сделать много броней
    - связь (один-к-одному) с платежом



<a name="sql"><h3>SQL запросы</h3></a>

SQL-запросы, создающие таблицы согласно описанной выше архитектуре

```sql
create table lx__train.ref_booking_status
(
    name varchar(256) not null,
    id   serial
        constraint lx__train_ref_booking_status_pkey
            primary key
);

alter table lx__train.ref_booking_status
    owner to lx;

create table lx__train.ref_day_of_week
(
    name varchar(256) not null,
    id   serial
        constraint lx__train_ref_day_of_week_pkey
            primary key
);

alter table lx__train.ref_day_of_week
    owner to lx;

create table lx__train.ref_payment_status
(
    name varchar(256) not null,
    id   serial
        constraint lx__train_ref_payment_status_pkey
            primary key
);

alter table lx__train.ref_payment_status
    owner to lx;

create table lx__train.payment
(
    created_at timestamp not null,
    id         serial
        constraint lx__train_payment_pkey
            primary key,
    fk_status  integer
        constraint fk__lx__train_payment__status
            references lx__train.ref_payment_status
);

alter table lx__train.payment
    owner to lx;

create table lx__train.ref_time_slot
(
    start_time time not null,
    end_time   time not null,
    id         serial
        constraint lx__train_ref_time_slot_pkey
            primary key
);

alter table lx__train.ref_time_slot
    owner to lx;

create table lx__train.ref_transaction_type
(
    name varchar(256) not null,
    id   serial
        constraint lx__train_ref_transaction_type_pkey
            primary key
);

alter table lx__train.ref_transaction_type
    owner to lx;

create table lx__train.route
(
    name varchar(256) not null,
    id   serial
        constraint lx__train_route_pkey
            primary key
);

alter table lx__train.route
    owner to lx;

create table lx__train.station
(
    name varchar(256) not null,
    id   serial
        constraint lx__train_station_pkey
            primary key
);

alter table lx__train.station
    owner to lx;

create table lx__train.platform
(
    number     integer not null,
    id         serial
        constraint lx__train_platform_pkey
            primary key,
    fk_station integer
        constraint fk__lx__train_platform__station
            references lx__train.station
);

alter table lx__train.platform
    owner to lx;

create table lx__train.parking
(
    sequence_order integer  not null,
    way_duration   interval not null,
    stay_duration  interval not null,
    id             serial
        constraint lx__train_parking_pkey
            primary key,
    fk_station     integer
        constraint fk__lx__train_parking__station
            references lx__train.station,
    fk_platform    integer
        constraint fk__lx__train_parking__platform
            references lx__train.platform,
    fk_route       integer
        constraint fk__lx__train_parking__route
            references lx__train.route,
    fk_incoming    integer
        constraint fk__lx__train_parking__incoming
            references lx__train.ref_time_slot,
    fk_outgoing    integer
        constraint fk__lx__train_parking__outgoing
            references lx__train.ref_time_slot
);

alter table lx__train.parking
    owner to lx;

create table lx__train.stage
(
    distance        integer        not null,
    cost            numeric(10, 2) not null,
    id              serial
        constraint lx__train_stage_pkey
            primary key,
    fk_station_from integer
        constraint fk__lx__train_stage__station_from
            references lx__train.station,
    fk_station_to   integer
        constraint fk__lx__train_stage__station_to
            references lx__train.station
);

alter table lx__train.stage
    owner to lx;

create table lx__train.train
(
    code        varchar(256) not null,
    seats_count integer      not null,
    id          serial
        constraint lx__train_train_pkey
            primary key
);

alter table lx__train.train
    owner to lx;

create table lx__train.trip
(
    name              varchar(256) not null,
    departure_date    date         not null,
    arrival_date      date         not null,
    total_seats_count integer      not null,
    approved          boolean default false,
    id                serial
        constraint lx__train_trip_pkey
            primary key,
    fk_route          integer
        constraint fk__lx__train_trip__route
            references lx__train.route,
    fk_train          integer
        constraint fk__lx__train_trip__train
            references lx__train.train
);

alter table lx__train.trip
    owner to lx;

create table lx__train.stage_in_trip
(
    cost                 numeric(10, 2),
    reserved_seats_count integer default 0,
    id                   serial
        constraint lx__train_stage_in_trip_pkey
            primary key,
    fk_trip              integer
        constraint fk__lx__train_stage_in_trip__trip
            references lx__train.trip,
    fk_stage             integer
        constraint fk__lx__train_stage_in_trip__stage
            references lx__train.stage
);

alter table lx__train.stage_in_trip
    owner to lx;

create table lx__train.users
(
    login varchar(256) not null,
    role  varchar(256) not null,
    id    serial
        constraint lx__train_users_pkey
            primary key
);

alter table lx__train.users
    owner to lx;

create table lx__train.balance
(
    balance numeric(10, 2) default '0'::numeric,
    id      serial
        constraint lx__train_balance_pkey
            primary key,
    fk_user integer
        constraint fk__lx__train_balance__user
            references lx__train.users
);

alter table lx__train.balance
    owner to lx;

create table lx__train.booking
(
    ticket     varchar(256),
    id         serial
        constraint lx__train_booking_pkey
            primary key,
    fk_trip    integer
        constraint fk__lx__train_booking__trip
            references lx__train.trip,
    fk_status  integer
        constraint fk__lx__train_booking__status
            references lx__train.ref_booking_status,
    fk_user    integer
        constraint fk__lx__train_booking__user
            references lx__train.users,
    fk_payment integer
        constraint fk__lx__train_booking__payment
            references lx__train.payment
);

alter table lx__train.booking
    owner to lx;

create table lx__train.transaction
(
    amount          numeric(10, 2) not null,
    created_at      timestamp      not null,
    id              serial
        constraint lx__train_transaction_pkey
            primary key,
    fk_payment      integer
        constraint fk__lx__train_transaction__payment
            references lx__train.payment,
    fk_type         integer
        constraint fk__lx__train_transaction__type
            references lx__train.ref_transaction_type,
    fk_balance_from integer
        constraint fk__lx__train_transaction__balance_from
            references lx__train.balance,
    fk_balance_to   integer
        constraint fk__lx__train_transaction__balance_to
            references lx__train.balance
);

alter table lx__train.transaction
    owner to lx;

create table lx__train._rel__ref_day_of_week__routes__route__days_of_week
(
    fk_ref_day_of_week integer not null
        constraint fk__lx__train_route__days_of_week
            references lx__train.ref_day_of_week,
    fk_route           integer not null
        constraint fk__lx__train_ref_day_of_week__routes
            references lx__train.route
);

alter table lx__train._rel__ref_day_of_week__routes__route__days_of_week
    owner to lx;
```
