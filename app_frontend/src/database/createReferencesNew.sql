ALTER TABLE neosuniversity.tc_course
ADD  FOREIGN KEY (author_id)
REFERENCES neosuniversity.tc_author (id);

ALTER TABLE neosuniversity.tr_requirement_course
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tr_requirement_course
ADD  FOREIGN KEY (requirement_id)
REFERENCES neosuniversity.tc_requirement (id);

ALTER TABLE neosuniversity.tr_categ_course
ADD  FOREIGN KEY (category_id)
REFERENCES neosuniversity.tc_category (id);

ALTER TABLE neosuniversity.tr_categ_course
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tr_objective_course
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tr_objective_course
ADD  FOREIGN KEY (objective_id)
REFERENCES neosuniversity.tc_objective (id);

ALTER TABLE neosuniversity.tw_class
ADD  FOREIGN KEY (control_panel_id)
REFERENCES neosuniversity.tw_control_panel (id);

ALTER TABLE neosuniversity.tw_class
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tw_section
ADD  FOREIGN KEY (control_panel_id)
REFERENCES neosuniversity.tw_control_panel (id);

ALTER TABLE neosuniversity.tw_section
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tr_class
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tr_course_section
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);


ALTER TABLE neosuniversity.tw_control_panel
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tw_control_panel
ADD  FOREIGN KEY (username_id)
REFERENCES neosuniversity.tw_user (username);

ALTER TABLE neosuniversity.tw_user
ADD  FOREIGN KEY (country_id)
REFERENCES neosuniversity.tc_country (id);

/*is pending tw_control_panel*/
