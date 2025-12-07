SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE code_play_hub;

CREATE TABLE debug_attempts (
  id int NOT NULL,
  challenge_id int NOT NULL,
  user_id int NOT NULL,
  selected_lines varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  submitted_code text COLLATE utf8mb4_unicode_ci,
  is_correct tinyint(1) NOT NULL,
  response_time_seconds int DEFAULT NULL,
  submitted_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO debug_attempts (id, challenge_id, user_id, selected_lines, submitted_code, is_correct, response_time_seconds, submitted_at) VALUES
(1, 1, 1, '', NULL, 0, NULL, '2025-12-05 12:53:53'),
(2, 1, 1, '', NULL, 0, NULL, '2025-12-05 12:54:06'),
(3, 1, 1, '', NULL, 0, NULL, '2025-12-05 12:54:07'),
(4, 1, 1, '', NULL, 0, NULL, '2025-12-05 12:54:10'),
(5, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 10, '2025-12-05 12:54:35'),
(6, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 15, '2025-12-05 12:54:40'),
(7, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 45, '2025-12-05 12:55:10'),
(8, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 51, '2025-12-05 12:55:15'),
(9, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 52, '2025-12-05 12:55:16'),
(10, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 53, '2025-12-05 12:55:18'),
(11, 1, 1, '2', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 227, '2025-12-05 12:58:11'),
(12, 1, 1, '2', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 228, '2025-12-05 12:58:12'),
(13, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 5, '2025-12-05 13:03:00'),
(14, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 51, '2025-12-05 13:03:45'),
(15, 1, 1, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 52, '2025-12-05 13:03:46'),
(16, 1, 2, '3', NULL, 1, NULL, '2025-12-05 13:14:03'),
(17, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 10, '2025-12-05 19:58:16'),
(18, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 12, '2025-12-05 19:58:18'),
(19, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 13, '2025-12-05 19:58:19'),
(20, 1, 2, '2', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 682, '2025-12-05 20:09:29'),
(21, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 8, '2025-12-05 20:11:00'),
(22, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7
', 0, 15, '2025-12-05 20:11:07'),
(23, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 4, '2025-12-05 20:48:40'),
(24, 1, 2, '2', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 18, '2025-12-05 20:48:53'),
(25, 1, 2, '2', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 19, '2025-12-05 20:48:54'),
(26, 1, 2, '2', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 20, '2025-12-05 20:48:55'),
(27, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 45, '2025-12-05 20:49:20'),
(28, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 80, '2025-12-05 20:49:55'),
(29, 1, 2, '4', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 212, '2025-12-05 20:52:07'),
(30, 1, 2, '1', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 218, '2025-12-05 20:52:13'),
(31, 1, 2, '2', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 5, '2025-12-05 20:52:23'),
(32, 1, 2, '4', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 12, '2025-12-05 20:52:30'),
(33, 1, 2, '5', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 17, '2025-12-05 20:52:35'),
(34, 1, 2, '6', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 24, '2025-12-05 20:52:42'),
(35, 1, 2, '7', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 30, '2025-12-05 20:52:48'),
(36, 1, 2, '', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i <= n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 86, '2025-12-05 20:54:15'),
(37, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i < n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 143, '2025-12-05 20:55:13'),
(38, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i < n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 144, '2025-12-05 20:55:14'),
(39, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i < n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 145, '2025-12-05 20:55:15'),
(40, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i < n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 146, '2025-12-05 20:55:16'),
(41, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i < n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 147, '2025-12-05 20:55:17'),
(42, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i < n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 147, '2025-12-05 20:55:17'),
(43, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i < n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 147, '2025-12-05 20:55:17'),
(44, 1, 2, '3', 'int sum_array(const int *arr, int n) {        // 1
    int sum = 0;                              // 2
    for (int i = 0; i < n; i++) {            // 3
        sum += arr[i];                        // 4
    }                                         // 5
    return sum;                               // 6
}                                             // 7', 0, 147, '2025-12-05 20:55:17'),
(45, 1, 2, '3', 'int sum_array(const int *arr, int n) {        
    int sum = 0;                              
    for (int i = 0; i < n; i++) {            
        sum += arr[i];                        
    }                                         
    return sum;                               
}', 0, 238, '2025-12-05 20:56:48'),
(46, 1, 2, '3', 'int sum_array(const int *arr, int n) {        
    int sum = 0;                              
    for (int i = 0; i < n; i++) {            
        sum += arr[i];                        
    }                                         
    return sum;                               
}', 0, 239, '2025-12-05 20:56:49'),
(47, 1, 2, '3', 'int sum_array(const int *arr, int n) {
    int sum = 0;
    for (int i = 0; i < n; i++) {  
        sum += arr[i];           
    }
    return sum;
}', 0, 293, '2025-12-05 20:57:42'),
(48, 1, 2, '3', 'int sum_array(const int *arr, int n) {
    int sum = 0;
    for (int i = 0; i < n; i++) {  
        sum += arr[i];           
    }
    return sum;
}', 0, 293, '2025-12-05 20:57:43'),
(49, 1, 2, '3', 'int sum_array(const int *arr, int n) {
    int sum = 0;
    for (int i = 0; i < n; i++) {  
        sum += arr[i];           
    }
    return sum;
}', 0, 709, '2025-12-05 21:04:39'),
(50, 1, 2, '3', NULL, 1, 4, '2025-12-05 21:07:34'),
(51, 1, 2, '2', NULL, 0, 14, '2025-12-05 21:07:44'),
(52, 1, 2, '3', NULL, 1, 6, '2025-12-05 21:10:08'),
(53, 1, 2, '3', NULL, 1, 5, '2025-12-05 21:10:25'),
(54, 2, 1, '2', NULL, 1, 5, '2025-12-05 21:15:53'),
(55, 4, 1, '4', NULL, 1, 8, '2025-12-05 21:23:16'),
(56, 4, 1, '4', NULL, 1, 9, '2025-12-05 21:23:18'),
(57, 4, 1, '4', NULL, 1, 16, '2025-12-05 21:23:38'),
(58, 6, 1, '9,14', NULL, 0, NULL, '2025-12-05 21:29:46'),
(59, 6, 1, '', NULL, 0, NULL, '2025-12-05 21:30:18'),
(60, 7, 1, '2,9', NULL, 1, NULL, '2025-12-05 21:33:06'),
(61, 10, 1, '8,9', NULL, 0, NULL, '2025-12-05 21:42:49'),
(62, 12, 1, '9,10', NULL, 1, NULL, '2025-12-05 21:52:19'),
(63, 14, 1, '4', NULL, 1, NULL, '2025-12-05 21:58:52');

CREATE TABLE debug_challenges (
  id int NOT NULL,
  title varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  description text COLLATE utf8mb4_unicode_ci NOT NULL,
  language enum('C','Python','Pseudocode') COLLATE utf8mb4_unicode_ci NOT NULL,
  difficulty enum('easy','medium','hard') COLLATE utf8mb4_unicode_ci NOT NULL,
  code text COLLATE utf8mb4_unicode_ci NOT NULL,
  fixed_code text COLLATE utf8mb4_unicode_ci NOT NULL,
  correct_lines varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  explanation text COLLATE utf8mb4_unicode_ci NOT NULL,
  is_active tinyint(1) NOT NULL DEFAULT '1',
  created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created_by int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO debug_challenges (id, title, description, language, difficulty, code, fixed_code, correct_lines, explanation, is_active, created_at, created_by) VALUES
(1, 'Sum array with wrong bound', 'The function should return the sum of all elements in the array, but sometimes reads outside the array and crashes.', 'C', 'easy', 'int sum_array(const int *arr, int n) {        // 1\r\n    int sum = 0;                              // 2\r\n    for (int i = 0; i <= n; i++) {            // 3\r\n        sum += arr[i];                        // 4\r\n    }                                         // 5\r\n    return sum;                               // 6\r\n}                                             // 7\r\n', 'int sum_array(const int *arr, int n) {\r\n    int sum = 0;\r\n    for (int i = 0; i < n; i++) {\r\n        sum += arr[i];\r\n    }\r\n    return sum;\r\n}\r\n', '3', 'The loop condition uses i <= n, which accesses arr[n], one element past the last valid index (n - 1). This results in out-of-bounds memory access and undefined behavior. The correct bound is i < n.', 1, '2025-12-05 12:53:43', 1),
(2, 'Average of two ints (precision lost)', 'The function should return the average of two integers as double, but it always returns a rounded value.', 'C', 'easy', 'double average_two(int a, int b) {            // 1\r\n    double avg = (a + b) / 2;                 // 2\r\n    return avg;                               // 3\r\n}                                             // 4\r\n', 'double average_two(int a, int b) {\r\n    double avg = (a + b) / 2.0;\r\n    return avg;\r\n}\r\n', '2', 'The expression (a + b) / 2 performs integer division because both operands are integers. The fractional part is lost before assigning to a double. Changing 2 to 2.0 forces floating-point division and preserves precision.', 1, '2025-12-05 21:15:21', 1),
(3, 'Copy string without terminator', 'The function copies characters from src to dst, but printed strings have trash characters at the end.', 'C', 'easy', 'void copy_str(char *dst, const char *src) {   // 1\r\n    int i = 0;                                // 2\r\n    while (src[i] != ''\\0'') {                  // 3\r\n        dst[i] = src[i];                      // 4\r\n        i++;                                  // 5\r\n    }                                         // 6\r\n}                                             // 7\r\n', 'void copy_str(char *dst, const char *src) {\r\n    int i = 0;\r\n    while (src[i] != ''\\0'') {\r\n        dst[i] = src[i];\r\n        i++;\r\n    }\r\n    dst[i] = ''\\0'';\r\n}\r\n', '7', 'The loop copies characters from src to dst, but never writes the terminating ''\\0''. As a result, functions such as printf read past the buffer and print garbage. A null terminator must be added after the loop.', 1, '2025-12-05 21:18:54', 1),
(4, 'Find minimum using wrong comparison', 'This function is supposed to find the minimum, but always returns the largest value.', 'C', 'easy', 'int find_min(const int *arr, int n) {         // 1\r\n    int min = arr[0];                         // 2\r\n    for (int i = 1; i < n; i++) {             // 3\r\n        if (arr[i] > min) {                   // 4\r\n            min = arr[i];                     // 5\r\n        }                                     // 6\r\n    }                                         // 7\r\n    return min;                               // 8\r\n}                                             // 9\r\n', 'int find_min(const int *arr, int n) {\r\n    int min = arr[0];\r\n    for (int i = 1; i < n; i++) {\r\n        if (arr[i] < min) {\r\n            min = arr[i];\r\n        }\r\n    }\r\n    return min;\r\n}\r\n', '4', 'The comparison uses arr[i] > min, which updates the value when a larger element is found. This finds the maximum, not the minimum. The comparison must be reversed to arr[i] < min.', 1, '2025-12-05 21:23:01', 1),
(5, 'Print double with wrong format specifier', 'The program prints nonsense for pi, although the value looks correct.', 'C', 'easy', '#include <stdio.h>                            // 1\r\n\r\nint main(void) {                              // 2\r\n    double pi = 3.14159;                      // 3\r\n    printf(\"Pi = %d\\n\", pi);                  // 4\r\n    return 0;                                 // 5\r\n}                                             // 6\r\n', '#include <stdio.h>\r\n\r\nint main(void) {\r\n    double pi = 3.14159;\r\n    printf(\"Pi = %.2f\\n\", pi);\r\n    return 0;\r\n}\r\n', '4', '%d expects an int, but a double is being passed. Using the wrong format specifier produces undefined behavior and incorrect output. For double, the correct specifier is %f (e.g., %.2f).', 1, '2025-12-05 21:25:54', 1),
(6, 'Leak when early-returning', 'The function loads integers, computes sum and average, then prints them. In error paths it leaks memory.', 'C', 'medium', '#include <stdio.h>                            // 1\r\n#include <stdlib.h>                           // 2\r\n\r\nvoid process(int n) {                         // 3\r\n    int *data = malloc(n * sizeof(int));      // 4\r\n    if (!data) {                              // 5\r\n        fprintf(stderr, \"alloc failed\\n\");    // 6\r\n        return;                               // 7\r\n    }                                         // 8\r\n\r\n    for (int i = 0; i < n; i++) {             // 9\r\n        if (scanf(\"%d\", &data[i]) != 1) {     // 10\r\n            fprintf(stderr, \"input error\\n\"); // 11\r\n            return;                           // 12\r\n        }                                     // 13\r\n    }                                         // 14\r\n\r\n    long long sum = 0;                        // 15\r\n    for (int i = 0; i < n; i++) {             // 16\r\n        sum += data[i];                       // 17\r\n    }                                         // 18\r\n\r\n    double avg = (double)sum / n;             // 19\r\n    printf(\"avg = %f\\n\", avg);                // 20\r\n    free(data);                               // 21\r\n}                                             // 22\r\n', '#include <stdio.h>\r\n#include <stdlib.h>\r\n\r\nvoid process(int n) {\r\n    int *data = malloc(n * sizeof(int));\r\n    if (!data) {\r\n        fprintf(stderr, \"alloc failed\\n\");\r\n        return;\r\n    }\r\n\r\n    for (int i = 0; i < n; i++) {\r\n        if (scanf(\"%d\", &data[i]) != 1) {\r\n            fprintf(stderr, \"input error\\n\");\r\n            free(data);\r\n            return;\r\n        }\r\n    }\r\n\r\n    long long sum = 0;\r\n    for (int i = 0; i < n; i++) {\r\n        sum += data[i];\r\n    }\r\n\r\n    double avg = (double)sum / n;\r\n    printf(\"avg = %f\\n\", avg);\r\n    free(data);\r\n}\r\n', '12', 'If input parsing fails inside the loop, the function returns immediately without freeing the allocated buffer. This causes a memory leak. Before returning on an error path, the buffer must be freed', 1, '2025-12-05 21:29:24', 1),
(7, 'Max of two with uninitialized result', 'Sometimes this function returns a random value, depending on inputs.', 'C', 'medium', 'int max_if(int a, int b) {                    // 1\r\n    int result;                               // 2\r\n    if (a > b) {                              // 3\r\n        result = a;                           // 4\r\n    }                                         // 5\r\n    else if (b > a) {                         // 6\r\n        result = b;                           // 7\r\n    }                                         // 8\r\n    return result;                            // 9\r\n}                                             // 10\r\n', 'int max_if(int a, int b) {\r\n    int result;\r\n    if (a > b) {\r\n        result = a;\r\n    } else {\r\n        result = b;\r\n    }\r\n    return result;\r\n}\r\n', '2, 9', 'If a == b, neither if branch initializes result, yet the function still returns it. Reading an uninitialized variable is undefined behavior. The else branch must assign a value for the equality case.', 1, '2025-12-05 21:32:57', 1),
(8, 'Realloc and lost pointer', 'The function tries to grow a buffer, but when realloc fails, the original buffer is lost and memory leaks or access crashes.', 'C', 'medium', '#include <stdlib.h>                           // 1\r\n\r\nint *grow_array(int *arr, int new_size) {     // 2\r\n    arr = realloc(arr, new_size * sizeof(int)); // 3\r\n    if (!arr) {                               // 4\r\n        return NULL;                          // 5\r\n    }                                         // 6\r\n    for (int i = 0; i < new_size; i++) {      // 7\r\n        if (arr[i] < 0) arr[i] = 0;           // 8\r\n    }                                         // 9\r\n    return arr;                               // 10\r\n}                                             // 11\r\n', '#include <stdlib.h>\r\n\r\nint *grow_array(int *arr, int new_size) {\r\n    int *tmp = realloc(arr, new_size * sizeof(int));\r\n    if (!tmp) {\r\n        return arr;\r\n    }\r\n    for (int i = 0; i < new_size; i++) {\r\n        if (tmp[i] < 0) tmp[i] = 0;\r\n    }\r\n    return tmp;\r\n}\r\n', '3, 4, 5', 'Assigning arr = realloc(arr, ...) directly can lose the original pointer if realloc fails and returns NULL. This leads to memory leaks and invalid access. A temporary pointer must be used to ensure that the original memory is preserved on failure.', 1, '2025-12-05 21:37:30', 1),
(9, 'Binary search off-by-one bug', 'Sometimes the function loops forever for certain sorted arrays.', 'C', 'medium', 'int bin_search(const int *a, int n, int key) { // 1\r\n    int lo = 0;                                // 2\r\n    int hi = n - 1;                            // 3\r\n    while (lo < hi) {                          // 4\r\n        int mid = (lo + hi) / 2;               // 5\r\n        if (a[mid] == key) {                   // 6\r\n            return mid;                        // 7\r\n        } else if (a[mid] < key) {             // 8\r\n            lo = mid;                          // 9\r\n        } else {                               // 10\r\n            hi = mid;                          // 11\r\n        }                                      // 12\r\n    }                                          // 13\r\n    return -1;                                 // 14\r\n}                                              // 15\r\n', 'int bin_search(const int *a, int n, int key) {\r\n    int lo = 0;\r\n    int hi = n - 1;\r\n    while (lo <= hi) {\r\n        int mid = lo + (hi - lo) / 2;\r\n        if (a[mid] == key) {\r\n            return mid;\r\n        } else if (a[mid] < key) {\r\n            lo = mid + 1;\r\n        } else {\r\n            hi = mid - 1;\r\n        }\r\n    }\r\n    return -1;\r\n}\r\n', '4, 5, 9, 11', 'Using lo = mid and hi = mid does not remove mid from the search range. For certain inputs, the interval never shrinks, causing an infinite loop. The correct update is mid + 1 or mid - 1, and the loop condition must be lo <= hi.', 1, '2025-12-05 21:40:24', 1),
(10, 'Print after free', 'The function frees a buffer and then tries to print its contents in a helper function.', 'C', 'medium', '#include <stdio.h>                            // 1\r\n#include <stdlib.h>                           // 2\r\n\r\nstatic void print_buffer(const char *buf) {   // 3\r\n    printf(\"%s\\n\", buf);                      // 4\r\n}                                             // 5\r\n\r\nvoid demo(void) {                             // 6\r\n    char *buf = malloc(32);                   // 7\r\n    if (!buf) return;                         // 8\r\n\r\n    snprintf(buf, 32, \"Hello world\");         // 9\r\n    free(buf);                                // 10\r\n    print_buffer(buf);                        // 11\r\n}                                             // 12\r\n', '#include <stdio.h>\r\n#include <stdlib.h>\r\n\r\nstatic void print_buffer(const char *buf) {\r\n    printf(\"%s\\n\", buf);\r\n}\r\n\r\nvoid demo(void) {\r\n    char *buf = malloc(32);\r\n    if (!buf) return;\r\n\r\n    snprintf(buf, 32, \"Hello world\");\r\n    print_buffer(buf);\r\n    free(buf);\r\n}\r\n', '10, 11', 'The function frees buf and immediately passes it to print_buffer(). Accessing freed memory is undefined behavior and can crash. The buffer must be used before free, not after.', 1, '2025-12-05 21:42:38', 1),
(11, 'snprintf off-by-one overflow', 'The function attempts to append a suffix to a string using snprintf, but for certain buffer sizes it overwrites one byte past the end of the buffer.', 'C', 'hard', '#include <stdio.h>                            // 1\r\n#include <string.h>                           // 2\r\n\r\nvoid append_suffix(char *buf, size_t bufsize) { // 3\r\n    const char *suffix = \"_done\";             // 4\r\n    size_t len = strlen(buf);                 // 5\r\n\r\n    if (len > bufsize) {                      // 6\r\n        return;                               // 7\r\n    }                                         // 8\r\n\r\n    size_t remaining = bufsize - len;         // 9\r\n    snprintf(buf + len, remaining, \"%s\", suffix); // 10\r\n}                                             // 11\r\n', '#include <stdio.h>\r\n#include <string.h>\r\n\r\nvoid append_suffix(char *buf, size_t bufsize) {\r\n    const char *suffix = \"_done\";\r\n    size_t len = strlen(buf);\r\n\r\n    if (len >= bufsize) {\r\n        return;\r\n    }\r\n\r\n    size_t remaining = bufsize - len;\r\n    if (remaining == 0) {\r\n        return;\r\n    }\r\n\r\n    snprintf(buf + len, remaining, \"%s\", suffix);\r\n}\r\n', '6, 9, 10', 'The check if (len > bufsize) is incorrect: if len == bufsize, there is no room left even for the null terminator. This allows the function to compute remaining = 0 and pass it to snprintf, which then writes out of bounds. Buffer size must always reserve at least one byte for ''\\0''.', 1, '2025-12-05 21:47:05', 1),
(12, 'Realloc with stale pointer arithmetic', 'The function grows a dynamic array and appends new values, but sometimes it corrupts the existing elements.', 'C', 'hard', '#include <stdlib.h>                           // 1\r\n\r\nint push_back(int **arr, int *size, int value) { // 2\r\n    int new_size = *size + 1;                 // 3\r\n    int *ptr = realloc(*arr, new_size * sizeof(int)); // 4\r\n    if (!ptr) {                               // 5\r\n        return -1;                            // 6\r\n    }                                         // 7\r\n\r\n    *arr = ptr;                               // 8\r\n    int *end = *arr + *size;                  // 9\r\n    *end = value;                             // 10\r\n    return 0;                                 // 11\r\n}                                             // 12\r\n', '#include <stdlib.h>\r\n\r\nint push_back(int **arr, int *size, int value) {\r\n    int new_size = *size + 1;\r\n    int *ptr = realloc(*arr, new_size * sizeof(int));\r\n    if (!ptr) {\r\n        return -1;\r\n    }\r\n\r\n    *arr = ptr;\r\n    (*arr)[*size] = value;\r\n    *size = new_size;\r\n    return 0;\r\n}\r\n', '9, 10', 'The index for the new element is derived from *size before it is updated. More importantly, using *arr + *size is ambiguous and may refer to the old layout before realloc. The safe version explicitly writes (*arr)[*size] = value; and updates *size afterward to keep indices consistent.', 1, '2025-12-05 21:50:48', 1),
(13, 'Recursive max with broken base', 'The function finds the maximum of an array recursively, but for certain input sizes it causes a stack overflow (infinite recursion).', 'C', 'hard', 'int max_rec(const int *arr, int left, int right) { // 1\r\n    if (left == right) {                     // 2\r\n        return arr[left];                    // 3\r\n    }                                        // 4\r\n    int mid = (left + right) / 2;            // 5\r\n    int a = max_rec(arr, left, mid);         // 6\r\n    int b = max_rec(arr, mid, right);        // 7\r\n    return a > b ? a : b;                    // 8\r\n}                                            // 9\r\n', 'int max_rec(const int *arr, int left, int right) {\r\n    if (left == right) {\r\n        return arr[left];\r\n    }\r\n    int mid = left + (right - left) / 2;\r\n    int a = max_rec(arr, left, mid);\r\n    int b = max_rec(arr, mid + 1, right);\r\n    return a > b ? a : b;\r\n}\r\n', '5, 7', 'The right recursive call uses [mid, right] instead of [mid + 1, right]. For intervals of size two, mid repeats in both recursive branches, preventing the range from shrinking. This creates infinite recursion and eventually stack overflow.', 1, '2025-12-05 21:55:33', 1),
(14, 'Signed/unsigned mix causing infinite loop', 'The loop is supposed to iterate from i = n-1 down to 0, but for small values of n it either gets stuck in an infinite loop or reads out of bounds.', 'C', 'hard', '#include <stddef.h>                           // 1\r\n\r\nint count_nonzero(const int *arr, size_t n) { // 2\r\n    int count = 0;                            // 3\r\n    for (int i = n - 1; i >= 0; i--) {        // 4\r\n        if (arr[i] != 0) {                    // 5\r\n            count++;                          // 6\r\n        }                                     // 7\r\n    }                                         // 8\r\n    return count;                             // 9\r\n}                                             // 10\r\n', '#include <stddef.h>\r\n\r\nint count_nonzero(const int *arr, size_t n) {\r\n    int count = 0;\r\n    if (n == 0) return 0;\r\n    for (size_t i = n; i-- > 0; ) {\r\n        if (arr[i] != 0) {\r\n            count++;\r\n        }\r\n    }\r\n    return count;\r\n}\r\n', '4', 'The loop initializes i with n - 1, where n is size_t (unsigned). Casting between signed and unsigned types, combined with the condition i >= 0, causes unexpected wrap-around behavior. The loop never terminates for some values. Using a purely unsigned decrement idiom (size_t i = n; i-- > 0;) avoids the undefined mixing.', 1, '2025-12-05 21:58:44', 1),
(15, 'Join strings into buffer (overflow)', 'The function concatenates several words into a single buffer with spaces, but for certain combinations of lengths it writes out of bounds.', 'C', 'hard', '#include <string.h>                           // 1\r\n\r\nvoid join_words(char *out, size_t out_size,   // 2\r\n                const char **words, int count) { // 3\r\n    size_t pos = 0;                           // 4\r\n    for (int i = 0; i < count; i++) {         // 5\r\n        size_t len = strlen(words[i]);        // 6\r\n        if (pos + len <= out_size) {          // 7\r\n            memcpy(out + pos, words[i], len); // 8\r\n            pos += len;                       // 9\r\n        }                                     // 10\r\n        if (i + 1 < count && pos + 1 <= out_size) { // 11\r\n            out[pos] = '' '';                   // 12\r\n            pos++;                            // 13\r\n        }                                     // 14\r\n    }                                         // 15\r\n    out[pos] = ''\\0'';                          // 16\r\n}                                             // 17\r\n', '#include <string.h>\r\n\r\nvoid join_words(char *out, size_t out_size,\r\n                const char **words, int count) {\r\n    if (out_size == 0) {\r\n        return;\r\n    }\r\n    size_t pos = 0;\r\n    for (int i = 0; i < count && pos + 1 < out_size; i++) {\r\n        const char *w = words[i];\r\n        size_t len = strlen(w);\r\n\r\n        if (len > out_size - 1 - pos) {\r\n            len = out_size - 1 - pos;\r\n        }\r\n\r\n        memcpy(out + pos, w, len);\r\n        pos += len;\r\n\r\n        if (i + 1 < count && pos + 1 < out_size) {\r\n            out[pos++] = '' '';\r\n        }\r\n    }\r\n    out[pos] = ''\\0'';\r\n}\r\n', '7, 8, 11, 16', 'The conditions check pos + len <= out_size, which allows writing at index out[pos + len] == out[out_size]. The null terminator is not guaranteed to fit. This creates subtle one-byte buffer overflows. The correct logic must ensure space for ''\\0'' and verify bounds using < out_size - 1.', 1, '2025-12-05 22:01:51', 1);


CREATE TABLE debug_challenge_tags (
  challenge_id int NOT NULL,
  tag_id int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO debug_challenge_tags (challenge_id, tag_id) VALUES
(1, 21),
(4, 21),
(1, 22),
(4, 22),
(14, 22),
(1, 23),
(9, 23),
(13, 23),
(2, 24),
(2, 25),
(14, 25),
(2, 26),
(3, 27),
(11, 27),
(15, 27),
(3, 28),
(6, 28),
(8, 28),
(10, 28),
(3, 29),
(7, 30),
(4, 31),
(5, 32),
(5, 33),
(5, 34),
(6, 35),
(6, 36),
(6, 37),
(8, 37),
(7, 38),
(8, 39),
(12, 39),
(9, 40),
(9, 41),
(10, 42),
(11, 43),
(11, 44),
(15, 44),
(10, 45),
(12, 45),
(12, 46),
(13, 47),
(13, 48),
(14, 49),
(15, 50);


CREATE TABLE debug_tags (
  id int NOT NULL,
  name varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO debug_tags (id, name) VALUES
(40, 'algorithms'),
(21, 'arrays'),
(41, 'binary-search'),
(50, 'bounds-checking'),
(44, 'buffer-overflow'),
(31, 'conditions'),
(48, 'divide-and-conquer'),
(46, 'dynamic-array'),
(37, 'error-handling'),
(34, 'format-string'),
(26, 'integer-division'),
(32, 'io'),
(36, 'leak'),
(30, 'logic'),
(22, 'loops'),
(35, 'malloc'),
(24, 'math'),
(28, 'memory'),
(29, 'null-terminator'),
(23, 'off-by-one'),
(45, 'pointers'),
(33, 'printf'),
(39, 'realloc'),
(47, 'recursion'),
(49, 'signed-unsigned'),
(43, 'snprintf'),
(27, 'strings'),
(25, 'types'),
(38, 'uninitialized-variable'),
(42, 'use-after-free');



CREATE TABLE games (
  id int NOT NULL,
  code varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  name varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  description text COLLATE utf8mb4_unicode_ci,
  is_active tinyint(1) NOT NULL DEFAULT '1',
  created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO games (id, code, name, description, is_active, created_at) VALUES
(1, 'reaction_time', 'Reaction Time', 'Test how fast you can react to a color change.', 1, '2025-12-05 00:51:36'),
(2, 'memory_match', 'Memory Match', 'Flip cards and find matching pairs as fast as you can.', 1, '2025-12-05 00:51:36'),
(3, 'typing_speed', 'Typing Speed', 'Type the shown text as fast and as accurately as possible.', 1, '2025-12-05 00:51:36'),
(4, 'number_guess', 'Number Guess', 'Guess a random number in as few tries as possible.', 1, '2025-12-05 00:51:36'),
(5, 'focus_click', 'Focus Click', 'Click on highlighted targets while ignoring distractions.', 1, '2025-12-05 00:51:36');


CREATE TABLE game_sessions (
  id int NOT NULL,
  user_id int NOT NULL,
  game_id int NOT NULL,
  score int NOT NULL,
  duration_seconds int DEFAULT NULL,
  started_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  finished_at datetime DEFAULT NULL,
  details text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO game_sessions (id, user_id, game_id, score, duration_seconds, started_at, finished_at, details) VALUES
(1, 1, 1, -422, 0, '2025-12-05 00:52:01', '2025-12-05 00:52:01', 'reaction_ms=422'),
(2, 1, 1, -305, 0, '2025-12-05 00:52:09', '2025-12-05 00:52:09', 'reaction_ms=305'),
(3, 1, 1, -349, 0, '2025-12-05 00:52:42', '2025-12-05 00:52:42', 'reaction_ms=349'),
(4, 1, 1, -366, 0, '2025-12-05 00:52:48', '2025-12-05 00:52:48', 'reaction_ms=366'),
(5, 2, 2, 60, NULL, '2025-12-05 00:58:20', '2025-12-05 00:58:20', 'moves=16'),
(6, 2, 3, 23, 3, '2025-12-05 00:58:49', '2025-12-05 00:58:49', 'correct_chars=1'),
(7, 2, 5, 20, NULL, '2025-12-05 00:59:44', '2025-12-05 00:59:44', 'rounds=20');


CREATE TABLE users (
  id int NOT NULL,
  name varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  username varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  email varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  password_hash varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  role enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO users (id, name, username, email, password_hash, role, created_at, last_login) VALUES
(1, 'Gresa', 'gresahasani', 'gresahasani@gmail.com', '$2y$10$f00LHofwmyFKvXDhfY1ANe9lIRCNFVzB2YuUDhKDZtoHTatLpykJ.', 'admin', '2025-12-05 00:12:35', '2025-12-05 21:11:14'),
(2, 'Hera', 'herakurti', 'herakurti@gmail.com', '$2y$10$eiD4hGtYpZDEM2PV02HfuuqxPzhOjju/dmkP2DMpl2kdvyWXYwQ5C', 'user', '2025-12-05 00:29:24', '2025-12-05 13:13:41');


ALTER TABLE debug_attempts
  ADD PRIMARY KEY (id),
  ADD KEY idx_debug_attempts_user (user_id),
  ADD KEY idx_debug_attempts_challenge (challenge_id),
  ADD KEY idx_debug_attempts_correct (is_correct);


ALTER TABLE debug_challenges
  ADD PRIMARY KEY (id),
  ADD KEY fk_debug_challenges_user (created_by),
  ADD KEY idx_debug_challenges_language (language),
  ADD KEY idx_debug_challenges_difficulty (difficulty),
  ADD KEY idx_debug_challenges_is_active (is_active);


ALTER TABLE debug_challenge_tags
  ADD PRIMARY KEY (challenge_id, tag_id),
  ADD KEY idx_dct_tag (tag_id);


ALTER TABLE debug_tags
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY name (name);


ALTER TABLE games
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY code (code);


ALTER TABLE game_sessions
  ADD PRIMARY KEY (id),
  ADD KEY idx_game_sessions_user (user_id),
  ADD KEY idx_game_sessions_game (game_id);


ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY username (username),
  ADD UNIQUE KEY email (email);


ALTER TABLE debug_attempts
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;


ALTER TABLE debug_challenges
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;


ALTER TABLE debug_tags
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;


ALTER TABLE games
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE game_sessions
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE users
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE debug_attempts
  ADD CONSTRAINT fk_debug_attempts_challenge FOREIGN KEY (challenge_id) REFERENCES debug_challenges (id) ON DELETE CASCADE,
  ADD CONSTRAINT fk_debug_attempts_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE;


ALTER TABLE debug_challenges
  ADD CONSTRAINT fk_debug_challenges_user FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL;


ALTER TABLE debug_challenge_tags
  ADD CONSTRAINT fk_dct_challenge FOREIGN KEY (challenge_id) REFERENCES debug_challenges (id) ON DELETE CASCADE,
  ADD CONSTRAINT fk_dct_tag FOREIGN KEY (tag_id) REFERENCES debug_tags (id) ON DELETE CASCADE;


ALTER TABLE game_sessions
  ADD CONSTRAINT fk_game_sessions_game FOREIGN KEY (game_id) REFERENCES games (id) ON DELETE CASCADE,
  ADD CONSTRAINT fk_game_sessions_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE;
COMMIT;


