create table admins
(
    aid    int auto_increment
        primary key,
    fname  varchar(80)                 not null,
    lname  varchar(80)                 not null,
    level  int                         not null,
    active enum ('1', '2') default '2' not null,
    date   datetime                    not null
)
    engine = MyISAM;

create table applicants
(
    aplid    int auto_increment
        primary key,
    inid     int                         not null,
    stid     int                         not null,
    accepted enum ('0', '1') default '0' not null,
    code     varchar(100)                null,
    date     datetime                    not null
)
    engine = MyISAM;

create table appusers
(
    apid      int auto_increment
        primary key,
    userid    int                  not null,
    email     varchar(80)          not null,
    password  varchar(80)          null,
    user_type enum ('s', 'c', 'a') not null,
    token     varchar(100)         null,
    firebase  varchar(200)         null,
    constraint email
        unique (email)
)
    engine = MyISAM;

create table company
(
    cid          int auto_increment
        primary key,
    cname        varchar(100)                     not null,
    type         varchar(60)                      null,
    location     varchar(100)                     not null,
    address      varchar(100)                     not null,
    email        varchar(100)                     null,
    bio          text                             not null,
    logo         varchar(80)                      null,
    active       enum ('0', '1', '2') default '0' not null,
    date         datetime                         not null,
    passcode     varchar(100)                     null,
    subscription datetime                         null,
    constraint passcode
        unique (passcode)
)
    engine = MyISAM;

create table countries
(
    id           int auto_increment
        primary key,
    country_code char(2)     not null,
    country_name varchar(80) not null,
    phonecode    int(5)      not null
)
    engine = MyISAM;

create table cv_education
(
    ceid     int auto_increment
        primary key,
    stid     int          not null,
    school   varchar(100) not null,
    location varchar(100) not null,
    degree   varchar(100) not null,
    field    varchar(100) not null,
    finish   int(4)       not null,
    date     datetime     not null
)
    engine = MyISAM;

create table cv_hobbies
(
    chid    int auto_increment
        primary key,
    stid    int      not null,
    hobbies text     not null,
    date    datetime not null
)
    engine = MyISAM;

create table cv_prof
(
    cpid    int auto_increment
        primary key,
    stid    int      not null,
    summary text     not null,
    date    datetime not null
)
    engine = MyISAM;

create table cv_service
(
    csvid   int auto_increment
        primary key,
    stid    int      not null,
    service text     not null,
    date    datetime not null
)
    engine = MyISAM;

create table cv_skills
(
    csid  int auto_increment
        primary key,
    stid  int      not null,
    skill text     not null,
    date  datetime not null
)
    engine = MyISAM;

create table cv_work
(
    cwid      int auto_increment
        primary key,
    stid      int                         not null,
    job_title varchar(100)                not null,
    employer  varchar(100)                not null,
    duties    text                        null,
    country   varchar(100)                not null,
    start     date                        not null,
    end       date                        null,
    current   enum ('0', '1') default '0' not null,
    date      datetime                    not null
)
    engine = MyISAM;

create table facebook_account
(
    apid        int         not null,
    facebook_id varchar(30) null,
    token       varchar(60) null,
    createdDate date        null,
    constraint facebook_account_userid_uindex
        unique (apid)
)
    charset = utf8;

alter table facebook_account
    add primary key (apid);

create table interests
(
    id    int auto_increment,
    title varchar(100) not null,
    constraint interests_id_uindex
        unique (id),
    constraint interests_title_uindex
        unique (title)
);

alter table interests
    add primary key (id);

create table internship
(
    inid        int auto_increment
        primary key,
    cid         int                         not null,
    title       varchar(100)                not null,
    description text                        not null,
    starts      date                        not null,
    ends        date                        not null,
    created     datetime                    not null,
    deleted     enum ('0', '1') default '0' null
)
    engine = MyISAM;

create table linkedin_account
(
    apid        int         not null,
    linkedin_id int         null,
    token       varchar(60) null,
    createdDate date        null,
    constraint linkedin_account_apid_uindex
        unique (apid)
)
    charset = utf8;

alter table linkedin_account
    add primary key (apid);

create table notification
(
    nid     int auto_increment
        primary key,
    apid    int                         not null,
    ntype   enum ('t', 'i', 'a')        not null,
    note_id varchar(100)                not null,
    note    varchar(200)                not null,
    seen    enum ('0', '1') default '0' not null,
    date    datetime                    not null
)
    engine = MyISAM;

create table password_change_keys
(
    pckid int auto_increment
        primary key,
    apid  int          not null,
    pass  varchar(100) not null
)
    engine = MyISAM;

create table phone_code
(
    pcid int auto_increment
        primary key,
    uid  int         not null,
    code varchar(10) not null,
    constraint uid
        unique (uid)
)
    engine = MyISAM;

create table portfolio_items
(
    id           int auto_increment,
    portfolio_id int                    not null,
    type         enum ('link', 'image') not null,
    url          varchar(200)           not null,
    constraint table_name_id_uindex
        unique (id)
);

alter table portfolio_items
    add primary key (id);

create table schools
(
    id       int auto_increment,
    name     varchar(200) not null,
    location varchar(100) null,
    constraint schools_id_uindex
        unique (id),
    constraint schools_name_uindex
        unique (name)
);

