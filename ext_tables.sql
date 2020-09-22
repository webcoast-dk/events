create table tx_events_domain_model_event
(
    title                      varchar(255)     not null default '',
    teaser                     text             not null,
    description                text             not null,
    location                   varchar(255)     not null default '',
    date                       date             null,
    time                       time             null,
    end_date                   date             null,
    end_time                   time             null,
    non_stop                   tinyint(1)       not null default '0',
    images                     int(10) unsigned not null default '0',
    downloads                  int(10) unsigned not null default '0',
    recurring_weeks            int(11)          not null default '0',
    recurring_days             int(11)          not null default '0',
    recurring_stop             date             null,
    recurring_exclude_holidays tinyint(4)       not null default '0',
    recurring_exclude_dates    text
);
