INSERT INTO myrooker_develDB.articles (id, title, timepost, category_id, company_id, views, link) VALUES (1, 'Career talk about the positions available at the company', '2019-06-28 12:07:43', 1, 2, 2, 'https://facebook.com');
INSERT INTO myrooker_develDB.articles (id, title, timepost, category_id, company_id, views, link) VALUES (2, 'Training workshop to introduce certain skills', '2019-06-28 12:11:27', 2, 6, 0, 'https://facebook.com');
INSERT INTO myrooker_develDB.events (id, title, image, price, timepost, location, event_date, details, company_id, category_id) VALUES (1, 'SAT Trial Exams', 'https://myrookery.com/img/sat.png', 20, '2018-06-28 12:27:19', 'Aikins Educational Consult', '2019-06-28 12:27:39', 'Take the SAT diagnostic test to find your score', 10, 1);
INSERT INTO myrooker_develDB.events (id, title, image, price, timepost, location, event_date, details, company_id, category_id) VALUES (2, 'Moot Court Trial', 'https://myrookery.com/img/moot.png', 0, '2019-01-28 12:30:04', 'Kempinski Hotel', '2019-06-28 13:30:18', 'Trial court to leverage your law skills', 2, 2);
INSERT INTO myrooker_develDB.discover (id, image_url, type, target_id, timepost) VALUES (4, 'dis1.png', 'task', 12, '2019-06-29 07:37:47');
INSERT INTO myrooker_develDB.discover (id, image_url, type, target_id, timepost) VALUES (5, 'dis2.png', 'company', 9, '2019-06-29 07:38:07');
INSERT INTO myrooker_develDB.discover (id, image_url, type, target_id, timepost) VALUES (6, 'dis3.png', 'rookie', null, '2019-06-29 07:38:19');
INSERT INTO myrooker_develDB.polls (id, title, company_id, timepost, options, start, end, status) VALUES (1, 'Would you buy data for Ghc10000', 1, '2019-06-28 12:50:13', '["Yes","No","None"]', '2019-06-14', '2019-06-29', '1');
INSERT INTO myrooker_develDB.polls (id, title, company_id, timepost, options, start, end, status) VALUES (2, 'How many times do you buy bundle a month?', 10, '2019-06-28 12:51:20', '["Daily", "Weekly"]', '2019-06-07', '2019-11-22', '1');
INSERT INTO myrooker_develDB.polls (id, title, company_id, timepost, options, start, end, status) VALUES (3, 'How are you doing', 12, '2019-06-28 13:13:08', '["Good", "Bad", "Find out"]', '2019-06-28', '2019-11-26', '0');
INSERT INTO myrooker_develDB.polls (id, title, company_id, timepost, options, start, end, status) VALUES (4, 'Last Poll Test', 2, '2019-06-29 06:30:56', '["a", "b", "c"]', '2019-06-29', '2019-06-30', '1');
INSERT INTO myrooker_develDB.videos (id, title, timepost, views, category_id, company_id, link) VALUES (1, 'Career talk about the positions available at the company', '2019-06-29 06:36:32', 2, 1, 4, 'https://www.youtube.com/watch?v=zfLcdBuB7NY&list=PLqtuzCJ-NAlb0mFcL9YfFlc3XHivFPzl8&index=15');
INSERT INTO myrooker_develDB.videos (id, title, timepost, views, category_id, company_id, link) VALUES (2, 'Training workshop to introduce certain skills', '2019-06-29 06:37:01', 30, 2, 9, 'https://www.youtube.com/watch?v=Z8agqyGIaD8&list=PLqtuzCJ-NAlb0mFcL9YfFlc3XHivFPzl8&index=16');
INSERT INTO myrooker_develDB.poll_results (id, poll_id, student_id, timepost, result) VALUES (1, 1, 745, '2019-06-28 12:56:08', 0);
INSERT INTO myrooker_develDB.poll_results (id, poll_id, student_id, timepost, result) VALUES (2, 1, 700, '2019-06-28 12:56:39', 0);
INSERT INTO myrooker_develDB.poll_results (id, poll_id, student_id, timepost, result) VALUES (3, 1, 614, '2019-06-28 12:56:52', 1);
INSERT INTO myrooker_develDB.poll_results (id, poll_id, student_id, timepost, result) VALUES (4, 2, 243, '2019-06-29 06:27:18', 1);
INSERT INTO myrooker_develDB.article_logs (id, article_id, student_id, timepost, interested, viewed) VALUES (1, 1, 745, '2019-06-28 12:09:27', 'yes', 1);
INSERT INTO myrooker_develDB.article_logs (id, article_id, student_id, timepost, interested, viewed) VALUES (2, 1, 645, '2019-06-28 12:10:20', 'no', 0);