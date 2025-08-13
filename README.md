# 🎂 Birthday Buddy - A PHP Birthday Reminder Application

Birthday Buddy is a secure, multi-user web application built with PHP and MySQL. It provides a simple and elegant interface for users to manage a personal list of birthdays and receive timely notifications so they never miss an important day.

* **Live Demo:** http://birthday-buddy.free.nf
* **Created by:** Ayush Sharma

![image](birthday-cake.png)
*(Feel free to replace the image above with a screenshot of your application's dashboard)*

---

## ✨ Core Features

* **Secure User Authentication**:
    * Users can create a unique account through the registration page.
    * Passwords are securely hashed using the `password_hash` function.
    * A robust login system verifies credentials using `password_verify`.

* **Reminder Management (CRUD)**:
    * **Create**: Users can add new birthday reminders with a name and date of birth. The form uses a jQuery UI datepicker for easy date selection.
    * **Read**: All upcoming birthdays are displayed on a central dashboard, sorted by the soonest date. A separate page lists all reminders in a table.
    * **Delete**: Users can delete their own reminders, with security checks to prevent deleting reminders owned by other accounts.

* **Dual Notification System**:
    * **In-Page Notifications**: The navigation bar automatically displays a prominent card on the homepage if a contact has a birthday on the current day.
    * **Desktop Push Notifications**: The application uses the browser's Notification API to send native desktop notifications, checking for birthdays every hour. This is powered by a `check_birthdays.php` backend script that provides the necessary data.

---

## 🛠️ Tech Stack

* **Backend**: PHP
* **Database**: MySQL
* **Frontend**:
    * HTML5
    * CSS3 (with custom styles in `style.css`)
    * JavaScript (ES6)
* **Libraries**:
    * Bootstrap 4
    * jQuery & jQuery UI
    * Font Awesome
    * Google Fonts (Poppins)

---

## 🚀 Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

* A local web server environment (e.g., XAMPP, WAMP)
* PHP
* MySQL Database

### Installation

1.  Clone the repository to your local machine:
    ```bash
    git clone [https://github.com/](https://github.com/)[your-username]/[your-repo-name].git
    ```
2.  Navigate to your web server's root directory (e.g., `htdocs` in XAMPP) and place the cloned folder there.
3.  Import the database schema by importing the `db_birthday_reminder.sql` file into your MySQL database through a tool like phpMyAdmin. This will create the `accounts` and `users` tables.
4.  Create a `config.php` file in the project's root directory by copying the contents of `config.php.example`.
5.  Open `config.php` and enter your local database credentials (username, password).
6.  Launch your local web server and navigate to the project directory in your browser.

---

## 📂 File Structure

A brief overview of the key files in the project:

| File                  | Description                                                                                                                              |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| `index.php`           | Handles user login and authentication.                                                                                         |
| `register.php`        | The user registration page.                                                                                                   |
| `home.php`            | The main dashboard page that displays upcoming birthday cards.                                                                 |
| `add_reminder.php`    | Page to add a new reminder and view all existing reminders in a table.                                                         |
| `delete_reminder.php` | Server-side script to handle the deletion of a reminder.                                                                       |
| `check_birthdays.php` | An API-like endpoint that returns a JSON list of names for today's birthdays, used for desktop notifications.                    |
| `notifications.js`    | Frontend script that requests permission and displays desktop notifications.                                                    |
| `config.php`          | **(Local Only)** Contains the database connection credentials. This file should not be committed to version control.              |
| `style.css`           | Contains all custom CSS for styling the application.                                                                          |
| `navbar.php`          | A reusable navigation component that also contains the logic for the in-page "Today's Birthday" notification card.             |
| `db_birthday_reminder.sql` | The SQL dump file to set up the database structure.                                                                        |

---

## 📜 License

This project is licensed under the MIT License. See the `LICENSE` file for details.
