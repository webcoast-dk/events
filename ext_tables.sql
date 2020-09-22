create table tx_events_domain_model_event
(
    title                      varchar(255)     not null default '',
    teaser                     text             not null,
    description                text             not null,
    location                   varchar(255)     not null default '',
    event_date                 date             null,
    event_time                 time             null,
    event_stop_date            date             null,
    images                     int(10) unsigned not null default '0',
    downloads                  int(10) unsigned not null default '0',
    recurring_weeks            int(11)          not null default '0',
    recurring_days             int(11)          not null default '0',
    recurring_stop             date             null,
    recurring_exclude_holidays tinyint(4)       not null default '0',
    recurring_exclude_dates    text
);
