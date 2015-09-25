-- δημιουργία certificate
insert into `certificate` (`id`, `course`, `author`, `title`, `created`) values (1, 1, 1, 'demo certificate', '2015-08-19 00:00:00');

-- απονέμεται στο χρήστη 2 το certificate
insert into `user_certificate` (`user`, `certificate`) values (2, 1);

-- κριτήρια certificate
-- το null στη στήλη resource σημαίνει εφαρμογή σε όλο το υποσύστημα και όχι για συγκεκριμένους πόρους, δηλαδή:
-- αν ο τελεστής συγκρίνει το threshold για έναν πόρο ή για όλους μέσα στο υποσύστημα κρίνεται από την απουσία ή μή τιμής στη στήλη resource
-- αν μέσα σε ένα υποσύστημα υπάρχουν πολλαπλοί πόροι, π.χ. για τα social bookmarks υπάρχουν τόσο τα likes όσο οι ίδιοι οι πόροι, αυτό θα 
-- το καταλαβάινει από τη στήλη module (id του υποσυστήματος) σε συνδιασμό με το string στη στήλη activity type. Για το παρακάτω παράδειγμα
-- στα social bookmarks, δεν είναι (ακόμα) γνωστό το module_id, οπότε κρίνει μόνο από το string activity_type

-- αριθμός κοινωνικών συνδέσμων στο μάθημα >= 10
-- εδώ πρέπει να συμπληρωθεί και το module id FK των Social Bookmarks
insert into `certificate_criterion` (`certificate`, `activity_type`, `threshold`, `operator`) values (1, 'social bookmarks', '10.0', 'get');

-- αριθμός likes στους κοινωνικούς συνδέσμους >= 20
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `threshold`, `operator`) values (1, 'social bookmark likes', 39, '20.0', 'get');

-- προβολή του εγγράφου με id 1
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`) values (1, 'document', 3, 1);

-- βαθμός στην εργασία με id 1 >= 8.5
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`, `threshold`, `operator`) values (1, 'assignment', 5, 1, '8.5', 'get');

-- βαθμός στην εργασία με id 2 = 10
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`, `threshold`, `operator`) values (1, 'assignment', 5, 2, '10.0', 'eq');

-- βαθμός στην άσκηση με id 1 >= 8.5
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`, `threshold`, `operator`) values (1, 'exercise', 10, 1, '8.5', 'get');

-- βαθμός στην άσκηση με id 2 = 10
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`, `threshold`, `operator`) values (1, 'exercise', 10, 2, '10.0', 'eq');

-- παρουσίες > 20
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `threshold`, `operator`) values (1, 'attendance', 30, '20.0', 'gt');

-- βαθμολόγιο >= 7
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `threshold`, `operator`) values (1, 'gradebook', 32, '7.0', 'get');

-- προβολή του πολυμέσου με id 1
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`) values (1, 'video', 4, 1);

-- πλήθος των posts στις συζητήσεις >= 5
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `threshold`, `operator`) values (1, 'forum', 9, '5.0', 'get');

-- πλήθος likes στα posts >= 20
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `threshold`, `operator`) values (1, 'forum likes', 39, '20.0', 'get');

-- προσπέλαση του ηλ. βιβλίου με id 1
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`) values (1, 'ebook', 18, 1);

-- απάντηση στο ερωτηματολόγιο με id 1
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`) values (1, 'questionnaire', 21, 1);

-- συμμετοχή στη γραμμή μάθησης με id 1 με ποσοστό >= 75%
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `resource`, `threshold`, `operator`) values (1, 'learning path', 23, 1, '75.0', 'get');

-- αριθμός δημιουργημένων σελίδων στο wiki >= 5
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `threshold`, `operator`) values (1, 'wiki', 26, '5.0', 'get');

-- πλήθος posts στο ιστολόγιο >= 10
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `threshold`, `operator`) values (1, 'blog', 37, '10.0', 'get');

-- πλήθος σχολίων σε όλα τα posts του χρήστη >= 15
insert into `certificate_criterion` (`certificate`, `activity_type`, `module`, `threshold`, `operator`) values (1, 'blog comments', 38, '15.0', 'get');

-- ο χρήστης με id 1 ικανοποιεί το κριτήριο certificate με id 1
-- insert into `user_certificate_criterion` (`user`, `certificate_criterion`) values (1, 1);
-- κ.ο.κ ...
