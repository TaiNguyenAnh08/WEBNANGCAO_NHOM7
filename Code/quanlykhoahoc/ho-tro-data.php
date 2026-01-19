<?php

/*
HỖ TRỢ QUẢN LÝ KHÓA HỌC

Users: gộp student với quản lý cho tiện
- id INT primary key
- fullname varchar 200
- email varchar 100
- phone varchar 50
- address varchar 500
- forget_token varchar 500
- active_token varchar 500
- status int (0,1): phân biệt đã kích hoạt tài khoản hay chưa (1: đã kích hoạt, 0: chưa)
- permission text: id khóa học
- group_id int -> bảng Groups
- created_at datetime
- updated_at datetime



Token_login: quản lý đăng nhập
- id int primary key
- user_id int  :kiểm tra tài khoản đăng nhập hay không ->bảng users
- token varchar 200
- created_at datetime
- updated_at datetime

Course: bảng khóa học
- id int primary key
- name varchar 100
- slug varchar 100 đường dẫn khóa học
- category_id INT -> bảng Course_category
- description text
- price INT
- thumbnail varchar 200
- created_at datetime
- updated_at datetime


Course_category: lĩnh vực
- id int primary key
- name varchar 100
- slug varchar 100 (đường dẫn khóa học)
- created_at datetime
- updated_at datetime


//Permission: phân quyền truy cập khóa học của user 

Groups: phân quyền admin, user
- id int primary key
- name varchar 100
- created_at datetime
- updated_at datetime



*/