alter table schools
    add primary key (id);

create table skills
(
    id    int auto_increment,
    title varchar(100) not null,
    constraint skills_id_uindex
        unique (id),
    constraint skills_title_uindex
        unique (title)
);

alter table skills
    add primary key (id);

create table solution
(
    sid        int auto_increment
        primary key,
    stid       int                                   not null,
    tid        int                                   not null,
    summary    text                                  null,
    file       varchar(100)                          null,
    rate       int                       default 0   null,
    submission int                       default 0   not null,
    attempt    int                       default 0   not null,
    speed      int                       default 0   not null,
    remark     varchar(100)                          null,
    status     enum ('0', '1', '2', '3') default '0' not null,
    send_date  datetime                              null,
    date       datetime                              not null
)
    engine = MyISAM;

create table student_interests
(
    id          int auto_increment,
    user_id     int not null,
    interest_id int not null,
    constraint student_interests_id_uindex
        unique (id),
    constraint student_interests_user_id_interest_id_uindex
        unique (user_id, interest_id)
);

alter table student_interests
    add primary key (id);

create table student_portfolios
(
    id          int auto_increment,
    user_id     int                     not null,
    title       varchar(100)            not null,
    description varchar(200)            null,
    start_date  varchar(50) default '0' null,
    end_date    varchar(50) default '0' null,
    constraint student_portfolios_id_uindex
        unique (id)
);

alter table student_portfolios
    add primary key (id);

create table student_schools
(
    id         int auto_increment,
    user_id    int          not null,
    school_id  int          not null,
    course     varchar(200) not null,
    completion int(4)       not null,
    level      varchar(100) not null,
    constraint student_schools_id_uindex
        unique (id),
    constraint student_schools_user_id_school_id_course_uindex
        unique (user_id, school_id, course)
);

alter table student_schools
    add primary key (id);

create table student_skills
(
    id       int auto_increment,
    user_id  int not null,
    skill_id int not null,
    constraint student_skills_id_uindex
        unique (id),
    constraint student_skills_user_id_skill_id_uindex
        unique (user_id, skill_id)
);

alter table student_skills
    add primary key (id);

create table student_workplaces
(
    id           int auto_increment,
    user_id      int                     not null,
    workplace_id int                     not null,
    title        varchar(200)            not null,
    start_date   varchar(50) default '0' not null,
    end_date     varchar(50) default '0' not null,
    is_current   tinyint(1)  default 0   not null,
    constraint student_workplace_id_uindex
        unique (id),
    constraint student_workplaces_all_uindex
        unique (user_id, workplace_id, title, start_date, end_date)
);

alter table student_workplaces
    add primary key (id);

create table students
(
    stid              int auto_increment
        primary key,
    fname             varchar(80)                      not null,
    lname             varchar(80)                      not null,
    gender            enum ('f', 'm')                  null,
    dob               date                             null,
    active            enum ('0', '1', '2') default '0' null,
    city              varchar(100)                     null,
    state             varchar(100)                     null,
    postal            varchar(100)                     null,
    country           int                              null,
    phone             varchar(30)                      null,
    avatar            varchar(100)                     null,
    date              datetime                         not null,
    subscription      datetime                         null,
    welcome           enum ('0', '1')      default '0' null,
    nationality       int                              null,
    employment_status enum ('student', 'employed')     null,
    marital_status    enum ('single', 'married')       null
)
    engine = MyISAM;

create table subscribe
(
    sbid int auto_increment
        primary key,
    stid int      not null,
    cid  int      not null,
    date datetime not null
)
    engine = MyISAM;

create table task
(
    tid         int auto_increment
        primary key,
    cid         int                         not null,
    title       varchar(100)                not null,
    summary     text                        not null,
    file        varchar(100)                null,
    days        int                         null,
    delete_task enum ('0', '1') default '0' not null,
    date        datetime                    not null
)
    engine = MyISAM;

create table transaction
(
    tid             int auto_increment
        primary key,
    wallet          varchar(30)          not null,
    wallet_type     enum ('t', 'm')      not null,
    apid            int                  not null,
    amount          decimal(10, 2)       not null,
    invoice_num     varchar(80)          not null,
    transaction_num varchar(80)          null,
    status          enum ('f', 'p', 's') not null,
    date            datetime             not null,
    constraint invoice_num
        unique (invoice_num),
    constraint transaction_num
        unique (transaction_num)
)
    engine = MyISAM;

create table twitter_account
(
    apid        int         not null,
    twitter_id  varchar(30) null,
    token       varchar(60) null,
    createdDate date        null,
    constraint twitter_account_apid_uindex
        unique (apid)
)
    charset = utf8;

alter table twitter_account
    add primary key (apid);

create table watches
(
    wid  int auto_increment
        primary key,
    cid  int      not null,
    stid int      not null,
    date datetime not null
)
    engine = MyISAM;

create table workplaces
(
    id       int auto_increment,
    name     varchar(100) not null,
    location varchar(150) not null,
    constraint workplaces_id_uindex
        unique (id),
    constraint workplaces_name_uindex
        unique (name)
);

alter table workplaces
    add primary key (id);


