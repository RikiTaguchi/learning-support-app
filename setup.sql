CREATE TABLE info_account (
    user_name VARCHAR(255),
    login_id VARCHAR(255),
    user_pass VARCHAR(255),
    table_id INTEGER,
    account_type VARCHAR(255),
    class_id INTEGER
);

CREATE TABLE info_countdown (
    table_id INTEGER,
    title VARCHAR(255),
    date_limit DATE
);

CREATE TABLE info_feedback (
    table_id INTEGER,
    book_id VARCHAR(255),
    question_number INTEGER
);

CREATE TABLE info_my_book_index (
    table_id INTEGER,
    book_id VARCHAR(255),
    book_name VARCHAR(255),
    memo VARCHAR(255)
);

CREATE TABLE info_my_book_data (
    table_id INTEGER,
    book_id VARCHAR(255),
    word VARCHAR(255),
    answer VARCHAR(255),
    question_number INTEGER
);

CREATE TABLE info_notice (
    id INTEGER,
    title VARCHAR(255),
    date DATE,
    detail VARCHAR(255),
    account_type VARCHAR(255)
);

CREATE TABLE info_image (
    table_id INTEGER,
    img_id INTEGER,
    stamp_id VARCHAR(255),
    stamp_prob VARCHAR(255),
    img_extention VARCHAR(255),
    img_title VARCHAR(255),
    date_limit DATE,
    stamp_state VARCHAR(255)
);

CREATE TABLE info_stamp (
    id INTEGER,
    user_table_id INTEGER,
    director_table_id INTEGER,
    img_id INTEGER,
    stamp_id VARCHAR(255),
    get_date DATE
);

CREATE TABLE info_analysis {
    table_id INTEGER,
    log_code INTEGER,
    log_detail VARCHAR(255),
    log_date DATE
};

CREATE TABLE target_1400 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE target_1900 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE system_English {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE rapid_Reading {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE pass_3 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE pass_pre2 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE pass_2 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE pass_pre1 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE pass_1 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE gold_phrase {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE get_Through_2600 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE meiko_original_1 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE kobun300 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE kobun315 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE kobun330 {
    id INTEGER,
    word VARCHAR(255),
    answer VARCHAR(255)
};

CREATE TABLE Vintage {
    id INTEGER,
    word VARCHAR(255),
    select1 VARCHAR(255),
    select2 VARCHAR(255),
    select3 VARCHAR(255),
    select4 VARCHAR(255),
    answer VARCHAR(255),
    type INTEGER
};

CREATE TABLE meiko_original_2 {
    id INTEGER,
    word VARCHAR(255),
    select1 VARCHAR(255),
    select2 VARCHAR(255),
    select3 VARCHAR(255),
    select4 VARCHAR(255),
    answer VARCHAR(255),
    type INTEGER
};
