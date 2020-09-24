create table tx_events_domain_model_event
(
    title                      varchar(255)     not null default '',
    teaser                     text             not null,
    description                text             not null,
    location                   text             not null,
    date                       date             null,
    time                       time             null,
    end_date                   date             null,
    end_time                   time             null,
    non_stop                   tinyint(1)       not null default '0',
    images                     int(10) unsigned not null default '0',
    downloads                  int(10) unsigned not null default '0',
    organizer                  int(10) unsigned not null default '0',
    recurring_weeks            int(11)          not null default '0',
    recurring_days             int(11)          not null default '0',
    recurring_stop             date             null,
    recurring_exclude_holidays tinyint(4)       not null default '0',
    recurring_exclude_dates    text,
    content_elements           int(10) unsigned not null default '0'
);

create table tx_events_domain_model_organizer
(
    name    varchar(200) not null default '',
    address text         not null default '',
    phone   varchar(20)  not null default '',
    email   varchar(200) not null default '',
    website varchar(200) not null default ''
);

create table tx_events_domain_model_event_2_organizer
(
    uid_local   int(10) unsigned not null default '0',
    uid_foreign int(10) unsigned not null default '0',
    sorting     int(11)          not null default '0'
);

create table tt_content
(
    tx_events_parent int(10) not null default '0'
);
